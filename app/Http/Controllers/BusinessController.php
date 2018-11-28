<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Auth;
use Moloquent;
use App\Business;
use App\User;
use App\Rating;
use App\Review;

class BusinessController extends Controller
{
   // Apply auth middleware so only authenticated users have access
	public function __construct()
	{
		$this->middleware('auth');
	}

	// Returns all businesses if user is admin / normal user
	// Returns both all businesses and the owned businesses if merchant
	public function index()
	{
		return $this->showUserBusinesses(Auth::user()->id);
	}

	// Provides listing of businesses (with ratings and reviews)
	public function list()
	{
		$businesses = Business::all();

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

	public function create()
	{
		return view('businesses.create');
	}

	public function store(Request $request)
	{
		// Ensures certain fields must be provided
		$this->validate($request,
			[
				'name' => 'required',
				'description' => 'required',
				'menu' => 'required',
				'contact_number' => 'required',
			]);

		// create a new Business based on input
		$business = new Business;

		$images = [];

		if ($request->hasFile('imageData')) {
			$file = $request->file('imageData');
			$imageData = base64_encode(file_get_contents($request->file('imageData')));

			if ($file->getMimeType() == "image/png") {
				$imageData = "data:image/png;base64," . $imageData;
			}
			else if ($file->getMimeType() == "image/jpeg") {
				$imageData = "data:image/jpeg;base64," . $imageData;
			}

			$image = new \stdClass();

			$image->name = $request->imageName;
			$image->description = $request->imageDescription;
			$image->data = $imageData;

			array_push($images, $image);
		}


		$business->owner_id = Auth::user()->id;
		$business->name = $request->name;
		$business->description = $request->description;

		$business->menu = array_filter($request->menu, function($var){return !is_null($var);} );
		$business->contact_number = $request->contact_number;
		$business->verified = false;
		$business->images = $images;

		$business->save();

		return redirect()->route('business.index');
	}

	public function show($id)
	{
		$business = Business::findOrFail($id);
		$ratings = Rating::where('ratee_id','=', $id)->get();

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

		$reviews = Review::where('reviewee_id','=', $id)->get();

		foreach ($reviews as $review)
		{
			$user = User::findOrFail($review->reviewer_id);
			$review->user = $user;
		}

		$business->reviews = $reviews;

		$holder = array();

		foreach ($business->images as $key) {
			$image = new \stdClass();

			$image->name = $key['name'];
			$image->description = $key['description'];
			$image->data = $key['data'];

			array_push($holder,$image);
		}
		$business->images = $holder;

		return view('businesses.show', compact('business'));
	}

	public function edit($id)
	{
		$business = Business::findOrFail($id);

		$holder = array();
		foreach ($business->images as $key) {
			$image = new \stdClass();

			$image->name = $key['name'];
			$image->description = $key['description'];
			$image->data = $key['data'];

			array_push($holder,$image);
		}
		$business->images = $holder;

		return view('businesses.edit', compact('business'));
	}

	public function update(Request $request, $id)
	{
		$business = Business::findOrFail($id);

		$holder = array();

		foreach ($business->images as $key) {
			$image = new \stdClass();

			$image->name = $key['name'];
			$image->description = $key['description'];
			$image->data = $key['data'];

			array_push($holder,$image);
		}

		if ($request->hasFile('imageData')) {
			$file = $request->file('imageData');
			$imageData = base64_encode(file_get_contents($request->file('imageData')));


			if ($file->getMimeType() == "image/png") {
				$imageData = "data:image/png;base64," . $imageData;
			}
			else if ($file->getMimeType() == "image/jpeg") {
				$imageData = "data:image/jpeg;base64," . $imageData;
			}

			$image = new \stdClass();

			$image->name = $request->imageName;
			$image->description = $request->imageDescription;
			$image->data = $imageData;


			array_push($holder, $image);
		}

		$business->images = $holder;

		// $business->owner_id = $request->owner_id;
		// $business->owner_id = Auth::user()->id;

		$business->name = $request->name;
		$business->description = $request->description;
		$business->menu = array_filter($request->menu, function($var){return !is_null($var);} );
		$business->contact_number = $request->contact_number;
		
		$business->save();

		return redirect()->route('business.index');
	}

	public function destroy($id)
	{
		Business::findOrFail($id)->delete();

		return redirect()->back();
	}

	public function showUserBusinesses($owner_id)
	{
		$businesses = Business::where('owner_id','=',$owner_id)->get();

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

	public function verify($id)
	{
		$business = Business::findOrFail($id);
		if (Auth::user()->role === 'admin')
		{
			$business->verified = $request->verified;
			return view('businesses.index', compact('business'));
		}
	}

	public function test()
	{
		// $hello = "helloworld";
		//
		// Storage::disk('businesses')->put('hello.json', '{"hello": "world"}');
		// $path = Storage::disk('businesses')->url('hello.json');

		// $b64image = base64_encode(file_get_contents('http://www.onzehost.com.br/images/test-img.jpg'));
		//
		// $b64image = base64_decode($b64image);
		//


		$img_url = 'https://securitywatch.ie/media/catalog/product/t/e/test-logo-circle-black-transparent.png';
		$b64_url = 'php://filter/read=convert.base64-encode/resource='.$img_url;
		$b64_img = file_get_contents($b64_url);
		// echo $b64_img;

		$imageData = base64_decode($b64_img);
		$source = imagecreatefromstring($imageData);
		$angle = 90;
		$rotate = imagerotate($source, $angle, 0); // if want to rotate the image
		$imageName = "hello1.png";
		$imageSave = imagejpeg($rotate,$imageName,100);
		imagedestroy($source);

		$users = User::all();

		foreach ($users as $user) {
			$user->profile_image = $b64_img;
			// dd($user);
		}

		foreach ($users as $user) {
			base64_decode($user->profile_image);
			echo '<img src="data:image/png;base64,' . $user->profile_image . '" />';
			// dd($user);
		}





		// echo $imageSave;


		// dd($imageSave);
	}

}
