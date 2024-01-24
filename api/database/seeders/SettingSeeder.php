<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([[
            'id'=>1,
            'name'=>'rateLimiting',
            'value'=>'',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'id'=>2,
            'name'=> '2FA',
            'value'=> false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'id'=>3,
            'name'=> 'social login',
            'value'=> false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
        [
            'id'=>3,
            'name'=> 'recaptcha',
            'value'=> false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]
        ]);
    }
}
