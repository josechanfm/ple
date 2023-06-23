<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('guardians')->insert([
            'user_id' => '4',
            'name'=>'Guardian 1'
        ]);
        DB::table('guardian_member')->insert([
            'guardian_id'=>1,
            'member_id'=>2
        ]);
        DB::table('guardian_member')->insert([
            'guardian_id'=>1,
            'member_id'=>3
        ]);
    }
}
