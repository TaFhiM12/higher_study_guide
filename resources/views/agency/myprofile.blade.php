@extends('layouts.home')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8 mt-8">
        <!-- Agency Profile Header -->
        <div class="bg-white shadow-md rounded-lg p-6 relative">
            <div class="flex items-center space-x-6">
                <!-- Logo Section -->
                <div class="relative w-full">
                    <img src="{{ asset('storage/' . $agency->logo ?? 'default-logo.png') }}" alt="{{ $agency->name }}"
                        class="w-32 h-32 border-4 border-gray-200 shadow-lg">
                </div>

                <!-- Agency Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $agency->name }}</h1>
                    <p class="text-gray-600">
                        <strong>Website:</strong> <a href="{{ $agency->website }}" target="_blank"
                            class="text-indigo-600 hover:underline">{{ $agency->website }}</a>
                        <br>
                        <strong>TIN:</strong> {{ $agency->TIN ?? 'Not Provided' }}
                        <br>
                        <strong>Rating:</strong>
                        @if ($ratings > 0)
                            <span class="text-yellow-500">{{ $ratings }}/5</span>
                        @else
                            <span class="text-gray-500">Unrated</span>
                        @endif
                        <br>
                        <strong>Bio:</strong> {{ $agency->bio ?? 'No bio provided.' }}
                    </p>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-6 border-gray-300">

            <!-- Editable Form Section -->
            <div>
                <form id="agency-profile-form" action="{{ route('agency.update', $agency->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6 hidden">
                    @csrf
                    @method('PUT')

                    <!-- Logo Upload Section -->
                    <div>
                        <label for="logo" class="block text-gray-800 font-bold">Change Logo:</label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                            class="mt-2 border rounded-lg px-4 py-2 w-full">
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-gray-800 font-bold">Bio:</label>
                        <textarea name="bio" id="bio" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('bio', $agency->bio) }}</textarea>
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-gray-800 font-bold">Website:</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $agency->website) }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- TIN -->
                    <div>
                        <label for="TIN" class="block text-gray-800 font-bold">TIN:</label>
                        <input type="text" id="TIN" name="TIN" value="{{ old('TIN', $agency->TIN) }}"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700">
                            Save Changes
                        </button>
                    </div>
                </form>

                <!-- Edit Button -->
                <div class="mt-4">
                    <button id="edit-profile" type="button"
                        class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg shadow hover:bg-indigo-700">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-6 border-gray-300">

        <!-- Offers Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Our Offers</h2>
                @auth
                    <button id="add-offer"
                        class="px-4 py-2 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700">
                        Add Offer
                    </button>
                @endauth
            </div>
            @if ($offers->isNotEmpty())
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
				@foreach ($offers as $offer)
					<div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 flex flex-col">
						<div class="relative">
							<!-- Image -->
							<img src="{{ asset('storage/'.$offer->image) }}" alt="{{ $offer->country_name }}" class="w-full h-32 object-cover">
							
							<!-- Processing Time -->
							<div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-3 py-1 rounded-lg">
								Processing Time: {{ $offer->processing_time }} Weeks
							</div>
			
							<!-- Approval Status -->
							<div class="absolute bottom-2 right-2 text-xs">
								@if ($offer->is_approved)
									<span class="bg-green-600 text-white px-3 py-1 rounded-lg">Approved</span>
								@else
									<span class="bg-yellow-600 text-white px-3 py-1 rounded-lg">Pending</span>
								@endif
							</div>
						</div>
						<div class="p-4 flex-1">
							<!-- Country Name -->
							<h3 class="text-lg font-semibold text-gray-800">
								<a href="#" class="hover:text-indigo-600">
									{{ $offer->country_name }}
								</a>
							</h3>
							<!-- Degree and Cost -->
							<p class="mt-2 text-sm text-gray-600">
								<span class="font-bold">Degree:</span> {{ $offer->degree }}<br>
								<span class="font-bold">Cost:</span> {{ $offer->cost }}
							</p>
						</div>
						@auth
							@if (Auth::user()->agency && Auth::user()->agency->id === $offer->agency_id)
								<!-- Edit and Delete Actions -->
								<div class="p-2 border-t border-gray-200 flex justify-between items-center">
									<!-- Edit Button -->
									<button onclick="openEditModal({{ $offer->id }})" class="text-blue-600 hover:text-blue-800">
										<i class="fas fa-edit"></i> Edit
									</button>
									<!-- Delete Button -->
									<form action="{{ route('agency.deleteOffer', $offer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this offer?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-red-600 hover:text-red-800">
											<i class="fas fa-trash-alt"></i> Delete
										</button>
									</form>
								</div>
							@endif
						@endauth
					</div>
				@endforeach
			</div>
			
			
			
            @else
                <p class="text-gray-500">No offers available.</p>
            @endif
        </div>

        <!-- Blogs Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Our Blogs</h2>
                @auth
                    <button id="add-blog"
                        class="px-4 py-2 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700">
                        Add Blog
                    </button>
                @endauth
            </div>
            @if ($blogs->isNotEmpty())
                @foreach ($blogs as $blog)
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-xl font-bold text-indigo-600">{{ $blog->title }}</h3>
                        <p class="text-gray-600">{{!! \Illuminate\Support\Str::limit($blog->content, 150) !!}}</p>
                        <div class="flex justify-end space-x-4">
                            @auth
                                <button class="text-blue-600 hover:underline">Edit</button>
                                <button class="text-red-600 hover:underline">Delete</button>
                            @endauth
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">No blogs available.</p>
            @endif
        </div>
    </div>
    <!--modal to add offer-->
    <div id="offer-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl mx-auto relative overflow-y-auto max-h-[90vh]">
            <!-- Sticky Header with Title and Close Button -->
            <div class="sticky top-0 bg-white border-b border-gray-300 p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Add VisaPack Offer</h2>
                <button id="close-offer-modal" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times text-lg"></i><span>Close</span>
                </button>
            </div>

            <!-- Offer Form -->
            <div class="p-4">
                <form action="{{ route('agency.addOffer') }}" method="POST" enctype="multipart/form-data" id="offer-form">
                    @csrf
                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-bold">Title:</label>
                        <input type="text" id="title" name="title"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            value="{{ old('title', $visaPack->title ?? '') }}" required>
                    </div>


                    <!-- Country Name -->
                    <div class="mb-4">
                        <label for="country_name" class="block text-gray-700 font-bold">Country Name:</label>
                        <input type="text" id="country_name" name="country_name"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                    </div>

                    <!-- Degree -->
                    <div class="mb-4">
                        <label for="degree" class="block text-gray-700 font-bold">Degree:</label>
                        <input type="text" id="degree" name="degree"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                    </div>

                    <!-- Processing Time -->
                    <div class="mb-4">
                        <label for="processing_time" class="block text-gray-700 font-bold">Processing Time
                            (weeks):</label>
                        <input type="number" id="processing_time" name="processing_time"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                    </div>

                    <!-- Cost -->
                    <div class="mb-4">
                        <label for="cost" class="block text-gray-700 font-bold">Cost:</label>
                        <input type="number" id="cost" name="cost"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            required>
                    </div>

					<div class="mb-4 col-span-3 z-10">
						<label for="details">Details</label>
						<textarea id="details" name="details" class="rich-editor"
							placeholder="Write details here">
							
						</textarea>
					</div>

					<div class="mb-4">
						<label for="image" class="block text-gray-700 font-bold">Thumbnail Image:</label>
						<input type="file" id="image" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2">
						<div id="image-preview" class="mt-2">
							<!-- The existing image will be displayed here -->
						</div>
					</div>
					

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700">
                            Submit Offer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <!-- Modal Template for Adding Blog -->
    <div id="blog-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-lg">
            <!-- Blog Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('edit-profile').addEventListener('click', () => {
            const form = document.getElementById('agency-profile-form');
            form.classList.toggle('hidden');
        });

// Get modal elements
const offerModal = document.getElementById('offer-modal');
const addOfferButton = document.getElementById('add-offer');
const closeOfferModalButton = document.getElementById('close-offer-modal');
const offerForm = document.getElementById('offer-form');

// Show modal for "Add Offer"
if (addOfferButton) {
    addOfferButton.addEventListener('click', () => {
        // Reset the form fields for adding a new offer
        offerForm.reset();

        // Remove the hidden "_method" input for PUT if it exists
        const methodInput = offerForm.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        // Set the form action to the add route
        offerForm.action = `/agency/offers`; // This ensures POST is used for adding a new offer

        // Clear the TinyMCE editor content
        if (tinymce.get('details')) {
            tinymce.get('details').setContent('');
        }

        // Clear any image preview
        const imagePreview = document.getElementById('image-preview');
        if (imagePreview) {
            imagePreview.innerHTML = '';
        }

        // Set the modal title to "Add VisaPack Offer"
        document.querySelector('#offer-modal .sticky h2').innerText = 'Add VisaPack Offer';

        // Show the modal
        offerModal.classList.remove('hidden');
    });
}

// Show modal for "Edit Offer"
function openEditModal(offerId) {
    // Fetch the offer details using AJAX
    fetch(`/agency/offers/${offerId}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Failed to fetch offer details: ${response.statusText}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                throw new Error(data.error); // Handle backend errors
            }

            // Populate the form fields with fetched offer data
            document.getElementById('title').value = data.title || '';
            document.getElementById('country_name').value = data.country_name || '';
            document.getElementById('degree').value = data.degree || '';
            document.getElementById('processing_time').value = data.processing_time || '';
            document.getElementById('cost').value = data.cost || '';
            tinymce.get('details').setContent(data.details || ''); // Populate TinyMCE editor

            // Handle image display (if available)
            const imagePreview = document.getElementById('image-preview');
            if (data.image) {
                imagePreview.innerHTML = `<img src="/storage/${data.image}" alt="Offer Image" class="w-32 h-32 mt-2 rounded">`;
            } else {
                imagePreview.innerHTML = 'No image uploaded';
            }

            // Set the form action to the edit route and add the hidden "_method" input for PUT
            offerForm.action = `/agency/offers/${offerId}`;
            if (!offerForm.querySelector('input[name="_method"]')) {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                offerForm.appendChild(methodInput);
            }

            // Set the modal title to "Edit VisaPack Offer"
            document.querySelector('#offer-modal .sticky h2').innerText = 'Edit VisaPack Offer';

            // Show the modal
            offerModal.classList.remove('hidden');
        })
        .catch((error) => {
            console.error('Error fetching offer details:', error);
            alert('Failed to fetch offer details. Please try again.');
        });
}

// Close the modal
if (closeOfferModalButton) {
    closeOfferModalButton.addEventListener('click', () => {
        offerModal.classList.add('hidden');
    });
}

// Optional: Close modal when clicking outside of it
if (offerModal) {
    offerModal.addEventListener('click', (event) => {
        if (event.target === offerModal) {
            offerModal.classList.add('hidden');
        }
    });
}

    </script>
@endpush
