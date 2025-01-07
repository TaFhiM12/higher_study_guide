<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Correct namespace for Auth
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display the authenticated student's profile.
     */
    public function index()
    {
        $student = Auth::user()->student; // Get the authenticated user's student profile
        return view('student.myprofile', compact('student'));
    }

    /**
     * Update the authenticated student's profile.
     */
    public function update(Request $request, $id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Ensure the authenticated user is authorized to update this profile
        if ($student->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $validated = $request->validate([
            'academic' => 'nullable|array',
            'academic.*.exam_name' => 'nullable|string|max:255',
            'academic.*.institution' => 'nullable|string|max:255',
            'academic.*.result' => 'nullable|string|max:255',
            'academic.*.scale' => 'nullable|string|max:255',
            'academic.*.passing_year' => 'nullable|string|max:255',
            'language' => 'nullable|array',
            'language.*.type' => 'nullable|string|max:255',
            'language.*.score' => 'nullable|string|max:255',
            'language.*.scale' => 'nullable|string|max:255',
            'fund' => 'nullable|numeric|min:0',
            'profile_image' => 'nullable|image', // Max 2MB image
        ]);

        // Filter out empty academic entries
        $academicData = array_filter($request->academic ?? [], function ($academic) {
            return !empty(array_filter($academic, fn($value) => $value !== null && $value !== ''));
        });

        // Filter out empty language entries
        $languageData = array_filter($request->language ?? [], function ($language) {
            return !empty(array_filter($language, fn($value) => $value !== null && $value !== ''));
        });

        // Update academic, language, and fund fields
        $student->academic = $academicData;
        $student->language = $languageData;
        $student->fund = $request->fund;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('students', $fileName, 'public');
            $student->image = $filePath;
            logger('Manually stored file', ['filePath' => $filePath]);
        }
        
        // Save the updated student profile
        $student->save();

        // Redirect back with a success message
        return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function showEligibility(){
        $student = Auth::user()->student;
        return view('student.show_eligibility', compact('student'));
    }

    public function assessEligibility(Request $request)
{
    // Combine old and new academic entries
    $academic = array_merge(
        $request->input('old_academic', []),
        $request->input('new_academic', [])
    );

    // Combine old and new language proficiency entries
    $language = array_merge(
        $request->input('old_language', []),
        $request->input('new_language', [])
    );

    // Get fund amount
    $fund = $request->input('fund', 0);

    // Default response
    $response = [
        'eligibility' => false,
        'message' => 'Eligibility failed. Please check your details.',
        'countries' => []
    ];

    // 1. Check Academic Info
    if (empty($academic)) {
        $response['message'] = 'No academic information provided.';
        return response()->json($response);
    }

    $hasValidExam = false;
    foreach ($academic as $entry) {
        if (
            isset($entry['exam_name'], $entry['result'], $entry['scale']) &&
            strtolower($entry['exam_name']) === 'hsc' &&
            $entry['result'] >= 3
        ) {
            $hasValidExam = true;
        }
    }

    if (!$hasValidExam) {
        $response['message'] = 'No valid academic qualification found or result too low.';
        return response()->json($response);
    }

    // 2. Check Fund
    if ($fund < 200000) { // Minimum fund requirement (BDT 200,000)
        $response['message'] = 'Insufficient funds for higher studies.';
        return response()->json($response);
    }

    // 3. Check Language Proficiency
    $languageValid = false;
    foreach ($language as $entry) {
        if (
            isset($entry['type'], $entry['score'], $entry['scale']) &&
            (
                (strtolower($entry['type']) === 'ielts' && $entry['score'] >= 5) ||
                (strtolower($entry['type']) === 'sat' && $entry['score'] >= 1000) ||
                (strtolower($entry['type']) === 'toefl' && $entry['score'] >= 60)
            )
        ) {
            $languageValid = true;
            break;
        }
    }

    if (!$languageValid) {
        $response['message'] = 'No valid language proficiency test score found.';
        return response()->json($response);
    }

    // 4. Suggest Countries Based on Fund
    if ($fund >= 3000000) {
        // High budget: Eligible for all top countries
        $response['countries'] = ['USA', 'Canada', 'UK', 'Germany', 'France', 'Australia', 'Japan', 'South Korea', 'Singapore'];
    } elseif ($fund >= 1200000) {
        // Mid-budget: Europe, Asia (developed countries)
        $response['countries'] = ['Germany', 'France', 'Netherlands', 'Sweden', 'Japan', 'South Korea', 'Singapore'];
    } elseif ($fund >= 200000) {
        // Low-budget: Affordable countries
        $response['countries'] = ['Turkey', 'Malaysia', 'China', 'India'];
    } else {
        $response['message'] = 'Not enough funds for higher studies.';
        return response()->json($response);
    }

    // If all conditions pass, eligibility is true
    $response['eligibility'] = true;
    $response['message'] = 'Eligible for higher studies.';

    return response()->json($response);
}

}
