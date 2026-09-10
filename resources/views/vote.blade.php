<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Links Voting - Alignment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/vote.css" />
</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 min-h-screen p-3 sm:p-6">

    <div class="max-w-5xl mx-auto bg-white/90 backdrop-blur rounded-2xl shadow-lg p-4 sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <a href="./dashboard" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Dashboard
            </a>
            <p id="progress" class="text-sm text-gray-500"></p>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-900 text-center">Links <span
                class="text-pink-500">Voting</span></h1>
        <p class="text-center text-gray-600 text-sm mt-1 mb-6">Do these two concepts really match? Your votes help
            decide which links are kept.</p>

        <!-- Filters -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 mb-4">
            <input id="search" type="search" placeholder="Search concept…" class="input">
            <select id="projectFilter" class="input">
                <option value="">All projects</option>
            </select>
            <select id="relationFilter" class="input">
                <option value="">All relation types</option>
            </select>
            <select id="sort" class="input">
                <option value="unvoted">Not voted first</option>
                <option value="score">Highest score</option>
                <option value="controversial">Most disputed</option>
                <option value="popular">Most votes</option>
                <option value="newest">Newest</option>
            </select>
        </div>

        <div id="list" class="space-y-3">
            <p class="text-gray-500 text-sm text-center py-6"><span class="spinner"></span> Loading links…</p>
        </div>
        <div class="flex justify-center mt-4"><button id="more" class="btn btn-ghost hidden">Show more</button></div>
    </div>

    <div id="toasts" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem("token");
        if (!token) window.location.href = "./login";

        const PAGE = 15;
        let links = [], shown = 0, projectNames = {};
        const myVotes = {};      // link id -> 1 | -1 | 0

        async function api(path, options = {}) {
            const res = await fetch(window.apiBaseUrl + path, { ...options, headers: { Authorization: "Bearer " + token, "Content-Type": "application/json", ...(options.headers || {}) } });
            if (res.status === 401) { localStorage.removeItem("token"); window.location.href = "./login"; return; }
            if (!res.ok) { let m = res.statusText; try { m = (await res.json()).detail || m; } catch (_) { } throw new Error(typeof m === "string" ? m : JSON.stringify(m)); }
            return res;
        }
        const getJSON = (p) => api(p).then(r => r.json());
        const esc = (s) => String(s ?? "").replace(/[&<>"']/g, c => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
        const shortUri = (u) => String(u || "").split(/[#/]/).filter(Boolean).pop() || u;
        const relName = (l) => l.link_type?.value ?? shortUri(l.link_type?.inner) ?? `type ${l.link_type_id}`;
        function toast(msg, kind = "info") {
            const el = document.createElement("div"); el.className = `toast toast-${kind}`; el.textContent = msg;
            document.getElementById("toasts").appendChild(el);
            requestAnimationFrame(() => el.classList.add("show"));
            setTimeout(() => { el.classList.remove("show"); setTimeout(() => el.remove(), 300); }, 3500);
        }

        async function load() {
            try {
                const [data, projects] = await Promise.all([getJSON("/links-vote"), getJSON("/my-projects").catch(() => [])]);
                links = data;
                projects.forEach(p => projectNames[p.id] = p.name);

                const pf = document.getElementById("projectFilter");
                [...new Set(links.map(l => l.project_id))].forEach(id => {
                    const o = document.createElement("option"); o.value = id; o.textContent = projectNames[id] || `Project #${id}`; pf.appendChild(o);
                });
                const rf = document.getElementById("relationFilter");
                [...new Set(links.map(relName))].sort().forEach(r => {
                    const o = document.createElement("option"); o.value = r; o.textContent = r; rf.appendChild(o);
                });

                // my existing votes (parallel, best effort)
                await Promise.all(links.map(l =>
                    getJSON(`/projects/${l.project_id}/links/${l.id}/score`).then(s => {
                        myVotes[l.id] = s.my_vote || 0; l.upvote = s.likes; l.downvote = s.dislikes;
                    }).catch(() => { myVotes[l.id] = 0; })
                ));
                render(true);
            } catch (err) {
                document.getElementById("list").innerHTML = `<p class="text-red-600 text-sm text-center py-6">${esc(err.message)}</p>`;
            }
        }

        function filtered() {
            const q = document.getElementById("search").value.trim().toLowerCase();
            const pf = document.getElementById("projectFilter").value;
            const rf = document.getElementById("relationFilter").value;
            const sort = document.getElementById("sort").value;
            let out = links.filter(l =>
                (!q || l.source_node.toLowerCase().includes(q) || l.target_node.toLowerCase().includes(q)) &&
                (!pf || String(l.project_id) === pf) &&
                (!rf || relName(l) === rf));
            const total = (l) => (l.upvote || 0) + (l.downvote || 0);
            const sorters = {
                unvoted: (a, b) => (myVotes[a.id] !== 0) - (myVotes[b.id] !== 0) || (b.suggestion_score || 0) - (a.suggestion_score || 0),
                score: (a, b) => (b.suggestion_score || 0) - (a.suggestion_score || 0),
                controversial: (a, b) => Math.min(b.upvote, b.downvote) - Math.min(a.upvote, a.downvote) || total(b) - total(a),
                popular: (a, b) => total(b) - total(a),
                newest: (a, b) => (b.id || 0) - (a.id || 0),
            };
            return out.sort(sorters[sort]);
        }

        function render(reset) {
            const list = document.getElementById("list");
            const items = filtered();
            if (reset) { list.innerHTML = ""; shown = 0; }
            const voted = links.filter(l => myVotes[l.id]).length;
            document.getElementById("progress").textContent = links.length ? `You have voted on ${voted} of ${links.length} links` : "";
            if (!items.length) {
                list.innerHTML = `<div class="text-center py-10"><p class="font-medium text-gray-700">${links.length ? "No links match the filters." : "No links to vote on yet."}</p><p class="text-sm text-gray-500">${links.length ? "" : "Links from public projects appear here once someone creates them."}</p></div>`;
                document.getElementById("more").classList.add("hidden");
                return;
            }
            items.slice(shown, shown + PAGE).forEach(l => list.appendChild(card(l)));
            shown = Math.min(shown + PAGE, items.length);
            document.getElementById("more").classList.toggle("hidden", shown >= items.length);
            document.getElementById("more").textContent = `Show more (${items.length - shown} left)`;
        }

        function card(l) {
            const score = l.suggestion_score != null ? Math.round(l.suggestion_score) : null;
            const el = document.createElement("div");
            el.className = "card p-4" + (myVotes[l.id] === 1 ? " voted-up" : myVotes[l.id] === -1 ? " voted-down" : "");
            el.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <strong class="text-gray-800 truncate max-w-full" title="${esc(l.source_node)}">${esc(shortUri(l.source_node))}</strong>
                            <span class="rel">${esc(relName(l))}</span>
                            <strong class="text-gray-800 truncate max-w-full" title="${esc(l.target_node)}">${esc(shortUri(l.target_node))}</strong>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">${esc(projectNames[l.project_id] || "Project #" + l.project_id)}${score != null ? ` · suggested at ${score}%` : " · added manually"}</div>
                        ${score != null ? `<div class="score-bar mt-2 max-w-xs"><div style="width:${score}%"></div></div>` : ""}
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button class="btn btn-up ${myVotes[l.id] === 1 ? "active" : ""}" data-vote="upvote" aria-label="Agree">👍 <span data-up>${l.upvote ?? 0}</span></button>
                        <button class="btn btn-down ${myVotes[l.id] === -1 ? "active" : ""}" data-vote="downvote" aria-label="Disagree">👎 <span data-down>${l.downvote ?? 0}</span></button>
                        <button class="btn btn-ghost" data-why>Why?</button>
                    </div>
                </div>
                <div class="why hidden" data-why-panel></div>`;

            el.querySelectorAll("[data-vote]").forEach(b => b.addEventListener("click", () => vote(l, el, b.dataset.vote)));
            el.querySelector("[data-why]").addEventListener("click", (e) => explain(l, el, e.currentTarget));
            return el;
        }

        async function vote(l, el, kind) {
            const current = myVotes[l.id] || 0;
            const wanted = kind === "upvote" ? 1 : -1;
            const type = current === wanted ? "remove" : kind;   // clicking your own vote again removes it
            el.querySelectorAll("[data-vote]").forEach(b => b.disabled = true);
            try {
                const r = await api(`/links/${l.id}/vote`, { method: "POST", body: JSON.stringify({ type }) }).then(r => r.json());
                l.upvote = r.upvote; l.downvote = r.downvote;
                myVotes[l.id] = type === "remove" ? 0 : wanted;
                el.querySelector("[data-up]").textContent = r.upvote;
                el.querySelector("[data-down]").textContent = r.downvote;
                el.classList.toggle("voted-up", myVotes[l.id] === 1);
                el.classList.toggle("voted-down", myVotes[l.id] === -1);
                el.querySelector('[data-vote="upvote"]').classList.toggle("active", myVotes[l.id] === 1);
                el.querySelector('[data-vote="downvote"]').classList.toggle("active", myVotes[l.id] === -1);
                toast(type === "remove" ? "Vote removed" : "Thanks for voting!", "success");
                const voted = links.filter(x => myVotes[x.id]).length;
                document.getElementById("progress").textContent = `You have voted on ${voted} of ${links.length} links`;
            } catch (err) {
                toast("Could not save vote: " + err.message, "error");
            } finally {
                el.querySelectorAll("[data-vote]").forEach(b => b.disabled = false);
            }
        }

        //  explanation 
        const SIGNAL_NAMES = {
            jaro_winkler: "Spelling", token_set: "Words", dice: "Bigrams", notation: "Code", label_embedding: "Label meaning",
            concept_embedding: "Concept meaning", definition_embedding: "Definition meaning", definition_tfidf: "Definition words",
            parent: "Parents", child: "Children", sibling: "Siblings", ancestor_path: "Ancestors", depth: "Depth", subtree: "Subtree"
        };
        const pick = (d, ...keys) => { for (const k of keys) { const v = d?.[k]; if (v) return Array.isArray(v) ? v.join(" / ") : v; } return ""; };

        async function explain(l, el, btn) {
            const panel = el.querySelector("[data-why-panel]");
            if (!panel.classList.contains("hidden")) { panel.classList.add("hidden"); btn.textContent = "Why?"; return; }
            panel.classList.remove("hidden");
            btn.textContent = "Hide";
            if (panel.dataset.loaded) return;
            panel.innerHTML = `<p class="text-sm text-gray-500"><span class="spinner"></span> Comparing the two concepts…</p>`;
            try {
                const [src, tgt, sug] = await Promise.all([
                    getJSON(`/node-details/?project_id=${l.project_id}&uri=${encodeURIComponent(l.source_node)}`).catch(() => null),
                    getJSON(`/node-details/?project_id=${l.project_id}&uri=${encodeURIComponent(l.target_node)}`).catch(() => null),
                    getJSON(`/projects/${l.project_id}/suggestions?node_uri=${encodeURIComponent(l.source_node)}&method=lexical&min_threshold=0&top_k=200`).catch(() => null),
                ]);
                const match = sug?.suggestions?.find(s => s.node2 === l.target_node);
                const concept = (d, uri) => `
                    <div class="bg-gray-50 rounded-lg p-3 min-w-0">
                        <div class="font-semibold text-gray-800">${esc(pick(d?.details, "prefLabel", "label") || shortUri(uri))}</div>
                        ${pick(d?.details, "altLabel") ? `<div class="text-xs text-gray-500">also: ${esc(pick(d?.details, "altLabel"))}</div>` : ""}
                        ${pick(d?.details, "definition", "scopeNote", "comment") ? `<p class="text-xs text-gray-600 mt-1">${esc(pick(d?.details, "definition", "scopeNote", "comment"))}</p>` : `<p class="text-xs text-gray-400 mt-1">No definition</p>`}
                        ${pick(d?.details, "broader") ? `<div class="text-xs text-gray-500 mt-1">broader: ${esc(shortUri(pick(d?.details, "broader")))}</div>` : ""}
                    </div>`;
                let verdict = "";
                if (match) {
                    const s = Math.round(match.similarity * 100);
                    verdict = `<div class="text-sm mb-2">${s >= 80 ? "🟢" : s >= 55 ? "🟡" : "🔴"} The matcher rates this pair at <strong>${s}%</strong>${match.suggested_relation && match.suggested_relation !== "uncertain" ? ` and would call it <strong>${esc(match.suggested_relation)}</strong>` : ""}.
                        ${match.reasons?.length ? `<span class="text-green-700">${match.reasons.map(esc).join(" · ")}</span>` : ""}
                        ${match.better_source_for_target ? `<span class="text-amber-700">⚠ “${esc(shortUri(match.better_source_for_target))}” fits this target better.</span>` : ""}</div>
                        <div class="sig mb-2">${Object.entries(match.scores || {}).map(([k, v]) => `<div>${SIGNAL_NAMES[k] || k}<strong class="${v >= 0.7 ? "text-green-600" : v >= 0.4 ? "text-indigo-600" : "text-gray-400"}">${Math.round(v * 100)}%</strong></div>`).join("")}</div>`;
                } else if (sug) {
                    verdict = `<div class="text-sm mb-2 text-amber-700">🔴 The matcher finds almost no similarity between these two concepts — check the definitions carefully.</div>`;
                }
                panel.innerHTML = `${verdict}<div class="grid grid-cols-1 sm:grid-cols-2 gap-2">${concept(src, l.source_node)}${concept(tgt, l.target_node)}</div>
                    <p class="text-xs text-gray-400 mt-2">This is only a hint. Vote on whether the concepts really mean the same thing.</p>`;
                panel.dataset.loaded = "1";
            } catch (err) {
                panel.innerHTML = `<p class="text-sm text-red-600">${esc(err.message)}</p>`;
            }
        }

        //  events 
        ["search", "projectFilter", "relationFilter", "sort"].forEach(id => document.getElementById(id).addEventListener("input", () => render(true)));
        document.getElementById("more").addEventListener("click", () => render(false));
        load();
    </script>
</body>

</html>