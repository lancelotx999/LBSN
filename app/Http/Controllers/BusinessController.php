<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Business;
use App\Rating;
use App\Review;

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
        if (Auth::user()->role === 'admin')
        {
            $businesses = Business::all();
            return view('businesses.index', compact('businesses'));
        }
        else
        {   
            return $this->showUserBusinesses(Auth::user()->id); 
        }  

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

}
