<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AlignMe - Graph Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/forcedirectree.css" />
</head>

<body class="bg-gradient-to-br from-indigo-500 via-purple-100 to-pink-800 font-sans min-h-screen p-3 sm:p-6">

    <div class="max-w-7xl mx-auto space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <a href="./dashboard" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900 drop-shadow-md">Graph Explorer</h1>
            <span class="text-sm text-indigo-900/70 hidden sm:inline">Click a node to see its details · double-click to
                expand its children · drag to move</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-4">

            <!-- Sidebar: files -->
            <aside class="panel p-4 space-y-3 lg:max-h-[calc(100vh-8rem)] lg:overflow-y-auto">
                <h2 class="font-bold text-indigo-900">Files</h2>
                <input id="fileSearch" type="search" placeholder="Filter files…" class="input w-full">
                <div id="filesContainer" class="space-y-2">
                    <p class="text-sm text-gray-500">Loading…</p>
                </div>
            </aside>

            <!-- Main: graph -->
            <section class="space-y-3">
                <div class="panel p-3 flex flex-wrap items-center gap-2">
                    <select id="rootSelect" class="input flex-1 min-w-[180px]" disabled>
                        <option value="">Start from top concepts</option>
                    </select>
                    <label class="text-sm text-gray-700 flex items-center gap-1">Depth <input id="depth" type="number"
                            min="1" max="10" value="2" class="input w-16"></label>
                    <label class="text-sm text-gray-700 flex items-center gap-1">Max nodes <input id="maxNodes"
                            type="number" min="10" max="3000" step="50" value="300" class="input w-24"></label>
                    <label class="text-sm text-gray-700 flex items-center gap-1"><input id="related" type="checkbox"
                            checked class="accent-purple-600"> related / mappings</label>
                    <button id="reload" class="btn btn-primary" disabled>Draw</button>
                    <div class="ml-auto flex gap-2">
                        <input id="nodeSearch" type="search" placeholder="Find node…" class="input w-40" disabled>
                        <button id="fit" class="btn btn-ghost" title="Fit to screen" disabled>⤢</button>
                        <button id="download" class="btn btn-ghost" title="Download SVG" disabled>⬇ SVG</button>
                    </div>
                </div>

                <div class="relative">
                    <div id="graphContainer"
                        class="w-full bg-white/70 backdrop-blur border rounded-2xl shadow-xl overflow-hidden"
                        style="height: min(70vh, 700px)">
                        <div class="h-full flex items-center justify-center text-gray-500 text-sm p-6 text-center">
                            Select a parsed file on the left to draw its graph.</div>
                    </div>
                    <div id="graphMeta"
                        class="absolute left-3 bottom-3 text-xs bg-white/90 rounded-lg px-2 py-1 text-gray-600 hidden">
                    </div>
                    <div id="legend"
                        class="absolute right-3 bottom-3 text-xs bg-white/90 rounded-lg px-2 py-1 text-gray-600 hidden">
                        <span class="inline-block w-4 border-t-2 border-gray-400 align-middle"></span> broader &nbsp;
                        <span class="inline-block w-4 border-t-2 border-dashed border-amber-500 align-middle"></span>
                        related &nbsp;
                        <span class="inline-block w-4 border-t-2 border-dotted border-emerald-500 align-middle"></span>
                        mapping
                    </div>
                    <div id="nodeInfo"
                        class="absolute top-3 right-3 panel p-4 w-80 max-w-[90%] max-h-[80%] overflow-y-auto hidden">
                    </div>
                </div>
            </section>
        </div>
        <footer class="text-indigo-100 text-sm text-center pt-4">&copy; <span id="year"></span> AlignMe</footer>
    </div>

    <div id="toasts" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem('token');
        if (!token) window.location.href = './login';
        document.getElementById('year').textContent = new Date().getFullYear();

        // ---------- helpers ----------
        const $ = (id) => document.getElementById(id);
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const shortName = (u) => String(u || '').split(/[#/]/).filter(Boolean).pop() || u;
        async function api(path, options = {}) {
            const res = await fetch(window.apiBaseUrl + path, { ...options, headers: { Authorization: 'Bearer ' + token, ...(options.headers || {}) } });
            if (res.status === 401) { localStorage.removeItem('token'); window.location.href = './login'; return; }
            if (!res.ok) { let m = res.statusText; try { m = (await res.json()).detail || m; } catch (_) { } throw new Error(typeof m === 'string' ? m : JSON.stringify(m)); }
            return res.json();
        }
        function toast(msg, kind = 'info') {
            const el = document.createElement('div'); el.className = `toast toast-${kind}`; el.textContent = msg;
            $('toasts').appendChild(el); requestAnimationFrame(() => el.classList.add('show'));
            setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 300); }, 4000);
        }

        // ---------- files ----------
        let files = [], activeFile = null;
        async function loadFiles() {
            try {
                files = (await api('/my-files')).sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                renderFiles();
                const preset = new URLSearchParams(location.search).get('file');
                if (preset) { const f = files.find(x => String(x.id) === preset); if (f) selectFile(f); }
            } catch (err) { $('filesContainer').innerHTML = `<p class="text-sm text-red-600">${esc(err.message)}</p>`; }
        }
        function renderFiles() {
            const q = $('fileSearch').value.trim().toLowerCase();
            const box = $('filesContainer'); box.innerHTML = '';
            const list = files.filter(f => !q || f.filename.toLowerCase().includes(q));
            if (!list.length) { box.innerHTML = '<p class="text-sm text-gray-500">No files.</p>'; return; }
            list.forEach(f => {
                const card = document.createElement('div');
                card.className = 'file-card' + (activeFile?.id === f.id ? ' active' : '');
                card.innerHTML = `<div class="font-semibold text-indigo-900 truncate" title="${esc(f.filename)}">📄 ${esc(f.filename)}</div>
                    <div class="flex flex-wrap gap-1 mt-1">
                        <span class="badge bg-indigo-100 text-indigo-800">${esc((f.filetype || '').toUpperCase())}</span>
                        ${f.parsed ? '<span class="badge bg-green-100 text-green-800">parsed</span>' : '<span class="badge bg-gray-200 text-gray-700">not parsed</span>'}
                        ${f.public ? '<span class="badge bg-emerald-100 text-emerald-800">public</span>' : ''}
                    </div>
                    ${f.parsed ? '' : '<button class="btn btn-ghost mt-2 w-full" data-parse>Parse now</button>'}`;
                card.addEventListener('click', (e) => { if (!e.target.closest('[data-parse]')) selectFile(f); });
                card.querySelector('[data-parse]')?.addEventListener('click', async (e) => {
                    e.target.disabled = true; e.target.textContent = 'Parsing…';
                    try { const r = await api(`/files/${f.id}/parse`, { method: 'POST' }); f.parsed = true; toast(`Parsed ${r.triples_count} triples`, 'success'); renderFiles(); selectFile(f); }
                    catch (err) { toast(err.message, 'error'); e.target.disabled = false; e.target.textContent = 'Parse now'; }
                });
                box.appendChild(card);
            });
        }
        $('fileSearch').addEventListener('input', renderFiles);

        async function selectFile(f) {
            if (!f.parsed) { toast('Parse the file first', 'info'); return; }
            activeFile = f; renderFiles();
            history.replaceState(null, '', `?file=${f.id}`);
            $('rootSelect').innerHTML = '<option value="">Start from top concepts</option>';
            try {
                const { labels } = await api(`/files/${f.id}/skos`);
                labels.slice(0, 2000).forEach(c => { const o = document.createElement('option'); o.value = c.subject; o.textContent = c.label; $('rootSelect').appendChild(o); });
                $('rootSelect').disabled = false;
            } catch (_) { }
            ['reload', 'fit', 'download', 'nodeSearch'].forEach(id => $(id).disabled = false);
            drawGraph();
        }

        // ---------- graph ----------
        let sim = null, svg = null, gRoot = null, zoom = null, nodeSel = null, linkSel = null, graphData = null;

        async function drawGraph(rootOverride) {
            if (!activeFile) return;
            const container = $('graphContainer');
            container.innerHTML = '<div class="h-full flex items-center justify-center text-gray-500 text-sm">Loading graph…</div>';
            $('nodeInfo').classList.add('hidden');
            const params = new URLSearchParams({
                depth: $('depth').value || 2, max_nodes: $('maxNodes').value || 300, include_related: $('related').checked,
            });
            const root = rootOverride ?? $('rootSelect').value;
            if (root) params.set('root', root);
            try {
                graphData = await api(`/files/${activeFile.id}/graph?${params}`);
                if (!graphData.nodes.length) { container.innerHTML = '<div class="h-full flex items-center justify-center text-gray-500 text-sm p-6 text-center">No concepts with labels found in this file.</div>'; return; }
                render(graphData);
                $('graphMeta').textContent = `${graphData.shown} of ${graphData.total_concepts} concepts` + (graphData.truncated ? ' · some children hidden — double-click a node with a + to expand, or raise depth / max nodes' : '');
                $('graphMeta').classList.remove('hidden'); $('legend').classList.remove('hidden');
            } catch (err) { container.innerHTML = `<div class="h-full flex items-center justify-center text-red-600 text-sm p-6 text-center">${esc(err.message)}</div>`; }
        }

        function render(data) {
            const container = $('graphContainer');
            container.innerHTML = '';
            const width = container.clientWidth, height = container.clientHeight;
            const nodes = data.nodes.map(d => ({ ...d }));
            const links = data.links.map(d => ({ ...d }));
            const color = d3.scaleOrdinal(d3.schemeTableau10);
            const radius = (d) => 6 + Math.min(14, Math.sqrt(d.children || 0) * 3);

            svg = d3.select(container).append('svg').attr('width', width).attr('height', height).attr('viewBox', [0, 0, width, height]);
            gRoot = svg.append('g');
            zoom = d3.zoom().scaleExtent([0.1, 6]).on('zoom', (e) => gRoot.attr('transform', e.transform));
            svg.call(zoom).on('dblclick.zoom', null);

            sim = d3.forceSimulation(nodes)
                .force('link', d3.forceLink(links).id(d => d.id).distance(d => d.relation === 'broader' ? 70 : 120).strength(d => d.relation === 'broader' ? 0.8 : 0.2))
                .force('charge', d3.forceManyBody().strength(-220))
                .force('collide', d3.forceCollide().radius(d => radius(d) + 14))
                .force('center', d3.forceCenter(width / 2, height / 2));

            linkSel = gRoot.append('g').selectAll('line').data(links).join('line').attr('class', d => `link ${d.relation}`).attr('stroke-width', d => d.relation === 'broader' ? 1.5 : 1);

            nodeSel = gRoot.append('g').selectAll('g').data(nodes).join('g').attr('class', 'node')
                .call(d3.drag()
                    .on('start', (e, d) => { if (!e.active) sim.alphaTarget(0.3).restart(); d.fx = d.x; d.fy = d.y; })
                    .on('drag', (e, d) => { d.fx = e.x; d.fy = e.y; })
                    .on('end', (e, d) => { if (!e.active) sim.alphaTarget(0); d.fx = null; d.fy = null; }));
            nodeSel.append('circle').attr('r', radius).attr('fill', d => color(d.depth));
            nodeSel.append('text').attr('dx', d => radius(d) + 4).attr('dy', 4).attr('font-size', 11).attr('fill', '#111827')
                .text(d => d.name.length > 32 ? d.name.slice(0, 30) + '…' : d.name);
            nodeSel.filter(d => d.hidden_children > 0).append('text').attr('text-anchor', 'middle').attr('dy', 4).attr('font-size', 11).attr('font-weight', 700).attr('fill', '#fff').text('+');
            nodeSel.append('title').text(d => `${d.name}\n${d.id}${d.hidden_children ? `\n${d.hidden_children} hidden children (double-click)` : ''}`);

            nodeSel.on('click', (e, d) => { e.stopPropagation(); highlight(d); showNodeInfo(d); });
            nodeSel.on('dblclick', (e, d) => { e.stopPropagation(); if (d.hidden_children || d.children) { $('rootSelect').value = d.id; drawGraph(d.id); } });
            svg.on('click', () => { highlight(null); $('nodeInfo').classList.add('hidden'); });

            sim.on('tick', () => {
                linkSel.attr('x1', d => d.source.x).attr('y1', d => d.source.y).attr('x2', d => d.target.x).attr('y2', d => d.target.y);
                nodeSel.attr('transform', d => `translate(${d.x},${d.y})`);
            });
            sim.on('end', fit);
        }

        function highlight(d) {
            if (!nodeSel) return;
            if (!d) { nodeSel.classed('dim', false); linkSel.classed('dim', false); return; }
            const near = new Set([d.id]);
            linkSel.each(l => { if (l.source.id === d.id) near.add(l.target.id); if (l.target.id === d.id) near.add(l.source.id); });
            nodeSel.classed('dim', n => !near.has(n.id));
            linkSel.classed('dim', l => l.source.id !== d.id && l.target.id !== d.id);
        }

        function fit() {
            if (!gRoot || !svg) return;
            const b = gRoot.node().getBBox(); if (!b.width || !b.height) return;
            const w = svg.attr('width'), h = svg.attr('height');
            const scale = Math.min(0.9 * w / b.width, 0.9 * h / b.height, 2);
            const t = d3.zoomIdentity.translate(w / 2 - scale * (b.x + b.width / 2), h / 2 - scale * (b.y + b.height / 2)).scale(scale);
            svg.transition().duration(500).call(zoom.transform, t);
        }
        $('fit').addEventListener('click', fit);
        $('reload').addEventListener('click', () => drawGraph());
        $('rootSelect').addEventListener('change', () => drawGraph());
        $('download').addEventListener('click', () => {
            if (!svg) return;
            const s = new XMLSerializer().serializeToString(svg.node());
            const a = document.createElement('a'); a.href = URL.createObjectURL(new Blob([s], { type: 'image/svg+xml' }));
            a.download = `${activeFile.filename}_graph.svg`; a.click();
        });
        $('nodeSearch').addEventListener('input', (e) => {
            const q = e.target.value.trim().toLowerCase();
            if (!nodeSel) return;
            nodeSel.classed('hit', d => q && d.name.toLowerCase().includes(q));
            if (q) { const hit = nodeSel.filter(d => d.name.toLowerCase().includes(q)).data()[0]; if (hit && hit.x != null) svg.transition().duration(400).call(zoom.transform, d3.zoomIdentity.translate(svg.attr('width') / 2 - hit.x * 1.5, svg.attr('height') / 2 - hit.y * 1.5).scale(1.5)); }
        });
        window.addEventListener('resize', () => { if (graphData) render(graphData); });

        // ---------- node info ----------
        async function showNodeInfo(d) {
            const box = $('nodeInfo');
            box.classList.remove('hidden');
            box.innerHTML = `<h4 class="font-bold text-indigo-900 mb-1">${esc(d.name)}</h4><p class="text-xs text-gray-400 break-all mb-2">${esc(d.id)}</p><p class="text-sm text-gray-500">Loading…</p>`;
            try {
                const data = await api(`/node-details-skostree/?file_id=${activeFile.id}&uri=${encodeURIComponent(d.id)}`);
                const rows = Object.entries(data.details).map(([k, v]) => {
                    const vals = (Array.isArray(v) ? v : [v]).map(x => String(x).startsWith('http') ? `<a href="#" data-goto="${esc(x)}" class="text-indigo-600 underline">${esc(shortName(x))}</a>` : esc(x));
                    return `<li><span class="font-semibold text-gray-700">${esc(k)}:</span> ${vals.join(', ')}</li>`;
                }).join('');
                box.innerHTML = `<div class="flex justify-between items-start gap-2"><h4 class="font-bold text-indigo-900">${esc(d.name)}</h4><button class="text-gray-400 hover:text-gray-700" data-close>✕</button></div>
                    <p class="text-xs text-gray-400 break-all mb-2">${esc(d.id)}</p>
                    <ul class="text-sm space-y-1">${rows || '<li class="text-gray-500">No properties</li>'}</ul>
                    <div class="flex gap-2 mt-3">
                        <button class="btn btn-primary flex-1" data-focus>Focus here</button>
                        <a class="btn btn-ghost" href="./skosviewer/${activeFile.id}" target="_blank">Open in viewer</a>
                    </div>`;
                box.querySelector('[data-close]').addEventListener('click', () => { box.classList.add('hidden'); highlight(null); });
                box.querySelector('[data-focus]').addEventListener('click', () => { $('rootSelect').value = d.id; drawGraph(d.id); });
                box.querySelectorAll('[data-goto]').forEach(a => a.addEventListener('click', (e) => { e.preventDefault(); const uri = a.dataset.goto; const n = nodeSel?.data().find(x => x.id === uri); if (n) { highlight(n); showNodeInfo(n); } else { $('rootSelect').value = uri; drawGraph(uri); } }));
            } catch (err) { box.innerHTML += `<p class="text-sm text-red-600">${esc(err.message)}</p>`; }
        }

        loadFiles();
    </script>
</body>

</html>