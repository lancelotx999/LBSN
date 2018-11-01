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
        return view('users.index', compact('users'));
    }

    public function create()
    {
  
    }

    public function store(Request $request)
    {
      
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
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
            'role' => 'required'
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
}
