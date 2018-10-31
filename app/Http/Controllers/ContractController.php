<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Contract;

class ContractController extends Controller
{
    // Apply auth middleware so only authenticated users have access
	public function __construct() 
    {
		$this->middleware('auth');
	}

    // List all contracts if user is admin 
    // Shows only user contracts if user is a user/merchant
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $contracts = Contract::all();
        }
        else
        {
            $contracts = Contract::where('provider_id','=', Auth::user()->id)-> orWhere('receiver_id','=', Auth::user()->id)->get();
        }
        
        return view('contracts.index', compact('contracts'));
    }

    public function showAll()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    // Gets all the Contracts associated with specified user
    public function showUserContracts($user_id)
    {
        $user_contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();
        return view('contracts.index', compact('user_contracts'));
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
			'contractType' => 'required',
            'contractValue' => 'required',
            'contractStatus' => 'required',
 		]);

 		// create a new contract based on user contracts relationship
 		$contract = $request->user()->contracts()->create([
            // 'contractOwnerID' => $request->contractOwnerID,
            'providerID' => $request->providerID,
            'receiverID' => $request->receiverID,
			'locationID' => $request->locationID,
			'contractType' => $request->contractType,
            'contractContent' => $request->contractContent,
            'contractValue' => $request->contractValue,
            'contractStatus' => $request->contractStatus,
            'providerSignature' => $request->providerSignature,
            'receiverSignature' => $request->receiverSignature,
 		]);

 		// return contract with user object
 		return response()->json($contract->with('user')->find($contract->_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
		return response()->json([
			'contract' => $contract,
		]);
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
		$contract = Contract::findOrFail($id);
		$contract->update($input);
		return response()->json($contract->with('user')->find($contract->_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contract::findOrFail($id)->delete();
    }
}
