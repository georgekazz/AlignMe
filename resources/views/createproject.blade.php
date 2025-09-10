<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
</head>

<body
    class="bg-gradient-to-br from-purple-900 via-indigo-800 to-indigo-700 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Background Semantic Web Effect -->
    <div class="absolute inset-0">
        <canvas id="bgCanvas" class="w-full h-full"></canvas>
    </div>

    <div
        class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-lg relative z-10 animate__animated animate__fadeInDown">
        <!-- Back Button -->
        <div class="mb-6">
            <button onclick="window.location.href='./dashboard'"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span>Back to Dashboard</span>
            </button>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold mb-6 text-indigo-900 text-center">Create <span class="text-pink-500">New Project</span>
        </h2>

        <!-- Form -->
        <form id="createProjectForm" class="space-y-5">
            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="projectName">Project Name</label>
                <input type="text" id="projectName" placeholder="Enter project name" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="file1">Select First RDF File</label>
                <select id="file1" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">-- Choose File --</option>
                </select>
            </div>

            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="file2">Select Second RDF File</label>
                <select id="file2" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">-- Choose File --</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-yellow-400 text-indigo-900 font-bold py-3 rounded-lg hover:bg-yellow-300 transition transform hover:scale-105 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8M8 16l4-4 4 4" />
                </svg>
                Create Project
            </button>
        </form>
    </div>

    <script>

        const token = localStorage.getItem('token');

        async function loadUserFiles() {
            try {
                const response = await fetch('http://127.0.0.1:8000/my-files', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });
                if (!response.ok) throw new Error('Failed to fetch files');

                const files = await response.json();
                const file1Select = document.getElementById('file1');
                const file2Select = document.getElementById('file2');

                files.forEach(file => {
                    if (file.parsed) {
                        const option1 = document.createElement('option');
                        option1.value = file.id;
                        option1.textContent = file.filename;
                        file1Select.appendChild(option1);

                        const option2 = document.createElement('option');
                        option2.value = file.id;
                        option2.textContent = file.filename;
                        file2Select.appendChild(option2);
                    }
                });

            } catch (err) {
                console.error(err);
                alert('Error loading files');
            }
        }

        loadUserFiles();

        document.getElementById('createProjectForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('projectName').value;
            const file1_id = document.getElementById('file1').value;
            const file2_id = document.getElementById('file2').value;

            if (file1_id === file2_id) {
                alert("Please select two different files!");
                return;
            }

            try {
                const response = await fetch('http://127.0.0.1:8000/projects/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({ name, file1_id: parseInt(file1_id), file2_id: parseInt(file2_id) })
                });

                const data = await response.json();
                if (response.ok) {
                    alert('Project created successfully!');
                    window.location.href = './project';
                } else {
                    alert('Failed to create project: ' + JSON.stringify(data.detail));
                }
            } catch (err) {
                console.error(err);
                alert('Error creating project');
            }
        });
    </script>

    <script>
        
        const canvas = document.getElementById('bgCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const nodes = [];
        for (let i = 0; i < 25; i++) {
            nodes.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(255,255,255,0.7)';
            ctx.strokeStyle = 'rgba(255,255,255,0.3)';
            nodes.forEach(node => {
                node.x += node.vx;
                node.y += node.vy;
                if (node.x < 0 || node.x > canvas.width) node.vx *= -1;
                if (node.y < 0 || node.y > canvas.height) node.vy *= -1;
                ctx.beginPath();
                ctx.arc(node.x, node.y, 3, 0, Math.PI * 2);
                ctx.fill();
                nodes.forEach(other => {
                    const dx = node.x - other.x;
                    const dy = node.y - other.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 150) {
                        ctx.beginPath();
                        ctx.moveTo(node.x, node.y);
                        ctx.lineTo(other.x, other.y);
                        ctx.stroke();
                    }
                });
            });
            requestAnimationFrame(animate);
        }
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>

</body>

</html>