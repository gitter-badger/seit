<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('EveCorporationRolemapSeeder');
        $this->call('EveNotificationTypesSeeder');
        $this->call('EveErrorlistSeeder');
        $this->call('EveReftypesSeeder');
        $this->call('EveApiCalllistSeeder');
    }
}
