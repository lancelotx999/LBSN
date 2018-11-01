<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Business;
use App\Contract;
use App\Property;
use App\Receipt;
use App\Rating;
use App\Review;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
        $user = Auth::user();
        $users = User::all();
        $user_properties = Property::where('owner_id','=', $owner_id)->get();
  
        return view('users.show', compact('user', 'users', 'locations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(User $user)
    {   
        $user = Auth::user();
        $users = User::all();
        return view('users.edit', compact('user', 'users'));
    }

    public function update(User $user)
    { 
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'role' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $user->name = request('name');
        $user->email = request('email');
        $user->role = request('role');
        $user->password = bcrypt(request('password'));

        $user->save();

        // redirect
        return redirect()->route('users.show', ['user' => $user ])->with('status', 'Profile successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(User $user)
    {
        // delete user
        $user->delete();

        // redirect
        return redirect('/');
    }
}
