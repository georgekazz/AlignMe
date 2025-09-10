<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
</head>

<body class="bg-indigo-900 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-md w-full animate__animated animate__fadeInDown">
        <h2 class="text-3xl font-bold text-indigo-900 mb-6 text-center">Login to <span
                class="text-yellow-400">AlignMe</span></h2>

        <div class="mt-6 text-center">
            <button onclick="window.location.href='./'"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span>Back to Home</span>
            </button>
        </div>

        <form id="loginForm" class="max-w-sm mx-auto mt-10 p-6 bg-white rounded-lg shadow-md space-y-5">
            <h2 class="text-2xl font-bold text-center text-gray-700">Login</h2>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" id="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 text-gray-700" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <input type="password" id="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 text-gray-700" />
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">
                Login
            </button>
        </form>


        <p class="mt-6 text-center text-indigo-700">
            Don't have an account?
            <a href="./register" class="text-yellow-400 font-semibold hover:underline">Register</a>
        </p>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('http://127.0.0.1:8000/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();
            console.log(data);

            if (response.ok) {
                localStorage.setItem('token', data.access_token);

                window.location.href = './dashboard';
            } else {
                alert('Login failed: ' + JSON.stringify(data.detail));
            }
        });
    </script>

</body>

</html>