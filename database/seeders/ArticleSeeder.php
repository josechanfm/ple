<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'organization_id'=>1,
            'category_code'=>'COURSE',
            'title_en'=>'article 1',
            'content_en'=>'article 1 content',
            'url'=>'https://www.mpu.edu.mo',
            'user_id'=>1,
            'public'=>true,
            'published'=>true,
        ]);
    }
}
