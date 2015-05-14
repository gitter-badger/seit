<?php

use Illuminate\Database\Seeder;

use \SeIT\Services\BaseApi as EveApi;
use \Pheal\Pheal;

class EveApiCalllistSeeder extends Seeder
{
    public function run()
    {
        $timestamp = \Carbon\Carbon::now();

        \DB::table('eve_api_calllist')->truncate();

        EveApi::bootstrap();
        $pheal = new  Pheal();

        $callList = $pheal->apiScope->CallList();

        foreach ($callList->calls as $call) {
            $calls[] = array(
                'accessMask'  => $call->accessMask,
                'type'        => $call->type,
                'name'        => $call->name,
                'created_at'  => $timestamp,
                'updated_at'  => $timestamp,
            );
        }

        \DB::table('eve_api_calllist')->insert(
            $calls
        );
    }
}
