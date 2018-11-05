<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Receipt;
use App\Contract;

class ReceiptController extends Controller
{
  // Apply auth middleware so only authenticated users have access
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // List all receipts if user is admin 
    // Shows only user receipts if user is a merchant / normal user
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $receipts = Receipt::all();
            return view('receipts.index', compact('receipts'));
        }
        else
        {
            $contracts = Contract::where('provider_id','=', Auth::user()->id)-> orWhere('receiver_id','=', Auth::user()->id)->get();
            
            $receipts = Receipt::where('contract_id','=',Auth::user()->id)->get();
            return view('receipts.index', compact('receipts'));
        }          
    }

    // Gets all reviews
    public function showAll()
    {
        $receipts = Receipt::all();
        return view('receipts.index', compact('receipts'));
    }

    // Gets all the receipts associated with specified user
    public function showUserReceipts($user_id)
    {
        $contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();

        $receipts = Receipt::where('reviewer_id','=', $user_id)-> orWhere('reviewee_id','=', $user_id)->get();

        dd($contracts);
        return view('receipts.index', compact('receipts'));
    }

    public function test()
    {
        $user_id = '5bdfe2db84220c09e56acd43';
        $counter = 0;

        $contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();

        foreach ($contracts as $contract)
        {
            $receipts = Receipt::where('contract_id','=', $contract->id)->get();
            $counter++;
        }

        dd($receipts);
    }

    public function create(Request $request, Invoice $invoice)
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
