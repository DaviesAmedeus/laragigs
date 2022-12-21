<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{   
    // Show all listings
    public function index()
    {
        
        return view('listings.index', [
            'mda'=> '2:48:21',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))
            ->paginate(4)
        ]);
    }

        // Show single listing
    public function show($id)
    {
        return view('listings.show', [
            'listing'=> Listing::find($id)
         ]);
    }

        //show create form
    public function create()
    {
        return view('listings.create');
    }

    // store listing data
    public function store(Request $request){
        // dd($request->file('logo'));
        $formFields = $request->validate([
            'title'=> 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location'=> 'required',
            'website'=>'required',
            'email'=> ['required', 'email'],
            'tags'=> 'required',
            'description'=> 'required'
        ]);

        LIsting::create($formFields);

        return redirect('/')->with('message', 'Listing Created successfully');
    }

}

