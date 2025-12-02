<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register - AlignMe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="icon" href="./img/favicon.png" type="image/x-icon">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    #bgCanvas {
      position: fixed;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>

<body
  class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100">

  <canvas id="bgCanvas"></canvas>

  <div
    class="bg-white/90 backdrop-blur rounded-2xl shadow-2xl p-10 w-full max-w-md transform transition-all duration-500 hover:scale-[1.02]">

    <div class="mb-6">
      <button onclick="window.location.href='./'"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <span>Back to Home</span>
      </button>
    </div>

    <h1 class="text-3xl font-extrabold text-indigo-900 mb-6 text-center">
      Create <span class="text-pink-500">Account</span>
    </h1>

    <form id="registerForm" class="space-y-5">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
        <div class="relative">
          <input type="text" id="name" placeholder="John Doe" required
            class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 text-gray-700" />
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5.121 17.804A9.965 9.965 0 0112 15c2.21 0 4.248.72 5.879 1.927M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
        <div class="relative">
          <input type="email" id="email" placeholder="you@example.com" required
            class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 text-gray-700" />
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 12H8m0 0a4 4 0 018 0m-8 0a4 4 0 01-8 0m16 0a4 4 0 018 0" />
          </svg>
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
        <div class="relative">
          <input type="password" id="password" placeholder="********" required
            class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 text-gray-700" />
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 11c0-1.105.895-2 2-2s2 .895 2 2m-6 0c0-1.105.895-2 2-2s2 .895 2 2m-2 9v2m0-8v2m0-8v2" />
          </svg>
        </div>
      </div>

      <button type="submit"
        class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
        Register
      </button>
    </form>

    <p class="mt-6 text-center text-gray-700">
      Already have an account?
      <a href="./login" class="text-indigo-600 font-semibold hover:underline">Login</a>
    </p>
  </div>
  <script>
    window.apiBaseUrl = "{{ config('api.base_url') }}";

    const canvas = document.getElementById("bgCanvas");
    const ctx = canvas.getContext("2d");
    let nodes = [];

    function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      nodes = Array.from({ length: 25 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        dx: (Math.random() - 0.5) * 0.7,
        dy: (Math.random() - 0.5) * 0.7
      }));
    }
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let i = 0; i < nodes.length; i++) {
        for (let j = i + 1; j < nodes.length; j++) {
          const a = nodes[i];
          const b = nodes[j];
          const dist = Math.hypot(a.x - b.x, a.y - b.y);
          if (dist < 150) {
            ctx.strokeStyle = "rgba(79,70,229,0.2)";
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.stroke();
          }
        }
      }

      nodes.forEach(node => {
        ctx.beginPath();
        ctx.arc(node.x, node.y, 3, 0, Math.PI * 2);
        ctx.fillStyle = "#a02dd4ff";
        ctx.fill();

        node.x += node.dx;
        node.y += node.dy;
        if (node.x < 0 || node.x > canvas.width) node.dx *= -1;
        if (node.y < 0 || node.y > canvas.height) node.dy *= -1;
      });

      requestAnimationFrame(draw);
    }

    draw();
  </script>
  <script>
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      try {
        const response = await fetch(`${window.apiBaseUrl}/register`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, password })
        });

        const data = await response.json();

        if (response.ok) {
          alert('🎉 Registration successful! You can now login.');
          window.location.href = './login';
        } else {
          alert('❌ Registration failed: ' + (data.detail || "Unknown error"));
        }
      } catch (err) {
        console.error(err);
        alert("⚠️ Server error, please try again later.");
      }
    });
  </script>

</body>

</html>