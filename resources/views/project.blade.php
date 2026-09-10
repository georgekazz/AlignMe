<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/project.css">
</head>

<body class="hero-bg min-h-screen">

    <!-- Top bar -->
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-indigo-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center gap-3">
            <a href="/dashboard" class="btn btn-ghost"
                onclick="if (history.length > 1) { history.back(); return false; }">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
            <h1 id="projectName" class="font-bold text-indigo-900 text-lg truncate flex-1 min-w-0">Loading project…</h1>

            <div class="flex items-center gap-2">
                <select id="exportFormat" class="input w-auto text-sm" title="Alignment export format">
                    <option value="turtle">Turtle (.ttl)</option>
                    <option value="xml">RDF/XML (.rdf)</option>
                    <option value="nt">N-Triples (.nt)</option>
                    <option value="json-ld">JSON-LD</option>
                </select>
                <button id="exportOntologyBtn" class="btn btn-secondary">Export alignment</button>
                <button id="exportLinksBtn" class="btn btn-ghost" title="Download all links as JSON">Links JSON</button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        <!-- Trees -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="panel tree-panel" data-tree="1">
                <div class="panel-head">
                    <div class="min-w-0">
                        <h2 class="panel-title">File 1</h2>
                        <p class="panel-sub truncate" data-filename>—</p>
                    </div>
                    <div class="flex gap-1">
                        <button class="btn-icon" data-expand-all title="Expand all">＋</button>
                        <button class="btn-icon" data-collapse-all title="Collapse all">－</button>
                    </div>
                </div>
                <div class="search-row">
                    <input type="search" placeholder="Search File 1 (Enter = next match)" class="input" data-search>
                    <span class="search-count" data-search-count></span>
                </div>
                <div class="tree-scroll">
                    <div class="tree-container" data-tree-container>
                        <p class="muted">Loading…</p>
                    </div>
                </div>
            </div>

            <div class="panel tree-panel" data-tree="2">
                <div class="panel-head">
                    <div class="min-w-0">
                        <h2 class="panel-title">File 2</h2>
                        <p class="panel-sub truncate" data-filename>—</p>
                    </div>
                    <div class="flex gap-1">
                        <button class="btn-icon" data-expand-all title="Expand all">＋</button>
                        <button class="btn-icon" data-collapse-all title="Collapse all">－</button>
                    </div>
                </div>
                <div class="search-row">
                    <input type="search" placeholder="Search File 2 (Enter = next match)" class="input" data-search>
                    <span class="search-count" data-search-count></span>
                </div>
                <div class="tree-scroll">
                    <div class="tree-container" data-tree-container>
                        <p class="muted">Loading…</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Selected node + matching -->
        <section id="matchPanel" class="panel">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
                <div class="flex-1 min-w-0">
                    <p class="panel-sub">Selected concept</p>
                    <h2 id="node-title" class="text-xl font-bold text-indigo-900 truncate">Click a concept in either
                        tree to start</h2>
                    <p id="node-uri" class="text-xs text-gray-500 break-all mt-1"></p>
                    <details id="node-info" class="mt-2 hidden">
                        <summary class="text-sm text-indigo-700 cursor-pointer select-none">Show properties</summary>
                        <div id="node-details" class="mt-2 text-sm space-y-1"></div>
                    </details>
                </div>

                <form id="matchForm" class="w-full md:w-auto md:min-w-[320px] space-y-3" onsubmit="return false;">
                    <div class="segmented" role="radiogroup" aria-label="Matching algorithm">
                        <label><input type="radio" name="matchingModel" value="lexical"><span>Lexical</span></label>
                        <label><input type="radio" name="matchingModel" value="semantic"><span>Semantic</span></label>
                        <label><input type="radio" name="matchingModel" value="hybrid"
                                checked><span>Hybrid</span></label>
                    </div>
                    <p id="modelHint" class="text-xs text-gray-500">Labels, definitions, meaning and hierarchy combined,
                        with similarity propagation. Recommended.</p>

                    <details class="text-sm">
                        <summary class="cursor-pointer text-indigo-700 select-none">Options</summary>
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <label class="field">Min. score <span id="thresholdValue">0.40</span>
                                <input type="range" id="minThreshold" min="0.1" max="0.95" step="0.05" value="0.4"
                                    class="w-full">
                            </label>
                            <label class="field">Max results
                                <input type="number" id="topK" min="1" max="200" value="20" class="input">
                            </label>
                            <label class="field">Neighbour match <span id="structValue">0.60</span>
                                <input type="range" id="structThreshold" min="0.3" max="0.9" step="0.05" value="0.6"
                                    class="w-full">
                            </label>
                            <label class="field">Propagation rounds
                                <input type="number" id="propagation" min="0" max="5" value="2" class="input">
                            </label>
                            <label class="col-span-2 flex items-center gap-2 text-sm" id="contextOption">
                                <input type="checkbox" id="useContext"> Include parent/child labels (semantic only)
                            </label>
                        </div>
                    </details>

                    <button id="generateSuggestionsBtn" class="btn btn-primary w-full" disabled>Find matches</button>
                    <button id="alignAllBtn" class="btn btn-secondary w-full" type="button">Align whole project</button>
                </form>
            </div>
        </section>

        <!-- Suggestions -->
        <section id="node-suggestions" class="panel hidden">
            <div class="panel-head">
                <div>
                    <h2 class="panel-title">Matches</h2>
                    <p id="suggestionsMeta" class="panel-sub"></p>
                </div>
                <div class="group relative">
                    <button class="btn-icon" aria-label="How to read scores">?</button>
                    <div class="tooltip hidden group-hover:block group-focus-within:block">
                        90–100% excellent · 70–89% good · 50–69% moderate · below 50% weak.
                        Open a card to see which signals (label, definition, hierarchy) contributed.
                    </div>
                </div>
            </div>
            <div id="suggestions-list" class="space-y-3"></div>
        </section>

        <!-- Create link -->
        <section id="linkPanel" class="panel hidden">
            <h2 class="panel-title mb-3">Create link</h2>
            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-3 items-center text-sm mb-4">
                <div class="link-end"><span class="panel-sub">From</span><strong id="linkSource"
                        class="truncate block"></strong></div>
                <button id="swapDirection" class="btn-icon justify-self-center" title="Swap direction">⇄</button>
                <div class="link-end"><span class="panel-sub">To</span><strong id="linkTarget"
                        class="truncate block"></strong></div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <select id="linkCategory" class="input flex-1">
                    <option value="">Category…</option>
                    <option value="SKOS">SKOS</option>
                    <option value="OWL">OWL</option>
                    <option value="RDFS">RDFS</option>
                </select>
                <select id="linkTypeSelect" class="input flex-1" disabled>
                    <option value="">Relation type…</option>
                </select>
                <button id="createLinkBtn" class="btn btn-primary" disabled>Create link</button>
            </div>
        </section>

        <!-- Existing links -->
        <section class="panel">
            <div class="panel-head">
                <h2 class="panel-title">Links in this project <span id="linksCount"
                        class="panel-sub font-normal"></span></h2>
                <button id="refreshLinks" class="btn-icon" title="Refresh">↻</button>
            </div>
            <div id="links-list" class="space-y-2">
                <p class="muted">Loading…</p>
            </div>
        </section>
    </main>

    <div id="toasts" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const projectId = window.location.pathname.split('/').filter(Boolean).pop();
        const token = localStorage.getItem("token");
        if (!token) window.location.href = "/login";

        const state = {
            files: [null, null],          
            selected: null,               
            suggestion: null,            
            swapped: false,              
            linkTypes: [],
        };
        const trees = {};                 

        async function api(path, options = {}) {
            const res = await fetch(window.apiBaseUrl + path, {
                ...options,
                headers: { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json', ...(options.headers || {}) },
            });
            if (res.status === 401) { localStorage.removeItem("token"); window.location.href = "/login"; return; }
            if (!res.ok) {
                let msg = res.statusText;
                try { msg = (await res.json()).detail || msg; } catch (_) { }
                throw new Error(typeof msg === 'string' ? msg : JSON.stringify(msg));
            }
            return res;
        }
        const getJSON = (p) => api(p).then(r => r.json());

        function toast(message, kind = "info") {
            const el = document.createElement("div");
            el.className = `toast toast-${kind}`;
            el.textContent = message;
            document.getElementById("toasts").appendChild(el);
            setTimeout(() => el.classList.add("show"), 10);
            setTimeout(() => { el.classList.remove("show"); setTimeout(() => el.remove(), 300); }, 4000);
        }
        const esc = (s) => String(s ?? "").replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const pct = (x) => (Number(x || 0) * 100).toFixed(0);
        const labelFor = (uri) => {
            for (const t of Object.values(trees)) {
                const hit = t.nodes.find(n => n.node.uri === uri);
                if (hit) return hit.node.name;
            }
            return uri.split(/[#/]/).pop();
        };
        function download(blob, filename) {
            const a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = filename;
            document.body.appendChild(a); a.click(); a.remove();
            setTimeout(() => URL.revokeObjectURL(a.href), 1000);
        }

        function renderTree(treeIndex, data) {
            const panel = document.querySelector(`.tree-panel[data-tree="${treeIndex}"]`);
            const container = panel.querySelector('[data-tree-container]');
            container.innerHTML = "";
            const t = trees[treeIndex] = { container, nodes: [], search: { matches: [], cursor: -1 } };

            function createNode(node, parentEl, depth) {
                const wrapper = document.createElement("div");
                wrapper.className = "node-wrapper";
                const card = document.createElement("div");
                card.className = "node-card";
                card.tabIndex = 0;
                card.dataset.uri = node.uri;
                const hasChildren = node.children && node.children.length > 0;
                card.innerHTML = `${hasChildren ? '<svg class="arrow arrow-collapsed" viewBox="0 0 24 24"><path fill="currentColor" d="M9 6l6 6-6 6"/></svg>' : '<span class="leaf-dot"></span>'}<span class="node-name">${esc(node.name)}</span>${hasChildren ? `<span class="node-count">${node.children.length}</span>` : ''}`;
                wrapper.appendChild(card);

                let childrenEl = null;
                if (hasChildren) {
                    childrenEl = document.createElement("div");
                    childrenEl.className = "node-children";
                    childrenEl.hidden = depth > 0;         // root level open by default
                    if (depth === 0) card.querySelector('.arrow').classList.remove('arrow-collapsed');
                    node.children.forEach(c => createNode(c, childrenEl, depth + 1));
                    wrapper.appendChild(childrenEl);
                }
                parentEl.appendChild(wrapper);
                t.nodes.push({ node, el: card, childrenEl });

                const toggle = () => {
                    if (!childrenEl) return;
                    childrenEl.hidden = !childrenEl.hidden;
                    card.querySelector('.arrow').classList.toggle('arrow-collapsed', childrenEl.hidden);
                };
                card.addEventListener("click", (e) => {
                    if (e.target.closest('.arrow')) { e.stopPropagation(); toggle(); return; }
                    selectNode(node, treeIndex, card);
                    if (childrenEl && childrenEl.hidden) toggle();
                });
                card.addEventListener("keydown", (e) => {
                    if (e.key === "Enter" || e.key === " ") { e.preventDefault(); card.click(); }
                    if (e.key === "ArrowRight" && childrenEl && childrenEl.hidden) toggle();
                    if (e.key === "ArrowLeft" && childrenEl && !childrenEl.hidden) toggle();
                });
            }

            (Array.isArray(data) ? data : [data]).forEach(n => createNode(n, container, 0));
            if (!t.nodes.length) container.innerHTML = "<p class='muted'>No concepts with labels found in this file.</p>";

            panel.querySelector('[data-expand-all]').onclick = () => setAll(treeIndex, false);
            panel.querySelector('[data-collapse-all]').onclick = () => setAll(treeIndex, true);
            const input = panel.querySelector('[data-search]');
            const count = panel.querySelector('[data-search-count]');
            input.oninput = () => runSearch(treeIndex, input.value, count);
            input.onkeydown = (e) => { if (e.key === "Enter") { e.preventDefault(); nextMatch(treeIndex, count); } };
        }

        function setAll(treeIndex, collapsed) {
            trees[treeIndex].nodes.forEach(n => {
                if (!n.childrenEl) return;
                n.childrenEl.hidden = collapsed;
                n.el.querySelector('.arrow').classList.toggle('arrow-collapsed', collapsed);
            });
        }

        function revealNode(cardEl) {
            let parent = cardEl.closest('.node-children');
            while (parent) {
                parent.hidden = false;
                parent.previousElementSibling?.querySelector('.arrow')?.classList.remove('arrow-collapsed');
                parent = parent.parentElement.closest('.node-children');
            }
            cardEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function runSearch(treeIndex, query, countEl) {
            const t = trees[treeIndex];
            const q = query.trim().toLowerCase();
            t.nodes.forEach(n => n.el.classList.remove('search-hit', 'search-current'));
            t.search = { matches: [], cursor: -1 };
            if (!q) { countEl.textContent = ""; return; }
            t.search.matches = t.nodes.filter(n => n.node.name.toLowerCase().includes(q) || n.node.uri.toLowerCase().includes(q));
            t.search.matches.forEach(n => n.el.classList.add('search-hit'));
            if (t.search.matches.length) nextMatch(treeIndex, countEl);
            else countEl.textContent = "No matches";
        }

        function nextMatch(treeIndex, countEl) {
            const s = trees[treeIndex].search;
            if (!s.matches.length) return;
            if (s.cursor >= 0) s.matches[s.cursor].el.classList.remove('search-current');
            s.cursor = (s.cursor + 1) % s.matches.length;
            const hit = s.matches[s.cursor];
            hit.el.classList.add('search-current');
            revealNode(hit.el);
            countEl.textContent = `${s.cursor + 1} / ${s.matches.length}`;
        }

        async function selectNode(node, treeIndex, el) {
            document.querySelectorAll('.node-card.selected').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            state.selected = { node, treeIndex, el };
            state.suggestion = null;
            state.swapped = false;

            document.getElementById("node-title").textContent = node.name;
            document.getElementById("node-uri").textContent = node.uri;
            document.getElementById("generateSuggestionsBtn").disabled = false;
            document.getElementById("generateSuggestionsBtn").textContent = `Find matches in File ${treeIndex === 1 ? 2 : 1}`;
            document.getElementById("linkPanel").classList.add("hidden");
            document.getElementById("node-suggestions").classList.add("hidden");
            document.getElementById("matchPanel").scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            const info = document.getElementById("node-info");
            const details = document.getElementById("node-details");
            info.classList.remove("hidden");
            details.innerHTML = "<p class='muted'>Loading…</p>";
            try {
                const data = await getJSON(`/node-details/?project_id=${projectId}&uri=${encodeURIComponent(node.uri)}`);
                details.innerHTML = Object.entries(data.details).map(([k, v]) =>
                    `<div><span class="detail-key">${esc(k)}</span> ${(Array.isArray(v) ? v : [v]).map(x => `<span class="detail-value">${esc(x)}</span>`).join(' ')}</div>`
                ).join("") || "<p class='muted'>No properties.</p>";
            } catch (err) {
                details.innerHTML = `<p class='text-red-600'>${esc(err.message)}</p>`;
            }
        }

        const modelRadios = document.querySelectorAll('input[name="matchingModel"]');
        const hints = {
            lexical: "String similarity of labels (same language), notation codes, definitions and hierarchy. Works offline.",
            semantic: "Multilingual language model compares meaning, plus hierarchy. Slower on the first run while the model loads.",
            hybrid: "Labels, definitions, meaning and hierarchy combined, with similarity propagation. Recommended.",
        };
        modelRadios.forEach(r => r.addEventListener("change", () => {
            document.getElementById("modelHint").textContent = hints[r.value];
            document.getElementById("minThreshold").value = r.value === "lexical" ? 0.4 : 0.5;
            document.getElementById("thresholdValue").textContent = Number(document.getElementById("minThreshold").value).toFixed(2);
            document.getElementById("contextOption").classList.toggle("opacity-50", r.value === "lexical");
        }));
        document.getElementById("structThreshold").addEventListener("input", (e) => {
            document.getElementById("structValue").textContent = Number(e.target.value).toFixed(2);
        });
        function matchParams() {
            const model = document.querySelector('input[name="matchingModel"]:checked').value;
            return new URLSearchParams({
                method: model,
                min_threshold: document.getElementById("minThreshold").value,
                top_k: document.getElementById("topK").value || 20,
                use_context: document.getElementById("useContext").checked,
                structural_threshold: document.getElementById("structThreshold").value,
                propagation_iterations: document.getElementById("propagation").value || 2,
            });
        }
        document.getElementById("minThreshold").addEventListener("input", (e) => {
            document.getElementById("thresholdValue").textContent = Number(e.target.value).toFixed(2);
        });

        document.getElementById("generateSuggestionsBtn").addEventListener("click", async () => {
            if (!state.selected) return toast("Select a concept first", "warn");
            const params = matchParams();
            const model = params.get("method");
            params.set("node_uri", state.selected.node.uri);

            const btn = document.getElementById("generateSuggestionsBtn");
            const section = document.getElementById("node-suggestions");
            const list = document.getElementById("suggestions-list");
            btn.disabled = true; btn.innerHTML = '<span class="spinner"></span> Finding matches…';
            section.classList.remove("hidden");
            list.innerHTML = `<p class="muted">${model === "lexical" ? "Comparing labels…" : "Comparing meanings — the first run loads the language model and matches the whole project, later clicks are instant."}</p>`;

            try {
                const data = await getJSON(`/projects/${projectId}/suggestions?${params}`);
                renderSuggestions(data, model);
            } catch (err) {
                list.innerHTML = `<div class="empty"><p class="text-red-600 font-medium">Could not get matches</p><p class="muted">${esc(err.message)}</p></div>`;
            } finally {
                btn.disabled = false;
                btn.textContent = `Find matches in File ${state.selected.treeIndex === 1 ? 2 : 1}`;
            }
        });

        function renderSuggestions(data, model) {
            const list = document.getElementById("suggestions-list");
            const meta = document.getElementById("suggestionsMeta");
            list.innerHTML = "";
            state.suggestion = null;
            const s = data.suggestions || [];
            meta.textContent = `${data.total_matches} candidate${data.total_matches === 1 ? "" : "s"} · ${data.exact_matches} exact · ${model} matching · ${data.summary.concepts_file1} × ${data.summary.concepts_file2} concepts compared`;

            if (!s.length) {
                list.innerHTML = `<div class="empty"><p class="font-medium text-gray-700">No matches above ${pct(data.parameters?.min_threshold)}%</p><p class="muted">Lower the minimum score in Options, or try the other algorithm.</p></div>`;
                return;
            }
            const exact = s.filter(x => x.is_exact_match), other = s.filter(x => !x.is_exact_match);
            if (exact.length) {
                list.insertAdjacentHTML("beforeend", `<p class="group-label text-green-700">Exact label matches (${exact.length})</p>`);
                exact.forEach(x => list.appendChild(suggestionCard(x, true)));
            }
            if (other.length) {
                list.insertAdjacentHTML("beforeend", `<p class="group-label text-indigo-700 ${exact.length ? "mt-4" : ""}">Similar concepts (${other.length})</p>`);
                other.forEach(x => list.appendChild(suggestionCard(x, false)));
            }
        }

        function scoreClass(p) { return p >= 90 ? "excellent" : p >= 70 ? "good" : p >= 50 ? "moderate" : "weak"; }

        const SIGNAL_NAMES = {
            jaro_winkler: "Spelling", token_set: "Words", dice: "Bigrams", notation: "Code",
            label_embedding: "Label meaning", concept_embedding: "Concept meaning", definition_embedding: "Definition meaning",
            definition_tfidf: "Definition words", parent: "Parents", child: "Children", sibling: "Siblings",
            ancestor_path: "Ancestors", depth: "Depth", subtree: "Subtree", label: "Label", concept: "Meaning", definition: "Definition"
        };
        const REL_LABEL = { exactMatch: "exact match", closeMatch: "close match", broadMatch: "broader", narrowMatch: "narrower", relatedMatch: "related", uncertain: "uncertain" };

        function suggestionCard(sug, isExact) {
            const p = sug.similarity * 100;
            const cls = scoreClass(p);
            const breakdown = Object.entries(sug.scores || {})
                .map(([k, v]) => `<div class="score-cell"><span>${SIGNAL_NAMES[k] || k}</span><strong class="${v >= 0.7 ? "text-green-600" : v >= 0.4 ? "text-indigo-600" : "text-gray-400"}">${pct(v)}%</strong></div>`).join("");
            const rel = sug.suggested_relation;
            const conflict = sug.better_source_for_target ? `<p class="text-xs text-amber-700 mt-1">⚠ Fits “${esc(labelFor(sug.better_source_for_target))}” better in the overall alignment.</p>` : "";
            const inAlign = sug.in_global_alignment ? '<span class="badge badge-align">best 1:1 match</span>' : "";

            const card = document.createElement("div");
            card.className = `suggestion-card score-${cls}`;
            card.tabIndex = 0;
            card.dataset.relation = rel;
            card.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            ${isExact ? '<span class="badge badge-exact">exact label</span>' : ""}
                            ${rel && rel !== "uncertain" ? `<span class="badge badge-rel">${REL_LABEL[rel] || rel}</span>` : ""}
                            ${inAlign}
                            <h4 class="font-semibold text-gray-800 truncate">${esc(sug.label2)}</h4>
                        </div>
                        ${sug.all_labels?.length > 1 ? `<p class="text-xs text-gray-500 mt-1">Also: ${sug.all_labels.slice(1, 4).map(l => `<span class="detail-badge">${esc(l)}</span>`).join(" ")}</p>` : ""}
                        ${sug.definition ? `<p class="text-xs text-gray-600 mt-1 line-clamp-2">${esc(sug.definition)}</p>` : ""}
                        ${sug.reasons?.length ? `<p class="text-xs text-green-700 mt-1">✓ ${sug.reasons.map(esc).join(" · ")}</p>` : ""}
                        ${conflict}
                        <div class="score-bar-container mt-2"><div class="score-bar" style="width:${p}%"></div></div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="score-pill">${p.toFixed(0)}%</div>
                        <button class="expand-btn" type="button">details</button>
                    </div>
                </div>
                <div class="score-details" hidden>
                    <div class="score-grid">${breakdown}</div>
                    ${sug.unavailable_signals?.length ? `<p class="text-xs text-gray-400 mt-2">Not available for this pair: ${sug.unavailable_signals.map(k => SIGNAL_NAMES[k] || k).join(", ")}</p>` : ""}
                    <p class="text-xs text-gray-500 mt-2 break-all">${esc(sug.node2)}</p>
                </div>`;

            card.querySelector(".expand-btn").addEventListener("click", (e) => {
                e.stopPropagation();
                const d = card.querySelector(".score-details");
                d.hidden = !d.hidden;
                e.target.textContent = d.hidden ? "details" : "hide";
            });
            const select = () => {
                document.querySelectorAll(".suggestion-card.selected").forEach(el => el.classList.remove("selected"));
                card.classList.add("selected");
                state.suggestion = sug;
                const otherIndex = state.selected.treeIndex === 1 ? 2 : 1;
                const hit = trees[otherIndex]?.nodes.find(n => n.node.uri === sug.node2);
                document.querySelectorAll('.node-card.target').forEach(c => c.classList.remove('target'));
                if (hit) { hit.el.classList.add('target'); revealNode(hit.el); }
                showLinkPanel();
                preselectRelation(rel);
            };
            card.addEventListener("click", select);
            card.addEventListener("keydown", (e) => { if (e.key === "Enter") select(); });
            return card;
        }

        async function preselectRelation(rel) {
            if (!rel || rel === "uncertain") return;
            if (categorySelect.value !== "SKOS") {
                categorySelect.value = "SKOS";
                categorySelect.dispatchEvent(new Event("change"));
                await new Promise(r => setTimeout(r, 300));
            }
            const opt = [...typeSelect.options].find(o => (o.textContent + " " + o.dataset.inner).toLowerCase().includes(rel.toLowerCase()));
            if (opt) { typeSelect.value = opt.value; updateCreateBtn(); }
        }

        document.getElementById("alignAllBtn").addEventListener("click", async () => {
            const params = matchParams();
            params.set("min_threshold", Math.max(0.6, Number(params.get("min_threshold"))));
            const section = document.getElementById("node-suggestions");
            const list = document.getElementById("suggestions-list");
            const meta = document.getElementById("suggestionsMeta");
            section.classList.remove("hidden");
            list.innerHTML = `<p class="muted">Aligning every concept of File 1 with File 2…</p>`;
            section.scrollIntoView({ behavior: "smooth", block: "start" });
            try {
                const data = await getJSON(`/projects/${projectId}/alignment?${params}`);
                meta.textContent = `${data.count} one-to-one pairs above ${pct(data.min_threshold)}% · ` +
                    Object.entries(data.by_relation).map(([k, v]) => `${v} ${REL_LABEL[k] || k}`).join(", ");
                list.innerHTML = "";
                if (!data.pairs.length) { list.innerHTML = `<div class="empty"><p class="muted">Nothing above the threshold. Lower the minimum score in Options.</p></div>`; return; }
                const bar = document.createElement("div");
                bar.className = "flex flex-wrap gap-2 items-center mb-3";
                bar.innerHTML = `<button id="acceptExact" class="btn btn-primary">Create links for exact matches ≥ 90%</button>
                                 <span class="muted">Links are created as SKOS relations; you can delete any of them below.</span>`;
                list.appendChild(bar);
                bar.querySelector("#acceptExact").addEventListener("click", async (e) => {
                    e.target.disabled = true;
                    try {
                        const r = await api(`/projects/${projectId}/alignment/accept`, {
                            method: "POST",
                            body: JSON.stringify({ method: params.get("method"), min_threshold: 0.9, relations: ["exactMatch"] })
                        }).then(r => r.json());
                        toast(`Created ${r.created} links`, "success"); loadLinks();
                    } catch (err) { toast(err.message, "error"); e.target.disabled = false; }
                });
                data.pairs.forEach(pair => {
                    const row = document.createElement("div");
                    row.className = `suggestion-card score-${scoreClass(pair.similarity * 100)} py-2`;
                    row.innerHTML = `<div class="flex items-center gap-3 text-sm">
                        <strong class="truncate" title="${esc(pair.node1)}">${esc(pair.label1)}</strong>
                        <span class="badge badge-rel">${REL_LABEL[pair.suggested_relation] || pair.suggested_relation}</span>
                        <strong class="truncate" title="${esc(pair.node2)}">${esc(pair.label2)}</strong>
                        <span class="score-pill ml-auto">${pct(pair.similarity)}%</span></div>
                        ${pair.reasons?.length ? `<p class="text-xs text-green-700 mt-1">✓ ${pair.reasons.map(esc).join(" · ")}</p>` : ""}`;
                    row.addEventListener("click", () => {
                        const hit = trees[1]?.nodes.find(n => n.node.uri === pair.node1);
                        if (hit) { revealNode(hit.el); hit.el.click(); }
                    });
                    list.appendChild(row);
                });
            } catch (err) {
                list.innerHTML = `<div class="empty"><p class="text-red-600 font-medium">Alignment failed</p><p class="muted">${esc(err.message)}</p></div>`;
            }
        });

        // ---------- links ----------
        function linkEnds() {
            const a = { uri: state.selected.node.uri, name: state.selected.node.name };
            const b = { uri: state.suggestion.node2, name: state.suggestion.label2 };
            return state.swapped ? [b, a] : [a, b];
        }
        function showLinkPanel() {
            const [from, to] = linkEnds();
            document.getElementById("linkSource").textContent = from.name;
            document.getElementById("linkSource").title = from.uri;
            document.getElementById("linkTarget").textContent = to.name;
            document.getElementById("linkTarget").title = to.uri;
            document.getElementById("linkPanel").classList.remove("hidden");
            updateCreateBtn();
        }
        document.getElementById("swapDirection").addEventListener("click", () => { state.swapped = !state.swapped; showLinkPanel(); });

        const categorySelect = document.getElementById("linkCategory");
        const typeSelect = document.getElementById("linkTypeSelect");
        function updateCreateBtn() {
            document.getElementById("createLinkBtn").disabled = !(state.suggestion && typeSelect.value);
        }
        categorySelect.addEventListener("change", async () => {
            typeSelect.innerHTML = `<option value="">Relation type…</option>`;
            typeSelect.disabled = true;
            updateCreateBtn();
            if (!categorySelect.value) return;
            try {
                const types = await getJSON(`/link-types?group=${encodeURIComponent(categorySelect.value)}`);
                if (!types.length) { typeSelect.innerHTML = `<option value="">No types in this category</option>`; return; }
                types.forEach(t => {
                    const o = document.createElement("option");
                    o.value = t.id;
                    o.textContent = t.value ?? t.name ?? t.label ?? t.inner;
                    o.dataset.inner = t.inner || "";
                    typeSelect.appendChild(o);
                });
                typeSelect.disabled = false;
            } catch (err) { toast("Could not load relation types: " + err.message, "error"); }
        });
        typeSelect.addEventListener("change", updateCreateBtn);

        document.getElementById("createLinkBtn").addEventListener("click", async () => {
            if (!state.selected || !state.suggestion) return toast("Pick a concept and a match first", "warn");
            if (!typeSelect.value) return toast("Choose a relation type", "warn");
            const [from, to] = linkEnds();
            const btn = document.getElementById("createLinkBtn");
            btn.disabled = true;
            try {
                await api(`/links/`, {
                    method: "POST",
                    body: JSON.stringify({
                        project_id: Number(projectId),
                        source_node: from.uri,
                        target_node: to.uri,
                        link_type_id: Number(typeSelect.value),
                        suggestion_score: Number((state.suggestion.similarity * 100).toFixed(1)),
                    }),
                });
                toast(`Linked "${from.name}" → "${to.name}"`, "success");
                loadLinks();
            } catch (err) { toast("Could not create link: " + err.message, "error"); }
            finally { btn.disabled = false; }
        });

        async function loadLinks() {
            const list = document.getElementById("links-list");
            try {
                const links = await getJSON(`/projects/${projectId}/links`);
                document.getElementById("linksCount").textContent = links.length ? `(${links.length})` : "";
                if (!links.length) { list.innerHTML = `<div class="empty"><p class="muted">No links yet. Select a concept, find matches and create the first link.</p></div>`; return; }
                list.innerHTML = "";
                links.forEach(l => {
                    const typeName = l.link_type?.value ?? l.link_type?.name ?? l.link_type?.label ?? l.link_type?.inner?.split(/[#/]/).pop() ?? `type #${l.link_type_id}`;
                    const row = document.createElement("div");
                    row.className = "link-row";
                    row.innerHTML = `
                        <div class="min-w-0 flex-1">
                            <div class="text-sm truncate"><strong title="${esc(l.source_node)}">${esc(labelFor(l.source_node))}</strong>
                                <span class="rel">${esc(typeName)}</span>
                                <strong title="${esc(l.target_node)}">${esc(labelFor(l.target_node))}</strong></div>
                            <div class="text-xs text-gray-500">${l.suggestion_score != null ? `score ${Number(l.suggestion_score).toFixed(0)}%` : "manual"}</div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button class="vote-btn" data-vote="upvote" title="Agree">👍 <span>${l.upvote ?? 0}</span></button>
                            <button class="vote-btn" data-vote="downvote" title="Disagree">👎 <span>${l.downvote ?? 0}</span></button>
                            <button class="btn-icon text-red-500" data-delete title="Delete link">✕</button>
                        </div>`;
                    row.querySelectorAll("[data-vote]").forEach(b => b.addEventListener("click", async () => {
                        try {
                            const r = await api(`/links/${l.id}/vote`, { method: "POST", body: JSON.stringify({ type: b.dataset.vote }) }).then(r => r.json());
                            row.querySelector('[data-vote="upvote"] span').textContent = r.upvote;
                            row.querySelector('[data-vote="downvote"] span').textContent = r.downvote;
                        } catch (err) { toast(err.message, "error"); }
                    }));
                    row.querySelector("[data-delete]").addEventListener("click", async () => {
                        if (!confirm("Delete this link?")) return;
                        try { await api(`/links/${l.id}`, { method: "DELETE" }); row.remove(); toast("Link deleted", "success"); loadLinks(); }
                        catch (err) { toast(err.message, "error"); }
                    });
                    list.appendChild(row);
                });
            } catch (err) { list.innerHTML = `<p class="text-red-600 text-sm">${esc(err.message)}</p>`; }
        }
        document.getElementById("refreshLinks").addEventListener("click", loadLinks);

        document.getElementById("exportOntologyBtn").addEventListener("click", async () => {
            const fmt = document.getElementById("exportFormat").value;
            try {
                const res = await api(`/projects/${projectId}/export?format=${fmt}`);
                const ext = { turtle: "ttl", xml: "rdf", nt: "nt", "json-ld": "jsonld" }[fmt];
                download(await res.blob(), `project_${projectId}_alignment.${ext}`);
            } catch (err) { toast("Export failed: " + err.message, "error"); }
        });
        document.getElementById("exportLinksBtn").addEventListener("click", async () => {
            try {
                const res = await api(`/projects/${projectId}/export-links`);
                download(await res.blob(), `project_${projectId}_links.json`);
            } catch (err) { toast("Export failed: " + err.message, "error"); }
        });

        async function init() {
            try {
                const [project, files] = await Promise.all([
                    getJSON(`/projects/${projectId}`),
                    getJSON(`/project-files/${projectId}`),
                ]);
                document.getElementById("projectName").textContent = project.name || `Project ${projectId}`;
                document.title = `${project.name || "Project"} - AlignMe`;
                files.forEach((f, i) => {
                    state.files[i] = f;
                    const panel = document.querySelector(`.tree-panel[data-tree="${i + 1}"]`);
                    panel.querySelector('[data-filename]').textContent = `${f.original_filename} · ${f.triples_count} triples`;
                    renderTree(i + 1, f.tree);
                });
            } catch (err) {
                document.querySelectorAll('[data-tree-container]').forEach(c => c.innerHTML = `<p class="text-red-600 text-sm">${esc(err.message)}</p>`);
                toast(err.message, "error");
            }
            loadLinks();
        }
        init();
    </script>
</body>

</html>