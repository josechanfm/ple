<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $referees=array(
            'INT'=>'International referee',
            'CON'=>'Continental referee',
            'NAT'=>'National referee',
            'KAT'=>'Kata referee',
            'COM'=>'Commission member',
            'ASS'=>'Assessor',
            'SUP'=>'Supervisor',
            'IBSA'=>'IBSA referee',
            'HIR'=>'Honorary international referee',
            'HCR'=>'Honorary continental referee'
        );
        $officials=array(
            'PRE'=>'President',
            'VPR'=>'Vice president',
            'GSE'=>'General secretary',
            'TRE'=>'Treasurer',
            'CPIJF'=>'Contact person for IJF',
            'TEC'=>'Technical director',
            'NOC'=>'Member of NOC',
            'RCD'=>'Referee Commision Director',
            'MED'=>'Media Director',
            'ITD'=>'IT Director',
            'TDR'=>'Team Doctor',
            'TPH'=>'Team Physiotherapist',
            'YCOM'=>'Youth Commissioner',
            'KCOM'=>'Kata Commissioner',
            'MSC'=>'Mass Sports Commissioner',
            'VET'=>'Veterans contact',
            'LAC'=>'Legal Affairs Commissioner',            
        );
        DB::table('positions')->insert([
            'scope' => 'ATHLETE',
            'code'=>'ATH',
            'title_en'=>'Athlete'
        ]);
        DB::table('positions')->insert([
            'scope' => 'COACH',
            'code'=>'COA',
            'title_en'=>'Coach'
        ]);

        foreach($referees as $code=>$item){
            DB::table('positions')->insert([
                'scope' => 'REFEREE',
                'code'=>$code,
                'title_en'=>$item
            ]);
        }
        foreach($officials as $code=>$item){
            DB::table('positions')->insert([
                'scope' => 'Federation official',
                'code'=>$code,
                'title_en'=>$item
            ]);
        }
        foreach($officials as $code=>$item){
            DB::table('positions')->insert([
                'scope' => 'Organization official',
                'code'=>$code,
                'title_en'=>$item
            ]);
        }

    }
}
