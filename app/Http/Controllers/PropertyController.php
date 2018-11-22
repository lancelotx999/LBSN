<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Property;
use App\Rating;
use App\Review;
use App\User;

class PropertyController extends Controller
{
   // Apply auth middleware so only authenticated users have access
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all properties if user is admin / normal user
    // Shows only user properties if user is a merchant
    public function index()
    {
        return $this->showUserProperties(Auth::user()->id);
    }

    // Gets all properties
    public function showAll()
    {
    	$properties = Property::all();

        foreach ($properties as $property)
        {
            $ratings = Rating::where('ratee_id','=', $property->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0)
            {
                foreach ($ratings as $rating)
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $property->rate = $totalRates/$totalUsers;

            }
            else
            {
                $property->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $property->id)->get();

            foreach ($reviews as $review)
            {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $property->reviews = $reviews;
        }

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create', compact('user_properties'));
    }


    public function store(Request $request)
    {
        // dd($request);
        // Validation Logic
        $this->validate($request,
            [
                'owner_id' => 'required',
                'name' => 'required',
                'address' => 'required',
                'description' => 'required',
                'status' => 'required',
                // 'tags' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

        // create a new Property based on input
        $property = new Property;
        $images = [];

        if ($request->hasFile('imageData')) {
            $file = $request->file('imageData');
            $imageData = base64_encode(file_get_contents($request->file('imageData')));

            if ($file->getMimeType() == "image/png") {
                $imageData = "data:image/png;base64," . $imageData;
            }
            else if ($file->getMimeType() == "image/jpeg") {
                $imageData = "data:image/jpeg;base64," . $imageData;
            }

            $image = new \stdClass();

            $image->name = $request->imageName;
            $image->description = $request->imageDescription;
            $image->data = $imageData;

            array_push($images, $image);
        }

        // dd($images);

        $property->owner_id = $request->owner_id;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->status = $request->status;
        $property->images = $images;
        // $property->tags = $request->tags;
        $property->latitude = $request->latitude;
        $property->longitude = $request->longitude;
        $property->verified = false;

        // dd($property);
        $property->save();

        return redirect()->route('property.index');
    }


    public function show($id)
    {
        $property = Property::findOrFail($id);
        $ratings = Rating::where('ratee_id','=', $id)->get();

        $totalRates = 0;
        $totalUsers = count($ratings);

        if ($totalUsers > 0)
        {
            foreach ($ratings as $rating)
            {
                $totalRates = $totalRates + $rating->rate;
            }

            $property->rate = $totalRates/$totalUsers;

        }
        else
        {
            $property->rate = 0;
        }

        $reviews = Review::where('reviewee_id','=', $id)->get();

        foreach ($reviews as $review)
        {
            $user = User::findOrFail($review->reviewer_id);
            $review->user = $user;
        }

        $property->reviews = $reviews;

        $holder = array();
        // dd($property->images);
        // dd($property);
        foreach ($property->images as $key) {
            $image = new \stdClass();

            $image->name = $key['name'];
            $image->description = $key['description'];
            $image->data = $key['data'];

            array_push($holder,$image);
        }
        $property->images = $holder;



        return view('properties.show', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        $holder = array();
        // dd($property->images);
        // dd($property);
        foreach ($property->images as $key) {
            $image = new \stdClass();

            $image->name = $key['name'];
            $image->description = $key['description'];
            $image->data = $key['data'];

            array_push($holder,$image);
        }
        $property->images = $holder;

        // dd($property);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $property = Property::findOrFail($id);

        $holder = array();
        // dd($property->images);
        // dd($property);
        foreach ($property->images as $key) {
            $image = new \stdClass();

            $image->name = $key['name'];
            $image->description = $key['description'];
            $image->data = $key['data'];

            array_push($holder,$image);
        }

        // dd($property);

        if ($request->hasFile('imageData')) {
            $file = $request->file('imageData');
            $imageData = base64_encode(file_get_contents($request->file('imageData')));

            if ($file->getMimeType() == "image/png") {
                $imageData = "data:image/png;base64," . $imageData;
            }
            else if ($file->getMimeType() == "image/jpeg") {
                $imageData = "data:image/jpeg;base64," . $imageData;
            }

            $image = new \stdClass();

            $image->name = $request->imageName;
            $image->description = $request->imageDescription;
            $image->data = $imageData;


            array_push($holder, $image);
        }

        $property->images = $holder;


        $property->owner_id = $request->owner_id;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->status = $request->status;
        $property->tags = $request->tags;
        $property->latitude = $request->latitude;
        $property->longitude = $request->longitude;
        $property->verified = $request->verified;

        // dd($property);
        $property->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        Property::findOrFail($id)->delete();

        return redirect()->back();
    }

    // Gets all the properties associated with specified user
    public function showUserProperties($owner_id)
    {
        $properties = Property::where('owner_id','=',$owner_id)->get();

        foreach ($properties as $property)
        {
            $ratings = Rating::where('ratee_id','=', $property->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0)
            {
                foreach ($ratings as $rating)
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $property->rate = $totalRates/$totalUsers;

            }
            else
            {
                $property->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $property->id)->get();

            foreach ($reviews as $review)
            {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $property->reviews = $reviews;
        }

        return view('properties.index', compact('properties'));
    }

}
