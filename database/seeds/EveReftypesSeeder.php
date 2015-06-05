<?php namespace SeIT\Database\Seeds;

use Illuminate\Database\Seeder;

use \SeIT\Services\BaseApi as EveApi;
use \Pheal\Pheal;

class EveReftypesSeeder extends Seeder
{
    public function run()
    {
        \DB::table('eve_reftypes')->truncate();

        EveApi::bootstrap();
        $pheal = new  Pheal();

        $typeList = $pheal->eveScope->RefTypes();

        foreach ($typeList->refTypes as $type) {
            $errors[] = array(
                'refTypeID' => $type->refTypeID,
                'refTypeName' => $type->refTypeName,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            );
        }

        \DB::table('eve_reftypes')->insert(
            $errors
        );
    }
}
