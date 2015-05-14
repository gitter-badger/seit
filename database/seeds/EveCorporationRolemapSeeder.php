<?php

use Illuminate\Database\Seeder;

/**
* see http://oldforums.eveonline.com/?a=topic&threadID=1250101
*/

class EveCorporationRolemapSeeder extends Seeder
{
    public function run()
    {
        $timestamp = \Carbon\Carbon::now();

        \DB::table('eve_corporation_rolemap')->truncate();

        \DB::table('eve_corporation_rolemap')->insert(
            array(
                array(
                    'roleID' => 1,
                    'roleName' => 'Director',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 128,
                    'roleName' => 'Personnel Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 256,
                    'roleName' => 'Accountant',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 512,
                    'roleName' => 'Security Officer',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 1024,
                    'roleName' => 'Factory Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 2048,
                    'roleName' => 'Station Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 4096,
                    'roleName' => 'Auditor',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 134217728,
                    'roleName' => 'Can take from Wallet Division 1',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 268435456,
                    'roleName' => 'Can take from Wallet Division 2',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 536870912,
                    'roleName' => 'Can take from Wallet Division 3',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 1073741824,
                    'roleName' => 'Can take from Wallet Division 4',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 2147483648,
                    'roleName' => 'Can take from Wallet Division 5',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 4294967296,
                    'roleName' => 'Can take from Wallet Division 6',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 8589934592,
                    'roleName' => 'Can take from Wallet Division 7',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 2199023255552,
                    'roleName' => 'Equipment Config',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 562949953421312,
                    'roleName' => 'Can Rent Office',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 1125899906842624,
                    'roleName' => 'Can Rent Factory Slot',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 2251799813685248,
                    'roleName' => 'Can Rent Research Slot',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 4503599627370496,
                    'roleName' => 'Junior Accountant',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 9007199254740992,
                    'roleName' => 'Starbase Config',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 18014398509481984,
                    'roleName' => 'Trader',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 36028797018963968,
                    'roleName' => 'Chat Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 72057594037927936,
                    'roleName' => 'Contract Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 144115188075855872,
                    'roleName' => 'Infrastructure Tactical Officer',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 288230376151711744,
                    'roleName' => 'Starbase Caretaker',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 576460752303423488,
                    'roleName' => 'Fitting Manager',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 8192,
                    'roleName' => 'Can take from Hangar 1',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 16384,
                    'roleName' => 'Can take from Hangar 2',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 32768,
                    'roleName' => 'Can take from Hangar 3',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 65536,
                    'roleName' => 'Can take from Hangar 4',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 131072,
                    'roleName' => 'Can take from Hangar 5',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 262144,
                    'roleName' => 'Can take from Hangar 6',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 524288,
                    'roleName' => 'Can take from Hangar 7',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 1048576,
                    'roleName' => 'Can query Hangar 1',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 2097152,
                    'roleName' => 'Can query Hangar 2',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 4194304,
                    'roleName' => 'Can query Hangar 3',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 8388608,
                    'roleName' => 'Can query Hangar 4',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 16777216,
                    'roleName' => 'Can query Hangar 5',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 33554432,
                    'roleName' => 'Can query Hangar 6',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 67108864,
                    'roleName' => 'Can query Hangar 7',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 4398046511104,
                    'roleName' => 'Can take Container from Hangar 1',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 8796093022208,
                    'roleName' => 'Can take Container from Hangar 2',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 17592186044416,
                    'roleName' => 'Can take Container from Hangar 3',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 35184372088832,
                    'roleName' => 'Can take Container from Hangar 4',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 70368744177664,
                    'roleName' => 'Can take Container from Hangar 5',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 140737488355328,
                    'roleName' => 'Can take Container from Hangar 6',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
                array(
                    'roleID' => 281474976710656,
                    'roleName' => 'Can take Container from Hangar 7',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ),
            )
        );
    }
}
