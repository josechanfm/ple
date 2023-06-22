<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::factory()->count(10)->create();
        $organization=Organization::find(1);
        $organization->abbr="MJA";
        $organization->full_name="澳門柔道協會";
        $organization->save();  

        DB::table('organization_user')->insert([
            'user_id'=>'1',
            'organization_id'=>'1',
        ]);
        DB::table('organization_user')->insert([
            'user_id'=>'2',
            'organization_id'=>'3',
        ]);
        DB::table('organization_user')->insert([
            'user_id'=>'3',
            'organization_id'=>'3',
        ]);
        DB::table('organization_user')->insert([
            'user_id'=>'4',
            'organization_id'=>'4',
        ]);


        DB::table('member_organization')->insert([
            'member_id'=>'1',
            'organization_id'=>'1',
        ]);
        DB::table('member_organization')->insert([
            'member_id'=>'2',
            'organization_id'=>'1',
        ]);
        DB::table('member_organization')->insert([
            'member_id'=>'3',
            'organization_id'=>'1',
        ]);


        DB::table('member_organization')->insert([
            'member_id'=>'4',
            'organization_id'=>'2',
        ]);
        DB::table('member_organization')->insert([
            'member_id'=>'5',
            'organization_id'=>'2',
        ]);
        DB::table('member_organization')->insert([
            'member_id'=>'6',
            'organization_id'=>'2',
        ]);




    }
}

