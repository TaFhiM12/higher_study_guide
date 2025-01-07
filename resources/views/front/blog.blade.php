@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8 mt-8">
    <!-- Blog Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-xl sm:text-4xl lg:text-4xl font-bold text-indigo-600">Study Abroad Blog</h1>
        <div class="relative w-1/3">
            <input 
                type="text" 
                id="search" 
                class="w-full px-4 py-2 border rounded-lg shadow focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                placeholder="Search articles..."
            />
            <span class="absolute right-3 top-2 text-gray-400"><i class="fas fa-search"></i></span>
        </div>
    </div>

    <!-- Blog Posts -->
    <div id="blog-posts" class="space-y-6">
        @forelse ($posts as $post)
        <div class="flex flex-col md:flex-row items-start space-x-0 md:space-x-4 border-b pb-4">
            <div class="w-full md:w-1/4">
                <a href="{{ route('home.blog.show', $post->id) }}">
                    <img src="{{ asset('storage/'.$post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-auto rounded-lg shadow-md md:h-40 lg:h-48">
                </a>
            </div>
            <div class="w-full md:w-3/4">
                <a href="{{ route('home.blog.show', $post->id) }}">
                    <h2 class="text-lg md:text-2xl font-bold text-indigo-600 hover:underline">{{ $post->title }}</h2>
                </a>
                <p class="text-gray-500 text-xs md:text-sm mb-2">Published: {{ $post->created_at->format('M d, Y') }}</p>
                <p class="text-gray-600 text-sm md:text-base">{{ \Illuminate\Support\Str::limit(strip_tags($post->post_content), 300) }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500">
            No blog posts found.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links('pagination::tailwind') }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search');
    const blogPostsContainer = document.getElementById('blog-posts');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim(); // Get the search query

        if (query === '') {
            // Reload the original posts if the search box is empty
            fetch('{{ route('home.blog') }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newPosts = doc.querySelector('#blog-posts').innerHTML;
                    blogPostsContainer.innerHTML = newPosts;
                })
                .catch(error => console.error('Error fetching posts:', error));
            return;
        }

        // Make an AJAX request to the search endpoint
        fetch('{{ route('home.blog.search') }}?q=' + encodeURIComponent(query))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch search results.');
                }
                return response.json();
            })
            .then(data => {
                blogPostsContainer.innerHTML = ''; // Clear the current posts

                if (data.posts.length === 0) {
                    blogPostsContainer.innerHTML = '<p class="text-gray-500">No articles found.</p>';
                    return;
                }

                // Display the search results
                data.posts.forEach(post => {
                    const postElement = `
                        <div class="flex items-start space-x-4 border-b pb-4">
                            <div class="w-1/4">
                                <a href="{{ route('home.blog.show', '') }}/${post.id}">
                                    <img src="${post.image}" alt="${post.title}" class="w-full h-auto rounded-lg shadow-md">
                                </a>
                            </div>
                            <div class="w-3/4">
                                <a href="{{ route('home.blog.show', '') }}/${post.id}">
                                    <h2 class="text-2xl font-bold text-indigo-600 hover:underline">${post.title}</h2>
                                </a>
                                <p class="text-gray-500 text-sm mb-2">Published: ${new Date(post.created_at).toLocaleDateString()}</p>
                                <p class="text-gray-600">${post.excerpt}</p>
                            </div>
                        </div>
                    `;
                    blogPostsContainer.innerHTML += postElement;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                blogPostsContainer.innerHTML = '<p class="text-gray-500">Failed to fetch articles. Please try again later.</p>';
            });
    });
</script>
@endpush
