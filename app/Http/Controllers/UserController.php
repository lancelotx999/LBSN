<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Business;
use App\Contract;
use App\Property;
use App\Receipt;
use App\Rating;
use App\Review;

class UserController extends Controller
{
  // Apply auth middleware so only authenticated users have access
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all Users if user is admin
    // Shows only self if user is a merchant / normal user
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $users = User::all();
            return view('users.index', compact('users'));
        }
        else
        {
            $users = Auth::user();
            return view('users.index', compact('users'));
        }
    }

    // Gets all reviews
    public function showAll()
    {
        $users = User::all();

        foreach ($users as $user)
        {

            $ratings = Rating::where('ratee_id','=', $user->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0)
            {
                foreach ($ratings as $rating)
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $user->rate = $totalRates/$totalUsers;

            }
            else
            {
                $user->rate = 0;
            }
            $reviews = Review::where('reviewee_id','=', $user->id)->get();

            foreach ($reviews as $review)
            {
                $reviewer = User::findOrFail($review->reviewer_id);
                $review->user = $reviewer;
            }

            $user->reviews = $reviews;

        }
        return view('users.index', compact('users'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function getContract($id)
    {
        $user = User::findOrFail($id);

        return view('users.contract', compact('user'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $users = User::all();
        $properties = Property::all();

        $ratings = Rating::where('ratee_id','=', $id)->get();

        $totalRates = 0;
        $totalUsers = count($ratings);

        if ($totalUsers > 0)
        {
            foreach ($ratings as $rating)
            {
                $totalRates = $totalRates + $rating->rate;
            }

            $user->rate = $totalRates/$totalUsers;

        }
        else
        {
            $user->rate = 0;
        }

        $reviews = Review::where('reviewee_id','=', $id)->get();

        foreach ($reviews as $review)
        {
            $user = User::findOrFail($review->reviewer_id);
            $review->user = $user;
        }

        $user->reviews = $reviews;

        return view('users.show', compact('user', 'users', 'properties'));
    }

    public function showUserDetails($user_id)
    {
        $businesses = Business::where('owner_id','=', $user_id)->get();
        $sent_contracts = Contract::where('provider_id','=',$user_id)->get();
        $received_contracts = Contract::where('receiver_id','=',$user_id)->get();
        $properties = Property::where('owner_id','=',$user_id)->get();
        $sent_ratings = Rating::where('rater_id','=',$user_id)->get();
        $received_ratings = Rating::where('ratee_id','=',$user_id)->get();
        $sent_reviews = Review::where('reviewer_id','=',$user_id)->get();
        $received_reviews = Review::where('reviewee_id','=',$user_id)->get();

        $receipts = collect();
        $contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();

        foreach ($contracts as $contract)
        {
            $receipt = Receipt::whereIn('contract_id',[$contract->id])->get()->first();
            $receipts->push($receipt);
        }

        return view('users.show', compact('user','businesses','sent_contracts','received_contracts','properties','sent_ratings','received_ratings','sent_reviews','received_reviews','receipts'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

         $this->validate($request(),
        [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:6|confirmed',
            'contact_number' => 'required',
            'role' => 'required',
            'verified' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->contact_number = $request->contact_number;
        $user->role = $request->role;
        $user->verified = $request->verified;

        $user->save();
        // redirect
        return redirect()->route('users.show', ['user' => $user ])->with('status', 'Profile successfully updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back();
    }

    public function test(){
        $id = "5be59efc339b574ea07c0ea2";
        $user = User::findOrFail($id);

        $reviews = Review::where('reviewee_id','=', $id)->get();

        foreach ($reviews as $review)
        {
            $user = User::findOrFail($review->reviewer_id);
            $review->user = $user;
        }

        $user->reviews = $reviews;

        dd($user);

    }

}
