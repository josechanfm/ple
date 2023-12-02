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
            ["region"=>"C","name"=>"Kazakhstan","abbr"=>"FDK","title"=>" Kazakhstan Judo Federation","address"=>" Kabanbay Batyra 11/5, 8th floor, Office 802, Block B 010000 Astana","phone"=>"Phone : +7 (7172)79 90 45","web"=>" www.fdk.kz","email"=>" kazakhstan.judo.fed@gmail.com","president"=>"YESSEKEYEV Kuanyshbek"],
            ["region"=>"C","name"=>"Kyrgyzstan","abbr"=>"FKGZ","title"=>" The National Judo Federation of Kyrgyzstan","address"=>" Suvanberdiev Str, 102/10 7200010 Bishkek","phone"=>"Phone : +996555554730","web"=>" judo.kg","email"=>" judo-fkgz@mail.ru","president"=>"KOLBAEV Zholdoshbek"],
            ["region"=>"C","name"=>"Tajikistan","abbr"=>"TJF","title"=>" Tajikistan Judo Federation","address"=>" Ainy 24 734025 Dushanbe","phone"=>"Phone : +992 919551225","web"=>" www.judo.tj","email"=>" info@judo.tj","president"=>"MAHMADZOIR Ismoil"],
            ["region"=>"C","name"=>"Turkmenistan","abbr"=>"TJF","title"=>" Judo Federation of Turkmenistan","address"=>" Parahat 2/1, 21-181 744000 Ashgabat","phone"=>"Phone : +99312455114","web"=>"","email"=>" tjf.president@gmail.com","president"=>"GURBANMYRADOV Velmyrat"],
            ["region"=>"C","name"=>"Uzbekistan","abbr"=>"UJF","title"=>" Uzbekistan Judo Federation","address"=>" A.Kadiriy 7A Shaykhontokhur dstr. 100128 Tashkent","phone"=>"Phone : +998 71 232 62 31","web"=>" judo.uz","email"=>" uzbjudofed@gmail.com","president"=>"KAMILOV Azizjon"],
            ["region"=>"C","name"=>"Afganistan","abbr"=>"AJF","title"=>" Afganistan Judo Federation","address"=>" NOC Afghanistan P.O.Box 5197 Kabul","phone"=>"Phone : +93 781 20 20 90","web"=>"","email"=>" president@afghanjudofederation.af","president"=>"NAZARI Zabiullah"],
            ["region"=>"SE","name"=>"Cambodian","abbr"=>"CJF","title"=>" Cambodian Judo Federation","address"=>" CJF Building, Olympic Stadium, Sangkat Veal Vong, Khan 7 Makar 12250 Phnom Penh","phone"=>"Phone : +855 89730309 / +855 10782978","web"=>"","email"=>" cambodiajudofederation@gmail.com","president"=>"Heng Ly"],
            ["region"=>"SE","name"=>"Indonesia","abbr"=>"PBPJSI","title"=>" Indonesia Judo Federation","address"=>" Gedung PPK GBK 2nd floor, Jl. Pintu 1, Senayan 10270 Central Jakarta","phone"=>"Phone : +62 21 57940079","web"=>" www.pbpjsi.org","email"=>" pbpjsi88@gmail.com","president"=>"SIMANJUNTAK MARULI"],
            ["region"=>"SE","name"=>"Lao","abbr"=>"LJF","title"=>" Lao Judo Federation","address"=>" 04 Khounboulom Road LAO PDR Vientiane Capital","phone"=>"Phone : +856 21 265290","web"=>"","email"=>" laojudo@yahoo.com","president"=>"PHILAPHANDETH Khemsath"],
            ["region"=>"SE","name"=>"Malaysia","abbr"=>"MJF","title"=>" Malaysia Judo Federation","address"=>" Jalan Hang Jebat Lot 2 50150 Kuala Lumpur","phone"=>"Phone : +60164219009","web"=>"","email"=>" Malaysiajudofederation@gmail.com","president"=>"LIM TATT KEONG Andrew Datuk"],
            ["region"=>"SE","name"=>"Myanmar","abbr"=>"MYJF","title"=>" Myanmar Judo Federation","address"=>" National Swimming Pool, Judo training camp, U Wisara road 11191 Dagaon Township, Yangon","phone"=>"Phone : +951-380772","web"=>"","email"=>" myanmarjudo@myanmar.com.mm","president"=>"Tun Tun U"],
            ["region"=>"SE","name"=>"Philippine","abbr"=>"PJF","title"=>" Philippine Judo Federation, Inc.","address"=>" Baseball Dug-out, Back of PNB Harrison Plaza Branch 1004 City of Manila","phone"=>"Phone : +63905-5206671","web"=>" https://www.philippinejudofederation.org/","email"=>" dcarter4171@yahoo.com, luleo.panganiban@gmail.com","president"=>"CARTER David"],
            ["region"=>"SE","name"=>"Singapore","abbr"=>"SJF","title"=>" Singapore Judo Federation","address"=>" 1 GUILLEMARD CRESCENT 399913 SINGAPORE","phone"=>"Phone : +65 6348 9792","web"=>" www.sjf.sg","email"=>" singaporejudofederation@gmail.com","president"=>"CHIN SENG Yeo"],
            ["region"=>"SE","name"=>"Thailand","abbr"=>"JAT","title"=>" Judo Association of Thailand Under The Patronage of His Majesty The King","address"=>" 286 Sports Authority of Thailand. E2 Rajamangala National Stadium, Hua Mark 10240 Bangkapi, Bangkok","phone"=>"Phone : +66 2 3691514","web"=>" http://www.judothailand.com/","email"=>" judo.thailand@yahoo.com","president"=>"ROJANACHIVA Hassabodin"],
            ["region"=>"SE","name"=>"Vietnam","abbr"=>"VJA","title"=>" Vietnam Judo Association","address"=>" 36 Tranphu, Badinh 100000 Hanoi","phone"=>"Phone : +84912536089","web"=>"","email"=>" huuantkd@gmail.com","president"=>"NGUYEN Manh Hung"],
            ["region"=>"E","name"=>"People's Republic Of China","abbr"=>"CJA","title"=>" Chinese Judo Association","address"=>" NO.1,Anding Road, Chaoyang District 100100 Beijing","phone"=>"Phone : +86 010 84378212","web"=>"","email"=>" chinajudo@sports.cn","president"=>"ZHOU Jinqiang"],
            ["region"=>"E","name"=>"Chinese Taipei","abbr"=>"CTJF","title"=>" Chinese Taipei Judo Federation","address"=>" 510 No.20,Chu-Lun ST. 10489 Taipei City","phone"=>"Phone : (886-2)8772-7788","web"=>"","email"=>" tpejudo.ctja@msa.hinet.net","president"=>"LU Wei-Chen"],
            ["region"=>"E","name"=>"Democratic People's Republic of Korea","abbr"=>"DPRKJA","title"=>" DPR Korea Judo Association","address"=>" Kumsong Dong 2, Mangyongdae Dist. P.O. Box 56 Pyongyang","phone"=>"Phone : +850 2 18111 ext. 3418342","web"=>"","email"=>" prk@star-co.net.kp; prksport@star-co.net.kp","president"=>"KIM Ik Son"],
            ["region"=>"E","name"=>"Hong Kong, China","abbr"=>"JAHK","title"=>" The Judo Association of Hong Kong, China","address"=>" Rm. 1024, Olympic Hse., 1 Stadium Path, Causeway Bay 852 Hong Kong","phone"=>"Phone : +852 2504 8360","web"=>" hkjudo.org","email"=>" hkjudo_mail@yahoo.com.hk","president"=>"PUI Kwan Kay"],
            ["region"=>"E","name"=>"Japan","abbr"=>"AJJF","title"=>" All Japan Judo Federation","address"=>" 1-16-30 Kasuga, Bunkyo-ku 112-0003 Tokyo","phone"=>"Phone : 0081-3-38185009","web"=>" www.judo.or.jp","email"=>" ajjf@judo.or.jp","president"=>"YAMASHITA Yasuhiro"],
            ["region"=>"E","name"=>"Republic of Korea","abbr"=>"KJA","title"=>" Korea Judo Association","address"=>" 1F Olympic Convention Center, 424 Olympic-ro 05540 Songpa-Gu, Seoul","phone"=>"Phone : +82 2 422 0581","web"=>" judo.sports.or.kr","email"=>" judo@sports.or.kr","president"=>"CHO Yong-Chul"],
            ["region"=>"E","name"=>"Macau, China","abbr"=>"MJA","title"=>" Macau Judo Association","address"=>" Estrada Victoria, Centro Desportivo Vitoria, 1st floor 853 MACAU","phone"=>"Phone : +853 28523909","web"=>" https://macaujudo.org.mo/","email"=>" judomac@macau.ctm.net","president"=>"CHE Kuong Hon"],
            ["region"=>"E","name"=>"Mongolia","abbr"=>"MGJA","title"=>" Mongolian Judo Association","address"=>" Sukhbaatar district 8th khoroo, sports center, room 105 210648 Ulaanbaatar","phone"=>"Phone : (976) 98236666","web"=>" www.mongoljudo.mn","email"=>" judodata01@gmail.com","president"=>"KHALTMAA Battulga"],
            ["region"=>"W","name"=>"Islamic Republic of Iran (SUSPENDED)","abbr"=>"IIRAN","title"=>" Islamic Republic of Iran Judo Federation","address"=>" Varzandeh St, Mofatteh St 158151881 Tehran","phone"=>"Phone : +982188844731","web"=>"","email"=>" iiranjudof@yahoo.com,arash.miresmaeili@yahoo.com","president"=>"MIRESMAEILI Arash"],
            ["region"=>"W","name"=>"Iraq","abbr"=>"IRAQ","title"=>" Iraqi Judo Federation","address"=>" BALLOON EXPRESS COMPANY ALMANSOUR STR.13 BAGHDAD P.C 10013 IRAQ 009647706273518 Baghdad","phone"=>"Phone : 009647901305894","web"=>"","email"=>" iraqjudofed999@yahoo.com","president"=>"AL-MOUSAWAI Samir Sadig"],
            ["region"=>"W","name"=>"Jordan","abbr"=>"JORDAN","title"=>" Jordan Judo Federation","address"=>" Amman . sport city . gate 4 11953 Amman","phone"=>"Phone : +962-6 5625666","web"=>"","email"=>" jjf@jjfjo.com","president"=>"MALHAS Ali S"],
            ["region"=>"W","name"=>"Kuwait","abbr"=>"KUWAIT","title"=>" Kuwait Judo Federation","address"=>" Sabah Al-Salem area- Safat P.O.Box 23168 44001 Mubarak Al-Kabeer","phone"=>"Phone : + 965 25527276/+965 90911354 /+965 51092011 /+965","web"=>"","email"=>" judokuwait1@gmail.com","president"=>"ALENEZI Yousef"],
            ["region"=>"W","name"=>"Lebanon","abbr"=>"LEBANON","title"=>" Federation Libanaise de Judo","address"=>" P.O Box:11 463 Lebanon","phone"=>"Phone : (961-9) 222000","web"=>"","email"=>" judolebanon@hotmail.com","president"=>"SAADE Francois"],
            ["region"=>"W","name"=>"Palestine","abbr"=>"PALESTINE","title"=>" Palestinian Judo Federation","address"=>" P.O.Box 21458 JERUSALEM 9121302 Jerusalem","phone"=>"Phone : +972545652104 / +972547282627","web"=>"","email"=>" palestinejudofederation@gmail.com","president"=>"OWAIDA Jehad"],
            ["region"=>"W","name"=>"Qatar","abbr"=>"QATAR","title"=>" Qatar Taekwondo, Judo & Karate Federation","address"=>" Al-Cornech Road , Al-Biddaa Tower, Floor No.6-Doha-Qatar Po.Box:23554 23554 Doha","phone"=>"Phone : 00974/44943545 / 55496601","web"=>"","email"=>" qtjk@olympic.qa ; riyaz25@gmail.com","president"=>"ALATIYA Khalid"],
            ["region"=>"W","name"=>"Saudi Arabia","abbr"=>"SAUDI","title"=>" Saudi Judo Federation","address"=>" Prince Faisal Bin Fahad Olympic Complex, 8535 AlWadi-Ar Rafiah 12752-2281 Riyadh","phone"=>"Phone : +966 11 4829870","web"=>" www.judoksa.org","email"=>" Info@sajf.org.sa, info@judoksa.org","president"=>"ALBASSAM Abdulaziz"],
            ["region"=>"W","name"=>"Syrian Arab Republic","abbr"=>"SYR","title"=>" Syrian Judo Federation","address"=>" Faihaa palace Sport 222 Damascus","phone"=>"Phone : + 963-93 3688282","web"=>"","email"=>" syr.judo@membergsf.com","president"=>"HAG KADOUR Imad"],
            ["region"=>"W","name"=>"United Arab Emirates(UAE)","abbr"=>"UAE","title"=>" UAE Wrestling & Judo Federation","address"=>" Arabian Gulf Street - Al Mushrif 3573 Abu Dhabi","phone"=>"Phone : 00971504447743","web"=>"","email"=>" info@uaewjjf.com","president"=>"Thaaloob Alderei HE Mohammed"],
            ["region"=>"W","name"=>"Yemen","abbr"=>"YEMEN","title"=>" Yemen Judo Federation","address"=>" P.O. Box - 786 2701 Sana'a","phone"=>"Phone : +967 733528192","web"=>"","email"=>" YEMENJF@YAHOO.COM","president"=>"HASAN Noman"],
            ["region"=>"W","name"=>"Bahrain","abbr"=>"BAHRAIN","title"=>" Judo Federation Bahrain","address"=>" 1114 NA Tubli 711, Manama","phone"=>"Phone : +97339673222","web"=>" https://www.olympic.org/bahrain","email"=>" bahrainjudo.federation@gmail.com","president"=>"KANOO Faisal"],
            ["region"=>"S","name"=>"Bangladesh","abbr"=>"BANGLADESH","title"=>" Bangladesh Judo federation","address"=>" Room No. 230-232, Moulana Bhashani Hockey Stadium 1000 Dhaka","phone"=>"Phone : +880 1819191924","web"=>"","email"=>" bdjudo71@gmail.com","president"=>"Rahman Fayzur"],
            ["region"=>"S","name"=>"India","abbr"=>"INDIA","title"=>" Judo Federation of India","address"=>" F - 14, Gali No.12, Jagatpuri 110051 DELHI","phone"=>"Phone : +91-7827412316","web"=>" onlinejfi.org","email"=>" jfiindia@gmail.com; jfirajan@gmail.com","president"=>"Partap Singh BAJWA, MP (Erstwhile President)"],
            ["region"=>"S","name"=>"Nepal","abbr"=>"NEPAL","title"=>" Nepal Judo Association","address"=>" Dasharath Stadium, Tripureswor, p.o box 676 00977 Tripureswor","phone"=>"Phone : +977 1 4268828","web"=>"","email"=>" horizon@mos.com.np","president"=>"BAJRACHARYA Deepak"],
            ["region"=>"S","name"=>"Sri Lanka","abbr"=>"SLJ","title"=>" Sri Lanka Judo Association","address"=>" No 25 Ambagahapura, Maharagama, Sri Lanka 10280 Maharagama","phone"=>"Phone : +94 0718988288","web"=>"","email"=>" presidentSLjudo1@gmail.com","president"=>"WEERASINGHE Manjula"],
            ["region"=>"S","name"=>"Pakistan","abbr"=>"PAKISTAN","title"=>" Pakistan Judo Federation","address"=>" 1168-A Ghalib Street Peshawa Cantonment 25000 Peshawar","phone"=>"Phone : (92-91) 527 5627","web"=>" pjfpakistan.com","email"=>"Email","president"=>"ALAM Junaid"],
            ["region"=>"S","name"=>"Bhutan","abbr"=>"BHUTAN","title"=>" Bhutan Judo Association","address"=>" Tashi Pelkhil Village 11001 THIMPHU CITY","phone"=>"Phone : +97517110083","web"=>"","email"=>" bhutanjudo@gmail.com","president"=>"DORJI Karma"]
        ];

        $data=[
            ["region"=>"L","name"=>"澳門柔道館","abbr"=>"MJA","title"=>"Macao Judo Association","address"=>"澳門德勝體育館","phone"=>"Phone : 28523909","web"=>"macaojudo.org.mo","email"=>"info@macaujudo.org.mo","president"=>"--"],
            ["region"=>"L","name"=>"宣道堂柔道館","abbr"=>"STT","title"=>"Centro Comunitario Sun Tou Tong","address"=>"高士德大馬路100號宣道堂三樓","phone"=>"Phone : ","web"=>"--","email"=>"--","president"=>"--"],
            ["region"=>"L","name"=>"澳門培正中學","abbr"=>"PCS","title"=>"Pui Cheng Middle School",'address'=>"澳門培正中學","phone"=>"Phone : ","web"=>"--","email"=>"--","president"=>"--"],
            ["region"=>"L","name"=>"澳門化地瑪中學","abbr"=>"NSF","title"=>"Escola Nossa Senhora de Fátima",'address'=>"澳門培正中學","phone"=>"Phone : ","web"=>"--","email"=>"--","president"=>"--"],
        ];
        foreach($data as $org){
            DB::table('organizations')->insert([
                'region'=>$org['region'],
                'territory'=>$org['name'],
                'abbr'=>$org['abbr'],
                'full_name'=>$org['title'],
                'title'=>$org['title'],
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

