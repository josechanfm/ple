<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Bulletin;
use App\Models\BulletinImage;
use App\Models\Config;
use Facebook\Facebook;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use stdClass;

class BulletinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->per_page)) {
            $per_page = 10;
        } else {
            $per_page = $request->per_page;
        }
        $bulletins = Bulletin::with('images')->paginate($per_page);
        // dd(Config::item('bulletin_categories'));
        // dd($bulletins);

        return Inertia::render('Organization/Bulletins', [
            'bulletins' => $bulletins,
            'bulletinCategories' => Config::item('bulletin_categories'),
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
        // $fb = new Facebook([
        //     'app_id' => env('FACEBOOK_APP_ID'),
        //     'app_secret' => env('FACEBOOK_APP_SECRET'),
        //     'default_graph_version' => env('DEFAULT_GRAPH_VERSION'),
        // ]);

        $bulletin = new Bulletin;

        $bulletin->category = $request->category;
        $bulletin->description = $request->descripiton;
        $bulletin->published = $request->published;
        $bulletin->date = $request->date;
        $bulletin->title = $request->title;
        $bulletin->content = $request->content;
        $bulletin->created_by = Auth()->user()->id;
        $bulletin->save();
        // dd($request->file('images'));

        if ($request->file('images') != null) {
            foreach ($request->file('images') as $idx => $image) {
                // $bulletin->addMedia($image['originFileObj'])->toMediaCollection('bulletin');
                $path = Storage::putFile('public/images/bulletin', $image['originFileObj']);

                $bulletin_image = new BulletinImage;
                $bulletin_image->bulletin_id = $bulletin->id;
                $bulletin_image->image_path = $path;

                $params = array(
                    'url' => url('/') . Storage::url($path),
                    'published' => 'false'
                );
                /** facebook */
                // try {
                //     // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                //     // If you provided a 'default_access_token', the '{access-token}' is optional.
                //     $response = $fb->post('/me/photos', $params, env('FACEBOOK_ACCESS_TOKEN'));
                //     $bulletin_image->facebook_id = $response->getDecodedBody()['id'];
                // } catch (Exception $e) {
                //     // When Graph returns an error
                //     exit;
                // }
                $bulletin_image->save();

                if ($idx == 0) {
                    $bulletin->cover_image_path = $path;
                    $bulletin->save();
                }
            }
        }
        $bulletin_images = BulletinImage::where('bulletin_id', $bulletin->id)->get();
        $params = array('message' => $bulletin->content, 'published' => $bulletin->published);
        foreach ($bulletin_images as $key => $bi) {
            $params["attached_media[$key]"] = "{'media_fbid':'$bi->facebook_id'}";
        }
        // try {
        //     // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        //     // If you provided a 'default_access_token', the '{access-token}' is optional.
        //     $response = $fb->post('/me/feed', $params, env('FACEBOOK_ACCESS_TOKEN'));
        //     $bulletin->post_id = $response->getDecodedBody()['id'];
        //     $bulletin->save();
        //     return redirect()->back();
        // } catch (Exception $e) {
        //     // When Graph returns an error
        //     return redirect()->back()->withErrors(['error' => '新增成功,上傳facebook失敗']);
        //     exit;
        // }
        // dd($request);
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
    public function update(Request $request, $id)
    {
        // $fb = new Facebook([
        //     'app_id' => env('FACEBOOK_APP_ID'),
        //     'app_secret' => env('FACEBOOK_APP_SECRET'),
        //     'default_graph_version' => env('DEFAULT_GRAPH_VERSION'),
        // ]);

        $bulletin = Bulletin::find($id);
        $bulletin->category = $request->category;
        $bulletin->description = $request->description;
        $bulletin->published = $request->published;
        $bulletin->date = $request->date;
        $bulletin->title = $request->title;
        $bulletin->content = $request->content;
        $bulletin->updated_by = Auth()->user()->id;

        $bulletin->save();

        $bulletin_images = BulletinImage::where('bulletin_id', $id)->get()->toArray();
        $result = array_diff(array_column($bulletin_images, 'id'), array_column($request->images, 'id'));

        foreach ($result as $r) {
            BulletinImage::where('id', $r)->delete();
        }

        if ($request->file('images') != null) {
            foreach ($request->file('images') as $idx => $image) {
                // $bulletin->addMedia($image['originFileObj'])->toMediaCollection('bulletin');
                $path = Storage::putFile('public/images/bulletin', $image['originFileObj']);

                $bulletin_image = new BulletinImage;
                $bulletin_image->bulletin_id = $bulletin->id;
                $bulletin_image->image_path = $path;

                $params = array(
                    'url' => url('/') . Storage::url($path),
                    'published' => 'false'
                );

                // try {
                //     // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                //     // If you provided a 'default_access_token', the '{access-token}' is optional.
                //     $response = $fb->post('/me/photos', $params, env('FACEBOOK_ACCESS_TOKEN'));
                //     $bulletin_image->facebook_id = $response->getDecodedBody()['id'];
                // } catch (Exception $e) {
                //     // When Graph returns an error
                //     return redirect()->back()->withErrors(['error' => '更新相片成功,facebook更新相片失敗']);
                //     exit;
                // }
                $bulletin_image->save();
            }
        }
        $bulletin_image = BulletinImage::where('bulletin_id', $bulletin->id)->first();
        if ($bulletin_image != null) {
            $bulletin->cover_image_path = $bulletin_image->image_path;
            $bulletin->save();
        }
        // if ($bulletin->post_id != null) {
        //     $bulletin_images = BulletinImage::where('bulletin_id', $bulletin->id)->get();
        //     $params = array('message' => $bulletin->content, 'published' => $bulletin->published);
        //     foreach ($bulletin_images as $key => $bi) {
        //         $params["attached_media[$key]"] = "{'media_fbid':'$bi->facebook_id'}";
        //     }
        //     try {
        //         // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        //         // If you provided a 'default_access_token', the '{access-token}' is optional.
        //         $response = $fb->post("/$bulletin->post_id", $params, env('FACEBOOK_ACCESS_TOKEN'));
        //         return redirect()->back();
        //     } catch (Exception $e) {
        //         // When Graph returns an error
        //         return redirect()->back()->withErrors(['error' => '更新成功,facebook更新失敗']);
        //     }
        // }
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
        $bulletin = Bulletin::where('id', $id)->first();

        $bulletin->delete();

        return redirect()->back();
        //
    }
    public function save_test(Request $request)
    {
    }
}
