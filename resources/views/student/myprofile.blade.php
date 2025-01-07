@extends('layouts.home') 
@section('content')
<div class="container mx-auto px-6 py-8 mt-8">
    <div class="bg-white shadow-md rounded-lg p-6 relative">
        <!-- Profile Picture Section -->
        <div class="flex items-center space-x-6">
            <div class="relative">
                <!-- Current Profile Picture -->
                <img 
                    src="{{ asset('storage/'.$student->image ?? 'default-profile.png') }}" 
                    alt="{{ Auth::user()->name }}" 
                    class="w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg">
                @if($student->is_approved !== null && $student->is_approved === 1)
                <!-- Approval Tick -->
                <div class="absolute bottom-2 right-[10px] bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center">
                    <i class="fas fa-check"></i>
                </div>
                @else
                <!-- Not Approved Indicator -->
                <div class="absolute bottom-2 right-[10px] bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </div>
                @endif
            </div>

            <!-- Name and Status -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                <p class="text-gray-600">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                    <br>
                    <strong>Institution:</strong> {{ $student->current_institution }}

                </p>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-6 border-gray-300">

        <!-- Editable Form Section -->
        <div>
            <form id="student-profile-form" action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Profile Picture Upload Section -->
                <div id="image-upload-section" class="hidden">
                    <label for="profile-image" class="block text-gray-800 font-bold">Change Profile Picture:</label>
                    <input type="file" id="profile-image" name="profile_image" accept="image/*" class="mt-2 border rounded-lg px-4 py-2 w-full">
                </div>

                <!-- Academic Information -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Academic Information</h2>
                    <div id="academic-info">
                        @if(!empty($student->academic))
                        @foreach ($student->academic as $index => $academic)
                        <div class="academic-entry flex items-center space-x-4 mb-4">
                            <input type="text" name="academic[{{ $index }}][exam_name]" value="{{ $academic['exam_name'] ?? '' }}" placeholder="Exam Name" class="border rounded-lg px-4 py-2 w-1/5">
                            <input type="text" name="academic[{{ $index }}][institution]" value="{{ $academic['institution'] ?? '' }}" placeholder="Institution" class="border rounded-lg px-4 py-2 w-1/5">
                            <input type="text" name="academic[{{ $index }}][result]" value="{{ $academic['result'] ?? '' }}" placeholder="Result" class="border rounded-lg px-4 py-2 w-1/5">
                            <input type="text" name="academic[{{ $index }}][scale]" value="{{ $academic['scale'] ?? '' }}" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/5">
                            <input type="text" name="academic[{{ $index }}][passing_year]" value="{{ $academic['passing_year'] ?? '' }}" placeholder="Passing Year" class="border rounded-lg px-4 py-2 w-1/5">
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <!-- Add More Academic Info Button -->
                    <button type="button" id="add-academic" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-plus-circle"></i> Add More Academic Info
                    </button>
                </div>

                <!-- Language Proficiency -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Language Proficiency</h2>
                    <div id="language-info">
                        @if(!empty($student->language))
                        @foreach ($student->language as $index => $language)
                        <div class="language-entry flex items-center space-x-4 mb-4">
                            <input type="text" name="language[{{ $index }}][type]" value="{{ $language['type'] ?? '' }}" placeholder="Type (e.g., IELTS)" class="border rounded-lg px-4 py-2 w-1/3">
                            <input type="text" name="language[{{ $index }}][score]" value="{{ $language['score'] ?? '' }}" placeholder="Score" class="border rounded-lg px-4 py-2 w-1/3">
                            <input type="text" name="language[{{ $index }}][scale]" value="{{ $language['scale'] ?? '' }}" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/3">
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <!-- Add More Language Proficiency Button -->
                    <button type="button" id="add-language" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-plus-circle"></i> Add More Language Proficiency
                    </button>
                </div>

                <!-- Fund -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Available Funds</h2>
                    <input type="number" name="fund" value="{{ $student->fund ?? 0 }}" class="border rounded-lg px-4 py-2 w-full" placeholder="Enter available funds">
                </div>

                <!-- Edit Button -->
                <div class="mt-4">
                    <button id="edit-profile" type="button" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                    <button id="save-profile" type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 hidden">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const editButton = document.getElementById('edit-profile');
    const saveButton = document.getElementById('save-profile');
    const formInputs = document.querySelectorAll('#student-profile-form input, #student-profile-form select, #student-profile-form textarea');
    const form = document.getElementById('student-profile-form');

    // Initially disable all form inputs
    formInputs.forEach(input => input.disabled = true);

    // Enable inputs when Edit button is clicked
    editButton.addEventListener('click', () => {
        const imageUploadSection = document.getElementById('image-upload-section');
        if (imageUploadSection) {
            imageUploadSection.classList.remove('hidden'); // Show image upload section
        }
        formInputs.forEach(input => input.disabled = false); // Enable all inputs
        saveButton.classList.remove('hidden'); // Show save button
        editButton.classList.add('hidden'); // Hide edit button
    });

    // Add More Academic Info
    document.getElementById('add-academic').addEventListener('click', () => {
        const academicInfo = document.getElementById('academic-info');
        const newIndex = academicInfo.children.length;
        const academicDiv = document.createElement('div');
        academicDiv.classList.add('academic-entry', 'flex', 'items-center', 'space-x-4', 'mb-4');
        academicDiv.innerHTML = `
            <input type="text" name="academic[${newIndex}][exam_name]" placeholder="Exam Name" class="border rounded-lg px-4 py-2 w-1/5">
            <input type="text" name="academic[${newIndex}][institution]" placeholder="Institution" class="border rounded-lg px-4 py-2 w-1/5">
            <input type="text" name="academic[${newIndex}][result]" placeholder="Result" class="border rounded-lg px-4 py-2 w-1/5">
            <input type="text" name="academic[${newIndex}][scale]" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/5">
            <input type="text" name="academic[${newIndex}][passing_year]" placeholder="Passing Year" class="border rounded-lg px-4 py-2 w-1/5">
        `;
        academicInfo.appendChild(academicDiv);
    });

    // Add More Language Proficiency
    document.getElementById('add-language').addEventListener('click', () => {
        const languageInfo = document.getElementById('language-info');
        const newIndex = languageInfo.children.length;
        const languageDiv = document.createElement('div');
        languageDiv.classList.add('language-entry', 'flex', 'items-center', 'space-x-4', 'mb-4');
        languageDiv.innerHTML = `
            <input type="text" name="language[${newIndex}][type]" placeholder="Type (e.g., IELTS)" class="border rounded-lg px-4 py-2 w-1/3">
            <input type="text" name="language[${newIndex}][score]" placeholder="Score" class="border rounded-lg px-4 py-2 w-1/3">
            <input type="text" name="language[${newIndex}][scale]" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/3">
        `;
        languageInfo.appendChild(languageDiv);
    });

    // Remove 'disabled' attributes before form submission
    form.addEventListener('submit', () => {
        formInputs.forEach(input => input.disabled = false);
    });

    // Dynamically Show and Enable the Profile Image Input
    const imageUploadSection = document.getElementById('image-upload-section');
    if (imageUploadSection) {
        const profileImageInput = document.getElementById('profile-image');
        if (profileImageInput) {
            profileImageInput.disabled = true; // Disable initially
        }

        editButton.addEventListener('click', () => {
            if (profileImageInput) {
                profileImageInput.disabled = false; // Enable when editing
            }
        });

        form.addEventListener('submit', () => {
            if (profileImageInput) {
                profileImageInput.disabled = false; // Ensure it is included in the submission
            }
        });
    }
</script>
@endpush
