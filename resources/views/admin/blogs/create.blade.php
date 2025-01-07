@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Create New Blog</h1>
    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-lg">
        @csrf

        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-600">Title</label>
            <input type="text" name="title" id="title" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" placeholder="Enter Blog Title" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-600">Image</label>
            <input type="file" name="image" id="image" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Country -->
        <div>
            <label for="country_name" class="block text-sm font-semibold text-gray-600">Country</label>
            <select name="country_name" id="country_name" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                @foreach (countries() as $code => $details)
                    <option value="{{ $code }}">{{ $details['name'] }}</option>
                @endforeach
            </select>
            @error('country_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Degree Type -->
        <div>
            <label for="degree_type" class="block text-sm font-semibold text-gray-600">Degree Type</label>
            <select name="degree_type" id="degree_type" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Masters">Masters</option>
                <option value="PhD">PhD</option>
            </select>
            @error('degree_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-4 col-span-3 z-10">
            <label for="post_content">Content</label>
            <textarea id="post_content" name="post_content" class="rich-editor"
                placeholder="Write blog here">
                
            </textarea>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700">
                Create Blog
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')




</script>
@endpush
