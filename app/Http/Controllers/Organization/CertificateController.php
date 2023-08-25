<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organization;
use App\Models\Certificate;
use App\Models\Config;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Certificate::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Organization/Certificates',[
            'certificates'=>session('organization')->fresh()->certificates,
            'certificate_categories'=>Config::item('certificate_categories')
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
        $data=$request->all();
        // $data['organization_id']=session('organization')->id;
        // Certificate::create($data);

        $certificate= new Certificate($data);
        $certificate->organization()->associate(session('organization'));
        $certificate->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        return redirect(route('organization.certificate.memebers',[$organization->id,$certificate->id]));
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
    public function update(Request $request, Certificate $certificate)
    {
        $certificate->update($request->all());
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

    public function members(Organization $organization, Certificate $certificate){
        $this->authorize('view',$organization);
        $this->authorize('view',$certificate);
        return Inertia::render('Organization/CertificateMember',[
            'organization'=>$organization,
            'certificate'=>$certificate,
            'members'=>$certificate->members
        ]);
        
    }
}
