<?php namespace SeIT\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \GuzzleHttp\Client as GuzzleClient;

/**
 * Class UpdateEntityNamesMap
 * @package SeIT\Console\Commands
 */
class UpdateSDEData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task:update-sde-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes an update for SDE Data';

    /**
     * Create a new Guzzle Client instance
     *
     * @var GuzzleClient
     */
    protected $client;

    /**
     * User Agent for this->client
     *
     * @var string
     */
    protected $userAgent = 'SeIT/SDE-Updater';

    /**
     * SDE Metadata
     *
     * @var mixed
     */
    protected $sdeMeta;

    /**
     * Holds the Storage path
     *
     * @var string
     */
    protected $storage;

    /**
     * VVersion bucket for user defined version string
     *
     * @var string
     */
    protected $sdeversion;
    

    /**
     * Create a new command instance.
     */
    protected function bootstrap()
    {
        $this->client = new GuzzleClient();

        $r = $this->client->createRequest('GET', 'https://raw.githubusercontent.com/LunarchildEU/seit/resource/sde.json');
        $r->setHeader('User-Agent', $this->userAgent);

        $this->sdeMeta = json_decode($this->client->send($r)->getBody());
        $this->storage = storage_path() . '/sde/' . $this->sdeMeta->version . '/';

        if (!\File::exists($this->storage)) {
            \File::makeDirectory($this->storage, 0755, true);
        }
    }

    /**
     * Checks for unresolved entities in the DB and processes them against EvE ID2Name Api
     *
     * @return void
     */
    public function fire()
    {
        $this->bootstrap();

        if (!$this->option('sdeversion') === null)
        {
            $this->sdeversion = $this->option('sdeversion');
        }

        if ($this->option('status') === true) {
            $this->status();
        }

        if ($this->option('verify') === true) {
            $this->verify();
        }

        if ($this->option('download') === true) {
            $this->download();
        }

        //if ($this->option('update') === true) {
        //    $this->update();
        //}
    }

    protected function download()
    {
        if ($this->confirm('Reaquire missing SDE Data for update / refresh ? [YES/no]', true)) {
            foreach ($this->sdeMeta->tables as $table) {
                $url = $this->sdeMeta->url . $table . $this->sdeMeta->format;
                $file = $this->storage . $table . $this->sdeMeta->format;
                
                // Check if we do not have the file and download as needed
                if (!\File::exists($file)) {
                    $this->info('[info] Fetching ' . $table . ' from ' . $url);
                    $request = $client->createRequest('GET', $url);
                    $request->setHeader('User-Agent', $userAgent);
                    $response = $client->send($request);
                    \File::put($file, $response->getBody());
                    $this->info('[info] Saved ' . $table . ' to ' . $file);
                } else {
                    $request = $client->createRequest('HEAD', $url);
                    $request->setHeader('User-Agent', $userAgent);
                    $response = $client->send($request);
                    if (!\File::size($file) == $response->getHeader('content-length')) {
                        $this->info('[info] Reaquiring ' . $table . ' from ' . $url);
                        $request = $client->createRequest('GET', $url);
                        $request->setHeader('User-Agent', $userAgent);
                        $response = $client->send($request);
                        \File::put($file, $response->getBody());
                        $this->info('[info] Saved ' . $table . ' to ' . $file);
                    }
                }
            }
        }
    }

    protected function update()
    {
        if ($this->confirm('Unpack all downloaded files and import to "' . \Config::get('database.connections.seit.database') .'"? [YES/no]', true)) {
            foreach ($this->sdeMeta->tables as $table) {
                $file = $this->storage . $table . $this->sdeMeta->format;
                $file_sql = $this->storage . $table . '.sql';
                
                if (!\File::exists($file)) {
                    $this->warn($file . ' is missing.');
                    continue;
                }
                
                // Magic unpack code \*.*/
                $source = bzopen($file, 'r');
                $destination = fopen($file_sql, 'w');
                $bytes = stream_copy_to_stream($source, $destination);
                bzclose($source);
                fclose($destination);
                
                if (!$bytes > 0) {
                    $this->error('Error while unpacking ' . $table);
                    continue;
                } else {
                    $exec_command = 'mysql -u ' . \Config::get('database.connections.seit.username') .
                        (strlen(\Config::get('database.connections.seit.password')) ? ' -p' : '' )
                        . \Config::get('database.connections.seit.password') .
                        ' -h ' . \Config::get('database.connections.seit.host') .
                        ' ' .\Config::get('database.connections.seit.database') .
                        ' < ' . $file_sql;

                    exec($exec_command, $output, $exit_code);

                    if ($exit_code !== 0) {
                        $this->error('[fail] ' . $table . ' import failed with exit code ' . $exit_code . ' and output "' . implode('\n', $output) . '"');
                    } else {
                        $this->info('[ok] ' . $table);
                    }
                }
                \File::delete($file_sql);
            }
            
            $sde_installed = \SeIT\Models\SeITMetadata::where('key', '=', 'sde_version')->first();
            
            if (!$sde_installed) {
                $sde_installed = new \SeIT\Models\SeITMetadata();
                $sde_installed->key = 'sde_version';
            }
            $sde_installed->value = $this->sdeMeta->version;
            $sde_installed->save();
        } else {
            exit();
        }
    }

    protected function status()
    {
        $sde_installed = \SeIT\Models\SeITMetadata::where('key', '=', 'sde_version')->first();

        if (!$sde_installed) {
            $sde_installed = new \SeIT\Models\SeITMetadata();
            $sde_installed->key = 'sde_version';
            $sde_installed->value = 'undefined';
            $sde_installed->save();
        }

        $this->info('Installed SDE: ' . $sde_installed->value);
        $this->info('Available SDE: ' . $this->sdeMeta->version);
        $this->info('SDE Storage:   ' . $this->storage);
    }

    protected function verify()
    {
        $sde_installed = \SeIT\Models\SeITMetadata::where('key', '=', 'sde_version')->first();
        (int)$i = 0;

        foreach ($this->sdeMeta->tables as $table) {
            $file = $this->storage . $table . $this->sdeMeta->format;
            if (!\File::exists($file)) {
                $this->error('[missing] ' . $file);
            } else {
                $i++;
            }
        }

        if (!count($this->sdeMeta->tables) == $i) {
            return false;
        }

        return true;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['status',     null, InputOption::VALUE_OPTIONAL, 'Check for Updates', true],
            ['download',   null, InputOption::VALUE_OPTIONAL, 'Download missing SDE data', true],
            ['verify',     null, InputOption::VALUE_OPTIONAL, 'Verify that all SDE files are in place', true],
            ['update',     null, InputOption::VALUE_OPTIONAL, 'Apply an update', true],
            ['sdeversion', null, InputOption::VALUE_OPTIONAL, 'Override SDE Version', null],
        ];
    }
}
