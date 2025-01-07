<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GradXplore Admin Panel</title>

    <!-- TailwindCSS -->
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.rich-editor', // Class selector for the textareas
            plugins: 'lists table code link', // Add text alignment and font size plugins
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | fontsizeselect | table | code',
            menubar: true, // Disable the menu bar
            height: 300, // Set initial height of the editor box
            width: '100%', // Set initial width to 100% of the container
            content_style: "body { font-family:Arial,Helvetica,sans-serif; font-size:14px }", // Define default font and size
            license_key: 'gpl',
        });
    </script>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <!-- Mobile Hamburger -->
        <button id="mobile-menu-toggle" class="lg:hidden bg-indigo-600 text-white p-4 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-indigo-600 text-white w-64 h-full fixed lg:relative transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h2 class="text-2xl font-bold">GradXplore</h2>
                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-users mr-2"></i> Users Request
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-file-alt mr-2"></i> Reports
                        </a>
                    </li>

                    <!-- Blog Dropdown Menu -->
                    <li class="relative">
                        <button id="blog-dropdown-btn"
                            class="w-full text-left px-4 py-2 rounded hover:bg-indigo-700 flex items-center justify-between focus:outline-none">
                            <span>
                                <i class="fas fa-blog mr-2"></i> Blog
                            </span>
                            <i id="blog-dropdown-icon" class="fas fa-chevron-down"></i>
                        </button>
                        <ul id="blog-dropdown-menu" class="hidden mt-2 space-y-2 pl-6">
                            <li>
                                <a href="{{ route('blogs.admin_show') }}"
                                    class="block px-4 py-2 rounded hover:bg-indigo-700">List Blogs</a>
                            </li>
                            <li>
                                <a href="{{ route('blogs.admin_show') }}"
                                    class="block px-4 py-2 rounded hover:bg-indigo-700">Admin Blogs</a>
                            </li>
                            <li>
                                <a href="{{ route('blogs.create') }}"
                                    class="block px-4 py-2 rounded hover:bg-indigo-700">Create Blog</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-user-circle mr-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('clogout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="block px-4 py-2 rounded hover:bg-indigo-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                        
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-white overflow-auto">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Sidebar toggle for mobile
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebar = document.getElementById('sidebar');

        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Blog dropdown toggle
        const blogDropdownBtn = document.getElementById('blog-dropdown-btn');
        const blogDropdownMenu = document.getElementById('blog-dropdown-menu');
        const blogDropdownIcon = document.getElementById('blog-dropdown-icon');

        blogDropdownBtn.addEventListener('click', () => {
            blogDropdownMenu.classList.toggle('hidden');
            blogDropdownIcon.classList.toggle('fa-chevron-down');
            blogDropdownIcon.classList.toggle('fa-chevron-up');
        });
    </script>
    @stack('scripts')

</body>

</html>
