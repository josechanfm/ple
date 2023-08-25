<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organization;
use App\Models\Member;
use App\Models\User;
use App\Exports\MemberExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Password;

class MemberController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Organization::class);
        $this->authorizeResource(Member::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $org=Organization::find(session('organization')->id)->members;

        // session('organization')->fresh;
        // dd(session('organization')->members);
        return Inertia::render('Organization/Members',[
            //'members'=>session('organization')->members
            'members'=>Organization::find(session('organization')->id)->members
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
        $member= Member::create($request->all());
        $member->organizations()->attach(session('organization')->id);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return Inertia::render('Organization/MemberShow',[
            'member'=>$member,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization, Member $member)
    {
        // return Inertia::render('Organization/MemberEdit',[
        //     //'member'=>$member->belongsToOrganization($organization)->first(),
        //     'member'=>$member,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $member->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if($member->ownedBy(session('organization'))){
            $member->organizations()->detach();
            $member->delete();
        }
        return redirect()->back();
    }

    public function createLogin(Member $member){
        $this->authorize('update',$member);
        if (empty($member->user)) {
            $user=User::where('email',$member->email);
            if($user){
                return response()->json(['result'=>false,'message'=>'Email already in used!']);
            }else{
                $user = $member->createUser();
            }
        } else {
            return response()->json(['result'=>false,'message'=>'Login Account already created!']);
            $user = $member->user;
        }
        Password::broker(config('fortify.passwords'))->sendResetLink(
            [ 'email' => $user->email ]
        );
        return response()->json(['result'=>true,'message'=>'Login account created, please check you email.']);
    }
    public function export(){
        return Excel::download(new MemberExport, 'member.xlsx');
    }
}
