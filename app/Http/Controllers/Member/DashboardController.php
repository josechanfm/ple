<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Classify;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Form;
use App\Models\Member;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {

        $member = Auth()->user()->member;
        if (!$member) {
            return Inertia::render('Error', [
                'message' => "You are not a register member."
            ]);
        }
        //dd(Config::item('card_style'));
        $member->organizations;
        return Inertia::render('Member/Dashboard', [
            'member' => $member,
            // 'organizations'=>$member->organizations,
            'articles' => Article::privates(),
            'card_style' => Config::item('card_style')->{session('organization')->card_style},
            //'current_organization'=>session('organization'),//set current_organization, coz the first access has not activate session variable yet.
            //'articles'=>Classify::whereBelongsTo(session('organization'))->first()->articles
        ]);
    }
    public function getQrcode()
    {
        $userId = auth()->user()->id;
        $memberId = auth()->user()->id;
        $organizationId = session('organization')->id;
        $time = time();
        $text = $organizationId . ',' . $memberId . ',' . $time;
        return $text . ',' . hash('crc32', $text);

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
