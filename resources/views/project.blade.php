<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - AlignMe</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <style>
        .tree-container {
            display: flex;
            gap: 2rem;
        }

        .tree {
            flex: 1;
            border: 1px solid #ddddddff;
            background: #f9fafb;
            padding: 0.5rem;
            max-height: 400px;
            overflow-y: auto;
            border-radius: 0.5rem;
        }

        .node-card {
            display: flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            margin-bottom: 0.25rem;
            border-radius: 0.25rem;
            background: #fff;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .node-card:hover {
            background: #e0f2fe;
        }

        .node-card.selected {
            background: #2563eb;
            color: #fff;
        }

        .node-children {
            margin-left: 1rem;
            border-left: 1px dashed #ddd;
            padding-left: 0.5rem;
        }

        .arrow {
            width: 1rem;
            height: 1rem;
            margin-right: 0.25rem;
            color: #6b7280;
            transition: transform 0.2s;
        }

        .arrow-collapsed {
            transform: rotate(-90deg);
        }

        #node-info {
            transition: all 0.3s;
            border-left: 4px solid #2563eb;
            margin-top: 1rem;
            padding: 1rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        #node-info h2 {
            color: #1e3a8a;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .detail-key {
            font-weight: 500;
            color: #374151;
        }

        .detail-value {
            display: inline-block;
            margin-left: 0.25rem;
            background: #f3f4f6;
            padding: 0.15rem 0.3rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        #node-suggestions {
            max-height: 200px;
            overflow-y: auto;
            margin-top: 1rem;
        }
        .hero-bg {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }
    </style>
</head>

<body class="hero-bg min-h-screen p-6">

    <!-- Back Button -->
    <div class="mb-6">
        <button onclick="window.history.back()"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Dashboard
        </button>
    </div>

    <!-- Trees Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div id="tree1" class="bg-white rounded-xl shadow-lg p-4 overflow-y-auto max-h-[450px] animate__animated animate__fadeInLeft">
            <h3 class="font-bold text-indigo-900 mb-2">Tree 1</h3>
        </div>
        <div id="tree2" class="bg-white rounded-xl shadow-lg p-4 overflow-y-auto max-h-[450px] animate__animated animate__fadeInRight">
            <h3 class="font-bold text-indigo-900 mb-2">Tree 2</h3>
        </div>
    </div>

    <div id="node-info" class="hidden bg-white p-4 rounded shadow max-w-s max-h-64 overflow-y-auto">
        <h2 id="node-title" class="text-lg font-semibold mb-2"></h2>
        <div id="node-details" class="text-sm text-gray-700"></div>
    </div>

    <!-- Suggestions Section -->
    <div class="flex flex-col items-center gap-4 mb-8">
        <button id="generateSuggestionsBtn"
            class="px-6 py-2 bg-green-800 text-white font-semibold rounded-full shadow-lg hover:bg-green-600 transition transform hover:scale-105 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Find Suggestions
        </button>

        <div id="suggestionsStatus" class="w-2/3">
            <div class="w-full bg-gray-300 rounded-full h-4 overflow-hidden shadow-inner">
                <div id="suggestionsProgress" class="bg-green-400 h-4 w-0 transition-all duration-500 rounded-full"></div>
            </div>
            <div class="text-center mt-1">
                <span id="suggestionsCount" class="text-sm text-gray-100 font-semibold"></span>
            </div>
        </div>
    </div>

    <div id="node-suggestions" class="hidden bg-white rounded-xl shadow-lg p-6 max-w-3xl mx-auto animate__animated animate__fadeInUp">
        <h3 class="text-lg font-semibold mb-3 text-indigo-900 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
            </svg>
            Suggestions
        </h3>
        <div id="suggestions-list" class="text-gray-700 text-sm space-y-1"></div>
    </div>

    <!-- Create Link Section -->
    <div class="link-section bg-white rounded-xl shadow-lg p-6 max-w-3xl mx-auto my-6 animate__animated animate__fadeInUp">
        <h3 class="text-lg font-semibold mb-4 text-indigo-900">Create Link</h3>

        <div class="flex flex-col md:flex-row md:gap-4 gap-2">
            <div class="flex-1 flex flex-col">
                <label for="linkCategory" class="text-sm font-medium mb-1">Category</label>
                <select id="linkCategory" class="p-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">-- Select Category --</option>
                    <option value="SKOS">SKOS</option>
                    <option value="OWL">OWL</option>
                    <option value="RDFS">RDFS</option>
                </select>
            </div>

            <div class="flex-1 flex flex-col">
                <label for="linkTypeSelect" class="text-sm font-medium mb-1">Type</label>
                <select id="linkTypeSelect" class="p-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">-- Select Type --</option>
                </select>
            </div>
        </div>

        <button id="createLinkBtn" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
            </svg>
            Link Selected Suggestion
        </button>
    </div>

    <!-- Export Links Button -->
    <div class="flex justify-end max-w-3xl mx-auto mb-6">
        <button id="exportLinksBtn" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 flex items-center gap-2 transition transform hover:scale-105 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0 0l-4-4m4 4l4-4M12 4v8" />
            </svg>
            Export Links
        </button>
    </div>

    <script>
        const pathSegments = window.location.pathname.split('/');
        const projectId = pathSegments[pathSegments.length - 1];

        const token = localStorage.getItem("token");
        let selectedNode = null;

        async function loadProjectFiles() {
            if (!token) { alert("No token found. Please log in."); return; }

            try {
                const res = await fetch(`http://127.0.0.1:8000/project-files/${projectId}`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                if (!res.ok) throw new Error("Failed to load project NT files");

                const files = await res.json();

                if (files[0] && files[0].tree) renderTree(files[0].tree, "#tree1");
                else document.querySelector("#tree1").innerHTML = "<p class='text-red-600 font-bold'>No tree data</p>";

                if (files[1] && files[1].tree) renderTree(files[1].tree, "#tree2");
                else document.querySelector("#tree2").innerHTML = "<p class='text-red-600 font-bold'>No tree data</p>";

            } catch (err) {
                console.error(err);
                alert("Error loading project files: " + err.message);
            }
        }

        async function showNodeInfo(nodeData) {
            const infoCard = document.getElementById("node-info");
            const title = document.getElementById("node-title");
            const detailsDiv = document.getElementById("node-details");

            title.textContent = nodeData.name;
            detailsDiv.innerHTML = "<p class='text-gray-500'>Loading...</p>";

            try {
                const res = await fetch(`http://127.0.0.1:8000/node-details/?project_id=${projectId}&uri=${encodeURIComponent(nodeData.uri)}`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();

                detailsDiv.innerHTML = "";
                for (const key in data.details) {
                    const value = data.details[key];
                    const div = document.createElement("div");
                    div.innerHTML = `<span class="detail-key">${key} →</span> 
                                     <span class="detail-value">${Array.isArray(value) ? value.join(", ") : value}</span>`;
                    detailsDiv.appendChild(div);
                }

                infoCard.classList.remove("hidden");
            } catch (err) {
                detailsDiv.innerHTML = "<p class='text-red-600'>Error loading node details</p>";
                console.error(err);
            }
        }

        let selectedSuggestion = null;

        async function showNodeSuggestions(nodeData) {
            const suggestionsDiv = document.getElementById("node-suggestions");
            const suggestionsList = document.getElementById("suggestions-list");
            suggestionsList.innerHTML = "<p class='text-gray-500'>Loading suggestions...</p>";
            suggestionsDiv.classList.remove("hidden");

            try {
                const res = await fetch(`http://127.0.0.1:8000/projects/${projectId}/suggestions?node_uri=${encodeURIComponent(nodeData.uri)}`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();

                suggestionsList.innerHTML = "";
                if (data.suggestions.length > 0) {
                    data.suggestions.forEach(s => {
                        const div = document.createElement("div");
                        div.className = "suggestion-item p-2 border-b border-gray-200 cursor-pointer hover:bg-indigo-50";
                        div.innerHTML = `<strong>${s.label2}</strong> 
                                 (<span class="text-indigo-600">${(s.similarity * 100).toFixed(0)}%</span>)`;

                        // click για επιλογή
                        div.addEventListener("click", () => {
                            document.querySelectorAll(".suggestion-item").forEach(el => el.classList.remove("bg-indigo-100"));
                            div.classList.add("bg-indigo-100");
                            selectedSuggestion = s;
                            console.log("Selected suggestion:", selectedSuggestion);
                        });

                        suggestionsList.appendChild(div);
                    });
                } else {
                    suggestionsList.innerHTML = "<p class='text-gray-500'>No suggestions found</p>";
                }

                let maxSim = data.suggestions.length > 0 ? Math.max(...data.suggestions.map(s => s.similarity)) : 0;
                document.getElementById("suggestionsProgress").style.width = (maxSim * 100) + "%";
                document.getElementById("suggestionsCount").textContent = `Highest similarity: ${(maxSim * 100).toFixed(0)}%`;

            } catch (err) {
                suggestionsList.innerHTML = "<p class='text-red-600'>Error loading suggestions</p>";
                console.error(err);
            }
        }

        let selectedNodeData = null;

        function renderTree(data, selector) {
            const container = d3.select(selector);
            container.html("");

            function createNode(nodeData, parentDiv) {
                const nodeDiv = parentDiv.append("div");
                const card = nodeDiv.append("div")
                    .attr("class", "node-card flex items-center")
                    .text(nodeData.name);

                let childrenDiv;
                if (nodeData.children && nodeData.children.length > 0) {
                    card.html(`<svg class="arrow" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M9 6l6 6-6 6"/>
                    </svg>` + nodeData.name);

                    childrenDiv = nodeDiv.append("div")
                        .attr("class", "node-children")
                        .style("display", "block");

                    nodeData.children.forEach(child => createNode(child, childrenDiv));
                }

                card.on("click", () => {
                    showNodeInfo(nodeData);

                    if (selectedNode) selectedNode.classed("selected", false);
                    card.classed("selected", true);
                    selectedNode = card;

                    selectedNodeData = nodeData;

                    if (childrenDiv) {
                        const visible = childrenDiv.style("display") === "block";
                        childrenDiv.style("display", visible ? "none" : "block");
                        card.select("svg.arrow").classed("arrow-collapsed", !visible);
                    }
                });
            }

            createNode(data, container);
        }

        loadProjectFiles();

        // Generate Suggestions Button
        const generateBtn = document.getElementById("generateSuggestionsBtn");
        generateBtn.addEventListener("click", async () => {
            if (!selectedNodeData) {
                alert("Please select a node first!");
                return;
            }
            await showNodeSuggestions(selectedNodeData);
        });

        const groupSelect = document.getElementById("linkCategory");
        const linkTypeSelect = document.getElementById("linkTypeSelect");

        groupSelect.addEventListener("change", async () => {
            const group = groupSelect.value;

            // Reset dropdown
            linkTypeSelect.innerHTML = `<option value="">-- Select Type --</option>`;

            if (!group) return;

            try {
                const res = await fetch(`http://127.0.0.1:8000/link-types?group=${group}`, {
                    headers: { "Authorization": "Bearer " + token }
                });
                if (!res.ok) throw new Error("Failed to load link types");

                const data = await res.json();

                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.value;
                    linkTypeSelect.appendChild(option);
                });

            } catch (err) {
                console.error(err);
                linkTypeSelect.innerHTML = `<option value="">Error loading types</option>`;
            }
        });


        const linkBtn = document.getElementById("createLinkBtn");

        document.addEventListener("DOMContentLoaded", () => {
            linkBtn.addEventListener("click", async () => {
                if (!selectedSuggestion) {
                    alert("Please pick a suggestion first!");
                    return;
                }
                if (!selectedNodeData) {
                    alert("Please select a source node first!");
                    return;
                }

                const category = document.getElementById("linkCategory").value;
                const type = document.getElementById("linkTypeSelect").value;

                if (!category || !type) {
                    alert("Please select both category and type");
                    return;
                }

                const link_type_id = parseInt(type);

                try {
                    const payload = {
                        project_id: parseInt(projectId),
                        source_node: selectedNodeData.uri,
                        target_node: selectedSuggestion.node2,
                        link_type_id: parseInt(linkTypeSelect.value),
                        suggestion_score: selectedSuggestion.similarity * 100
                    };

                    console.log("Link payload:", payload);

                    const res = await fetch(`http://127.0.0.1:8000/links/`, {
                        method: "POST",
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });


                    if (!res.ok) {
                        const errorData = await res.json();
                        throw new Error(errorData.detail || "Failed to create link");
                    }

                    const data = await res.json();
                    alert("Link created successfully!");
                    console.log(data);

                } catch (err) {
                    console.error(err);
                    alert("Error: " + err.message);
                }
            });
        });

        const exportBtn = document.getElementById('exportLinksBtn');
        exportBtn.addEventListener('click', async () => {
            try {
                const res = await fetch(`http://127.0.0.1:8000/projects/${projectId}/export-links`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });

                if (!res.ok) throw new Error("Failed to export links");

                const data = await res.json();

                // Δημιουργία blob και download
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `project_${projectId}_links.json`;
                a.click();
                URL.revokeObjectURL(url);

                alert("Links exported successfully!");
            } catch (err) {
                console.error(err);
                alert("Error exporting links: " + err.message);
            }
        });


    </script>

</body>

</html>