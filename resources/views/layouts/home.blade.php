<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GradXplore</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{asset('/style.css')}}">
  <link rel="icon" href="{{ asset('front/image/favicon.png') }}" type="image/png">
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
<body class="bg-gray-100 geologica">
  <nav class="bg-white shadow fixed top-0 left-0 right-0 z-50">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-2">
        <!-- Brand Name -->
        <a href="/" class="hidden sm:inline-block text-2xl font-bold text-blue-600">GradXplore</a>
		<a href="/" class="sm:hidden text-2xl font-bold text-blue-600 bg-amber-400 px-2 rounded-lg">G</a>

        <!-- Icons for large screens -->
        <div class="flex space-x-4 items-center">
          <a href="/" class="p-2 text-gray-600 hover:text-blue-600">
            <img src="{{asset('/front/image/home-icon.svg')}}" alt="" class="w-6 h-6">
          </a>
          <a href="{{route('home.blog')}}" class="p-2 text-gray-600 hover:text-blue-600">
			<img src="{{asset('/front/image/blog-icon.svg')}}" alt="" class="w-6 h-6">

          </a>
          <a href="#" class="p-2 text-gray-600 hover:text-blue-600">
			<img src="{{asset('/front/image/passport-icon.svg')}}" alt="" class="w-6 h-6">

          </a>
          <button id="dropdown-btn" class="p-2 text-gray-600 hover:text-blue-600">
			<img src="{{asset('/front/image/menu-icon.svg')}}" alt="" class="w-6 h-6">

          </button>
        </div>

      </div>

      <!-- Dropdown menu -->
      <div id="dropdown-menu" class="hidden bg-white shadow-md absolute right-4 top-12 rounded-lg w-44 z-50">
        @if(Auth::check())
            @if(Auth::user()->student)
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">My Profile</a>
                <a href="{{ route('student.eligibility') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Eligibility Check</a>
            @elseif(Auth::user()->agency)
                <a href="{{ route('agency.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">My Profile</a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Admin Dashboard</a>
            @endif
            <a href="{{ route('logout') }}" 
               class="block px-4 py-2 text-gray-700 hover:bg-teal-400" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>
            <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            <a href="{{ route('home.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Login</a>
            <a href="{{route('signup.show')}}" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Sign Up</a>
        @endif
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Our Pride</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-teal-400">Support</a>
    </div>
    
    
    

     
    </div>
  </nav>
  <main class="relative">
	@yield('content')
  </main>

  <script>
    const dropdownBtn = document.getElementById('dropdown-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');
    

    dropdownBtn.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
    });


  </script>
  @stack('scripts')
</body>
</html>
