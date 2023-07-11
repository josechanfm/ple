<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'key'=>'weight_categories',
            'value'=>'{
                "classes": "Junior",
                "description": "Age Group: +10 - 12 Years",
                "male": {
                    "30-": [25, 30],
                    "35-": [30, 35],
                    "40-": [35, 40],
                    "45-": [40, 45]
                },
                "female": {
                    "28-": [24, 28],
                    "32-": [28, 32],
                    "36-": [32, 36],
                    "40-": [36, 40]
                }
            }',
        ]);
        DB::table('configs')->insert([
            'key'=>'weight_categories',
            'value'=>'{
                "classes": "Junior2",
                "description": "Age Group: +12 - 14 Years",
                "male": {
                    "35-": [30, 35],
                    "40-": [35, 40],
                    "45-": [40, 45],
                    "50-": [45, 50]
                },
                "female": {
                    "32-": [28, 32],
                    "36-": [32, 36],
                    "40-": [36, 40],
                    "44-": [40, 44]
                }
            }',
        ]);
        DB::table('configs')->insert([
            'key'=>'weight_categories',
            'value'=>'{
                "classes": "Junior3",
                "description": "Age Group: +14 - 15 Years",
                "male": {
                    "50-": [45, 50],
                    "55-": [50, 55],
                    "60-": [55, 60],
                    "66-": [60, 66]
                },
                "female": {
                    "44-": [40, 44],
                    "48-": [44, 48],
                    "52-": [48, 52],
                    "57-": [52, 57]
                }
            }',
        ]);

        DB::table('configs')->insert([
            'key'=>'competition_roles',
            'value'=>'{
                "athlete": "運動員",
                "referee": "裁判",
                "coach": "教練",
                "scorer": "計分員"
            }',
        ]);


        
    }
}
