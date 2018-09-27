<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // apply auth middleware so only authenticated users have access
	// public function __construct() {
	// 	$this->middleware('auth');
	// }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Location $locations)
    {
        // get all the tasks based on current user id
		$allLocations = $location->whereIn('locationOwnerID', $request->user())->with('user');
        // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
		$locations = $allLocations->take(10)->get();

		// return json response
		return response()->json([
			'locations' => $locations,
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
     public function store(Request $request) {
 		// validate
 		$this->validate($request, [
            'locationOwnerIDInput' => 'required|max:100',
            // 'locationNameInput' => 'required|max:100',
            // 'locationAddressInput' => 'max:255',
            // 'locationDescriptionInput' => 'max:255',
            // 'locationStatusInput' => 'required|max:255',
            // 'locationRatingInput' => 'required',
            // 'locationLatitudeInput' => 'required',
            // 'locationLongitudeInput' => 'required',
 		]);
 		// create a new location based on user locations relationship
 		$location = $request->user()->locations()->create([
            'locationOwnerID' => $request->locationOwnerIDInput,
            // 'locationName' => $request->locationNameInput,
            // 'locationAddress' => $request->locationAddressInput,
            // 'locationDescription' => $request->locationDescriptionInput,
            // 'locationStatus' => $request->locationStatusInput,
            // 'locationRating' => $request->locationRatingInput,
            // 'locationLatitude' => $request->locationLatitudeInput,
            // 'locationLongitude' => $request->locationLongitudeInput,
 		]);
 		// return location with user object
 		return response()->json($location->with('user')->find($location->locationID));
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
