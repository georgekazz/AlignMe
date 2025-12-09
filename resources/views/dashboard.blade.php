<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
</head>

<body class="bg-indigo-100 min-h-screen">

    <header class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-5 flex justify-between items-center">
        <h1 class="text-xl font-bold">Alignment Dashboard</h1>
        <button id="logoutBtn"
            class="bg-yellow-400 text-indigo-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300">Logout</button>
    </header>

    <main class="p-10">
        <h2 class="text-3xl font-extrabold mb-6 text-gray-800 flex items-center gap-2">
            Welcome,
            <span id="userName"
                class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent animate-pulse">
            </span>!
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

            <!-- Upload RDF File -->
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Upload RDF File</h3>
                </div>
                <p class="text-gray-600">Upload your RDF files to start creating projects.</p>
                <a href="./uploadfile"
                    class="mt-4 inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    Upload
                </a>
            </div>

            <!-- Create Project -->
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a9 9 0 100 15.292M15 12h3m-6 0h.01M9 12H6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Create Project</h3>
                </div>
                <p class="text-gray-600">Combine parsed RDF files into a new project.</p>
                <a href="./createproject"
                    class="mt-4 inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
            </div>

            <!-- Vote -->
            <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 9l-5 5m0 0l-5-5m5 5V3m5 6h7m-7 0v12" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Vote</h3>
                </div>
                <p class="text-gray-600">See suggested links for your projects and vote.</p>
                <a href="./vote"
                    class="mt-4 inline-flex items-center gap-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 9l-5 5m0 0l-5-5m5 5V3m5 6h7m-7 0v12" />
                    </svg>
                    Go
                </a>
            </div>

            <!-- Direct Tree -->
            <div
                class="bg-gradient-to-br from-purple-50 to-purple-200 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-4 bg-white-800 text-white rounded-2xl shadow-inner">
                        <div class="p-4 bg-white-500 text-white rounded-2xl shadow-inner">
                            <p class="text-xl font-bold text-purple-800">Direct Tree</p>
                        </div>
                    </div>
                </div>

                <p class="text-purple-700 mb-4">Visualize ontologies in an interactive force-directed graph.</p>

                <button disabled
                    class="mt-2 w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-purple-300 text-purple-600 cursor-not-allowed shadow-inner">
                    Coming Soon
                </button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="font-semibold text-xl text-gray-800 mb-6 text-center">Your Uploaded RDF Files</h3>

            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-md">
                <table class="min-w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">ID</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Filename</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Filetype</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Status</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Public</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Created At</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Parse</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Delete</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">SKOS Viewer</th>
                        </tr>
                    </thead>
                    <tbody id="filesTableBody" class="divide-y divide-gray-100">
                        <!-- Τα projects θα φορτωθούν εδώ με JS -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="flex justify-center mt-4 space-x-2"></div>
        </div>

        <!-- Πίνακας Projects -->
        <div class="max-h-96 max-w-7xl mx-auto mt-8 bg-white p-6 rounded-2xl shadow-xl overflow-auto">
            <h3 class="font-semibold text-xl text-gray-800 mb-6 text-center">Your Projects</h3>

            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-md">
                <table class="min-w-full table-auto border-collapse bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">ID</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Name</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">File 1</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">File 2</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Created At</th>
                            <th class="px-6 py-3 text-sm font-semibold tracking-wide text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="projectsTableBody" class="divide-y divide-gray-100">
                        <!-- Τα projects θα φορτωθούν εδώ με JS -->
                    </tbody>
                </table>
            </div>
        </div>


        <div class="user-links-table max-h-96 max-w-7xl mx-auto mt-8 bg-white p-6 rounded-2xl shadow-xl overflow-auto">
            <h3 class="text-3xl font-extrabold mb-6 text-gray-800 text-center">
                My Links
            </h3>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">
                        <th class="px-6 py-3 text-left text-sm font-semibold">Source</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Target</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Type</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Score</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Upvotes</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Downvotes</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="userLinksBody" class="bg-white divide-y divide-gray-200">
                    <!-- Dynamically populated rows -->
                </tbody>
            </table>
        </div>


    </main>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem('token');
        if (!token) {
            alert('You must login first!');
            window.location.href = './login';
        }

        async function loadUser() {
            const response = await fetch(`${window.apiBaseUrl}/me`, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('userName').textContent = data.name;
            } else {
                alert('Session expired, please login again.');
                localStorage.removeItem('token');
                window.location.href = './login';
            }
        }
        loadUser();

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', () => {
            localStorage.removeItem('token');
            window.location.href = './login';
        });

        let currentPage = 1;
        const rowsPerPage = 5;
        let allFiles = [];

        async function loadUserFiles() {
            try {
                const response = await fetch(`${window.apiBaseUrl}/my-files/`, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch files');

                allFiles = await response.json();
                displayFiles(currentPage);
                setupPagination();
            } catch (err) {
                console.error(err);
                alert('Error loading files');
                showNotification('Error loading files', 'error');

            }
        }

        function displayFiles(page) {
            const tbody = document.getElementById('filesTableBody');
            tbody.innerHTML = '';

            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const files = allFiles.slice(start, end);

            files.forEach(file => {
                const tr = document.createElement('tr');
                const isParsed = file.parsed;

                tr.innerHTML = `
                    <td class="border px-4 py-2 text-center">${file.id}</td>
                    <td class="border px-4 py-2 text-center">${file.filename}</td>
                    <td class="border px-4 py-2 text-center">${file.filetype}</td>
                    <td class="border px-4 py-2 text-center">${file.status}</td>
                    <td class="border px-4 py-2 text-center">
                        ${file.public
                            ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>`
                            : `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>`}
                    </td>
                    <td class="border px-4 py-2 text-center">${new Date(file.created_at).toLocaleString()}</td>
                    <td class="border px-4 py-2 text-center">
                        <button class="px-3 py-1 rounded font-bold text-white ${isParsed ? 'bg-green-500' : 'bg-red-500'}">
                            ${isParsed ? 'Parsed' : 'Parse'}
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                onclick="deleteFile(${file.id})">
                            Delete
                        </button>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <button 
                            class="px-5 py-2 viewer-btn rounded-2xl font-semibold text-white shadow-lg transform transition-all duration-300 
                                ${isParsed 
                                        ? 'bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-purple-600 hover:to-indigo-500 hover:-translate-y-0.5' 
                                        : 'bg-gray-400 cursor-not-allowed opacity-70'}"
                            ${!isParsed ? 'disabled' : ''}
                        >
                            SKOS Viewer
                        </button>
                    </td>
                `;

                const viewerButton = tr.querySelector('.viewer-btn');
                if (isParsed) {
                    viewerButton.addEventListener('click', () => {
                        window.open(`./skosviewer/${file.id}`, '_blank');
                    });
                }

                const button = tr.querySelector('button');
                button.addEventListener('click', async () => {
                    try {
                        const parseResp = await fetch(`${window.apiBaseUrl}/files/${file.id}/parse`, {
                            method: 'POST',
                            headers: { 'Authorization': 'Bearer ' + token }
                        });
                        if (!parseResp.ok) throw new Error('Parsing failed');

                        button.classList.remove('bg-red-500');
                        button.classList.add('bg-green-500');
                        button.textContent = 'Parsed';
                        file.parsed = true;
                    } catch (err) {
                        showNotification('Parsing failed: ' + err.message, 'error');
                    }
                });

                tbody.appendChild(tr);
            });
        }

        async function deleteFile(fileId) {
            if (!confirm("Are you sure you want to delete this file?")) return;

            const token = localStorage.getItem("token");

            const response = await fetch(`${window.apiBaseUrl}/files/${fileId}`, {
                method: "DELETE",
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });

            if (response.ok) {
                alert("File deleted successfully");
                loadFiles();
            } else {
                const err = await response.json();
                alert("Error: " + err.detail);
            }
        }


        function setupPagination() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            const totalPages = Math.ceil(allFiles.length / rowsPerPage);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-3 py-1 border rounded ${i === currentPage ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700'}`;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    displayFiles(i);
                    setupPagination();
                });
                pagination.appendChild(btn);
            }
        }

        // Σιγουρέψου ότι υπάρχει div για τα κουμπιά pagination
        // <div id="pagination" class="flex justify-center mt-4 space-x-2"></div>

        loadUserFiles();


        async function loadUserProjects() {
            try {
                const response = await fetch(`${window.apiBaseUrl}/my-projects`, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });
                if (!response.ok) throw new Error('Failed to fetch projects');

                const projects = await response.json();
                const tbody = document.getElementById('projectsTableBody');
                tbody.innerHTML = '';

                projects.forEach(project => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                <td class="border px-4 py-2 text-center">${project.id}</td>
                <td class="border px-4 py-2 text-center">${project.name}</td>
                <td class="border px-4 py-2 text-center">${project.file1_name || '-'}</td>
                <td class="border px-4 py-2 text-center">${project.file2_name || '-'}</td>
                <td class="border px-4 py-2 text-center">${new Date(project.created_at).toLocaleString()}</td>
                <td class="border px-4 py-2 text-center">
                    <button class="bg-indigo-700 text-white px-3 py-1 rounded hover:bg-indigo-600"
                        onclick="goToProject(${project.id})">Open</button>
                </td>
            `;
                    tbody.appendChild(tr);
                });
            } catch (err) {
                console.error(err);
                showNotification('Error loading projects', 'error');
            }
        }


        function goToProject(projectId) {
            window.location.href = `./project/${projectId}`;
        }

        loadUserProjects();


        async function loadUserLinks() {
            try {
                const res = await fetch(`${window.apiBaseUrl}/user-links/`, {
                    headers: { "Authorization": "Bearer " + token }
                });
                const links = await res.json();

                const tbody = document.getElementById("userLinksBody");
                tbody.innerHTML = "";

                links.forEach(link => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                <td class="p-2 border">${link.source_node}</td>
                <td class="p-2 border">${link.target_node}</td>
                <td class="p-2 border">${link.link_type_id}</td>
                <td class="p-2 border">${link.suggestion_score}</td>
                <td class="p-2 border">${link.upvote}</td>
                <td class="p-2 border">${link.downvote}</td>
                <td class="p-2 border">
                    <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" onclick="deleteLink(${link.id})">Delete</button>
                </td>
            `;
                    tbody.appendChild(tr);
                });

            } catch (err) {
                console.error("Failed to load user links:", err);
            }
        }

        async function deleteLink(linkId) {
            if (!confirm("Are you sure you want to delete this link?")) return;

            try {
                const res = await fetch(`${window.apiBaseUrl}/links/${linkId}`, {
                    method: "DELETE",
                    headers: { "Authorization": "Bearer " + token }
                });
                const data = await res.json();
                if (data.message) {
                    alert(data.message);
                    loadUserLinks();
                } else {

                    showNotification('Error deleting link', 'error');
                }
            } catch (err) {
                console.error(err);
                showNotification('Failed to delete link', 'error');
            }
        }

        document.addEventListener("DOMContentLoaded", loadUserLinks);

        function showNotification(message, type = 'success') {
            const panel = document.getElementById('notificationPanel');
            panel.textContent = message;

            panel.className = "fixed top-6 left-1/2 transform -translate-x-1/2 w-auto max-w-lg px-6 py-3 rounded-xl shadow-lg text-white font-medium text-center z-50";

            if (type === 'success') {
                panel.classList.add("bg-green-500");
            } else if (type === 'error') {
                panel.classList.add("bg-red-500");
            } else if (type === 'warning') {
                panel.classList.add("bg-yellow-500");
            } else {
                panel.classList.add("bg-gray-700");
            }

            panel.classList.remove("hidden");

            setTimeout(() => {
                panel.classList.add("hidden");
            }, 5000);
        }

    </script>
    
    <div 
        id="notificationPanel" 
        class="fixed top-6 left-1/2 transform -translate-x-1/2 w-auto max-w-lg px-6 py-3 rounded-xl shadow-lg text-white font-medium text-center hidden z-50">
    </div>
    <!-- Footer -->
    <footer class="mt-auto mb-4 text-pink-500 text-sm animate__animated animate__fadeInUp text-center">
        &copy; 2025 AlignMe. All rights reserved.
    </footer>
</body>

</html>