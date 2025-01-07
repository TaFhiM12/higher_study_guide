@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8 mt-8">
    <!-- Blog Title and Meta -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-indigo-600 mb-4">{{ $post->title }}</h1>
        <p class="text-gray-500 text-sm">
            Published on {{ $post->created_at->format('F d, Y') }} | 
            By <span class="text-indigo-500 font-semibold">{{ $post->user->name }}</span> | 
            Country: <span class="text-indigo-500 font-semibold">{{ $post->country_name }}</span>
        </p>
    </div>

    <!-- Blog Image -->
    <div class="mb-8">
        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="max-w-md rounded-lg shadow-lg">
    </div>

    <!-- Blog Content -->
    <div class="prose lg:prose-xl max-w-none text-gray-800 leading-relaxed mb-12">
        {!! $post->post_content !!}
    </div>

    <!-- Comments Section -->
    <div class="bg-gray-50 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Comments</h2>

        {{-- <!-- Add Comment (Authenticated Users Only) -->
        @auth
        <div class="mb-6">
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-4">
                @csrf
                <textarea 
                    name="comment" 
                    rows="4" 
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                    placeholder="Write your comment..."></textarea>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">
                    Post Comment
                </button>
            </form>
        </div>
        @endauth

        <!-- Display Comments -->
        <div class="space-y-6">
            @forelse ($post->comments as $comment)
            <div class="flex space-x-4">
                <div class="w-12 h-12">
                    <img src="{{ asset($comment->user->avatar ?? 'default-avatar.png') }}" alt="{{ $comment->user->name }}" class="rounded-full">
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $comment->user->name }}</h4>
                    <p class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                    <p class="text-gray-700 mt-2">{{ $comment->content }}</p>
                </div>
            </div>
            @empty
            <p class="text-gray-500">No comments yet. Be the first to comment!</p>
            @endforelse
        </div> --}}
    </div>
</div>
@endsection
