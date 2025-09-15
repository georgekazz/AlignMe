<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlignMe - Direct Tree</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.18/24/solid/index.js"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
</head>

<body class="bg-gradient-to-br from-indigo-500 via-purple-100 to-pink-800 font-sans min-h-screen p-6">
<div class="mb-6">
      <button onclick="window.location.href='./dashboard'"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <span>Back to Home</span>
      </button>
    </div>
    <!-- Header -->
    <header class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-indigo-900 drop-shadow-md">
            My Files
        </h1>
        <p class="text-gray-600 mt-2">Explore your RDF graphs in style!</p>
    </header>

    <!-- Files Grid -->
    <div id="filesContainer" class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Cards injected dynamically -->
    </div>

    <!-- Pagination Controls -->
    <div id="paginationControls" class="flex justify-center items-center gap-6 mt-8">
        <button id="prevPage"
            class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg hover:scale-105 hover:from-indigo-600 hover:to-purple-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
            disabled>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span class="hidden sm:inline">Previous</span>
        </button>

        <span id="pageInfo" class="text-gray-800 font-semibold text-lg px-4 py-1 bg-white rounded-xl shadow">
            Page 1 of 5
        </span>

        <button id="nextPage"
            class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-500 text-white shadow-lg hover:scale-105 hover:from-purple-700 hover:to-indigo-600 transition disabled:opacity-40 disabled:cursor-not-allowed">
            <span class="hidden sm:inline">Next</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>

    <!-- Graph Section -->
    <section class="relative mt-12">
        <h2 class="text-2xl font-bold text-center text-purple-800 mb-4 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428A8 8 0 118.572 4.572a8 8 0 0110.856 10.856z" />
            </svg>
            Interactive Graph
        </h2>

        <div id="graphContainer"
            class="w-full h-[600px] bg-white/70 backdrop-blur border rounded-2xl shadow-xl relative overflow-hidden">
        </div>

        <!-- Node Info Panel -->
        <div id="nodeInfo"
            class="absolute top-6 right-6 bg-white p-5 rounded-2xl shadow-2xl w-72 hidden transition-all duration-300 ease-in-out transform">
        </div>
    </section>

    <script>
        let currentPage = 1;
        const itemsPerPage = 3;
        let filesData = [];

        // Create card (όπως πριν)
        function createCard(file) {
            const card = document.createElement('div');
            card.className = "bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:scale-105 hover:shadow-2xl transition transform duration-300 ease-in-out";

            card.innerHTML = `
    <div>
      <h3 class="text-lg font-bold text-indigo-900 mb-2 flex items-center gap-2">
        📄 ${file.filename}
      </h3>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Type:</span> ${file.filetype}</p>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Status:</span> ${file.status}</p>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Public:</span> ${file.public ? '✅' : '❌'}</p>
      <p class="text-xs text-gray-500 mt-2">🕒 ${new Date(file.created_at).toLocaleString()}</p>
    </div>
    <div class="mt-4 flex justify-between gap-3">
      <button class="px-4 py-2 rounded-xl font-bold text-white ${file.parsed ? 'bg-green-500' : 'bg-red-500'} shadow hover:opacity-90 transition">
        ${file.parsed ? '✔️ Parsed' : '⚡ Parse'}
      </button>
      <button class="px-4 py-2 rounded-xl font-bold bg-purple-600 text-white hover:bg-purple-700 shadow transition"
        onclick="viewGraph(${file.id})">
        🌐 View Graph
      </button>
    </div>
  `;
            return card;
        }

        // Render current page
        function renderPage(page) {
            const container = document.getElementById('filesContainer');
            container.innerHTML = '';

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = filesData.slice(start, end);

            paginatedItems.forEach(file => {
                container.appendChild(createCard(file));
            });

            document.getElementById('pageInfo').textContent = `Page ${page} of ${Math.ceil(filesData.length / itemsPerPage)}`;
            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = end >= filesData.length;
        }
        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderPage(currentPage);
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if (currentPage < Math.ceil(filesData.length / itemsPerPage)) {
                currentPage++;
                renderPage(currentPage);
            }
        });
        async function loadUserFiles() {
            const token = localStorage.getItem('token');
            try {
                const response = await fetch('http://127.0.0.1:8000/my-files/', {
                    headers: { 'Authorization': 'Bearer ' + token }
                });

                if (!response.ok) throw new Error('Failed to fetch files');

                filesData = await response.json();
                currentPage = 1;
                renderPage(currentPage);

            } catch (err) {
                console.error(err);
                alert(err.message);
            }

        }

        function viewGraph(fileId) {
            const container = document.getElementById('graphContainer');
            container.innerHTML = '';

            fetch(`http://127.0.0.1:8000/files/${fileId}/graph`)
                .then(res => res.json())
                .then(data => {
                    const width = container.clientWidth;
                    const height = container.clientHeight;

                    const svg = d3.select("#graphContainer")
                        .append("svg")
                        .attr("width", width)
                        .attr("height", height);

                    const g = svg.append("g");

                    svg.call(d3.zoom()
                        .scaleExtent([0.1, 4])
                        .on("zoom", (event) => g.attr("transform", event.transform)));

                    const simulation = d3.forceSimulation(data.nodes)
                        .force("link", d3.forceLink(data.links).id(d => d.id).distance(120))
                        .force("charge", d3.forceManyBody().strength(-400))
                        .force("center", d3.forceCenter(width / 2, height / 2));

                    const link = g.append("g")
                        .selectAll("line")
                        .data(data.links)
                        .join("line")
                        .attr("stroke", "#999")
                        .attr("stroke-width", 1.5);

                    const node = g.append("g")
                        .selectAll("circle")
                        .data(data.nodes)
                        .join("circle")
                        .attr("r", 10)
                        .attr("fill", "#4f46e5")
                        .call(drag(simulation))
                        .on("click", d => showNodeInfo(d));

                    const label = g.append("g")
                        .selectAll("text")
                        .data(data.nodes)
                        .join("text")
                        .text(d => d.name)
                        .attr("font-size", "12px")
                        .attr("fill", "#1f2937")
                        .attr("dx", 12)
                        .attr("dy", 4)
                        .style("pointer-events", "none");

                    simulation.on("tick", () => {
                        link
                            .attr("x1", d => d.source.x)
                            .attr("y1", d => d.source.y)
                            .attr("x2", d => d.target.x)
                            .attr("y2", d => d.target.y);

                        node
                            .attr("cx", d => d.x)
                            .attr("cy", d => d.y);

                        label
                            .attr("x", d => d.x)
                            .attr("y", d => d.y);
                    });

                    function drag(simulation) {
                        function dragstarted(event, d) {
                            if (!event.active) simulation.alphaTarget(0.3).restart();
                            d.fx = d.x;
                            d.fy = d.y;
                        }
                        function dragged(event, d) {
                            d.fx = event.x;
                            d.fy = event.y;
                        }
                        function dragended(event, d) {
                            if (!event.active) simulation.alphaTarget(0);
                            d.fx = null;
                            d.fy = null;
                        }
                        return d3.drag()
                            .on("start", dragstarted)
                            .on("drag", dragged)
                            .on("end", dragended);
                    }

                    function showNodeInfo(node) {
                        const infoDiv = document.getElementById("nodeInfo");
                        infoDiv.style.display = "block";

                        let detailsHtml = '';
                        if (node.details && Object.keys(node.details).length > 0) {
                            detailsHtml = '<ul class="text-sm text-gray-700">';
                            for (const [key, value] of Object.entries(node.details)) {
                                detailsHtml += `<li><strong>${key.split(/[\/#]/).pop()}:</strong> ${value}</li>`;
                            }
                            detailsHtml += '</ul>';
                        } else {
                            detailsHtml = '<p class="text-sm text-gray-700">No additional info</p>';
                        }

                        infoDiv.innerHTML = `
        <h4 class="font-bold text-indigo-900 mb-2">${node.name}</h4>
        ${detailsHtml}
    `;
                    }

                });
        }

        loadUserFiles();
    </script>

    <!-- Footer -->
    <footer class="mt-auto mb-4 text-indigo-100 text-sm animate__animated animate__fadeInUp text-center">
        &copy; 2025 AlignMe. All rights reserved.
    </footer>
</body>

</html>