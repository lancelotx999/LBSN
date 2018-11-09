<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\User;
use App\Business;
use App\Contract;
use App\Property;

class SearchController extends Controller
{
	public function searchUsers($word)
	{
        $data = collect();
		$users = User::where('name', 'like', '%'.$word.'%')->get();
        foreach ($users as $user)
        {
            $data->push($user);
        }
	}

    public function test()
    {
    	$data = collect();
    	$keyword = "test";
    	$keyword2 = "service";

    	$users = User::where('name', 'like', '%'.$keyword.'%')->get();
    	$contracts = Contract::where('type', 'like', '%'.$keyword2.'%')->get();

    	foreach ($users as $user)
    	{
    		$data->push($user);
    	}

    	foreach ($contracts as $contract)
    	{
    		$data->push($contract);
    	}
    	dd($data);

    }
}
