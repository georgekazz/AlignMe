<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - AlignMe</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/project.css">
</head>

<body class="hero-bg min-h-screen p-6">

    <!-- Back Button -->
  <div class="mb-8">
        <button onclick="window.history.back()"
            class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white/90 backdrop-blur-sm text-gray-700 rounded-xl hover:bg-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span class="font-semibold">Back to Dashboard</span>
        </button>
    </div>
    
    <!-- Trees Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div id="tree1"
            class="bg-white rounded-2xl shadow-lg p-4 overflow-y-auto max-h-[450px] animate__animated animate__fadeInLeft border border-gray-200">
            <h3 class="font-bold text-indigo-900 text-lg mb-3 border-b border-gray-100 pb-2">Source</h3>
            <div class="tree-container mt-2">
                <!-- Nodes θα γεμίσουν με JS -->
            </div>
        </div>

        <div id="tree2"
            class="bg-white rounded-2xl shadow-lg p-4 overflow-y-auto max-h-[450px] animate__animated animate__fadeInRight border border-gray-200">
            <h3 class="font-bold text-indigo-900 text-lg mb-3 border-b border-gray-100 pb-2">Target</h3>
            <div class="tree-container mt-2">
                <!-- Nodes θα γεμίσουν με JS -->
            </div>
        </div>
    </div>


    <div id="node-info" class="hidden bg-white p-4 rounded shadow max-w-s max-h-64 overflow-y-auto">
        <h2 id="node-title" class="text-lg font-semibold mb-2"></h2>
        <div id="node-details" class="text-sm text-gray-700"></div>
    </div>

    <!-- Suggestions Section -->
    <div class="flex flex-col items-center gap-6 mb-8 max-w-3xl mx-auto">

        <!-- Generate Suggestions Button -->
        <button id="generateSuggestionsBtn" 
                class="mt-6 flex items-center justify-center gap-2 px-6 py-3 rounded-full 
                    bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow-lg
                    hover:from-green-600 hover:to-green-800 transform transition-all duration-300 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Find Suggestions
        </button>

        <!-- Progress Bar -->
        <div id="suggestionsStatus" class="w-full bg-white/20 backdrop-blur-md rounded-2xl p-3 shadow-inner">
            <div class="w-full bg-gray-300 rounded-full h-4 overflow-hidden shadow-inner">
                <div id="suggestionsProgress" class="bg-green-400 h-4 w-0 transition-all duration-500 rounded-full">
                </div>
            </div>
            <div class="text-center mt-2">
                <span id="suggestionsCount" class="text-sm text-gray-900 font-semibold"></span>
            </div>
        </div>
    </div>

    <!-- Suggestions List -->
    <div id="node-suggestions"
         class="hidden bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 
            w-full max-w-7xl mx-auto 
            max-h-[100vh] overflow-y-auto
            animate__animated animate__fadeInUp">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-indigo-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                </svg>
                Matching Suggestions
            </h3>

            <!-- Info tooltip -->
            <div class="group relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 hover:text-indigo-600 cursor-help"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div
                    class="hidden group-hover:block absolute right-0 top-6 w-64 bg-gray-900 text-white text-xs rounded-lg p-3 shadow-lg z-10">
                    <strong>Match Quality:</strong><br>
                    • 90-100%: Excellent match<br>
                    • 70-89%: Good match<br>
                    • 50-69%: Moderate match<br>
                    • Below 50%: Weak match
                </div>
            </div>
        </div>

        <div id="suggestions-list" class="space-y-3"></div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-7xl mx-auto my-10">

    <!-- Create Link Section -->
    <div
        class="bg-white/80 backdrop-blur-md rounded-2xl shadow-2xl p-8 transform transition duration-500 hover:scale-[1.02] animate__animated animate__fadeInUp">

        <h3 class="text-2xl font-bold text-indigo-900 mb-6 text-center">Create Link</h3>

        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="flex-1 flex flex-col">
                <label for="linkCategory" class="text-sm font-medium mb-1">Category</label>
                <select id="linkCategory"
                    class="p-3 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent text-gray-700">
                    <option value="">-- Select Category --</option>
                    <option value="SKOS">SKOS</option>
                    <option value="OWL">OWL</option>
                    <option value="RDFS">RDFS</option>
                </select>
            </div>

            <div class="flex-1 flex flex-col">
                <label for="linkTypeSelect" class="text-sm font-medium mb-1">Type</label>
                <select id="linkTypeSelect"
                    class="p-3 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent text-gray-700">
                    <option value="">-- Select Type --</option>
                </select>
            </div>
        </div>

        <div class="flex justify-center">
            <button id="createLinkBtn" class="flex items-center justify-center gap-2 px-6 py-3 rounded-lg 
                bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold shadow-lg 
                hover:from-blue-600 hover:to-indigo-700 transform transition-all duration-300 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                </svg>
                Link Selected Suggestion
            </button>
        </div>
    </div>

    <!-- Export Section -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-8 border-2 border-white/50 transform transition duration-300 hover:shadow-purple-500/20">
            <h3 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Options
            </h3>

            <div class="flex flex-col gap-4">
                <button id="exportLinksBtn" 
                    class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl 
                    bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-bold shadow-xl text-lg
                    hover:from-indigo-600 hover:to-indigo-700 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0 0l-4-4m4 4l4-4M12 4v8" />
                    </svg>
                    Export Links
                </button>

                <button onclick="downloadOntology(projectId)" 
                    class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl 
                    bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold shadow-xl text-lg
                    hover:from-purple-600 hover:to-pink-600 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Export Ontology
                </button>
            </div>
</div>

    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const pathSegments = window.location.pathname.split('/');
        const projectId = pathSegments[pathSegments.length - 1];

        const token = localStorage.getItem("token");
        let selectedNode = null;

        async function loadProjectFiles() {
            if (!token) { alert("No token found. Please log in."); return; }

            try {
                const res = await fetch(`${window.apiBaseUrl}/project-files/${projectId}`, {
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

        function downloadOntology(projectId) {
            const url = `${window.apiBaseUrl}/projects/${projectId}/export`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("No ontology available for this project");
                    }
                    return response.blob();
                })
                .then(blob => {
                    const a = document.createElement("a");
                    a.href = URL.createObjectURL(blob);
                    a.download = `project_${projectId}_ontology.ttl`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                })
                .catch(err => {
                    alert(err.message);
                    console.error(err);
                });
        }

        async function showNodeInfo(nodeData) {
            const infoCard = document.getElementById("node-info");
            const title = document.getElementById("node-title");
            const detailsDiv = document.getElementById("node-details");

            title.textContent = nodeData.name;
            detailsDiv.innerHTML = "<p class='text-gray-500'>Loading...</p>";

            try {
                const res = await fetch(`${window.apiBaseUrl}/node-details/?project_id=${projectId}&uri=${encodeURIComponent(nodeData.uri)}`, {
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
            suggestionsList.innerHTML = "<p class='text-gray-500 text-center py-4'>Loading suggestions...</p>";
            suggestionsDiv.classList.remove("hidden");

            try {
                const res = await fetch(`${window.apiBaseUrl}/projects/${projectId}/suggestions_full?node_uri=${encodeURIComponent(nodeData.uri)}`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();

                suggestionsList.innerHTML = "";

                if (data.suggestions.length > 0) {
                    // Separate exact matches from others
                    const exactMatches = data.suggestions.filter(s => s.is_exact_match);
                    const otherMatches = data.suggestions.filter(s => !s.is_exact_match);

                    // Show exact matches first
                    if (exactMatches.length > 0) {
                        const exactHeader = document.createElement("div");
                        exactHeader.className = "mb-3 pb-2 border-b-2 border-green-500";
                        exactHeader.innerHTML = `
                    <span class="text-sm font-semibold text-green-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Exact Matches (${exactMatches.length})
                    </span>
                `;
                        suggestionsList.appendChild(exactHeader);

                        exactMatches.forEach(s => {
                            suggestionsList.appendChild(createSuggestionCard(s, true));
                        });
                    }

                    // Show other matches
                    if (otherMatches.length > 0) {
                        const otherHeader = document.createElement("div");
                        otherHeader.className = "mt-6 mb-3 pb-2 border-b-2 border-blue-300";
                        otherHeader.innerHTML = `
                    <span class="text-sm font-semibold text-blue-700">
                        Similar Matches (${otherMatches.length})
                    </span>
                `;
                        suggestionsList.appendChild(otherHeader);

                        otherMatches.forEach(s => {
                            suggestionsList.appendChild(createSuggestionCard(s, false));
                        });
                    }

                } else {
                    suggestionsList.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500 font-medium">No suggestions found</p>
                    <p class="text-gray-400 text-sm mt-1">Try selecting a different node</p>
                </div>
            `;
                }

                // Update progress bar
                let maxSim = data.suggestions.length > 0 ? Math.max(...data.suggestions.map(s => s.similarity)) : 0;
                document.getElementById("suggestionsProgress").style.width = (maxSim * 100) + "%";
                document.getElementById("suggestionsCount").textContent = `Best match: ${(maxSim * 100).toFixed(0)}%`;

            } catch (err) {
                suggestionsList.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-red-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-red-600 font-medium">Error loading suggestions</p>
                <p class="text-gray-500 text-sm mt-1">${err.message}</p>
            </div>
        `;
                console.error(err);
            }
        }

        function createSuggestionCard(suggestion, isExact) {
            const card = document.createElement("div");
            card.className = "suggestion-card bg-white rounded-lg p-4 cursor-pointer shadow-sm hover:shadow-md border border-gray-200";

            const similarity = suggestion.similarity * 100;
            const scoreClass = getScoreClass(similarity);
            const scoreBarClass = getScoreBarClass(similarity);

            // Get the scores object with defaults
            const scores = suggestion.scores || {
                label: suggestion.similarity,
                definition: 0,
                parent: 0,
                child: 0,
                sibling: 0
            };

            card.innerHTML = `
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-2">
                    ${isExact ? `
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            EXACT
                        </span>
                    ` : ''}
                    <h4 class="font-semibold text-gray-800 truncate">${suggestion.label2}</h4>
                </div>
                
                ${suggestion.all_labels && suggestion.all_labels.length > 1 ? `
                    <div class="text-xs text-gray-500 mb-2">
                        Also known as: ${suggestion.all_labels.slice(1).map(l => `<span class="detail-badge">${l}</span>`).join(' ')}
                    </div>
                ` : ''}
                
                <!-- Score bar -->
                <div class="score-bar-container mb-3">
                    <div class="score-bar ${scoreBarClass}" style="width: ${similarity}%"></div>
                </div>
                
                <!-- Main score and expand button -->
                <div class="flex items-center justify-between">
                    <span class="score-pill ${scoreClass}">${similarity.toFixed(1)}% Match</span>
                    
                    <button class="expand-btn text-xs text-gray-500 hover:text-indigo-600 flex items-center gap-1">
                        <span>Details</span>
                        <svg class="expand-icon w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Expandable details -->
                <div class="score-details hidden mt-3 pt-3 border-t border-gray-200">
                    <div class="text-xs text-gray-600 mb-2 font-medium">Score Breakdown:</div>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        ${createScoreDetail('Label', scores.label * 100, '📝')}
                        ${createScoreDetail('Definition', scores.definition * 100, '📄')}
                        ${createScoreDetail('Parent', scores.parent * 100, '⬆️')}
                        ${createScoreDetail('Child', scores.child * 100, '⬇️')}
                        ${createScoreDetail('Sibling', scores.sibling * 100, '↔️')}
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        <strong>URI:</strong> <code class="bg-gray-100 px-1 rounded">${suggestion.node2}</code>
                    </div>
                </div>
            </div>
        </div>
    `;

            card.addEventListener("click", (e) => {
                if (e.target.closest('.expand-btn')) return;

                document.querySelectorAll(".suggestion-card").forEach(el => el.classList.remove("selected"));
                card.classList.add("selected");
                selectedSuggestion = suggestion;
                console.log("Selected suggestion:", selectedSuggestion);
            });

            // Expand/collapse details
            const expandBtn = card.querySelector('.expand-btn');
            const details = card.querySelector('.score-details');
            const expandIcon = card.querySelector('.expand-icon');

            expandBtn.addEventListener("click", (e) => {
                e.stopPropagation();
                details.classList.toggle('hidden');
                expandIcon.classList.toggle('expanded');
            });

            return card;
        }

        function createScoreDetail(label, score, emoji) {
            const percentage = score.toFixed(0);
            const color = score >= 70 ? 'text-green-600' : score >= 40 ? 'text-blue-600' : 'text-gray-400';

            return `
        <div class="text-center p-2 bg-gray-50 rounded">
            <div class="text-lg">${emoji}</div>
            <div class="text-xs font-medium text-gray-600">${label}</div>
            <div class="text-sm font-bold ${color}">${percentage}%</div>
        </div>
    `;
        }

        function getScoreClass(score) {
            if (score >= 90) return 'score-excellent';
            if (score >= 70) return 'score-good';
            if (score >= 50) return 'score-moderate';
            return 'score-weak';
        }

        function getScoreBarClass(score) {
            if (score >= 90) return 'score-bar-excellent';
            if (score >= 70) return 'score-bar-good';
            if (score >= 50) return 'score-bar-moderate';
            return 'score-bar-weak';
        }

        let selectedNodeData = null;

        function renderTree(data, selector) {
            const container = d3.select(selector);
            container.html("");

            function createNode(nodeData, parentDiv) {
                // Δημιουργία node
                const nodeDiv = parentDiv.append("div").attr("class", "node-wrapper");
                const card = nodeDiv.append("div")
                    .attr("class", "node-card flex items-center")
                    .text(nodeData.name);

                let childrenDiv;
                if (nodeData.children && nodeData.children.length > 0) {
                    
                    card.html(`<svg class="arrow mr-2" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M9 6l6 6-6 6"/>
                            </svg>${nodeData.name}`);

                    childrenDiv = nodeDiv.append("div")
                        .attr("class", "node-children")
                        .style("display", "none"); 

                    nodeData.children.forEach(child => createNode(child, childrenDiv));
                }

                
                card.on("click", (event) => {
                    event.stopPropagation();
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

            if (Array.isArray(data)) {
                data.forEach(node => createNode(node, container));
            } else {
                createNode(data, container);
            }
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

            linkTypeSelect.innerHTML = `<option value="">-- Select Type --</option>`;

            if (!group) return;

            try {
                const res = await fetch(`${window.apiBaseUrl}/link-types?group=${group}`, {
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

                    const res = await fetch(`${window.apiBaseUrl}/links/`, {
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
                const res = await fetch(`${window.apiBaseUrl}/projects/${projectId}/export-links`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });

                if (!res.ok) throw new Error("Failed to export links");

                const data = await res.json();

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