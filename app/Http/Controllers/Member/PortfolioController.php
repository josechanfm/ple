<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Approbate;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $portfolios=auth()->user()->member->portfolios;
        // if(empty($portfolio)){
        //     $portfolio=new Portfolio;
        //     $portfolio->member_id=auth()->user()->member->id;
        //     $portfolio->approbate_id=1;
        //     $portfolio->save();
        //     $portfolios=auth()->user()->member->portfolio;
        // }
        $member=auth()->user()->member;
        if($member==null){ return redirect()->back();};
        $member->portfolios;
        
        return Inertia::render('Member/Portfolios',[
            'member'=>$member,
            //'portfolios'=>$portfolios
        ]);

        // return Inertia::render('Member/Portfolios',[
        //     'portfolios' => auth()->user()->member->portfolios,
        //     'approbates'=>session('organization')->approbates,
        //     'member'=>auth()->user()->member
        // ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $portfolio= new Portfolio();
        $portfolio->member_id=auth()->user()->member->id;
        $portfolio->approbate_id=$request->approbate_id;
        $portfolio->abbreviation=$request->abbreviation;
        $portfolio->title=$request->title;
        $portfolio->description=$request->description;
        $portfolio->start_date=$request->start_date;
        $portfolio->end_date=$request->end_date;
        $portfolio->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        return Inertia::render('Member/PortfolioEdit',[
            'portfolio'=>$portfolio
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
