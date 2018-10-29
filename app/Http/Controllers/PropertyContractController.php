<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Contract;
use App\PropertyContract;
use Illuminate\Http\Request;

class PropertyContractController extends Controller
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
    public function index(Request $request, PropertyContract $contract, User $user)
    {
        // get all the contracts based on current user id
		$allContracts = $contract->whereIn('user_id', $request->user())->with('user');
        // $contracts = $allContracts->orderBy('created_at', 'desc')->take(10)->get();
		$contracts = $allContracts->take(10)->get();

		// $allUsers = User::get();
		// $allUsers = Auth::user()->get()
		$allUsers = User::all();
		$allLocations = Location::all();


		// return json response
		return response()->json([
			'contracts' => $contracts,
			'users' => $allUsers,
			'locations' => $allLocations
		]);
    }

	public function listAll(Request $request, PropertyContract $contract, User $user){

	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$location = Location::with('user')->findOrFail($id);
        $contracts = PropertyContract::with('user')->take(10)->get();

        return view('propertyContract.create', compact('location', 'contracts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // validate
 		$this->validate($request, [
            // 'contractOwnerID' => 'required|max:100',
            'providerID' => 'required',
			'receiverID' => 'required',
            'locationID' => 'required',
            'contractValue' => 'required',
            'contractStatus' => 'required',
 		]);


		// create a new contract based on user contracts relationship
 		$contract = $request->user()->propertyContracts()->create([
            // 'contractOwnerID' => $request->contractOwnerID,
			'providerID' => $request->providerID,
            'provider' => User::find($request->providerID)->get()->toArray(),
			'receiverID' => $request->receiverID,
            'receiver' => User::find($request->receiverID),
			'locationID' => $request->locationID,
			'location' => Location::find($request->locationID),
            'contractContent' => $request->contractContent,
            'contractValue' => $request->contractValue,
            'contractStatus' => $request->contractStatus,
            'providerSignature' => $request->providerSignature,
            'receiverSignature' => $request->receiverSignature,
 		]);

		// $location = Location::with('user')->findOrFail($id);


		// $contract->user()->saveMany([
		// 	new User(['provider' => User::find($contract->providerID)]),
		// 	new User(['receiver' => User::find($contract->receiverID)]),
		// 	new Location(['location' => User::find($contract->locationID)]),
		// ]);
		// $users = User::where('_id', '==', $contract->providerID)->get();

		// $contract->provider = User::where('_id', '=', $contract->providerID)->first();
		// $contract->receiver = User::where('_id', '=', $contract->receiverID)->first();
		// $contract->location = Location::where('_id', '=', $contract->locationID)->first();
        //
		// // $contract->provider = User::find($contract->providerID);
		// // $contract->receiver = User::find($contract->receiverID);
		// // $contract->location = Location::find($contract->locationID);
        //
		// $contract->save();

		// $provider = User::find($contract->providerID);
        //
		// $receiver = User::find($contract->receiverID);


		// $buy->user()->attach($buyId);

		// $location = Location::find(1);
        //
		// $contract->user()->saveMany([
		// 	new user(['provider' => User::find($contract->providerID)]),
		// 	new user(['receiver' => User::find($contract->receiverID)]),
		// ]);

		// $contract = App\Post::find(1);

		// $contract->comments()->saveMany([
		// 	new App\Comment(['message' => 'A new comment.']),
		// 	new App\Comment(['message' => 'Another comment.']),
		// ]);

		// $contract = $request->user()->propertyContracts()->create([

		// $contract = $location->user()->create([
		// 	'provider' => 'A new comment.',
		// 	'receiver' => 'A new comment.',
		// ]);

		// PropertyContract::create($request->all());
		// $propertyContract = PropertyContract::where('unique_field', '=', $request->uniquefield)->first();
        //
		// $propertyContract->users()->attach($request->user_id);
		// $propertyContract->location()->attach($request->location_id);

 		// return contract with user object
		// return $contract;
		// return $contract;
 		return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::with('user')->findOrFail($id);
        $contracts = PropertyContract::with('user')->take(10)->get();

        return view('propertyContract.create', compact('location', 'contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $contract = PropertyContract::with('user')->findOrFail($id);
        //
        // return view('propertyContract.edit', compact('contract'));
		// return response()->json([
		// 	'contract' => $contract,
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
		$contract = PropertyContract::with('user')->findOrFail($id);
		$contract->update($input);
        return redirect()->route('propertyContract.edit', ['contract' => $contract ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PropertyContract::findOrFail($id)->delete();

        return redirect()->back();
    }
}
