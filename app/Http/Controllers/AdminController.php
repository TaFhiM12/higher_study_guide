<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Post;
use App\Models\Student;
use App\Models\VisaPack;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index() {
        return view('admin.dashboard');
    }

    public function approvePost($id)
    {
        $post = Post::findOrFail($id); // Find the post or fail if it doesn't exist
        $post->is_approved = true; // Set the approval status to true
        $post->save(); // Save the changes
    
        // Return a success response (redirect with success message)
        return redirect()->route('blogs.admin_show')->with('success', 'The post has been approved successfully.');
    }
    public function show_students()
{
    $students = Student::with('user')->get(); // Eager load the related user model
    return view('admin.student_request', compact('students'));
}

public function getStudentDetails($id)
{
    $student = Student::with('user')->find($id);

    if (!$student) {
        return response()->json(['success' => false, 'message' => 'Student not found.'], 404);
    }

    return response()->json([
        'success' => true,
        'name' => $student->user->name,
        'email' => $student->user->email,
        'academic' => $student->academic,
    ]);
}


public function approveStudent($id)
{
    $student = Student::findOrFail($id);

    // Update the approval status
    $student->is_approved = 1;
    $student->save();

    return redirect()->route('admin.student')->with('success', 'Student approved successfully.');
}

public function studentDestroy($id)
{
    $student = Student::findOrFail($id);

    // Delete associated user if needed (optional)
    if ($student->user) {
        $student->user->delete();
    }

    // Delete the student record
    $student->delete();

    return redirect()->route('admin.student')->with('success', 'Student deleted successfully.');
}

public function showAgencyRequests()
{
    $agencies = Agency::with('user')->get(); // Eager load the related user model (if required)
    return view('admin.agency_request', compact('agencies'));
}

public function approveAgency($id)
{
    $agency = Agency::findOrFail($id);

    // Update the approval status
    $agency->is_approved = 1;
    $agency->save();

    return redirect()->route('admin.agency')->with('success', 'Agency approved successfully.');
}
public function destroyAgency($id)
{
    // Find the agency by its ID or fail if it doesn't exist
    $agency = Agency::findOrFail($id);

    // Optional: If you want to delete associated user or other data
    if ($agency->user) {
        $agency->user->delete(); // Deletes the user associated with this agency
    }

    // Delete the agency itself
    $agency->delete();

    // Redirect back with a success message
    return redirect()->route('admin.agency')->with('success', 'Agency deleted successfully.');
}

public function getAgencyDetails($id)
{
    // Find the agency by its ID or fail if it doesn't exist
    $agency = Agency::with('user')->find($id);

    // Check if the agency exists
    if (!$agency) {
        return response()->json([
            'success' => false,
            'message' => 'Agency not found.',
        ], 404);
    }

    // Return agency details in JSON format
    return response()->json([
        'success' => true,
        'name' => $agency->user->name,
        'email' => $agency->user->email ?? 'No email provided',
        'website' => $agency->website ?? 'No website number provided',
        'address' => $agency->address ?? 'No address provided',
        'phone' => $agency->Phpne ?? 'No Phone provided',
    ]);
}


public function approveVisaOffer($id)
{
    $visaOffer = VisaPack::findOrFail($id); // Find the visa offer or fail if it doesn't exist
    $visaOffer->is_approved = true; // Set the approval status to true
    $visaOffer->save(); // Save the changes

    // Return a success response (redirect with success message)
    return redirect()->route('admin.visa_offers')->with('success', 'The visa offer has been approved successfully.');
}

public function destroyVisaOffer($id)
{
    $visaOffer = VisaPack::findOrFail($id); // Find the visa offer or fail if it doesn't exist

    // Delete the visa offer record
    $visaOffer->delete();

    return redirect()->route('admin.visa_offers')->with('success', 'Visa offer deleted successfully.');
}

public function getVisaOfferDetails($id)
{
    $visaOffer = VisaPack::find($id);

    if (!$visaOffer) {
        return response()->json(['success' => false, 'message' => 'Visa offer not found.'], 404);
    }

    return response()->json([
        'success' => true,
        'title' => $visaOffer->title,
        'country' => $visaOffer->country_name,
        'details' => $visaOffer->details, // Assuming this field exists in your VisaOffer model
    ]);
}

public function showVisaPack() {
    $visaOffers = VisaPack::latest()->get();  // Apply latest() first, then get() to retrieve the records
    return view('admin.visa_offers', compact('visaOffers'));
}



    
}
