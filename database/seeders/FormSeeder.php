<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            'organization_id'=>1,
            'name'=>'first form',
            'title'=>'First form of title'
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'username',
            'field_label'=>'Username',
            'type'=>'input'
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'gender',
            'field_label'=>'Gender',
            'type'=>'radio',
            'options'=>'[{"value":"M","label":"Male"},{"value":"F","label":"Female"}]'
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'dob',
            'field_label'=>'DOB',
            'type'=>'date',
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'education',
            'field_label'=>'Education',
            'type'=>'select',
            'options'=>'[{"value":"B","label":"Bachalor"},{"value":"M","label":"Master"},{"value":"D","label":"PhD."}]'
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'email',
            'field_label'=>'Email',
            'type'=>'email'
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '1',
            'field_name'=>'remark',
            'field_label'=>'Remark',
            'type'=>'textarea'
        ]);


        DB::table('forms')->insert([
            'organization_id'=>1,
            'name'=>'second form',
            'title'=>'Second form of title',
            'published'=>true
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '2',
            'field_name'=>'username',
            'field_label'=>'Username',
            'type'=>'input',
        ]);

        DB::table('forms')->insert([
            'organization_id'=>1,
            'name'=>'2023柔道投之形研習會',
            'title'=>'2023柔道投之形研習會',
            'description'=>'<p><span style="color: rgb(32, 33, 36);">課程名稱：2023柔道投之形研習會</span></p><p><span style="color: rgb(32, 33, 36);">學員意見調查表</span></p><p><span style="color: rgb(32, 33, 36);">本調查表收集學員個人對上述柔道專業發展課程的意見，以便改進同類課程的規劃、組織和實施，為本澳柔道工作者提供更多的培訓課程，請用心填選擇合適的選項或填寫簡明訊息。</span></p><p><br></p><p><span style="color: rgb(32, 33, 36);">多謝您的回應！</span></p>',
            'published'=>true
        ]);

        DB::table('form_fields')->insert([
            'form_id' => '3',
            'field_name'=>'性別',
            'field_label'=>'性別',
            'options'=>'[{"value":"M","label":"\u7537"},{"value":"F","label":"\u5973"}]',
            'direction'=>'V',
            'in_column'=>'1',
            'type'=>'radio',
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '3',
            'field_name'=>'柔道年資',
            'field_label'=>'柔道年資',
            'options'=>NULL,
            'direction'=>'V',
            'in_column'=>'0',
            'type'=>'input',
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '3',
            'field_name'=>'原因',
            'field_label'=>'報讀活動原因 (多選)',
            'options'=>'[{"value":"option_1","label":"\u500b\u4eba\u8208\u8da3"},{"value":"option_2","label":"\u67d4\u9053\u6703\u8981\u6c42"},{"value":"option_3","label":"\u67d4\u9053\u5c08\u696d\u8981\u6c42"}]',
            'direction'=>'V',
            'in_column'=>'0',
            'type'=>'checkbox',
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '3',
            'field_name'=>'目標陳述',
            'field_label'=>'課程目標陳述清楚',
            'options'=>'[{"value":5,"label":"\u975e\u5e38\u540c\u610f"},{"value":4,"label":"\u540c\u610f"},{"value":3,"label":"\u666e\u901a"},{"value":2,"label":"\u4e0d\u540c\u610f"},{"value":1,"label":"\u975e\u5e38\u4e0d\u540c\u610f"},{"value":0,"label":"\u4e0d\u9069\u7528"}]',
            'direction'=>'V',
            'in_column'=>'0',
            'type'=>'radio',
        ]);
        DB::table('form_fields')->insert([
            'form_id' => '3',
            'field_name'=>'符合專業',
            'field_label'=>'課程內容符合您個人專業實務需求',
            'options'=>'[{"value":5,"label":"\u975e\u5e38\u540c\u610f"},{"value":4,"label":"\u540c\u610f"},{"value":3,"label":"\u666e\u901a"},{"value":2,"label":"\u4e0d\u540c\u610f"},{"value":1,"label":"\u975e\u5e38\u4e0d\u540c\u610f"},{"value":0,"label":"\u4e0d\u9069\u7528"}]',
            'direction'=>'V',
            'in_column'=>'0',
            'type'=>'radio',
        ]);

    }
}
