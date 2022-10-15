<?php

namespace App\Http\Controllers;

use id;
use auth;

use App\Models\Listing;
use DeepCopy\Filter\Filter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;

class ListingController extends Controller
{
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6)
        ]);
    }


    public function show($id) {
        return view('listings.show', [
            'listing'=> Listing::find($id)
        ]);
        
    }

    public function create() {
        return view('listings.create');
        
    }

    //store listing data
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', ValidationRule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

       public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }

        //update listing data
        public function update(Request $request, Listing $listing){
            $formFields = $request->validate([
                'title' => 'required',
                'company' => 'required',
                'location' => 'required',
                'website' => 'required',
                'email' => 'required',
                'tags' => 'required',
                'description' => 'required'
            ]);
    
            if($request->hasFile('logo')) {
                $formFields['logo'] = $request->file('logo')->store('logos', 'public');
            }    
           $listing->update($formFields);
    
            return back()->with('message', 'Listing updated successfully');
           }

           //delete listing
           public function destroy(Listing $listing) {
            $listing->delete();
            return redirect('/')->with('message', 'Listing Deleted successfully');

           }
}
