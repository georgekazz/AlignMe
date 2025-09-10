<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload RDF - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
</head>
<body class="bg-gradient-to-r from-purple-600 to-indigo-500 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-md w-full animate__animated animate__fadeInDown">
        <!-- Back Button -->
        <div class="mb-6">
            <button onclick="window.location.href='./dashboard'" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-indigo-500 rounded-lg hover:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                     stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span>Back to Dashboard</span>
            </button>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-indigo-900 mb-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 inline-block mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4h4M21 7v4h-4M3 17v-4h4M21 17v-4h-4M12 3v4M12 17v4M7 12h4M13 12h4" />
            </svg>
            Upload RDF File
        </h2>

        <!-- Upload Form -->
        <form id="uploadForm" class="space-y-5" enctype="multipart/form-data">
            <div>
                <label for="file" class="block text-indigo-900 font-semibold mb-2">Select RDF file</label>
                <input type="file" id="file" accept=".rdf" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" id="public" class="h-5 w-5 text-yellow-400">
                <label for="public" class="text-indigo-900 font-semibold">Make Public</label>
            </div>

            <button type="submit" 
                    class="w-full bg-yellow-400 text-indigo-900 font-bold py-3 rounded-lg hover:bg-yellow-300 transition transform hover:scale-105 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8M8 16l4-4 4 4" />
                </svg>
                Upload
            </button>
        </form>

        <div id="status" class="mt-4 text-center text-indigo-700 font-semibold"></div>
    </div>

<script>
document.getElementById('uploadForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fileInput = document.getElementById('file');
    const publicCheckbox = document.getElementById('public');
    const statusDiv = document.getElementById('status');

    if (!fileInput.files.length) {
        alert("Please select a file.");
        return;
    }

    const formData = new FormData();
    formData.append('uploaded_file', fileInput.files[0]);
    formData.append('public', publicCheckbox.checked);

    const token = localStorage.getItem('token');
    if (!token) {
        alert("You must be logged in to upload files.");
        return;
    }

    try {
        const response = await fetch('http://127.0.0.1:8000/files/upload', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        const data = await response.json();
        console.log(data);

        if (response.ok) {
            statusDiv.innerText = `File uploaded successfully: ${data.filename}`;
            fileInput.value = "";
            publicCheckbox.checked = false;
        } else {
            statusDiv.innerText = `Upload failed: ${JSON.stringify(data.detail || data)}`;
        }
    } catch (err) {
        console.error(err);
        statusDiv.innerText = "An error occurred while uploading the file.";
    }
});
</script>

</body>
</html>
