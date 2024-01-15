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
        // Organization::factory()->count(10)->create();
        // $organization=Organization::find(1);
        // $organization->abbr="MJA";
        // $organization->full_name="澳門柔道協會";
        // $organization->save();  

        $data=[
            ["region"=>"L","name"=>"澳門教育發展研究學會","abbr"=>"MEDRA","title"=>"MEDRA","address"=>"NULL","phone"=>"Phone : 28523909","web"=>"macaojudo.org.mo","email"=>"info@macaujudo.org.mo","president"=>"--"],
            ["region"=>"L","name"=>"澳門教育科技發展學會","abbr"=>"STEAM","title"=>"STEAM","address"=>"NULL","phone"=>"Phone : ","web"=>"--","email"=>"--","president"=>"--"],
            ["region"=>"L","name"=>"澳門項目管理師協會","abbr"=>"MPMPA","title"=>"MPMPA",'address'=>"NULL","phone"=>"Phone : ","web"=>"--","email"=>"--","president"=>"--"]        ];
        foreach($data as $org){
            DB::table('organizations')->insert([
                'region'=>$org['region'],
                'territory'=>$org['region'],
                'abbr'=>$org['abbr'],
                'full_name'=>$org['name'],
                'title'=>$org['name'],
                'address'=>$org['address'],
                'href'=>$org['web'],
                'email'=>$org['email'],
                'president'=>$org['president'],
                'card_style'=>'card_01'
            ]);
        }
        DB::table('organizations')->where('id',22)->update([
            'registration_code'=>'112233',
        ]);
        DB::table('organization_user')->insert([
            'user_id'=>'3',
            'organization_id'=>'1',
        ]);


    }
}

