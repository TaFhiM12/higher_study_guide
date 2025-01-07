<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Post;
use App\Models\VisaPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function index()
    {
        // Get the authenticated user's agency
        $agency = Auth::user()->agency;
    
        // Check if the agency exists (optional, to handle cases where user might not have an agency)
        if (!$agency) {
            return redirect()->route('home')->with('error', 'You do not have an associated agency.');
        }
    
        // Fetch related visa packs (offers) and blogs (posts)
        $offers = VisaPack::where('agency_id', $agency->id)->get(); // Fetch offers for this agency
        $blogs = Post::where('user_id', Auth::user()->id)->get(); // Fetch blogs for this agency
    
        // Calculate agency ratings (optional)
        $ratings = $agency->reviews()->avg('rating') ?? 0; // Get average ratings or default to 0 if no reviews
        // Pass data to the view
        return view('agency.myprofile', compact('agency', 'offers', 'blogs', 'ratings'));
    }
    

    public function create()
    {
        return view('agencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'TIN' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $logoPath = $request->file('logo') ? $request->file('logo')->store('agency', 'public') : null;

        Agency::create([
            'user_id' => Auth::id(),
            'website' => $request->website,
            'logo' => $logoPath,
            'TIN' => $request->TIN,
            'bio' => $request->bio,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('agency.dashboard')->with('success', 'Agency created successfully.');
    }

    public function edit(Agency $agency)
    {
  
        return view('agencies.edit', compact('agency'));
    }

    public function update(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);
        $request->validate([
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'TIN' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $logoPath = $request->file('logo') ? $request->file('logo')->store('agency', 'public') : $agency->logo;

        $agency->update([
            'website' => $request->website,
            'logo' => $logoPath,
            'TIN' => $request->TIN,
            'bio' => $request->bio,
            'is_featured' => $request->boolean('is_featured'),
        ]);
        return redirect()->route('agency.dashboard')->with('success', 'Agency updated successfully.');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();

        return redirect()->route('agencies.index')->with('success', 'Agency deleted successfully.');
    }

    public function addOffer(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'country_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'processing_time' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
            'details' => 'required|string',
            
        ]);

        $agency = Auth::user()->agency;

        if (!$agency) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to add offers.']);
        }

        $data = $request->only([
            'title',
            'country_name',
            'degree',
            'processing_time',
            'cost',
            'details',
        ]);

        $data['agency_id'] = $agency->id;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('visa_packs', 'public');
            $data['image'] = $imagePath;
        }

        // Create the VisaPack offer
        VisaPack::create($data);

        return redirect()->route('agency.dashboard')->with('success', 'VisaPack offer added successfully.');
    }

    public function deleteOffer($id)
{
    // Fetch the offer by ID
    $offer = VisaPack::findOrFail($id);

    // Check if the authenticated user's agency is the owner of the offer
    if (Auth::user()->agency && Auth::user()->agency->id === $offer->agency_id) {
        // Delete the offer
        $offer->delete();

        // Redirect with a success message
        return redirect()->route('agency.dashboard')->with('success', 'Offer deleted successfully.');
    }

    // If the user doesn't own the offer, return an error response
    return redirect()->route('agency.dashboard')->with('error', 'You are not authorized to delete this offer.');
}

public function editOffer($id)
{
    // Find the VisaPack offer by ID
    $offer = VisaPack::where('id', $id)
        ->where('agency_id', Auth::user()->agency->id) // Ensure the logged-in agency owns this offer
        ->first();

    if (!$offer) {
        return response()->json(['message' => 'Offer not found or you are not authorized to edit this offer.'], 404);
    }

    // Return the offer details as JSON
    return response()->json($offer);
}
public function fetchOffer($id)
{
    // Fetch the offer details
    $offer = VisaPack::where('id', $id)
        ->where('agency_id', Auth::user()->agency->id)
        ->first();

    if (!$offer) {
        return response()->json(['error' => 'Offer not found or unauthorized access'], 404);
    }

    return response()->json($offer);
}

public function updateOffer(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'title' => 'required|string|max:255',
        'country_name' => 'required|string|max:255',
        'degree' => 'required|string|max:255',
        'processing_time' => 'required|integer|min:1',
        'cost' => 'required|numeric|min:0',
        'details' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the VisaPack offer by ID and ensure it belongs to the authenticated agency
    $offer = VisaPack::where('id', $id)
        ->where('agency_id', Auth::user()->agency->id)
        ->first();

    if (!$offer) {
        return redirect()->back()->withErrors(['error' => 'Offer not found or you are not authorized to update this offer.']);
    }

    // Update the offer details
    $offer->title = $request->input('title');
    $offer->country_name = $request->input('country_name');
    $offer->degree = $request->input('degree');
    $offer->processing_time = $request->input('processing_time');
    $offer->cost = $request->input('cost');
    $offer->details = $request->input('details');

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($offer->image && Storage::exists($offer->image)) {
            Storage::delete($offer->image);
        }

        // Store the new image and update the path
        $offer->image = $request->file('image')->store('offers');
    }

    // Save the updated offer
    $offer->save();

    return redirect()->route('agency.dashboard')->with('success', 'Offer updated successfully!');
}



}
