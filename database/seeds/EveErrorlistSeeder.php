<?php namespace SeIT\Database\Seeds;

use Illuminate\Database\Seeder;

use \SeIT\Services\BaseApi as EveApi;
use \Pheal\Pheal;

class EveErrorlistSeeder extends Seeder
{
    public function run()
    {
        \DB::table('eve_errorlist')->truncate();

        EveApi::bootstrap();
        $pheal = new  Pheal();

        $errorList = $pheal->eveScope->ErrorList();

        foreach ($errorList->errors as $error) {
            $errors[] = array(
                'errorCode' => $error->errorCode,
                'errorText' => $error->errorText,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            );
        }

        \DB::table('eve_errorlist')->insert(
            $errors
        );
    }
}
