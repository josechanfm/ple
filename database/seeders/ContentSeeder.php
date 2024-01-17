<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contents')->insert([
            'course_id'=>1,
            'module'=>'module1',
            'title'=>'Lecture 1',
            'type'=>'PAGE',
            'content'=>'
                Lecture 1 of course 1
                Lecture 1 of course 1
                Lecture 1 of course 1
            ',
            'frontpage'=>false,
            'user_id'=>1
        ]);
        DB::table('contents')->insert([
            'course_id'=>1,
            'module'=>'module2',
            'title'=>'Lecture 1 reference',
            'type'=>'URL',
            'content'=>'
                https://www.mpu.edu.mo
            ',
            'frontpage'=>false,
            'user_id'=>1
        ]);
        DB::table('contents')->insert([
            'course_id'=>1,
            'module'=>'module3',
            'title'=>'Lecture 1',
            'type'=>'PAGE',
            'content'=>'
                Lecture 1 of course 1
                Lecture 1 of course 1
                Lecture 1 of course 1
            ',
            'frontpage'=>true,
            'user_id'=>1
        ]);
    }
}
