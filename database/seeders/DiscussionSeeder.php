<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discussions')->insert([
            'forum_id'=>1,
            'discussion_id'=>null,
            'title'=>'talk 1',
            'content'=>'talk 1 content'
        ]);
        DB::table('discussions')->insert([
            'forum_id'=>1,
            'discussion_id'=>null,
            'title'=>'talk 1',
            'content'=>'talk 1 content'
        ]);
        DB::table('discussions')->insert([
            'forum_id'=>1,
            'discussion_id'=>2,
            'title'=>'talk 1',
            'content'=>'talk 1 content'
        ]);
    }
}
