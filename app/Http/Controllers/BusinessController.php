<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Auth;
use Moloquent;
use App\Business;
use App\User;

class BusinessController extends Controller
{
   // Apply auth middleware so only authenticated users have access
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Returns all businesses if user is admin / normal user
    // Returns both all businesses and the owned businesses if merchant
    public function index()
    {
       return $this->showUserBusinesses(Auth::user()->id);
    }

    // Gets all bussinesses
    public function showAll()
    {
    	$businesses = Business::all();

        foreach ($businesses as $business)
        {
            $ratings = Rating::where('ratee_id','=', $business->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0)
            {
                foreach ($ratings as $rating)
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $business->rate = $totalRates/$totalUsers;

            }
            else
            {
                $business->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $business->id)->get();

            foreach ($reviews as $review)
            {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $business->reviews = $reviews;
        }

        return view('businesses.index', compact('businesses'));
    }

    // Gets all the bussinesses associated with specified user

    public function create()
    {
        return view('businesses.create');
    }


    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request,
            [
                'owner_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'services' => 'required',
                'contact_number' => 'required',
            ]);

        // create a new Business based on input
        $business = new Business;

        $business->owner_id = $request->owner_id;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->services = array_filter($request->services, function($var){return !is_null($var);} );
        $business->contact_number = $request->contact_number;
        $business->verified = false;

        $business->save();

        return redirect()->route('business.index');
    }

    public function show($id)
    {
        $business = Business::findOrFail($id);
        $ratings = Rating::where('ratee_id','=', $id)->get();

        $totalRates = 0;
        $totalUsers = count($ratings);

        if ($totalUsers > 0)
        {
            foreach ($ratings as $rating)
            {
                $totalRates = $totalRates + $rating->rate;
            }

            $business->rate = $totalRates/$totalUsers;

        }
        else
        {
            $business->rate = 0;
        }

        $reviews = Review::where('reviewee_id','=', $id)->get();

        foreach ($reviews as $review)
        {
            $user = User::findOrFail($review->reviewer_id);
            $review->user = $user;
        }

        $business->reviews = $reviews;

        return view('businesses.show', compact('business'));
    }

    public function edit($id)
    {
        $business = Business::findOrFail($id);

        return view('businesses.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);

        $business->owner_id = $request->owner_id;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->services = array_filter($request->services, function($var){return !is_null($var);} );
        $business->contact_number = $request->contact_number;
        $business->verified = $request->verified;

        $business->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        Business::findOrFail($id)->delete();

        return redirect()->back();
    }

    public function showUserBusinesses($owner_id)
    {
        $businesses = Business::where('owner_id','=',$owner_id)->get();

        foreach ($businesses as $business)
        {
            $ratings = Rating::where('ratee_id','=', $business->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0)
            {
                foreach ($ratings as $rating)
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $business->rate = $totalRates/$totalUsers;

            }
            else
            {
                $business->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $business->id)->get();

            foreach ($reviews as $review)
            {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $business->reviews = $reviews;
        }

        return view('businesses.index', compact('businesses'));
    }

    public function uploadImage($id , Request $request)
    {
        Storage::disk('businesses')->put('hello.json', '{"hello": "world"}');

        // Storage::put('file.jpg', $contents);

    }

    public function test()
    {
        // $hello = "helloworld";
        //
        // Storage::disk('businesses')->put('hello.json', '{"hello": "world"}');
        // $path = Storage::disk('businesses')->url('hello.json');

        // $b64image = base64_encode(file_get_contents('http://www.onzehost.com.br/images/test-img.jpg'));
        //
        // $b64image = base64_decode($b64image);
        //


        $img_url = 'https://securitywatch.ie/media/catalog/product/t/e/test-logo-circle-black-transparent.png';
        $b64_url = 'php://filter/read=convert.base64-encode/resource='.$img_url;
        $b64_img = file_get_contents($b64_url);
        // echo $b64_img;

        $imageData = base64_decode($b64_img);
        $source = imagecreatefromstring($imageData);
        $angle = 90;
        $rotate = imagerotate($source, $angle, 0); // if want to rotate the image
        $imageName = "hello1.png";
        $imageSave = imagejpeg($rotate,$imageName,100);
        imagedestroy($source);

        $users = User::all();

        foreach ($users as $user) {
            $user->profile_image = $b64_img;
            // dd($user);
        }

        foreach ($users as $user) {
            base64_decode($user->profile_image);
            echo '<img src="data:image/png;base64,' . $user->profile_image . '" />';
            // dd($user);
        }





        // echo $imageSave;


        // dd($imageSave);
    }

}
