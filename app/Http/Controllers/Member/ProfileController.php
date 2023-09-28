<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Approbate;
use App\Models\Portfolio;
use App\Models\Position;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $portfolio=auth()->user()->member->portfolio;
        // if(empty($portfolio)){
        //     $portfolio=new Portfolio;
        //     $portfolio->member_id=auth()->user()->member->id;
        //     $portfolio->approbate_id=1;
        //     $portfolio->save();
        // }
        $member = auth()->user()->member;
        if($member==null){ return redirect()->back();};
        $member->positions;
        $member->athlete;
        return Inertia::render('Member/Profile', [
            'member' => $member,
            // 'profile'=>$portfolio,
            'positions' => Position::all()
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        dd($request->file());
        $data = $request->all();
        $member = Member::find($id);
        //$data['positions']=$request->positions;
        $member->update($data);

        if($request->file('avatar')){
            if($member->avatar!=null){
                if(Storage::exists($member->avatar)){
                    Storage::delete($member->avatar);
                }
            }
            $file = $request->file('avatar');
            $path = Storage::putFile('public/images/avatar', $file);
            $member->avatar = $path;
            $member->save();

        }

        return redirect()->back();
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
