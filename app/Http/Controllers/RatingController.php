<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
   // Apply auth middleware so only authenticated users have access
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // List all ratings if user is admin 
    // Shows only user ratings if user is a merchant / normal user
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $ratings = Rating::all();
            return view('ratings.index', compact('ratings'));
        }
        else
        {
        	$sent_ratings = Rating::where('rater_id','=',Auth::user()->id)->get();
        	$received_ratings = Rating::where('ratee_id','=',Auth::user()->id)->get();
        	return view('ratings.index', compact('sent_ratings','received_ratings'));
        }          
    }

    // Gets all ratings
    public function showAll()
    {
        $ratings = Rating::all();
        return view('ratings.index', compact('ratings'));
    }

    // Gets all the ratings associated with specified user
    public function showUserAllRatings($user_id)
    {
    	$ratings = Rating::where('rater_id','=', $user_id)-> orWhere('ratee_id','=', $user_id)->get();
    	return view('ratings.index', compact('ratings'));
    }

    public function showUserRaters($user_id)
    {
    	$ratings = Rating::where('rater_id','=', $user_id)->get();
    	return view('ratings.index', compact('ratings'));
    }

    public function showUserRatees($user_id)
    {
    	$ratings = Rating::where('ratee_id','=', $user_id)->get();
    	return view('ratings.index', compact('ratings'));
    }

    public function create(Request $request, Invoice $invoice)
    {
        $user_ratings = Rating::where('owner_id','=',Auth::user()->id)->get();
        $ratings = $user_ratings->take(10)->get();

        return view('ratings.create', compact('ratings'));
    }


    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request, 
        [
            'rater_id' => 'required',
            'ratee_id' => 'required',
            'rate' => 'required',
        ]);

        // create a new Rating based on input
        $rating = new Rating;

        $rating->rater_id = $request->rater_id;
        $rating->ratee_id = $request->ratee_id;
        $rating->rate = $request->rate;

        $rating->save();     

        return redirect()->back();
    }


    public function show($id)
    {
        $rating = Rating::findOrFail($id);

        return view('ratings.show', compact('rating'));
    }

    public function edit($id)
    {
        $rating = Rating::findOrFail($id);

        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::findOrFail($id);
        
        $rating->rater_id = $request->rater_id;
        $rating->ratee_id = $request->ratee_id;
        $rating->rate = $request->rate;

        $rating->save();  

        return redirect()->route('ratings.edit', ['rating' => $rating ]);
    }

    public function destroy($id)
    {
        Rating::findOrFail($id)->delete();

        return redirect()->back();
    }

}
