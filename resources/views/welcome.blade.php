<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alignment - Semantic Matching Tool</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }
        .btn-custom {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="hero-bg min-h-screen flex flex-col text-white">

    <!-- Header / Navigation -->
    <header class="absolute top-0 left-0 w-full p-6 flex justify-end space-x-4 z-10">
        <a href="{{ url('/login') }}" class="btn-custom bg-white text-indigo-700 px-5 py-2 rounded-full font-semibold shadow-md hover:bg-indigo-50">Login</a>
        <a href="./register" class="btn-custom bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold shadow-md hover:bg-indigo-500">Register</a>
    </header>

    <!-- Hero Wrapper -->
    <div class="flex-1 flex flex-col justify-center items-center text-center px-4">
        <!-- Hero Section -->
        <div class="animate__animated animate__fadeInDown">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Welcome to <span class="text-yellow-300">Alignment</span></h1>
            <p class="text-lg md:text-xl mb-8">The ultimate semantic matching & RDF analysis tool for cultural heritage and linked data.</p>
            <div class="flex justify-center gap-4">
                <a href="./login" class="btn-custom bg-yellow-400 text-indigo-900 px-6 py-3 rounded-full font-semibold shadow-md hover:bg-yellow-300 animate__animated animate__pulse animate__infinite">Get Started</a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-20 max-w-5xl grid md:grid-cols-3 gap-8 text-indigo-50 animate__animated animate__fadeInUp">
            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center hover:scale-105 transform transition">
                <h3 class="text-xl font-bold mb-3">Upload RDF</h3>
                <p>Upload your RDF files and convert them into N-Triples with a single click.</p>
            </div>
            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center hover:scale-105 transform transition">
                <h3 class="text-xl font-bold mb-3">Generate Suggestions</h3>
                <p>Get automatic link suggestions between datasets using SKOS similarity.</p>
            </div>
            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center hover:scale-105 transform transition">
                <h3 class="text-xl font-bold mb-3">Create Projects</h3>
                <p>Build your own semantic projects, track links, and collaborate on public datasets.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto mb-4 text-indigo-100 text-sm animate__animated animate__fadeInUp text-center">
        &copy; <span id="current-year"></span> Alignment. All rights reserved.
    </footer>

</body>
    <script>
        document.getElementById("current-year").textContent = new Date().getFullYear();
    </script>
</html>
