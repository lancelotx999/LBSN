<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Contract;
use App\ServiceContract;
use Illuminate\Http\Request;

class ServiceContractController extends Controller
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
    public function index(Request $request, ServiceContract $contract, User $user)
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

	public function listAll(Request $request, ServiceContract $contract, User $user){

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
    public function store(Request $request)
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
 		$contract = $request->user()->serviceContracts()->create([
            // 'contractOwnerID' => $request->contractOwnerID,
            'providerID' => $request->providerID,
            'receiverID' => $request->receiverID,
			'locationID' => $request->locationID,
            'contractContent' => $request->contractContent,
            'contractValue' => $request->contractValue,
            'contractStatus' => $request->contractStatus,
            'providerSignature' => $request->providerSignature,
            'receiverSignature' => $request->receiverSignature,
 		]);

 		// return contract with user object
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
        $contracts = ServiceContract::with('user')->take(10)->get();

        return view('serviceContract.create', compact('location', 'contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = ServiceContract::with('user')->findOrFail($id);

        return view('serviceContract.edit', compact('contract'));
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
		$contract = ServiceContract::with('user')->findOrFail($id);
		$contract->update($input);
		return redirect()->route('serviceContract.edit', ['contract' => $contract ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceContract::findOrFail($id)->delete();

        return redirect()->back();
    }
}
