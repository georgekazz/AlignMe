<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alignment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .search-highlight {
            background-color: #fef3c7;
            transition: background-color 0.3s;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen">

    <!-- Header -->
    <header class="glass sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center overflow-hidden">
                    <img src="./img/favicon.png" alt="Icon" class="w-6 h-6 object-contain">
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Alignment
                </h1>
            </div>
            <button id="logoutBtn"
                class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-6 py-2.5 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                Logout
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-4xl font-extrabold mb-2 text-gray-800">
                Welcome back,
                <span id="userName"
                    class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                </span>! 👋
            </h2>
            <p class="text-gray-600">Manage your RDF files, projects, and alignments all in one place.</p>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Upload RDF File -->
            <div class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-indigo-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Upload RDF</h3>
                <p class="text-gray-600 text-sm mb-4">Upload your RDF files to get started</p>
                <a href="./uploadfile"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all w-full justify-center font-medium">
                    Upload File
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Create Project -->
            <div class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Create Project</h3>
                <p class="text-gray-600 text-sm mb-4">Combine RDF files into projects</p>
                <a href="./createproject"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all w-full justify-center font-medium">
                    New Project
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Vote -->
            <div class="group bg-white p-6 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-yellow-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-yellow-500 to-orange-500 text-white rounded-xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Vote</h3>
                <p class="text-gray-600 text-sm mb-4">Review and vote on suggestions</p>
                <a href="./vote"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all w-full justify-center font-medium">
                    Start Voting
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Direct Tree -->
            <div class="group bg-gradient-to-br from-purple-100 to-pink-100 p-6 rounded-2xl shadow-md border-2 border-purple-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white text-purple-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
                        </svg>
                    </div>
                    <span class="bg-purple-600 text-white text-xs px-3 py-1 rounded-full font-semibold">Soon</span>
                </div>
                <h3 class="text-lg font-bold text-purple-900 mb-2">Direct Tree</h3>
                <p class="text-purple-700 text-sm mb-4">Interactive force-directed graphs</p>
                <button disabled
                    class="w-full px-4 py-2 rounded-lg bg-purple-300 text-purple-600 cursor-not-allowed font-medium">
                    Coming Soon
                </button>
            </div>
        </div>

     <!-- RDF Files Section -->
        <div class="bg-white p-8 rounded-2xl shadow-xl mb-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0 flex items-center gap-2">
                    <span>📁</span>
                    <span>Your RDF Files</span>
                </h3>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full border-collapse bg-white text-gray-700">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <th class="px-6 py-3 text-sm font-semibold text-left">ID</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left">Filename</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left">Type</th>
                            <th class="px-6 py-3 text-sm font-semibold text-center">Status</th>
                            <th class="px-6 py-3 text-sm font-semibold text-center">Public</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left">Created</th>
                            <th class="px-6 py-3 text-sm font-semibold text-center">Actions</th>
                            <th class="px-6 py-3 text-sm font-semibold text-center"></th>
                            <th class="px-6 py-3 text-sm font-semibold text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="filesTableBody" class="divide-y divide-gray-100">
                        <!-- Populated dynamically by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="flex justify-center mt-6 space-x-2"></div>
        </div>

        <!-- Projects Section -->
        <div class="bg-white p-8 rounded-2xl shadow-xl mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">🚀 Your Projects</h3>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full table-auto border-collapse bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                            <th class="px-6 py-4 text-sm font-semibold text-left">ID</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">Name</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">File 1</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">File 2</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">Created</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center">Actions</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="projectsTableBody" class="divide-y divide-gray-100">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteProjectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Delete Project</h3>
                        <p class="text-sm text-gray-500">This action cannot be undone</p>
                    </div>
                </div>
                
                <p class="text-gray-700 mb-6">
                    Are you sure you want to delete "<span id="deleteProjectName" class="font-semibold"></span>"? 
                    All associated links and votes will also be deleted.
                </p>
                
                <div class="flex gap-3 justify-end">
                    <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </button>
                    <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Project
                    </button>
                </div>
            </div>
        </div>

        <!-- My Links Section -->
        <div class="bg-white p-8 rounded-2xl shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">🔗 My Links</h3>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">
                            <th class="px-6 py-4 text-sm font-semibold text-left">Source</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">Target</th>
                            <th class="px-6 py-4 text-sm font-semibold text-left">Type</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center">Score</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center">👍 Upvotes</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center">👎 Downvotes</th>
                            <th class="px-6 py-4 text-sm font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userLinksBody" class="bg-white divide-y divide-gray-200">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
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
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">${file.id}</td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">${file.filename}</td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">${file.filetype}</td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">${file.status}</td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">
                        ${file.public
                            ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>`
                            : `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>`}
                    </td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">${new Date(file.created_at).toLocaleString()}</td>
                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">
                        <button class="px-3 py-1 rounded font-bold text-white ${isParsed ? 'bg-green-500' : 'bg-red-500'}">
                            ${isParsed ? 'Parsed' : 'Parse'}
                        </button>
                    </td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                    onclick="deleteFile(${file.id})">
                                Delete
                            </button>
                            <button 
                                class="px-4 py-1 viewer-btn rounded-2xl font-semibold text-white shadow-lg transform transition-all duration-300 
                                    ${isParsed 
                                        ? 'bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-purple-600 hover:to-indigo-500 hover:-translate-y-0.5' 
                                        : 'bg-gray-400 cursor-not-allowed opacity-70'}"
                                ${!isParsed ? 'disabled' : ''}>
                                SKOS Viewer
                            </button>
                        </div>
                    </td>
                `;

                // Event για SKOS Viewer
                const viewerButton = tr.querySelector('.viewer-btn');
                if (isParsed) {
                    viewerButton.addEventListener('click', () => {
                        window.open(`./skosviewer/${file.id}`, '_blank');
                    });
                }

                // Event για Parse button
                const parseButton = tr.querySelector('td:nth-child(7) > button');
                parseButton.addEventListener('click', async () => {
                    try {
                        const parseResp = await fetch(`${window.apiBaseUrl}/files/${file.id}/parse`, {
                            method: 'POST',
                            headers: { 'Authorization': 'Bearer ' + token }
                        });
                        if (!parseResp.ok) throw new Error('Parsing failed');

                        parseButton.classList.remove('bg-red-500');
                        parseButton.classList.add('bg-green-500');
                        parseButton.textContent = 'Parsed';
                        file.parsed = true;

                        // Enable SKOS Viewer button dynamically
                        viewerButton.disabled = false;
                        viewerButton.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-70');
                        viewerButton.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600');
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
                    <button 
                        class="px-4 py-2 rounded-2xl font-semibold text-white shadow-lg
                            bg-gradient-to-r from-indigo-500 to-purple-600
                            hover:from-purple-600 hover:to-indigo-500
                            transform transition-all duration-300 hover:-translate-y-0.5"
                        onclick="goToProject(${project.id})">
                        Open
                    </button>
                </td>
                 <td class="px-6 py-4 text-sm text-center">
                    <div class="flex items-center justify-center gap-2">   
                        <button onclick="showDeleteModal(${project.id}, '${project.name}')" 
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </div>
                </td>
            `;
                    tbody.appendChild(tr);
                });
            } catch (err) {
                console.error(err);
                showNotification('Error loading projects', 'error');
            }
        }

        let projectToDelete = null;

        function showDeleteModal(projectId, projectName) {
            projectToDelete = projectId;
            document.getElementById('deleteProjectName').textContent = projectName;
            document.getElementById('deleteProjectModal').classList.remove('hidden');
        }

        // Close delete modal
        function closeDeleteModal() {
            projectToDelete = null;
            document.getElementById('deleteProjectModal').classList.add('hidden');
        }

        // Confirm delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
            if (!projectToDelete) return;
            
            const btn = this;
            const originalText = btn.innerHTML;
            
            // Show loading state
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Deleting...
            `;
            
            try {
                 const response = await fetch(`${window.apiBaseUrl}/projects/${projectToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    alert(`✅ ${data.message}`);
                    
                    const rows = document.querySelectorAll('#projectsTableBody tr');
                    rows.forEach(row => {
                        if (row.querySelector('td')?.textContent === projectToDelete.toString()) {
                            row.remove();
                        }
                    });
                    
                    closeDeleteModal();
                } else {
                    const error = await response.json();
                    alert(`❌ Error: ${error.detail}`);
                }
            } catch (error) {
                console.error('Delete error:', error);
                alert('❌ Failed to delete project. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Close modal on background click
        document.getElementById('deleteProjectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });


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