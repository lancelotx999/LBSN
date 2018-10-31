<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    // apply auth middleware so only authenticated users have access
	public function __construct() {
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Location $location)
    {
        // // get all the locations based on current user id
		// $allLocations = $location->whereIn('user_id', $request->user())->with('user');
        // // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
		// $locations = $allLocations->take(10)->get();
        //
		// // return json response
		// return response()->json([
		// 	'locations' => $locations,
		// ]);

		$locations = Location::with('user')->get();
		return view('locations.all', compact('locations'));
    }

	public function allLocations(){
		// $locations = $locations->with('user');

		// $a=array("red","green");
		// array_push($a,"blue","yellow");
		// print_r($a);

		// $location = Location::findOrFail($id);
		// return response()->json($location->with('user')->find($location->_id));
		// return response()->json($locations->with('user')->find($locations->_id));
		// return response()->json($locations->with('user')->find($location->_id));
		// return response()->json($locations);
		// return response()->json($locations->with('user'));
		// return response()->json([
		// 	'locations' => $locations,
		// ]);
		$locations = Location::with('user')->get();
		return view('locations.all', compact('locations'));

	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Location $location)
    {
		// get all the locations based on current user id
		// $allLocations = $location->whereIn('user_id', $request->user())->with('user');
        // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
		// $locations = $allLocations->take(10)->get();

        return view('locations.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request) {
 		// validate
 		$this->validate($request, [
            // 'locationOwnerID' => 'required|max:100',
            'locationName' => 'required',
            'locationStatus' => 'required',
            'locationRating' => 'required',
            'locationLatitude' => 'required',
            'locationLongitude' => 'required',
 		]);
 		// create a new location based on user locations relationship
 		$location = $request->user()->locations()->create([
            // 'locationOwnerID' => $request->locationOwnerID,
            'locationName' => $request->locationName,
            'locationAddress' => $request->locationAddress,
            'locationDescription' => $request->locationDescription,
            'locationStatus' => $request->locationStatus,
            'locationRating' => $request->locationRating,
            'locationLatitude' => $request->locationLatitude,
            'locationLongitude' => $request->locationLongitude,
 		]);

 		// return location with user object
 		// return response()->json($location->with('user')->find($location->_id));
        return redirect()->route('location.create');
 	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// // get all the locations based on current user id
		// $allLocations = $location->whereIn('user_id', $request->user())->with('user');
        // // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
		// $locations = $allLocations->take(10)->get();
        //
        // return view('locations.register', compact('locations'));

		$location = Location::with('user')->findOrFail($id);

		return view('locations.view', compact('location'));
    }

	// // get all the locations based on current user id
	// $allLocations = $location->whereIn('user_id', $request->user())->with('user');
	// // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
	// $locations = $allLocations->take(10)->get();
    //
	// // return json response
	// return response()->json([
	// 	'locations' => $locations,
	// ]);

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$location = Location::with('user')->findOrFail($id);

        return view('locations.edit', compact('location'));
		// return response()->json([
		// 	'location' => $location,
		// ]);
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
		$input = $request->all();
		$location = Location::with('user')->findOrFail($id);
		$location->update($input);
		return redirect()->route('location.edit', ['location' => $location ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::findOrFail($id)->delete();

        return redirect()->back();
    }
}
