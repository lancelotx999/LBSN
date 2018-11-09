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

        if (Auth::user()->role === 'admin')
        {
            $properties = Property::all();
        }
        else if (Auth::user()->role === 'merchant')
        {
            $user_properties = Property::where('owner_id','=',Auth::user()->id)->get();
            $properties = Property::all();

            return view('properties.index', compact('user_properties','properties'));
        }
        else
        {
        	$properties = Property::all();
        }

        return view('properties.index', compact('properties'));
    }

    // Gets all properties
    public function showAll()
    {
    	$properties = Property::all();

        foreach ($properties as $property) {
            $ratings = Rating::where('ratee_id','=', $property->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0) {
                foreach ($ratings as $rating) {
                    $totalRates = $totalRates + $rating->rate;
                }

                $property->rate = $totalRates/$totalUsers;

            }
            else {
                $property->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $property->id)->get();

            foreach ($reviews as $review) {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $property->reviews = $reviews;
        }

    	return view('properties.index', compact('properties'));
    }

    // Gets all the properties associated with specified user
    public function showUserProperties($owner_id)
    {
    	$user_properties = Property::where('owner_id','=', $owner_id)->get();
    	return view('properties.index', compact('user_properties'));
    }

    public function create()
    {
        $user_properties = Property::where('owner_id','=',Auth::user()->id)->get();

        return view('properties.create', compact('user_properties'));
    }


    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request,
        [
            'owner_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'status' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // create a new Property based on input
        $property = new Property;

        $property->owner_id = $request->owner_id;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->status = $request->status;
        $property->latitude = $request->latitude;
        $property->longitude = $request->longitude;
        $property->verified = false;

        $property->save();

        return redirect()->route('property.index');
    }


    public function show($id)
    {
        $property = Property::findOrFail($id);
        $users = User::all();

        $ratings = Rating::where('ratee_id','=', $id)->get();

        $totalRates = 0;
        $totalUsers = count($ratings);

        if ($totalUsers > 0) {
            foreach ($ratings as $rating) {
                $totalRates = $totalRates + $rating->rate;
            }

            $property->rate = $totalRates/$totalUsers;

        }
        else {
            $property->rate = 0;
        }

        $reviews = Review::where('reviewee_id','=', $id)->get();

        foreach ($reviews as $review) {
            $user = User::findOrFail($review->reviewer_id);
            $review->user = $user;
        }

        $property->reviews = $reviews;

        return view('properties.show', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->owner_id = $request->owner_id;
        $property->name = $request->name;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->status = $request->status;
        $property->latitude = $request->latitude;
        $property->longitude = $request->longitude;
        $property->verified = $request->verified;

        $property->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        Property::findOrFail($id)->delete();

        return redirect()->back();
    }

}
