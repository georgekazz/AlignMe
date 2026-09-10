<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alignment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard.css" />
</head>

<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen flex flex-col">

    <header class="glass sticky top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                    <img src="./img/favicon.png" alt="" class="w-6 h-6 object-contain">
                </div>
                <h1
                    class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent truncate">
                    Alignment</h1>
            </div>
            <button id="logoutBtn"
                class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all">Logout</button>
        </div>
    </header>

    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 space-y-8 flex-1">

        <!-- Welcome -->
        <div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-2 text-gray-800">
                Welcome back, <span id="userName"
                    class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent"></span>!
                👋
            </h2>
            <p class="text-gray-600">Manage your RDF files, projects, and alignments all in one place.</p>
        </div>

        <!-- Quick actions -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="action-card hover:border-indigo-200">
                <div class="action-icon bg-gradient-to-br from-indigo-500 to-purple-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Upload RDF</h3>
                <p class="text-gray-600 text-sm mb-4">RDF, OWL, Turtle, N-Triples or JSON-LD</p>
                <a href="./uploadfile" class="btn btn-primary w-full">Upload File</a>
            </div>
            <div class="action-card hover:border-green-200">
                <div class="action-icon bg-gradient-to-br from-green-500 to-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Create Project</h3>
                <p class="text-gray-600 text-sm mb-4">Combine two parsed files into a project</p>
                <a href="./createproject" class="btn btn-green w-full">New Project</a>
            </div>
            <div class="action-card hover:border-yellow-200">
                <div class="action-icon bg-gradient-to-br from-yellow-500 to-orange-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Vote</h3>
                <p class="text-gray-600 text-sm mb-4">Review and vote on suggested links</p>
                <a href="./vote" class="btn btn-amber w-full">Start Voting</a>
            </div>
            <div class="action-card hover:border-purple-200">
                <div class="flex items-start justify-between">
                    <div class="action-icon bg-gradient-to-br from-purple-500 to-pink-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Direct Tree</h3>
                <p class="text-gray-600 text-sm mb-4">Interactive force-directed graphs</p>
                <a href="./force-tree" class="btn btn-primary w-full">Open</a>
            </div>
        </section>

        <!-- Files -->
        <section class="panel">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <h2 class="panel-title">📁 Your RDF Files <span id="filesCount" class="muted font-normal"></span></h2>
                <div class="flex gap-2 w-full sm:w-auto">
                    <input id="fileSearch" type="search" placeholder="Filter files…" class="input sm:w-56">
                    <select id="fileFilter" class="input sm:w-40">
                        <option value="all">All files</option>
                        <option value="mine">Mine</option>
                        <option value="public">Public</option>
                        <option value="unparsed">Not parsed</option>
                    </select>
                </div>
            </div>
            <div class="rows">
                <div class="row row-head files-grid">
                    <span>File</span><span>Type</span><span>Status</span><span>Visibility</span><span>Added</span><span>Actions</span>
                </div>
                <div id="filesList" class="rows">
                    <p class="muted p-2">Loading…</p>
                </div>
            </div>
            <div id="pagination" class="flex justify-center flex-wrap gap-1 mt-4"></div>
        </section>

        <!-- Projects -->
        <section class="panel">
            <h2 class="panel-title mb-4">🚀 Your Projects <span id="projectsCount" class="muted font-normal"></span>
            </h2>
            <div class="rows">
                <div class="row row-head projects-grid"><span>Name</span><span>File 1</span><span>File
                        2</span><span>Created</span><span>Actions</span></div>
                <div id="projectsList" class="rows">
                    <p class="muted p-2">Loading…</p>
                </div>
            </div>
        </section>

        <!-- Links -->
        <section class="panel">
            <h2 class="panel-title mb-4">🔗 My Links <span id="linksCount" class="muted font-normal"></span></h2>
            <div class="rows">
                <div class="row row-head links-grid">
                    <span>From</span><span>To</span><span>Relation</span><span>Score</span><span>Votes</span><span></span>
                </div>
                <div id="linksList" class="rows">
                    <p class="muted p-2">Loading…</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 text-center text-sm text-pink-500">&copy; <span id="current-year"></span> Alignment. All rights
        reserved.</footer>

    <!-- Confirm modal -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6" role="dialog" aria-modal="true">
            <h3 id="confirmTitle" class="text-lg font-bold text-gray-900 mb-2"></h3>
            <p id="confirmText" class="text-gray-600 mb-6"></p>
            <div class="flex gap-3 justify-end">
                <button id="confirmCancel" class="btn btn-ghost">Cancel</button>
                <button id="confirmOk" class="btn" style="background:#dc2626;color:#fff">Delete</button>
            </div>
        </div>
    </div>

    <div id="toasts" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem('token');
        if (!token) window.location.href = './login';
        document.getElementById("current-year").textContent = new Date().getFullYear();

        // ---------- helpers ----------
        async function api(path, options = {}) {
            const res = await fetch(window.apiBaseUrl + path, {
                ...options,
                headers: { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json', ...(options.headers || {}) },
            });
            if (res.status === 401) { localStorage.removeItem('token'); window.location.href = './login'; return; }
            if (!res.ok) {
                let msg = res.statusText;
                try { msg = (await res.json()).detail || msg; } catch (_) { }
                throw new Error(typeof msg === 'string' ? msg : JSON.stringify(msg));
            }
            return res;
        }
        const getJSON = (p) => api(p).then(r => r.json());
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const fmtDate = (d) => d ? new Date(d).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }) : '—';
        const shortUri = (u) => String(u || '').split(/[#/]/).filter(Boolean).pop() || u;

        function toast(message, kind = 'info') {
            const el = document.createElement('div');
            el.className = `toast toast-${kind}`;
            el.textContent = message;
            document.getElementById('toasts').appendChild(el);
            requestAnimationFrame(() => el.classList.add('show'));
            setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 300); }, 4000);
        }

        function confirmDialog(title, text) {
            return new Promise(resolve => {
                const modal = document.getElementById('confirmModal');
                document.getElementById('confirmTitle').textContent = title;
                document.getElementById('confirmText').textContent = text;
                modal.classList.remove('hidden');
                const done = (v) => { modal.classList.add('hidden'); cleanup(); resolve(v); };
                const onOk = () => done(true), onCancel = () => done(false);
                const onKey = (e) => { if (e.key === 'Escape') done(false); };
                const onBg = (e) => { if (e.target === modal) done(false); };
                const cleanup = () => {
                    document.getElementById('confirmOk').removeEventListener('click', onOk);
                    document.getElementById('confirmCancel').removeEventListener('click', onCancel);
                    document.removeEventListener('keydown', onKey);
                    modal.removeEventListener('click', onBg);
                };
                document.getElementById('confirmOk').addEventListener('click', onOk);
                document.getElementById('confirmCancel').addEventListener('click', onCancel);
                document.addEventListener('keydown', onKey);
                modal.addEventListener('click', onBg);
                document.getElementById('confirmOk').focus();
            });
        }

        // ---------- user ----------
        let currentUser = null;
        async function loadUser() {
            currentUser = await getJSON('/me');
            document.getElementById('userName').textContent = currentUser.name;
        }
        document.getElementById('logoutBtn').addEventListener('click', () => {
            localStorage.removeItem('token');
            window.location.href = './login';
        });

        // ---------- files ----------
        let allFiles = [], currentPage = 1;
        const rowsPerPage = 8;

        async function loadFiles() {
            try {
                allFiles = await getJSON('/my-files');
                allFiles.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                currentPage = 1;
                renderFiles();
            } catch (err) {
                document.getElementById('filesList').innerHTML = `<p class="text-red-600 text-sm p-2">${esc(err.message)}</p>`;
            }
        }

        function filteredFiles() {
            const q = document.getElementById('fileSearch').value.trim().toLowerCase();
            const f = document.getElementById('fileFilter').value;
            return allFiles.filter(file => {
                if (q && !file.filename.toLowerCase().includes(q)) return false;
                if (f === 'mine' && currentUser && file.owner_id !== currentUser.id) return false;
                if (f === 'public' && !file.public) return false;
                if (f === 'unparsed' && file.parsed) return false;
                return true;
            });
        }

        function renderFiles() {
            const list = document.getElementById('filesList');
            const files = filteredFiles();
            document.getElementById('filesCount').textContent = `(${files.length})`;
            list.innerHTML = '';

            if (!files.length) {
                list.innerHTML = `<div class="text-center py-8"><p class="text-gray-700 font-medium">${allFiles.length ? 'No files match the filter.' : 'No files yet.'}</p>${allFiles.length ? '' : '<a href="./uploadfile" class="btn btn-primary mt-3">Upload your first file</a>'}</div>`;
                document.getElementById('pagination').innerHTML = '';
                return;
            }

            const totalPages = Math.ceil(files.length / rowsPerPage);
            currentPage = Math.min(currentPage, totalPages);
            files.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).forEach(file => {
                const mine = !currentUser || file.owner_id === currentUser.id;
                const status = file.status === 'error'
                    ? '<span class="badge badge-red">Parse failed</span>'
                    : file.parsed ? '<span class="badge badge-green">Parsed</span>' : '<span class="badge badge-gray">Not parsed</span>';
                const row = document.createElement('div');
                row.className = 'row files-grid';
                row.innerHTML = `
                    <div class="min-w-0"><div class="font-medium text-gray-800 truncate" title="${esc(file.filename)}">${esc(file.filename)}</div>${mine ? '' : '<span class="muted text-xs">shared by another user</span>'}</div>
                    <div><span class="cell-label">Type</span><span class="badge badge-indigo">${esc((file.filetype || '').toUpperCase())}</span></div>
                    <div><span class="cell-label">Status</span>${status}</div>
                    <div><span class="cell-label">Visibility</span>${file.public ? '<span class="badge badge-green">Public</span>' : '<span class="badge badge-gray">Private</span>'}</div>
                    <div><span class="cell-label">Added</span><span class="text-sm text-gray-600">${fmtDate(file.created_at)}</span></div>
                    <div class="cell-actions">
                        <button class="btn btn-sm ${file.parsed ? 'btn-ghost' : 'btn-green'}" data-parse>${file.parsed ? 'Re-parse' : 'Parse'}</button>
                        <button class="btn btn-sm btn-primary" data-view ${file.parsed ? '' : 'disabled title="Parse the file first"'}>SKOS Viewer</button>
                        ${mine ? '<button class="btn btn-sm btn-danger" data-delete>Delete</button>' : ''}
                    </div>`;

                row.querySelector('[data-parse]').addEventListener('click', async (e) => {
                    const btn = e.currentTarget;
                    btn.disabled = true; btn.innerHTML = '<span class="spinner"></span> Parsing…';
                    try {
                        const data = await api(`/files/${file.id}/parse`, { method: 'POST' }).then(r => r.json());
                        toast(`Parsed ${file.filename}: ${data.triples_count} triples`, 'success');
                        file.parsed = true; file.status = 'parsed';
                    } catch (err) {
                        toast(`Could not parse ${file.filename}: ${err.message}`, 'error');
                        file.status = 'error';
                    }
                    renderFiles();
                });
                row.querySelector('[data-view]').addEventListener('click', () => window.open(`./skosviewer/${file.id}`, '_blank'));
                row.querySelector('[data-delete]')?.addEventListener('click', async () => {
                    if (!await confirmDialog('Delete file', `Delete "${file.filename}"? Files used in a project cannot be deleted.`)) return;
                    try {
                        await api(`/files/${file.id}`, { method: 'DELETE' });
                        toast('File deleted', 'success');
                        loadFiles();
                    } catch (err) { toast(err.message, 'error'); }
                });
                list.appendChild(row);
            });

            const pag = document.getElementById('pagination');
            pag.innerHTML = '';
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    const b = document.createElement('button');
                    b.textContent = i;
                    b.className = `btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-ghost'}`;
                    b.addEventListener('click', () => { currentPage = i; renderFiles(); });
                    pag.appendChild(b);
                }
            }
        }
        document.getElementById('fileSearch').addEventListener('input', () => { currentPage = 1; renderFiles(); });
        document.getElementById('fileFilter').addEventListener('change', () => { currentPage = 1; renderFiles(); });

        // ---------- projects ----------
        let projectNames = {};
        async function loadProjects() {
            const list = document.getElementById('projectsList');
            try {
                const projects = await getJSON('/my-projects');
                projectNames = Object.fromEntries(projects.map(p => [p.id, p.name]));
                document.getElementById('projectsCount').textContent = `(${projects.length})`;
                list.innerHTML = '';
                if (!projects.length) {
                    list.innerHTML = `<div class="text-center py-8"><p class="text-gray-700 font-medium">No projects yet.</p><p class="muted">Parse two files, then create a project to align them.</p><a href="./createproject" class="btn btn-green mt-3">New project</a></div>`;
                    return;
                }
                projects.forEach(p => {
                    const row = document.createElement('div');
                    row.className = 'row projects-grid';
                    row.innerHTML = `
                        <div class="font-medium text-gray-800 truncate">${esc(p.name)}</div>
                        <div class="truncate text-sm"><span class="cell-label">File 1</span>${esc(p.file1_name || '—')}</div>
                        <div class="truncate text-sm"><span class="cell-label">File 2</span>${esc(p.file2_name || '—')}</div>
                        <div class="text-sm text-gray-600"><span class="cell-label">Created</span>${fmtDate(p.created_at)}</div>
                        <div class="cell-actions">
                            <a href="./project/${p.id}" class="btn btn-sm btn-primary">Open</a>
                            <button class="btn btn-sm btn-danger" data-delete>Delete</button>
                        </div>`;
                    row.querySelector('[data-delete]').addEventListener('click', async () => {
                        if (!await confirmDialog('Delete project', `Delete "${p.name}"? All its links and votes will be removed. This cannot be undone.`)) return;
                        try {
                            const data = await api(`/projects/${p.id}`, { method: 'DELETE' }).then(r => r.json());
                            toast(`Deleted "${p.name}" (${data.deleted_links} links)`, 'success');
                            loadProjects(); loadLinks();
                        } catch (err) { toast(err.message, 'error'); }
                    });
                    list.appendChild(row);
                });
            } catch (err) {
                list.innerHTML = `<p class="text-red-600 text-sm p-2">${esc(err.message)}</p>`;
            }
        }

        // ---------- links ----------
        async function loadLinks() {
            const list = document.getElementById('linksList');
            try {
                const [links, types] = await Promise.all([getJSON('/links'), getJSON('/link-types?include_private=true')]);
                const typeName = Object.fromEntries(types.map(t => [t.id, t.value ?? t.name ?? shortUri(t.inner)]));
                document.getElementById('linksCount').textContent = `(${links.length})`;
                list.innerHTML = '';
                if (!links.length) {
                    list.innerHTML = `<div class="text-center py-8"><p class="text-gray-700 font-medium">You haven't created any links yet.</p><p class="muted">Open a project, pick a concept and find matches.</p></div>`;
                    return;
                }
                links.sort((a, b) => (b.id || 0) - (a.id || 0));
                links.forEach(l => {
                    const row = document.createElement('div');
                    row.className = 'row links-grid';
                    const rel = l.link_type?.value ?? typeName[l.link_type_id] ?? `#${l.link_type_id}`;
                    row.innerHTML = `
                        <div class="min-w-0"><div class="font-medium text-gray-800 truncate" title="${esc(l.source_node)}">${esc(shortUri(l.source_node))}</div><div class="muted text-xs truncate">${esc(projectNames[l.project_id] || 'project ' + l.project_id)}</div></div>
                        <div class="font-medium text-gray-800 truncate" title="${esc(l.target_node)}"><span class="cell-label">To</span>${esc(shortUri(l.target_node))}</div>
                        <div><span class="cell-label">Relation</span><span class="badge badge-indigo">${esc(rel)}</span></div>
                        <div class="text-sm"><span class="cell-label">Score</span>${l.suggestion_score != null ? Number(l.suggestion_score).toFixed(0) + '%' : '—'}</div>
                        <div class="text-sm"><span class="cell-label">Votes</span>👍 ${l.upvote ?? 0} &nbsp; 👎 ${l.downvote ?? 0}</div>
                        <div class="cell-actions justify-end"><a href="./project/${l.project_id}" class="btn btn-sm btn-ghost">Open</a><button class="btn btn-sm btn-danger" data-delete>Delete</button></div>`;
                    row.querySelector('[data-delete]').addEventListener('click', async () => {
                        if (!await confirmDialog('Delete link', `Remove the link ${shortUri(l.source_node)} → ${shortUri(l.target_node)}?`)) return;
                        try { await api(`/links/${l.id}`, { method: 'DELETE' }); toast('Link deleted', 'success'); loadLinks(); }
                        catch (err) { toast(err.message, 'error'); }
                    });
                    list.appendChild(row);
                });
            } catch (err) {
                list.innerHTML = `<p class="text-red-600 text-sm p-2">${esc(err.message)}</p>`;
            }
        }

        // ---------- init ----------
        (async () => {
            try { await loadUser(); } catch (err) { toast(err.message, 'error'); }
            loadFiles();
            await loadProjects();
            loadLinks();
        })();
    </script>
</body>

</html>