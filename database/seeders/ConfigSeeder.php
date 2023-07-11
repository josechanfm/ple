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
            'key'=>'category_weightvvvvvvvvvv',
            'value'=>'{
                "name": "Junior",
                "description": "Age Group: +10 - 12 Years",
                "male": [{
                        "code": "30-",
                        "name": "-30Kg",
                        "limit": [25, 30]
                    },
                    {
                        "code": "35-",
                        "name": "-35Kg",
                        "limit": [30, 35]
                    }, {
                        "code": "40-",
                        "name": "-40Kg",
                        "limit": [35, 40]
                    }, {
                        "code": "45-",
                        "name": "-45Kg",
                        "limit": [40, 45]
                    }
                ],
                "female": [{
                    "code": "28-",
                    "name": "-28Kg",
                    "limit": [24, 28]
                }, {
                    "code": "32-",
                    "name": "-32Kg",
                    "limit": [28, 32]
                }, {
                    "code": "36-",
                    "name": "-36Kg",
                    "limit": [32, 36]
                }, {
                    "code": "40-",
                    "name": "-40Kg",
                    "limit": [36, 40]
                }]
            }',
        ]);
        DB::table('configs')->insert([
            'key'=>'categories_weights',
            'value'=>'{
                "name": "Junior",
                "description": "Age Group: +12 - 14 Years",
                "male": [{
                        "code": "35-",
                        "name": "-35Kg",
                        "limit": [30, 35]
                    },
                    {
                        "code": "40-",
                        "name": "-40Kg",
                        "limit": [35, 40]
                    }, {
                        "code": "45-",
                        "name": "-45Kg",
                        "limit": [40, 45]
                    }, {
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [45, 50]
                    }
                ],
                "female": [{
                    "code": "32-",
                    "name": "-32Kg",
                    "limit": [28, 32]
                }, {
                    "code": "36-",
                    "name": "-36Kg",
                    "limit": [32, 36]
                }, {
                    "code": "40-",
                    "name": "-40Kg",
                    "limit": [36, 40]
                }, {
                    "code": "44-",
                    "name": "-44Kg",
                    "limit": [40, 44]
                }]
            }',
        ]);
        DB::table('configs')->insert([
            'key'=>'categories_weights',
            'value'=>'{
                "name": "Junior3",
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
                "name": "Junior",
                "description": "Age Group: +10 - 12 Years",
                "male": [{
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [45, 50]
                    },
                    {
                        "code": "55-",
                        "name": "-55Kg",
                        "limit": [50, 55]
                    }, {
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [55, 60]
                    }, {
                        "code": "66-",
                        "name": "-66Kg",
                        "limit": [60, 66]
                    }
                ],
                "female": [{
                    "code": "44-",
                    "name": "-44Kg",
                    "limit": [40, 44]
                }, {
                    "code": "48-",
                    "name": "-48Kg",
                    "limit": [44, 48]
                }, {
                    "code": "52-",
                    "name": "-52Kg",
                    "limit": [48, 52]
                }, {
                    "code": "57-",
                    "name": "-57Kg",
                    "limit": [52, 57]
                }]
            }',
        ]);


        
    }
}
