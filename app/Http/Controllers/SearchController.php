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
		return $data;
	}

	public function searchBusinesses(Request $request)
	{
		$filters->name = $request->name;
		$filters->services = $request->services;
		$filters->verified = $request->verified;

		$query = Business::query();
		$query->where('name', 'like', '%'.$filters->name.'%');
		unset($filters->name);

		foreach ($filters as $filter => $value)
		{
			if (is_array($value))
			{
				$query->whereIn($filter, $value);
			}
			else
			{
				$query->where($filter,$value);
			}
		}

		return ($query->get());
	}

	public function searchProperties(Request $request)
	{
		$filters->name = $request->name;
		$filters->services = $request->services;
		$filters->verified = $request->verified;

		$query = Property::query();
		$query->where('name', 'like', '%'.$filters->name.'%');
		unset($filters->name);

		foreach ($filters as $filter => $value)
		{
			if (is_array($value))
			{
				$query->whereIn($filter, $value);
			}
			else
			{
				$query->where($filter,$value);
			}
		}

		return ($query->get());
	}


	public function test()
	{
		$filters['name'] = "Clean";
		$filters['verified'] = true;
		$filters['services'] = ["Cleaning"];

		$query = Business::query();
		$query->where('name', 'like', '%'.$filters['name'].'%');
		unset($filters['name']);

		foreach ($filters as $filter => $value)
		{
			if (is_array($value))
			{
				$query->whereIn($filter, $value);
			}
			else
			{
				$query->where($filter,$value);
			}
		}

		dd($query->get());
	}
}
