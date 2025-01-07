@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-3 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Manage Student Requests</h1>
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
                @forelse ($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <!-- Fixed image size and alignment -->
                            <div class="w-20 h-20 mx-auto">
                                <img src="{{ asset('storage/'.$student->image ?? 'default-profile.png') }}" 
                                     alt="Student Image" 
                                     class="w-full h-full object-cover rounded-full border border-gray-300">
                            </div>
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700 truncate">{{ $student->user->name }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $student->user->email }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            @if (!$student->is_approved)
                                <i class="fas fa-circle text-red-600" title="Unapproved"></i>
                            @else
                                <i class="fas fa-check-circle text-green-600" title="Approved"></i>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @if (!$student->is_approved)
                                    <a href="{{ route('admin.approve_student', $student->id) }}" class="text-green-600 hover:text-green-800" title="Approve">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                                <button onclick="showDetailsModal({{ $student->id }})" class="text-blue-600 hover:text-blue-800" title="Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this student?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No student requests available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




<!-- Details Modal -->
<div id="details-modal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-2/3 lg:w-1/2">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Student Details</h2>
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
	function showDetailsModal(studentId) {
		const url = `{{ route('admin.student.details', ':id') }}`.replace(':id', studentId);
	
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
	
				// Check if academic info exists and is an array
				const academicInfo = Array.isArray(data.academic) && data.academic.length > 0
					? data.academic.map(a => `
						<li>${a.exam_name} - ${a.institution} (${a.result}/${a.scale}) - ${a.passing_year}</li>
					  `).join('')
					: `<p class="text-gray-500">Not provided</p>`;
	
				const content = `
					<p><strong>Name:</strong> ${data.name}</p>
					<p><strong>Email:</strong> ${data.email}</p>
					<p><strong>Academic Info:</strong></p>
					<ul class="list-disc ml-6">
						${academicInfo}
					</ul>
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
