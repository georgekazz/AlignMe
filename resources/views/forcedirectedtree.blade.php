<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AlignMe - My Files</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <style>
        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-500 via-purple-100 to-pink-800 font-sans min-h-screen p-6">
    <div class="mb-6">
        <button onclick="window.location.href='./dashboard'"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back to Home</span>
        </button>
    </div>

    <header class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-indigo-900 drop-shadow-md">My Files</h1>
        <p class="text-gray-600 mt-2">Explore your RDF graphs in style!</p>
    </header>

    <div id="filesContainer" class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"></div>

    <div id="paginationControls" class="flex justify-center items-center gap-6 mt-8">
        <button id="prevPage"
            class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg hover:scale-105 transition disabled:opacity-40"
            disabled>
            <span class="hidden sm:inline">Previous</span>
        </button>

        <span id="pageInfo" class="text-gray-800 font-semibold text-lg px-4 py-1 bg-white rounded-xl shadow">Page
            1</span>

        <button id="nextPage"
            class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-500 text-white shadow-lg hover:scale-105 transition">
            <span class="hidden sm:inline">Next</span>
        </button>
    </div>

    <section class="relative mt-12 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-center text-purple-800 mb-4">Interactive Graph</h2>

        <div id="graphContainer"
            class="w-full h-[600px] bg-white/70 backdrop-blur border rounded-2xl shadow-xl relative overflow-hidden">
        </div>

        <div id="nodeInfo"
            class="absolute top-6 right-6 bg-white p-5 rounded-2xl shadow-2xl w-72 hidden transition-all duration-300 ease-in-out transform">
        </div>
    </section>

    <script>
        let currentPage = 1;
        const itemsPerPage = 3;
        let filesData = [];

        // Δημιουργεί κάρτα αρχείου με κουμπί Convert και View
        function createCard(file) {
            const card = document.createElement('div');
            card.className = "bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:scale-105 hover:shadow-2xl transition transform duration-300 ease-in-out";

            const convertBtnId = `convert-btn-${file.id}`;
            const viewBtnId = `view-btn-${file.id}`;

            card.innerHTML = `
    <div>
      <h3 class="text-lg font-bold text-indigo-900 mb-2 flex items-center gap-2">📄 ${escapeHtml(file.filename || '')}</h3>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Type:</span> ${escapeHtml(file.filetype || '')}</p>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Status:</span> ${escapeHtml(file.status || '')}</p>
      <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Public:</span> ${file.public ? '✅' : '❌'}</p>
      <p class="text-xs text-gray-500 mt-2">🕒 ${file.created_at ? new Date(file.created_at).toLocaleString() : ''}</p>
    </div>
    <div class="mt-4 flex justify-between gap-3 items-center">
      <div class="flex gap-2">
        <button id="${convertBtnId}" class="px-3 py-2 rounded-xl font-semibold bg-yellow-500 text-white hover:bg-yellow-600 shadow transition" onclick="convertOnly(${file.id})">Convert</button>
      </div>
      <button id="${viewBtnId}" class="px-4 py-2 rounded-xl font-bold bg-purple-600 text-white hover:bg-purple-700 shadow transition" onclick="viewGraph(${file.id})">View Graph</button>
    </div>
  `;
            return card;
        }

        // Escape HTML
        function escapeHtml(str) {
            return String(str).replace(/[&<>"'`]/g, function (s) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`': '&#x60;' })[s];
            });
        }

        function renderPage(page) {
            const container = document.getElementById('filesContainer');
            container.innerHTML = '';
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = filesData.slice(start, end);
            paginatedItems.forEach(file => container.appendChild(createCard(file)));
            document.getElementById('pageInfo').textContent = `Page ${page} of ${Math.max(1, Math.ceil(filesData.length / itemsPerPage))}`;
            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = end >= filesData.length;
        }

        document.getElementById('prevPage').addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderPage(currentPage); } });
        document.getElementById('nextPage').addEventListener('click', () => { if (currentPage < Math.ceil(filesData.length / itemsPerPage)) { currentPage++; renderPage(currentPage); } });

        async function loadUserFiles() {
            const token = localStorage.getItem('token');
            try {
                const response = await fetch('http://127.0.0.1:8000/my-files/', { headers: { 'Authorization': 'Bearer ' + token } });
                if (!response.ok) throw new Error('Failed to fetch files');
                filesData = await response.json();
                currentPage = 1;
                renderPage(currentPage);
            } catch (err) { console.error(err); alert('Error loading files: ' + (err.message || err)); }
        }

        // --- Conversion ---
        async function convertOnly(fileId) {
            const token = localStorage.getItem('token');
            const btn = document.getElementById(`convert-btn-${fileId}`);
            setLoading(btn, true);
            try {
                const res = await fetch(`http://127.0.0.1:8000/files/${fileId}/convert`, { method: 'POST', headers: { 'Authorization': 'Bearer ' + token } });
                if (!res.ok) { const err = await safeJson(res); alert('Conversion failed: ' + (err.detail || err.message || res.statusText)); return false; }
                const data = await res.json();
                showNotification('Conversion succeeded!', 'success');
                markParsed(fileId);
                return true;
            } catch (e) { console.error(e); alert('Conversion error: ' + e.message); return false; }
            finally { setLoading(btn, false); }
        }

        function setLoading(btn, isLoading) {
            if (!btn) return;
            if (isLoading) { btn.classList.add('btn-loading'); btn.dataset.orig = btn.innerHTML; btn.innerHTML = '⏳...'; btn.disabled = true; }
            else { btn.classList.remove('btn-loading'); if (btn.dataset.orig) btn.innerHTML = btn.dataset.orig; btn.disabled = false; }
        }

        function markParsed(fileId) { const f = filesData.find(x => x.id === fileId); if (f) { f.parsed = true; renderPage(currentPage); } }

        async function safeJson(resp) { try { return await resp.json(); } catch (e) { return { message: resp.statusText || 'Unknown error' }; } }

        // --- View Graph ---
        async function viewGraph(fileId) {
            const token = localStorage.getItem('token');
            const container = document.getElementById('graphContainer');
            container.innerHTML = '<div class="p-4 text-gray-600">Loading graph...</div>';

            try {
                const res = await fetch(`http://127.0.0.1:8000/files/${fileId}/graph`, { headers: { 'Authorization': 'Bearer ' + token } });
                if (!res.ok) { const err = await safeJson(res); container.innerHTML = `<div class="p-4 text-red-600">Failed to load graph: ${escapeHtml(err.detail || err.message)}</div>`; return; }
                const data = await res.json();
                if (!data || !Array.isArray(data.nodes) || !Array.isArray(data.links)) { container.innerHTML = `<div class="p-4 text-red-600">Server returned invalid graph data.</div>`; return; }
                renderD3Graph(data, container, fileId);
            } catch (e) { console.error(e); container.innerHTML = `<div class="p-4 text-red-600">Error fetching graph: ${escapeHtml(e.message)}</div>`; }
        }

        // --- D3 rendering ---
        function renderD3Graph(data, containerElement, fileId) {
            const container = typeof containerElement === 'string' ? document.querySelector(containerElement) : containerElement;
            container.innerHTML = '';
            const width = container.clientWidth || 960;
            const height = container.clientHeight || 600;

            const svg = d3.select(container).append("svg").attr("width", width).attr("height", height).style("background", "transparent");
            const g = svg.append("g");
            svg.call(d3.zoom().scaleExtent([0.1, 4]).on("zoom", (event) => g.attr("transform", event.transform)));

            const nodes = data.nodes.map(d => Object.assign({}, d));
            const links = data.links.map(d => ({ source: d.source, target: d.target, relation: d.relation }));

            const simulation = d3.forceSimulation(nodes)
                .force("link", d3.forceLink(links).id(d => d.id).distance(450))
                .force("charge", d3.forceManyBody().strength(-400))
                .force("center", d3.forceCenter(width / 2, height / 2))
                .alphaTarget(0.1);

            const link = g.append("g").attr("stroke-opacity", 0.8).selectAll("line").data(links).join("line").attr("stroke", "#999").attr("stroke-width", 1.5);

            const linkLabel = g.append("g").selectAll("text").data(links).join("text").attr("font-size", 10).attr("fill", "#4b5563").text(d => shortName(d.relation));

            const node = g.append("g")
                .selectAll("circle")
                .data(nodes)
                .join("circle")
                .attr("r", 10)
                .attr("fill", "#4f46e5")
                .call(drag(simulation))
                .on("click", function (event, d) {
                    showNodeInfo(d, fileId); // εδώ το d.id πρέπει να είναι το URI
                });

            const label = g.append("g").selectAll("text").data(nodes).join("text")
                .text(d => d.name || d.id)
                .attr("font-size", "12px")
                .attr("fill", "#111827")
                .attr("dx", 12)
                .attr("dy", 4)
                .style("pointer-events", "none");

            simulation.on("tick", () => {
                link.attr("x1", d => getNodeX(d.source)).attr("y1", d => getNodeY(d.source))
                    .attr("x2", d => getNodeX(d.target)).attr("y2", d => getNodeY(d.target));
                node.attr("cx", d => d.x).attr("cy", d => d.y);
                label.attr("x", d => d.x).attr("y", d => d.y);
                linkLabel.attr("x", d => (getNodeX(d.source) + getNodeX(d.target)) / 2)
                    .attr("y", d => (getNodeY(d.source) + getNodeY(d.target)) / 2);
            });

            function getNodeX(n) { return (typeof n === 'object') ? n.x : (nodes.find(a => a.id === n) || {}).x || 0; }
            function getNodeY(n) { return (typeof n === 'object') ? n.y : (nodes.find(a => a.id === n) || {}).y || 0; }

            function drag(simulation) {
                function dragstarted(event, d) { if (!event.active) simulation.alphaTarget(0.3).restart(); d.fx = d.x; d.fy = d.y; }
                function dragged(event, d) { d.fx = event.x; d.fy = event.y; }
                function dragended(event, d) { if (!event.active) simulation.alphaTarget(0); d.fx = null; d.fy = null; }
                return d3.drag().on("start", dragstarted).on("drag", dragged).on("end", dragended);
            }
        }

        // --- Node info panel ---
        function showNodeInfo(node, fileId) {
            const infoDiv = document.getElementById("nodeInfo");
            infoDiv.style.display = "block";
            infoDiv.innerHTML = `<p class="text-sm text-gray-500">Loading...</p>`;

            fetch(`http://127.0.0.1:8000/nodes/${fileId}/${encodeURIComponent(node.id)}`)
                .then(res => {
                    if (!res.ok) throw new Error('Node not found');
                    return res.json();
                })
                .then(nodeData => {
                    let detailsHtml = '';
                    if (nodeData.details && Object.keys(nodeData.details).length > 0) {
                        detailsHtml = '<ul class="text-sm text-gray-700">';
                        for (const [key, value] of Object.entries(nodeData.details)) {
                            detailsHtml += `<li><strong>${shortName(key)}:</strong> ${value}</li>`;
                        }
                        detailsHtml += '</ul>';
                    } else {
                        detailsHtml = '<p class="text-sm text-gray-700">No additional info</p>';
                    }

                    infoDiv.innerHTML = `
        <h4 class="font-bold text-indigo-900 mb-2">${nodeData.name}</h4>
        ${detailsHtml}
      `;
                })
                .catch(err => {
                    infoDiv.innerHTML = `<p class="text-sm text-red-500">Error: ${err.message}</p>`;
                });
        }

        // shortName helper
        function shortName(uri) {
            if (!uri) return '';
            if (uri.includes('#')) return uri.split('#').pop();
            const parts = uri.split('/');
            return parts[parts.length - 1];
        }



        function shortName(uri) {
            if (!uri) return '';
            if (uri.includes('#')) return uri.split('#').pop();
            const parts = uri.split('/');
            return parts[parts.length - 1];
        }

        loadUserFiles();

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
    
    <footer class="mt-12 text-indigo-100 text-sm text-center">
        &copy; 2025 AlignMe. All rights reserved.
    </footer>
</body>

</html>