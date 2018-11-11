<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\User;
use App\Business;
use App\Contract;
use App\Property;
use App\Rating;
use App\Review;

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
		return view('users.index', compact('data'));
	}

	public function searchBusinesses(Request $request)
	{
		$filters = collect();
		$name = $request->name;
		$filters->services = $request->services;
		$filters->verified = $request->verified;

		$query = Business::query();
		$query->where('name', 'like', '%'.$name.'%');

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
		$businesses = $query->get();

        foreach ($businesses as $business) 
        {
            $ratings = Rating::where('ratee_id','=', $business->id)->get();

            $totalRates = 0;
            $totalUsers = count($ratings);

            if ($totalUsers > 0) 
            {
                foreach ($ratings as $rating) 
                {
                    $totalRates = $totalRates + $rating->rate;
                }

                $business->rate = $totalRates/$totalUsers;

            }
            else 
            {
                $business->rate = 0;
            }

            $reviews = Review::where('reviewee_id','=', $business->id)->get();

            foreach ($reviews as $review) 
            {
                $user = User::findOrFail($review->reviewer_id);
                $review->user = $user;
            }

            $business->reviews = $reviews;
        }

        return view('businesses.index', compact('businesses'));
	}

	public function searchProperties(Request $request)
	{
		$filters = collect();
		$name = $request->name;
		$filters->status = $request->status;
		$filters->tags = $request->tags;
		$filters->verified = $request->verified;

		$query = Property::query();
		$query->where('name', 'like', '%'.$name.'%');

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

		$properties = $query->get();

		foreach ($properties as $property) 
		{
			$ratings = Rating::where('ratee_id','=', $property->id)->get();

			$totalRates = 0;
			$totalUsers = count($ratings);

			if ($totalUsers > 0) 
			{
				foreach ($ratings as $rating) 
				{
					$totalRates = $totalRates + $rating->rate;
				}

				$property->rate = $totalRates/$totalUsers;

			}
			else 
			{
				$property->rate = 0;
			}

			$reviews = Review::where('reviewee_id','=', $property->id)->get();

			foreach ($reviews as $review) 
			{
				$user = User::findOrFail($review->reviewer_id);
				$review->user = $user;
			}

			$property->reviews = $reviews;
		}

		return view('properties.index', compact('properties'));
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
