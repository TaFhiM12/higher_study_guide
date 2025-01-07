<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - GradXplore</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center">

    <!-- Signup Form Container -->
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
        <!-- Branding -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-600">GradXplore</h1>
            <p class="text-gray-500">Empowering Students & Agencies Worldwide</p>
        </div>

        <h2 class="text-2xl font-bold text-center mb-6 text-indigo-600">Create Your Account</h2>
        <p class="text-center text-gray-500 mb-8">Join as a Student or an Agency</p>

        <!-- Form -->
        <form action="{{ route('signup') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-600">Full Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-600">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter your email address">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter a strong password">
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-semibold text-gray-600">Select Your Role</label>
                <select name="role" id="role" required
                    class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    onchange="toggleRoleFields()">
                    <option value="">Choose Role</option>
                    <option value="student">Student</option>
                    <option value="agency">Agency</option>
                </select>
            </div>

            <!-- Dynamic Fields -->
            <div id="student-fields" class="hidden">
                <!-- Current Institution -->
                <div class="mb-4">
                    <label for="current_institution" class="block text-sm font-semibold text-gray-600">Current
                        Institution</label>
                    <input type="text" name="current_institution" id="current_institution"
                        class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your current institution">
                </div>
            </div>

            <div id="agency-fields" class="hidden">
                <!-- Website -->
                <div class="mb-4">
                    <label for="website" class="block text-sm font-semibold text-gray-600">Website</label>
                    <input type="url" name="website" id="website"
                        class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your website URL">
                </div>

                <!-- TIN -->
                <div class="mb-4">
                    <label for="tin" class="block text-sm font-semibold text-gray-600">TIN</label>
                    <input type="text" name="tin" id="tin"
                        class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your TIN number">
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-semibold text-gray-600">Address</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full mt-1 p-3 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your address"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Sign Up
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript for Dynamic Fields -->
    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            const studentFields = document.getElementById('student-fields');
            const agencyFields = document.getElementById('agency-fields');

            if (role === 'student') {
                studentFields.classList.remove('hidden');
                agencyFields.classList.add('hidden');
            } else if (role === 'agency') {
                agencyFields.classList.remove('hidden');
                studentFields.classList.add('hidden');
            } else {
                studentFields.classList.add('hidden');
                agencyFields.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
