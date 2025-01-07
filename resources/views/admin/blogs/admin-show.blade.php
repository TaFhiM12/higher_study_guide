@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Manage Blogs</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                    <th class="px-4 py-2 border border-gray-200">#</th>
                    <th class="px-4 py-2 border border-gray-200">Title</th>
                    <th class="px-4 py-2 border border-gray-200">Country</th>
                    <th class="px-4 py-2 border border-gray-200">Degree</th>
                    <th class="px-4 py-2 border border-gray-200">Publisher</th>
                    <th class="px-4 py-2 border border-gray-200 text-center">Approval</th>
                    <th class="px-4 py-2 border border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $blog->title }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $blog->country_name }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $blog->degree_type }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-gray-700">{{ $blog->publishers }}</td>
                        <td class="px-4 py-2 border border-gray-200 text-center">
                            @if (!$blog->is_approved)
                                <!-- Red dot for unapproved -->
                                <i class="fas fa-circle text-red-600" title="Unapproved"></i>
                            @else
                                <!-- Green tick for approved -->
                                <i class="fas fa-check-circle text-green-600" title="Approved"></i>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-200 text-center flex items-center justify-center space-x-4">
                            <!-- Approve Icon -->
                            @if (!$blog->is_approved)
                                <a href="{{ route('admin.approve_post', $blog->id) }}" class="text-green-600 hover:text-green-800" title="Approve">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            @endif
                            <!-- Edit Icon -->
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Delete Icon -->
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this blog?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No blogs available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
