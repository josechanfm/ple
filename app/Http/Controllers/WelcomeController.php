<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Course;

class WelcomeController extends Controller
{
    public function index(){
        //dd(Article::publics());
        return Inertia::render('Welcome',[
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'phpVersion' => PHP_VERSION,
            'isMember' => Auth()->user() ? Auth()->user()->member : false,
            'isOrganizer' => Auth()->user() ? Auth()->user()->hasRole('organizer') : false,
            'articles' => Article::publics(),
            'courses'=>Course::recommends()
   
        ]);
    }
}
