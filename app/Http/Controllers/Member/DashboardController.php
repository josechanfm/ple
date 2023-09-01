<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Classify;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form;
use App\Models\Member;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {
        $member=Member::where('user_id',auth()->user()->id)->with('guardian')->first();
        //login user has guardian role
        if(auth()->user()->guardian){
            session(['guardian'=>auth()->user()->guardian]);
            return redirect()->route('member.guardian');
        }
        //login user is member

        if($member){
            // $organizations=$member->organizations;
            //$member->organization;
            if($member->organizations->count()<=0){
                dd("you don't belongs to any organization");
                return redirect()->route('/');
            }
            $member->portfolios;
            $member->events;
            $member->organizations[0]->forms;
            session(['organization'=>$member->organizations[0]]);
            //session('organization')->forms;
                
            //session('organization')->fresh();
            return Inertia::render('Member/Dashboard',[
                'member'=>$member,
                'organizations'=>$member->organizations,
                //'current_organization'=>session('organization'),
                //'articles'=>Classify::whereBelongsTo(session('organization'))->first()->articles
            ]);
        }

        //login user is organizer
        if (auth()->user()->hasRole(['organizer'])) {
            return redirect('manage');
        }

        //login user not a member but with specific roles
        if (auth()->user()->hasRole(['admin','master'])) {
            return redirect('admin');
        }
                
    }
    public function getQrcode()
    {
        $userId=auth()->user()->id;
        $memberId=auth()->user()->id;
        $organizationId= session('organization')->id;
        $time=time();
        $text=$organizationId.','.$memberId.','.$time;
        return $text.','.hash('crc32',$text);

        // $options = 0;
        // $ciphering = "AES-128-CTR";
        // $security_iv = '1234567891011121';
        // $security_key = "Linuxhint";

        // $plain_text = time().'0201'.'11234';
        // echo "Original String: " . $plain_text;
        // $iv_length = openssl_cipher_iv_length($ciphering);
        // $cipher_text = openssl_encrypt($plain_text, $ciphering,
        //             $security_key, $options, $security_iv);
        // echo '<br>';
        // echo "Encrypted String: " . $cipher_text . "\n";
        // $decryption=openssl_decrypt ($cipher_text, $ciphering,
        //         $security_key, $options, $security_iv);
        // echo '<br>';
        // echo "Decrypted String: " . $decryption;

    }
   
}
