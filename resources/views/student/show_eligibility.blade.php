@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8 mt-8">
    <h1 class="text-4xl font-bold text-indigo-600 mb-8">Check Your Eligibility</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Eligibility Result Section -->
                <div id="eligibility-result" class="hidden bg-gray-100 p-6 rounded-lg mb-6 border border-indigo-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Eligibility Result</h2>
                    <div id="result-message" class="text-lg text-gray-700 mb-4"></div>
                    <ul id="suggested-countries" class="list-disc ml-6 text-gray-600"></ul>
                </div>
        <form id="eligibility-form" action="{{ route('student.checkEligibility') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                    value="{{ old('name', Auth::user()->name) }}" required />
            </div>

            <!-- Academic Information -->
            <div id="academic-info-section" class="mb-6">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Academic Information</h2>

                @if (!empty($student->academic) && is_array($student->academic))
                    @foreach ($student->academic as $index => $academic)
                        <div class="academic-entry flex items-center space-x-4 mb-4">
                            <input type="hidden" name="old_academic[{{ $index }}][exam_name]" value="{{ $academic['exam_name'] }}">
                            <input type="hidden" name="old_academic[{{ $index }}][institution]" value="{{ $academic['institution'] }}">
                            <input type="hidden" name="old_academic[{{ $index }}][result]" value="{{ $academic['result'] }}">
                            <input type="hidden" name="old_academic[{{ $index }}][scale]" value="{{ $academic['scale'] }}">
                            <input type="hidden" name="old_academic[{{ $index }}][passing_year]" value="{{ $academic['passing_year'] }}">

                            <div class="flex-1">
                                <p><strong>{{ $academic['exam_name'] }}</strong> at <strong>{{ $academic['institution'] }}</strong></p>
                                <p>Result: {{ $academic['result'] }}/{{ $academic['scale'] }}, Passing Year: {{ $academic['passing_year'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div id="new-academic-entries" class="space-y-4"></div>
                <button type="button" id="add-academic-btn" class="text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-plus-circle"></i> Add Academic Entry
                </button>
            </div>

            <!-- Language Proficiency -->
            <div id="language-info-section" class="mb-6">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Language Proficiency</h2>

                @if (!empty($student->language) && is_array($student->language))
                    @foreach ($student->language as $index => $language)
                        <div class="language-entry flex items-center space-x-4 mb-4">
                            <input type="hidden" name="old_language[{{ $index }}][type]" value="{{ $language['type'] }}">
                            <input type="hidden" name="old_language[{{ $index }}][score]" value="{{ $language['score'] }}">
                            <input type="hidden" name="old_language[{{ $index }}][scale]" value="{{ $language['scale'] }}">

                            <div class="flex-1">
                                <p><strong>{{ $language['type'] }}</strong>: {{ $language['score'] }}/{{ $language['scale'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div id="new-language-entries" class="space-y-4"></div>
                <button type="button" id="add-language-btn" class="text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-plus-circle"></i> Add Language Proficiency
                </button>
            </div>

            <!-- Funds -->
            <div class="mb-6">
                <label for="fund" class="block text-gray-700 font-bold mb-2">Available Funds (in BDT):</label>
                <input type="number" id="fund" name="fund" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                    value="{{ old('fund', $student->fund ?? '') }}" required min="0" />
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg shadow hover:bg-indigo-700">
                    Check Eligibility
                </button>

            </div>
        </form>
    </div>
</div>

<!-- Academic and Language Entry Templates -->
<template id="academic-entry-template">
    <div class="academic-entry flex items-center space-x-4 mb-4">
        <input type="text" name="new_academic[][exam_name]" placeholder="Exam Name" class="border rounded-lg px-4 py-2 w-1/5">
        <input type="text" name="new_academic[][institution]" placeholder="Institution" class="border rounded-lg px-4 py-2 w-1/5">
        <input type="text" name="new_academic[][result]" placeholder="Result" class="border rounded-lg px-4 py-2 w-1/5">
        <input type="text" name="new_academic[][scale]" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/5">
        <input type="text" name="new_academic[][passing_year]" placeholder="Passing Year" class="border rounded-lg px-4 py-2 w-1/5">
        <button type="button" class="text-red-600 hover:text-red-800 remove-entry-btn">Remove</button>
    </div>
</template>

<template id="language-entry-template">
    <div class="language-entry flex items-center space-x-4 mb-4">
        <input type="text" name="new_language[][type]" placeholder="Type (e.g., IELTS)" class="border rounded-lg px-4 py-2 w-1/3">
        <input type="text" name="new_language[][score]" placeholder="Score" class="border rounded-lg px-4 py-2 w-1/3">
        <input type="text" name="new_language[][scale]" placeholder="Scale" class="border rounded-lg px-4 py-2 w-1/3">
        <button type="button" class="text-red-600 hover:text-red-800 remove-entry-btn">Remove</button>
    </div>
</template>
@endsection

@push('scripts')
<script>
    document.getElementById('add-academic-btn').addEventListener('click', () => {
        const template = document.getElementById('academic-entry-template').content.cloneNode(true);
        document.getElementById('new-academic-entries').appendChild(template);
    });

    document.getElementById('add-language-btn').addEventListener('click', () => {
        const template = document.getElementById('language-entry-template').content.cloneNode(true);
        document.getElementById('new-language-entries').appendChild(template);
    });

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-entry-btn')) {
            event.target.closest('.academic-entry, .language-entry').remove();
        }
    });

    document.getElementById('eligibility-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch eligibility. Please try again.');
        }
        return response.json();
    })
    .then(data => {
        const resultSection = document.getElementById('eligibility-result');
        const resultMessage = document.getElementById('result-message');
        const suggestedCountries = document.getElementById('suggested-countries');

        // Display the result section
        resultSection.classList.remove('hidden');

        // Update the result message
        if (data.eligibility) {
            resultMessage.innerHTML = `<span class="text-green-600 font-bold">${data.message}</span>`;
            suggestedCountries.innerHTML = data.countries.map(country => `<li>${country}</li>`).join('');
        } else {
            resultMessage.innerHTML = `<span class="text-red-600 font-bold">${data.message}</span>`;
            suggestedCountries.innerHTML = '<li>No countries available for eligibility.</li>';
        }

        // Scroll to the top of the result section
        resultSection.scrollIntoView({ behavior: 'smooth' });
    })
    .catch(error => {
        console.error(error);
        alert('An error occurred while checking eligibility. Please try again.');
    });
});

</script>
@endpush
