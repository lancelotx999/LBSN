<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Business;

class BusinessController extends Controller
{
   // Apply auth middleware so only authenticated users have access
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // List all businesses if user is admin / normal user
    // Shows only user businesses if user is a merchant
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $businesses = Business::all();
        }
        else if (Auth::user()->role === 'merchant')
        {
            $user_businesses = Business::where('owner_id','=',Auth::user()->id)->get();
            $businesses = Business::all();

            return view('businesses.index', compact('user_businesses','businesses'));
        }
        else
        {
        	$businesses = Business::all();
        }
        
        return view('businesses.index', compact('businesses'));
    }

    // Gets all bussinesses
    public function showAll()
    {
    	$businesses = Business::all();
    	return view('businesses.index', compact('businesses'));
    }

    // Gets all the bussinesses associated with specified user
    public function showUserProperties($owner_id)
    {
    	$user_businesses = Business::where('owner_id','=', $owner_id)->get();
    	return view('businesses.index', compact('user_businesses'));
    }

    public function create(Request $request, Invoice $invoice)
    {
        $user_businesses = Business::where('owner_id','=',Auth::user()->id)->get();
        $businesses = $user_businesses->take(10)->get();

        return view('businesses.create', compact('businesses'));
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

        // create a new Invoice based on input
        $business = new Business;

        $business->owner_id = $request->owner_id;
        $business->name = $request->name;
        $business->description = $request->description;
        $business->services = $request->services;	// Need to implement string separation
        $business->contact_number = $request->contact_number;

        $business->save();     

        return redirect()->back();
    }


    public function show($id)
    {
        $business = Business::findOrFail($id);

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
        $business->services = $request->services;	// Need to implement string separation
        $business->contact_number = $request->contact_number;

        $business->save();  

        return redirect()->route('businesses.edit', ['business' => $business ]);
    }

    public function destroy($id)
    {
        Business::findOrFail($id)->delete();

        return redirect()->back();
    }

}
