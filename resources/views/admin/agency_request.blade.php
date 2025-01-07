@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-3 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Manage Agency Requests</h1>
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="px-4 py-2 border border-gray-200 text-center w-16">#</th>
                    <th class="px-4 py-2 border border-gray-200 text-center w-28">Image</th>
                    <th class="px-4 py-2 border border-gray-200 text-left min-w-[150px]">Name</th>
                    <th class="px-4 py-2 border border-gray-200 text-left min-w-[200px]">Email</th>
                    <th class="px-4 py-2 border border-gray-200 text-center w-24">Approval</th>
                    <th class="px-4 py-2 border border-gray-200 text-center min-w-[150px]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($agencies as $agency)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <!-- Fixed image size and alignment -->
                            <div class="w-20 h-20 mx-auto">
                                <img src="{{ asset('storage/'.$agency->logo ?? 'default-profile.png') }}" 
                                     alt="Agency Image" 
                                     class="w-full h-full object-cover rounded-full border border-gray-300">
                            </div>
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 truncate">{{ $agency->user->name }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $agency->user->email }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            @if (!$agency->is_approved)
                                <i class="fas fa-circle text-red-600" title="Unapproved"></i>
                            @else
                                <i class="fas fa-check-circle text-green-600" title="Approved"></i>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @if (!$agency->is_approved)
                                    <a href="{{ route('admin.approve_agency', $agency->id) }}" class="text-green-600 hover:text-green-800" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                                <button onclick="showDetailsModal({{ $agency->id }})" class="text-blue-600 hover:text-blue-800" title="Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <form action="{{ route('admin.delete_agency', $agency->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this agency?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No agency requests available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Details Modal -->
<div id="details-modal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-2/3 lg:w-1/2 overflow-y-auto max-h-screen">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Agency Details</h2>
            <div id="details-content">
                <!-- Dynamic content loaded via JS -->
            </div>
            <div class="mt-4 text-right">
                <button onclick="closeDetailsModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDetailsModal(agencyId) {
    const url = `{{ route('admin.agency.details', ':id') }}`.replace(':id', agencyId);

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
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Email:</strong> ${data.email}</p>
				<p><strong>Phone:</strong> ${data.phone}</p>
                <p><strong>Additional Info:</strong></p>
				<p><strong>Website:</strong> ${data.website}</p>
				<p><strong>Address:</strong> ${data.address}</p>


               
            `;
            document.getElementById('details-content').innerHTML = content;
            document.getElementById('details-modal').classList.remove('hidden');
        })
        .catch(error => {
            alert(error.message || 'An error occurred while fetching details.');
            console.error(error);
        });
}

function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.getElementById('details-content').innerHTML = ''; // Clear content
}
</script>
@endpush
