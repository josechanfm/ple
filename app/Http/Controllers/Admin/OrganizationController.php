<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organization;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations=Organization::with('users')->get();
        // dd($organizations);
        return Inertia::render('Admin/Organizations',[
            'organizations'=>$organizations,
            'users'=>User::all()
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
        Organization::create($request->all());
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
    public function update(Request $request, Organization $organization)
    {
        $organization->update($request->all());
        $organization->users()->sync($request->user_ids);
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->back();

    }

    public function members(Organization $organization){
        //$members=Member::whereBelongsTo($)->get();
        return Inertia::render('Admin/OrganizationMembers',[
            'members'=>$organization->members,
        ]);

    }
    public function createLogin(Member $member){

        if (!$member->hasUser()) {
            $user = $member->createUser();
        } else {
            $user = $member->user;
        }

        Password::broker(config('fortify.passwords'))->sendResetLink(
            [ 'email' => $user->email ]
        );

    }
}
