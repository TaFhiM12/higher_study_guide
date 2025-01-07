@extends('layouts.home')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

        <style>
            body {
                overflow-x: hidden;
                /* Prevent horizontal scrollbar */
            }
        </style>
    @endpush

    <div class="bg-gray-100 font-medium px-4 py-8 mt-8">
        <div class="grid md:grid-cols-2 items-center gap-8 max-w-5xl max-md:max-w-md mx-auto">
            <!-- Left Section (Form) -->
            <div class="w-full max-w-md bg-white shadow-md border border-pink-300 rounded-lg p-6 relative">
                <div class="text-center">
                    <h4 class="text-indigo-600 text-2xl font-extrabold">Log In to GradXplore</h4>
                    <p class="text-sm text-gray-500 mt-3">Access your GradXplore account</p>
                </div>

                <div class="bg-gray-50">
                    <div class="flex flex-col items-center justify-center py-6 px-4">


                        <div class="px-3 w-full py-4 rounded-2xl bg-white shadow">

                            <form id="login-form" action="{{ route('clogin') }}" method="POST" class="space-y-4 mt-8">
                                @csrf
                                <!-- Email Field -->
                                <div class="relative flex items-center">
                                    <input type="email" name="email" placeholder="Enter Email"
                                        class="pl-4 pr-10 py-3 bg-white text-gray-800 w-full text-sm border border-gray-300 focus:border-indigo-600 outline-none rounded-lg"
                                        required />
                                </div>

                                <!-- Password Field -->
                                <div class="relative flex items-center">
                                    <input type="password" name="password" placeholder="Enter Password"
                                        class="pl-4 pr-10 py-3 bg-white text-gray-800 w-full text-sm border border-gray-300 focus:border-indigo-600 outline-none rounded-lg"
                                        required />
                                </div>

                                <!-- Remember Me -->
                                <div class="flex items-center">
                                    <input type="checkbox" id="remember-me" name="remember"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="remember-me" class="text-sm ml-2 text-gray-500">Remember Me</label>
                                </div>

                                <!-- Login Button -->
                                <div class="!mt-8">
                                    <button type="submit"
                                        class="px-6 py-3 tracking-wide w-full font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                                        Log In
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


                <hr class=" border-gray-300" />
                <p class="text-sm text-center text-gray-500">Don't have an account? <a href="{{route('signup.show')}}"
                        class="text-sm text-indigo-600 font-semibold whitespace-nowrap">Sign up</a></p>
            </div>

            <!-- Right Section (Information) -->
            <div class="max-md:text-center">
                <h3 class="text-gray-800 md:text-4xl text-2xl font-extrabold md:leading-[42px]">Your Future Awaits with
                    GradXplore</h3>
                <p class="mt-6 text-sm text-gray-500">
                    GradXplore is your gateway to higher education abroad. We assist students with applications, visas, and
                    everything in between, ensuring a seamless journey toward academic success.
                </p>
                <button type="button"
                    class="px-6 py-3 tracking-wide mt-6 font-semibold bg-amber-400 hover:bg-amber-500 text-white rounded-lg">Learn
                    More</button>
            </div>
        </div>
    </div>

    <section class="bg-gray-100 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-[gold] mb-6">Visa Offers for Students</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($offers as $offer)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 flex flex-col">
                <div class="relative">
                    <!-- Image -->
                    <img src="{{ asset('storage/'.$offer->image) }}" alt="{{ $offer->country_name }}" class="w-full h-44 object-cover">
                    
                    <!-- Processing Time -->
                    <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-3 py-1 rounded-lg">
                        Processing Time: {{ $offer->processing_time }} Weeks
                    </div>
    
                    <!-- Agency Name -->
                    <div class="absolute bottom-2 right-2 text-xs">
                        <span class="bg-yellow-600 text-white px-3 py-1 rounded-lg">{{$offer->agency->user->name}}</span>
                    </div>
                    <div class="absolute bottom-2 left-2 text-xs">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-lg">{{$offer->country_name}}</span>
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <!-- Country Name -->
                    <h3 class="text-lg font-semibold text-gray-800">
                        <a href="#" class="hover:text-indigo-600">
                            {{ $offer->title }}
                        </a>
                    </h3>
                    <!-- Degree and Cost -->
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-bold">Degree:</span> {{ $offer->degree }}<br>
                        <span class="font-bold">Cost:</span> {{ $offer->cost }} Taka
                    </p>
                </div>
            
            </div>
                
            @endforeach
            <!-- Visa Offer Cards -->
                <!-- Card -->

            
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-12 px-4">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Reviews from Students</h2>
            <p class="text-sm text-gray-600 mb-12">Hear from students who have successfully achieved their dreams with
                GradXplore.</p>

            <!-- Swiper Slider -->
            <div class="swiper">
                <div class="swiper-wrapper mb-10 md:mb-14">
                    <!-- Slide 1 -->
                    <div class="swiper-slide bg-white shadow-lg rounded-lg p-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('/path/to/student1.jpg') }}" alt="Student 1" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">John Doe</h4>
                                <p class="text-sm text-gray-500">USA - Master's Degree</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            GradXplore guided me every step of the way. The application process was seamless, and I couldn't
                            have done it without their help!
                        </p>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide bg-white shadow-lg rounded-lg p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('/path/to/student2.jpg') }}" alt="Student 2" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">Jane Smith</h4>
                                <p class="text-sm text-gray-500">UK - Undergraduate Degree</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            I had so many questions about studying abroad, but GradXplore answered them all. I highly
                            recommend their services!
                        </p>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide bg-white shadow-lg rounded-lg p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('/path/to/student3.jpg') }}" alt="Student 3"
                                class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">Ali Khan</h4>
                                <p class="text-sm text-gray-500">Canada - PhD</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            The team at GradXplore is amazing. They made my dream of studying in Canada a reality. Thank you
                            so much!
                        </p>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-center text-4xl font-extrabold text-blue-600 mb-8">Why Choose GradXplore?</h2>
            <p class="text-center text-lg text-gray-600 mb-12">
                Empowering students worldwide to achieve their academic dreams. See why thousands trust GradXplore for their
                higher education journey.
            </p>

            <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-x-6 gap-y-12 divide-x divide-gray-300">
                <!-- Unique Visitors -->
                <div class="text-center px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-10 inline-block"
                        viewBox="0 0 512 512">
                        <!-- SVG Path -->
                    </svg>
                    <h3 class="text-3xl font-extrabold text-blue-600 mt-5">400+</h3>
                    <p class="text-base text-gray-800 font-semibold mt-3">Daily Unique Visitors</p>
                    <p class="text-sm text-gray-600 mt-2">
                        Students from over 50 countries explore academic opportunities through GradXplore every day.
                    </p>
                </div>

                <!-- Total Sales -->
                <div class="text-center px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-10 inline-block"
                        viewBox="0 0 512 512">
                        <!-- SVG Path -->
                    </svg>
                    <h3 class="text-3xl font-extrabold text-blue-600 mt-5">450+</h3>
                    <p class="text-base text-gray-800 font-semibold mt-3">Successful Applications</p>
                    <p class="text-sm text-gray-600 mt-2">
                        From visa assistance to admission letters, we've guided hundreds of students toward their dream
                        universities.
                    </p>
                </div>

                <!-- Customer Satisfaction -->
                <div class="text-center px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-10 inline-block" viewBox="0 0 28 28">
                        <!-- SVG Path -->
                    </svg>
                    <h3 class="text-3xl font-extrabold text-blue-600 mt-5">500+</h3>
                    <p class="text-base text-gray-800 font-semibold mt-3">5-Star Reviews</p>
                    <p class="text-sm text-gray-600 mt-2">
                        Trusted by students and parents alike for our transparent processes and dedicated support.
                    </p>
                </div>

                <!-- System Uptime -->
                <div class="text-center px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-10 inline-block"
                        viewBox="0 0 512 512">
                        <!-- SVG Path -->
                    </svg>
                    <h3 class="text-3xl font-extrabold text-blue-600 mt-5">99.9%</h3>
                    <p class="text-base text-gray-800 font-semibold mt-3">System Uptime</p>
                    <p class="text-sm text-gray-600 mt-2">
                        Our platform ensures a smooth, uninterrupted experience for students around the globe.
                    </p>
                </div>
            </div>
        </div>
    </div>


    <footer class="bg-gray-900 pt-12 pb-6 px-10 font-sans tracking-wide relative">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Quick Links -->
                <div>
                    <h2 class="text-white text-sm uppercase font-semibold mb-4">Quick Links</h2>
                    <ul class="space-y-3">
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Home</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Services</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Follow Us -->
                <div>
                    <h2 class="text-white text-sm uppercase font-semibold mb-4">Follow Us</h2>
                    <ul class="space-y-3">
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Facebook</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">LinkedIn</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Instagram</a>
                        </li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h2 class="text-white text-sm uppercase font-semibold mb-4">Company</h2>
                    <ul class="space-y-3">
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">About Us</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="text-gray-400 hover:text-white text-sm transition-all">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>

                <!-- Brand Name -->
                <div class="flex items-center lg:justify-center">
                    <h1 class="text-white text-2xl font-bold">GradXplore</h1>
                </div>
            </div>

            <hr class="mt-12 mb-6 border-gray-600" />

            <div class="flex sm:justify-between flex-wrap gap-6">
                <!-- Social Media Icons -->
                <div class="flex space-x-5">
                    <a href="javascript:void(0)" class="text-gray-400 hover:text-white transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.558V12h2.77l-.443 2.89h-2.327V22C18.343 21.128 22 16.991 22 12z">
                            </path>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="text-gray-400 hover:text-white transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2C6.486 2 2 6.486 2 12c0 5.513 4.486 10 10 10s10-4.487 10-10c0-5.514-4.486-10-10-10zm0 1.542c4.951 0 8.458 3.392 8.458 8.458 0 4.949-3.391 8.458-8.458 8.458-4.948 0-8.458-3.391-8.458-8.458 0-4.949 3.392-8.458 8.458-8.458zM9.743 16.747V7.128l6.027 4.31-6.027 4.309z">
                            </path>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="text-gray-400 hover:text-white transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M21 5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5zm-2.5 8.2v5.3h-2.79v-4.93a1.4 1.4 0 0 0-1.4-1.4c-.77 0-1.39.63-1.39 1.4v4.93h-2.79v-8.37h2.79v1.11c.48-.78 1.47-1.3 2.32-1.3 1.8 0 3.26 1.46 3.26 3.26zM6.88 8.56a1.686 1.686 0 0 0 0-3.37 1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68zm1.39 1.57v8.37H5.5v-8.37h2.77z">
                            </path>
                        </svg>
                    </a>
                </div>

                <!-- Copyright -->
                <p class="text-gray-400 text-sm">© 2025 GradXplore. All rights reserved.</p>
            </div>
        </div>
    </footer>
@endsection

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const swiper = new Swiper('.swiper', {
                slidesPerView: 1,
                spaceBetween: 16,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        });
    </script>
@endpush
