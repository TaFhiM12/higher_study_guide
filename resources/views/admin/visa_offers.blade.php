@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-3 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Manage All Visa Offers</h1>
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="px-4 py-2 border border-gray-200 text-center w-16">#</th>
                    <th class="px-4 py-2 border border-gray-200 text-center w-28">Image</th>
                    <th class="px-4 py-2 border border-gray-200 text-left min-w-[150px]">Offer Title</th>
                    <th class="px-4 py-2 border border-gray-200 text-left min-w-[200px]">Country</th>
                    <th class="px-4 py-2 border border-gray-200 text-center w-24">Approval</th>
                    <th class="px-4 py-2 border border-gray-200 text-center min-w-[150px]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visaOffers as $visaOffer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <div class="w-20 h-20 mx-auto">
                                <img src="{{ asset('storage/'.$visaOffer->image ?? 'default-image.png') }}" 
                                     alt="Visa Offer Image" 
                                     class="w-full h-full object-cover rounded-full border border-gray-300">
                            </div>
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 truncate">{{ $visaOffer->title }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $visaOffer->country_name }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            @if (!$visaOffer->is_approved)
                                <i class="fas fa-circle text-red-600" title="Unapproved"></i>
                            @else
                                <i class="fas fa-check-circle text-green-600" title="Approved"></i>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @if (!$visaOffer->is_approved)
                                    <a href="{{ route('admin.approve_visa_offer', $visaOffer->id) }}" class="text-green-600 hover:text-green-800" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                                <button onclick="showDetailsModal({{ $visaOffer->id }})" class="text-blue-600 hover:text-blue-800" title="Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <form action="{{ route('admin.delete_visa_offer', $visaOffer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this visa offer?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No visa offers available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Details Modal -->
<div id="details-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl mx-auto max-h-screen overflow-y-auto relative">
        <!-- Close Button -->
        <button onclick="closeDetailsModal()" class="absolute top-3 right-3 text-red-600 hover:text-red-800">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Modal Content -->
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Visa Offer Details</h2>
            <div id="details-content" class="text-gray-700">
                <!-- Dynamic content loaded via JS -->
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 bg-gray-100 text-right">
            <button onclick="closeDetailsModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Close</button>
        </div>
    </div>
</div>




@endsection

@push('scripts')
<script>
function showDetailsModal(visaOfferId) {
    const url = `{{ route('admin.visa_offer.details', ':id') }}`.replace(':id', visaOfferId);

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch details. Server responded with status ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Failed to fetch details.');
            }
            const content = `
                <p><strong>Offer Title:</strong> ${data.title}</p>
                <p><strong>Country:</strong> ${data.country || 'Not Specified'}</p>
                <p><strong>Details:</strong></p>
                <p>${data.details || 'No details available.'}</p>
            `;
            document.getElementById('details-content').innerHTML = content;
            document.getElementById('details-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent background scrolling
        })
        .catch(error => {
            alert(error.message || 'An error occurred while fetching details.');
            console.error(error);
        });
}

function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.getElementById('details-content').innerHTML = ''; // Clear content
    document.body.classList.remove('overflow-hidden'); // Re-enable background scrolling
}


function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.getElementById('details-content').innerHTML = ''; // Clear content
    document.body.classList.remove('overflow-hidden'); // Re-enable background scrolling
}


function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.getElementById('details-content').innerHTML = ''; // Clear content
    document.body.classList.remove('overflow-hidden'); // Re-enable background scrolling
}


function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.getElementById('details-content').innerHTML = ''; // Clear content
    document.body.classList.remove('overflow-hidden'); // Enable background scrolling
}
</script>
@endpush
