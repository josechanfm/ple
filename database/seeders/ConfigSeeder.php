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
                    "background": "card_01.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:#c24641",
                    "cart_style":"card_01"
                },
                "card_02": {
                    "background": "card_02.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_03": {
                    "background": "card_03.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_04": {
                    "background": "card_04.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_05": {
                    "background": "card_05.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_06": {
                    "background": "card_06.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_07": {
                    "background": "card_07.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:#c24641"
                },
                "card_08": {
                    "background": "card_08.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:#c24641"
                },
                "card_09": {
                    "background": "card_09.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_10": {
                    "background": "card_10.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_11": {
                    "background": "card_11.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_12": {
                    "background": "card_12.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                },
                "card_13": {
                    "background": "card_13.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:#c24641"
                },
                "card_14": {
                    "background": "card_14.png",
                    "logo": "site_logo.png",
                    "font_style": "font-family:sans-serif;color:white"
                }
            }'
            ]);
            DB::table('configs')->insert([
                'organization_id'=>0,
                'key'=>'content_types',
                'value'=>'[
                    { "value": "PAGE", "label": "Page" },
                    { "value": "FILE", "label": "File"},
                    { "value": "URL", "label": "Url" },
                    { "value": "VIDEO", "label": "Video" },
                    { "value": "AUDIO", "label": "Audio" },
                    { "value": "TEXT", "label": "Text" },
                    { "value": "QUIZ", "label": "Quiz" },
                    { "value": "ASSIGNMENT", "label": "Assignment" }
                  ]'
            ]);
            DB::table('configs')->insert([
                'organization_id'=>0,
                'key'=>'actors',
                'value'=>'[
                    {"value":"STD","label":"Student"},
                    {"value":"TCH","label":"Teacher"}
                ]'
            ]);
            
            


            
    
    }
}
