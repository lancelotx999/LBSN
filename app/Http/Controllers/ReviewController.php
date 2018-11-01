<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Review;

class ReviewController extends Controller
{
   // Apply auth middleware so only authenticated users have access
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // List all reviews if user is admin 
    // Shows only user reviews if user is a merchant / normal user
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $reviews = Review::all();
            return view('reviews.index', compact('reviews'));
        }
        else
        {
        	$sent_reviews = Review::where('reviewer_id','=',Auth::user()->id)->get();
        	$received_reviews = Review::where('reviewee_id','=',Auth::user()->id)->get();
        	return view('reviews.index', compact('sent_reviews','received_reviews'));
        }          
    }

    // Gets all reviews
    public function showAll()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    // Gets all the reviews associated with specified user
    public function showUserAllReviews($user_id)
    {
    	$reviews = Review::where('reviewer_id','=', $user_id)-> orWhere('reviewee_id','=', $user_id)->get();
    	return view('reviews.index', compact('reviews'));
    }

    public function showUserReviewers($user_id)
    {
    	$reviews = Review::where('reviewer_id','=', $user_id)->get();
    	return view('reviews.index', compact('reviews'));
    }

    public function showUserReviewee($user_id)
    {
    	$reviews = Review::where('reviewee_id','=', $user_id)->get();
    	return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $user_reviews = Review::where('reviewer_id','=',Auth::user()->id)->get();
        $reviews = $user_reviews->take(10)->get();

        return view('reviews.create', compact('reviews'));
    }


    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request, 
        [
            'reviewer_id' => 'required',
            'reviewee_id' => 'required',
            'content' => 'required',
        ]);

        // create a new Review based on input
        $review = new Review;

        $review->reviewer_id = $request->reviewer_id;
        $review->reviewee_id = $request->reviewee_id;
        $review->content = $request->content;

        $review->save();     

        return redirect()->back();
    }


    public function show($id)
    {
        $review = Review::findOrFail($id);

        return view('reviews.show', compact('review'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $review->reviewer_id = $request->reviewer_id;
        $review->reviewee_id = $request->reviewee_id;
        $review->content = $request->content;

        $review->save();  

        return redirect()->route('reviews.edit', ['review' => $review ]);
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();

        return redirect()->back();
    }

}
