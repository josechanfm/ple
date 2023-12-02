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
            'organization_id'=>0,
            'key'=>'belt_ranks',
            'value'=>'[
                {"rankCode":"white","name_zh":"白帶","name_en":"White Belt (Dan )"},
                {"rankCode":"yellow","name_zh":"黃帶","name_en":"Yellow Belt"},
                {"rankCode":"orange","name_zh":"橙帶","name_en":"Orange Belt"},
                {"rankCode":"green","name_zh":"綠帶","name_en":"Green Belt"},
                {"rankCode":"blue","name_zh":"藍帶","name_en":"Blue Belt"},
                {"rankCode":"brown","name_zh":"啡帶","name_en":"Brown Belt"},
                {"rankCode":"dan_1","name_zh":"黑帶1段","name_en":"Blank Belt (Dan 1)"},
                {"rankCode":"dan_2","name_zh":"黑帶2段","name_en":"Blank Belt (Dan 2)"},
                {"rankCode":"dan_3","name_zh":"黑帶3段","name_en":"Blank Belt (Dan 3)"},
                {"rankCode":"dan_4","name_zh":"黑帶4段","name_en":"Blank Belt (Dan 4)"},
                {"rankCode":"dan_5","name_zh":"黑帶5段","name_en":"Blank Belt (Dan 5)"},
                {"rankCode":"dan_6","name_zh":"黑帶6段","name_en":"Blank Belt (Dan 6)"},
                {"rankCode":"dan_7","name_zh":"黑帶7段","name_en":"Blank Belt (Dan 7)"},
                {"rankCode":"dan_8","name_zh":"黑帶8段","name_en":"Blank Belt (Dan 8)"},
                {"rankCode":"dan_9","name_zh":"黑帶9段","name_en":"Blank Belt (Dan 9)"},
                {"rankCode":"dan_10","name_zh":"黑帶10段","name_en":"Blank Belt (Dan 10)"}
                ]'
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'categories_weights',
            'value'=>'{
                "code": "public",
                "name": "公開組",
                "description": "參加者年齡必須於16歲或以上者",
                "male": [{
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [50, 60]
                    },{
                        "code": "66-",
                        "name": "-66Kg",
                        "limit": [61, 66]
                    }, {
                        "code": "73-",
                        "name": "-73Kg",
                        "limit": [67, 73]
                    }, {
                        "code": "81-",
                        "name": "-81Kg",
                        "limit": [74, 81]
                    }, {
                        "code": "90-",
                        "name": "-90Kg",
                        "limit": [82, 90]
                    }, {
                        "code": "OPEN",
                        "name": "Open",
                        "limit": [50, 120]
                    }
                ],
                "female": [{
                        "code": "48-",
                        "name": "-48Kg",
                        "limit": [38, 48]
                    }, {
                        "code": "52-",
                        "name": "-52Kg",
                        "limit": [49, 52]
                    }, {
                        "code": "57-",
                        "name": "-57Kg",
                        "limit": [53, 57]
                    }, {
                        "code": "63-",
                        "name": "-63Kg",
                        "limit": [58, 63]
                    }, {
                        "code": "70-",
                        "name": "-70Kg",
                        "limit": [64, 70]
                    }, {
                        "code": "OPEN",
                        "name": "Open",
                        "limit": [30, 120]
                    }
                ]
            }',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'categories_weights',
            'value'=>'{
                "code":"junior_a",
                "name": "少年A組",
                "description": "參加者年齡必須於15歲至17歲或以上者",
                "male": [{
                        "code": "45-",
                        "name": "-45Kg",
                        "limit": [35, 45]
                    },{
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [46, 50]
                    }, {
                        "code": "55-",
                        "name": "-55Kg",
                        "limit": [51, 55]
                    }, {
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [56, 60]
                    }, {
                        "code": "66-",
                        "name": "-66Kg",
                        "limit": [61, 66]
                    }, {
                        "code": "73-",
                        "name": "-73Kg",
                        "limit": [67, 73]
                    }, {
                        "code": "73+",
                        "name": "+73Kg",
                        "limit": [73, 83]
                    }
                ],
                "female": [{
                        "code": "44-",
                        "name": "-44Kg",
                        "limit": [34, 44]
                    }, {
                        "code": "48-",
                        "name": "-48Kg",
                        "limit": [45, 48]
                    }, {
                        "code": "52-",
                        "name": "-52Kg",
                        "limit": [49, 52]
                    }, {
                        "code": "57-",
                        "name": "-57Kg",
                        "limit": [53, 57]
                    }, {
                        "code": "63-",
                        "name": "-63Kg",
                        "limit": [58, 63]
                    }, {
                        "code": "70-",
                        "name": "-70Kg",
                        "limit": [64, 70]
                    }, {
                        "code": "70+",
                        "name": "+70Kg",
                        "limit": [70, 80]
                    }
                ]
            }',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'categories_weights',
            'value'=>'{
                "code": "junior_b",
                "name": "少年B組",
                "description": "參加者年齡必須於13歲至14歲或以上者",
                "male": [{
                        "code": "42-",
                        "name": "-50Kg",
                        "limit": [32, 42]
                    },{
                        "code": "46-",
                        "name": "-46Kg",
                        "limit": [43, 46]
                    }, {
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [47, 50]
                    }, {
                        "code": "55-",
                        "name": "-55Kg",
                        "limit": [51, 55]
                    }, {
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [56, 60]
                    }, {
                        "code": "66-",
                        "name": "-66Kg",
                        "limit": [61, 66]
                    }, {
                        "code": "66+",
                        "name": "+66Kg",
                        "limit": [66, 76]
                    }
                ],
                "female": [{
                        "code": "40-",
                        "name": "-40Kg",
                        "limit": [30, 40]
                    }, {
                        "code": "46-",
                        "name": "-46Kg",
                        "limit": [45, 46]
                    }, {
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [47, 50]
                    }, {
                        "code": "55-",
                        "name": "-55Kg",
                        "limit": [51, 55]
                    }, {
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [56, 60]
                    }, {
                        "code": "66-",
                        "name": "-66Kg",
                        "limit": [61, 66]
                    }, {
                        "code": "66+",
                        "name": "+66Kg",
                        "limit": [66, 76]
                    }
                ]
            }',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'categories_weights',
            'value'=>'{
                "code": "child_c",
                "name": "兒童C組",
                "description": "參加者年齡必須於11歲至12歲或以上者",
                "male": [{
                        "code": "27-",
                        "name": "-27Kg",
                        "limit": [32, 27]
                    },{
                        "code": "30-",
                        "name": "-30Kg",
                        "limit": [28, 30]
                    }, {
                        "code": "34-",
                        "name": "-34Kg",
                        "limit": [31, 34]
                    }, {
                        "code": "38-",
                        "name": "-38Kg",
                        "limit": [35, 38]
                    }, {
                        "code": "42-",
                        "name": "-42Kg",
                        "limit": [39, 42]
                    }, {
                        "code": "46-",
                        "name": "-46Kg",
                        "limit": [43, 46]
                    }, {
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [47, 50]
                    }, {
                        "code": "55-",
                        "name": "-55Kg",
                        "limit": [51, 55]
                    }, {
                        "code": "60-",
                        "name": "-60Kg",
                        "limit": [56, 60]
                    }, {
                        "code": "60+",
                        "name": "+60Kg",
                        "limit": [60, 70]
                    }
                ],
                "female": [{
                        "code": "25-",
                        "name": "-25Kg",
                        "limit": [30, 25]
                    }, {
                        "code": "28-",
                        "name": "-28Kg",
                        "limit": [26, 28]
                    }, {
                        "code": "32-",
                        "name": "-32Kg",
                        "limit": [29, 32]
                    }, {
                        "code": "36-",
                        "name": "-36Kg",
                        "limit": [33, 36]
                    }, {
                        "code": "40-",
                        "name": "-40Kg",
                        "limit": [37, 40]
                    }, {
                        "code": "44-",
                        "name": "-44Kg",
                        "limit": [41, 44]
                    }, {
                        "code": "48-",
                        "name": "-48Kg",
                        "limit": [45, 48]
                    }, {
                        "code": "50-",
                        "name": "-50Kg",
                        "limit": [49, 50]
                    }, {
                        "code": "57-",
                        "name": "-57Kg",
                        "limit": [51, 57]
                    }, {
                        "code": "57+",
                        "name": "+57Kg",
                        "limit": [57, 67]
                    }
                ]
            }',
        ]);

        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'competition_roles',
            'value'=>'[
                {
                    "value": "athlete",
                    "label": "運動員"
                },{
                    "value": "referee",
                    "label": "裁判"
                },{
                    "value": "coach",
                    "label": "教練"
                },{
                    "value": "scorer",
                    "label": "計分員"
                },{
                    "value": "volunteer_parent",
                    "label": "家長義工"
                },{
                    "value": "volunteer_student",
                    "label": "學生義工"
                }
            ]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'article_categories',
            'value'=>'[{"value":"BLOG","label":"Blog"},{"value":"NEWS","label":"News"}]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'bulletin_categories',
            'value'=>'[{"value": "CMTE","label": "Committee"}, {"value": "GEN","label": "General"}]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'message_categories',
            'value'=>'[{
                "value": "ALL",
                "label": "Everyone"
            }, {
                "value": "ORG",
                "label": "Organization"
            }, {
                "value": "MEM",
                "label": "Member Only"
            }, {
                "value": "IND",
                "label": "Individual"
            }]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'event_categories',
            'value'=>'[{
                "value": "TRANING",
                "label": "Traning"
            }, {
                "value": "COURSE",
                "label": "Course"
            }]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'certificate_categories',
            'value'=>'[{
                "value": "BELT",
                "label": "Belt"
            }, {
                "value": "REFEREE",
                "label": "Referee"
            }, {
                "value": "COACH",
                "label": "Coach"
            }, {
                "value": "OTHER",
                "label": "Other"
            }]',
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'attendance_status',
            'value'=>'[{
                    "value": "ATTEND",
                    "label": "Attend"
                }, {
                    "value": "LATE",
                    "label": "Late"
                }, {
                    "value": "EXCUSE",
                    "label": "Excuse"
                }, {
                    "value": "ABSENT",
                    "label": "Absent"
            }]'
        ]);
        DB::table('configs')->insert([
            'organization_id'=>0,
            'key'=>'card_style',
            'value'=>'{
                    "card_01": {
                        "card_name": "card_01.png",
                        "font_style": "font-family:sans-serif;color:#c24641"
                    },
                    "card_02": {
                        "card_name": "card_02.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_03": {
                        "card_name": "card_03.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_04": {
                        "card_name": "card_04.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_05": {
                        "card_name": "card_05.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_06": {
                        "card_name": "card_06.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_07": {
                        "card_name": "card_07.png",
                        "font_style": "font-family:sans-serif;color:#c24641"
                    },
                    "card_08": {
                        "card_name": "card_08.png",
                        "font_style": "font-family:sans-serif;color:#c24641"
                    },
                    "card_09": {
                        "card_name": "card_09.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_10": {
                        "card_name": "card_10.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_11": {
                        "card_name": "card_11.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_12": {
                        "card_name": "card_12.png",
                        "font_style": "font-family:sans-serif;color:white"
                    },
                    "card_13": {
                        "card_name": "card_13.png",
                        "font_style": "font-family:sans-serif;color:#c24641"
                    },
                    "card_14": {
                        "card_name": "card_14.png",
                        "font_style": "font-family:sans-serif;color:white"
                    }
                }'
            ]);
    }
}
