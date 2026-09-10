<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/createproject.css" />
</head>

<body
    class="bg-gradient-to-br from-purple-900 via-indigo-800 to-indigo-700 min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden">

    <div class="absolute inset-0"><canvas id="bgCanvas" class="w-full h-full"></canvas></div>

    <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 w-full max-w-lg relative z-10">
        <a href="./dashboard"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition mb-6">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back to Dashboard</span>
        </a>

        <h2 class="text-3xl font-bold mb-2 text-indigo-900 text-center">Create <span class="text-pink-500">New
                Project</span></h2>
        <p class="text-center text-sm text-gray-500 mb-6">Pick two parsed files to align with each other.</p>

        <div id="loadError" class="hidden mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm"></div>
        <div id="noFiles" class="hidden mb-4 p-4 rounded-lg bg-amber-50 text-amber-800 text-sm text-center">
            You don't have any parsed files yet.
            <a href="./uploadfile" class="font-semibold underline">Upload one</a> and parse it first.
        </div>

        <form id="createProjectForm" class="space-y-5">
            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="projectName">Project Name</label>
                <input type="text" id="projectName" placeholder="e.g. Animals thesaurus alignment" required
                    maxlength="120" class="input focus:ring-2 focus:ring-yellow-400">
            </div>

            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="file1">First file</label>
                <select id="file1" required class="input focus:ring-2 focus:ring-yellow-400">
                    <option value="">-- Choose File --</option>
                </select>
                <div id="preview1" class="file-preview mt-2 hidden"></div>
            </div>

            <div class="flex justify-center">
                <span class="text-indigo-300 text-2xl" aria-hidden="true">⇄</span>
            </div>

            <div>
                <label class="block text-indigo-900 font-semibold mb-2" for="file2">Second file</label>
                <select id="file2" required class="input focus:ring-2 focus:ring-yellow-400">
                    <option value="">-- Choose File --</option>
                </select>
                <div id="preview2" class="file-preview mt-2 hidden"></div>
            </div>

            <p id="sameFileWarning" class="hidden text-sm text-red-600 text-center">Please select two different files.
            </p>

            <button type="submit" id="submitBtn" disabled
                class="w-full bg-yellow-400 text-indigo-900 font-bold py-3 rounded-lg hover:bg-yellow-300 transition transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-2">
                <svg id="submitIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8M8 16l4-4 4 4" />
                </svg>
                <span id="submitLabel">Create Project</span>
            </button>
        </form>
    </div>

    <div id="toasts" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem('token');
        if (!token) window.location.href = './login';

        const $ = (id) => document.getElementById(id);
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        function toast(msg, kind = 'info') {
            const el = document.createElement('div'); el.className = `toast toast-${kind}`; el.textContent = msg;
            $('toasts').appendChild(el); requestAnimationFrame(() => el.classList.add('show'));
            setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 300); }, 4000);
        }

        let files = [];
        async function loadUserFiles() {
            try {
                const res = await fetch(`${window.apiBaseUrl}/my-files`, { headers: { Authorization: 'Bearer ' + token } });
                if (res.status === 401) { localStorage.removeItem('token'); window.location.href = './login'; return; }
                if (!res.ok) throw new Error((await res.json().catch(() => ({}))).detail || 'Failed to fetch files');

                files = (await res.json()).filter(f => f.parsed).sort((a, b) => a.filename.localeCompare(b.filename));
                const s1 = $('file1'), s2 = $('file2');
                if (!files.length) { $('noFiles').classList.remove('hidden'); return; }
                files.forEach(f => {
                    const label = `${f.filename}${f.public ? ' 🌐' : ''}`;
                    s1.appendChild(new Option(label, f.id));
                    s2.appendChild(new Option(label, f.id));
                });
            } catch (err) {
                $('loadError').textContent = 'Could not load your files: ' + err.message;
                $('loadError').classList.remove('hidden');
            }
        }

        function fileById(id) { return files.find(f => String(f.id) === String(id)); }
        function renderPreview(select, box) {
            const f = fileById(select.value);
            if (!f) { box.classList.add('hidden'); return; }
            box.classList.remove('hidden');
            box.innerHTML = `<strong>${esc(f.filename)}</strong>
                <span class="badge bg-indigo-100 text-indigo-800 ml-1">${esc((f.filetype || '').toUpperCase())}</span>
                ${f.public ? '<span class="badge bg-emerald-100 text-emerald-800 ml-1">public</span>' : ''}
                <br><span class="text-purple-500">${f.created_at ? 'added ' + new Date(f.created_at).toLocaleDateString() : ''}</span>`;
        }

        function validate() {
            const f1 = $('file1').value, f2 = $('file2').value;
            const same = f1 && f2 && f1 === f2;
            $('sameFileWarning').classList.toggle('hidden', !same);
            $('submitBtn').disabled = !($('projectName').value.trim() && f1 && f2 && !same);
        }

        ['file1', 'file2', 'projectName'].forEach(id => $(id).addEventListener('input', validate));
        $('file1').addEventListener('change', () => { renderPreview($('file1'), $('preview1')); validate(); });
        $('file2').addEventListener('change', () => { renderPreview($('file2'), $('preview2')); validate(); });

        loadUserFiles();

        $('createProjectForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = $('projectName').value.trim();
            const file1_id = parseInt($('file1').value, 10);
            const file2_id = parseInt($('file2').value, 10);
            if (!name || !file1_id || !file2_id || file1_id === file2_id) { validate(); return; }

            const btn = $('submitBtn');
            btn.disabled = true;
            $('submitLabel').textContent = 'Creating…';
            $('submitIcon').outerHTML = '<span class="spinner" id="submitIcon"></span>';

            try {
                const res = await fetch(`${window.apiBaseUrl}/projects/`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', Authorization: 'Bearer ' + token },
                    body: JSON.stringify({ name, file1_id, file2_id }),
                });
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(typeof data.detail === 'string' ? data.detail : JSON.stringify(data.detail || res.statusText));

                toast('Project created!', 'success');
                window.location.href = `./project/${data.project_id}`;
            } catch (err) {
                toast('Failed to create project: ' + err.message, 'error');
                btn.disabled = false;
                $('submitLabel').textContent = 'Create Project';
                document.getElementById('submitIcon').outerHTML = '<svg id="submitIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8M8 16l4-4 4 4"/></svg>';
            }
        });

        // ---------- background animation ----------
        const canvas = $('bgCanvas');
        const ctx = canvas.getContext('2d');
        let dpr = Math.min(window.devicePixelRatio || 1, 2);
        function resizeCanvas() {
            canvas.width = window.innerWidth * dpr; canvas.height = window.innerHeight * dpr;
            canvas.style.width = window.innerWidth + 'px'; canvas.style.height = window.innerHeight + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const nodeCount = window.innerWidth < 640 ? 14 : 25;
        const nodes = Array.from({ length: nodeCount }, () => ({
            x: Math.random() * window.innerWidth, y: Math.random() * window.innerHeight,
            vx: (Math.random() - 0.5) * 0.5, vy: (Math.random() - 0.5) * 0.5,
        }));

        function drawFrame() {
            const w = window.innerWidth, h = window.innerHeight;
            ctx.clearRect(0, 0, w, h);
            ctx.fillStyle = 'rgba(255,255,255,0.7)';
            ctx.strokeStyle = 'rgba(255,255,255,0.3)';
            nodes.forEach(n => {
                if (!reduceMotion) {
                    n.x += n.vx; n.y += n.vy;
                    if (n.x < 0 || n.x > w) n.vx *= -1;
                    if (n.y < 0 || n.y > h) n.vy *= -1;
                }
                ctx.beginPath(); ctx.arc(n.x, n.y, 3, 0, Math.PI * 2); ctx.fill();
                nodes.forEach(o => {
                    const dist = Math.hypot(n.x - o.x, n.y - o.y);
                    if (dist < 150) { ctx.beginPath(); ctx.moveTo(n.x, n.y); ctx.lineTo(o.x, o.y); ctx.stroke(); }
                });
            });
        }
        if (reduceMotion) { drawFrame(); } else { (function animate() { drawFrame(); requestAnimationFrame(animate); })(); }
    </script>
</body>

</html>