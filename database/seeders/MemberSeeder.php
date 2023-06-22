<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::factory()->count(100)->create();
        Member::find(1)->update(['user_id'=>1]);
        Member::find(2)->update(['user_id'=>2]);
        Member::find(3)->update(['user_id'=>3]);
        Member::find(4)->update(['user_id'=>4]);
    }


}
