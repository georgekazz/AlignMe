<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File - AlignMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/uploadfile.css" />
</head>

<body class="bg-gradient-to-r from-purple-600 to-indigo-500 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 max-w-md w-full">
        <a href="./dashboard"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-indigo-500 rounded-lg hover:bg-gray-300 transition mb-6">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Dashboard
        </a>

        <h2 class="text-3xl font-bold text-indigo-900 mb-2 text-center">Upload RDF File</h2>
        <p class="text-center text-sm text-gray-500 mb-6">RDF/XML, OWL, Turtle, N3, N-Triples or JSON-LD · up to <span
                id="maxSize">50</span> MB</p>

        <form id="uploadForm" class="space-y-5">
            <label id="dropzone" class="dropzone block p-6 text-center" for="file">
                <input type="file" id="file" class="sr-only" accept=".rdf,.owl,.xml,.ttl,.n3,.nt,.jsonld">
                <div id="dropIdle">
                    <svg class="w-10 h-10 mx-auto text-indigo-400 mb-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-indigo-900 font-semibold">Drop a file here or <span class="underline">browse</span>
                    </p>
                </div>
                <div id="dropFile" class="hidden">
                    <p id="fileName" class="text-indigo-900 font-semibold break-all"></p>
                    <p id="fileMeta" class="text-sm text-gray-500 mt-1"></p>
                    <button type="button" id="clearFile" class="text-xs text-red-600 underline mt-2">remove</button>
                </div>
            </label>

            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" id="public" class="h-5 w-5 mt-0.5 accent-yellow-400">
                <span><span class="text-indigo-900 font-semibold">Make public</span><br><span
                        class="text-xs text-gray-500">Other users can view it and use it in their
                        projects.</span></span>
            </label>

            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" id="parseNow" class="h-5 w-5 mt-0.5 accent-yellow-400" checked>
                <span><span class="text-indigo-900 font-semibold">Parse after upload</span><br><span
                        class="text-xs text-gray-500">Converts it to triples so it's ready for projects.
                        Recommended.</span></span>
            </label>

            <button type="submit" id="submitBtn" disabled
                class="w-full bg-yellow-400 text-indigo-900 font-bold py-3 rounded-lg hover:bg-yellow-300 transition transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-2">
                <span id="btnLabel">Upload</span>
            </button>

            <div id="progressWrap" class="hidden">
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div id="progress" class="bg-yellow-400 h-2 w-0 transition-all"></div>
                </div>
            </div>
        </form>

        <div id="status" class="mt-4 text-sm rounded-lg p-3 hidden"></div>

        <div id="done" class="mt-4 hidden flex flex-col sm:flex-row gap-2">
            <a href="./dashboard"
                class="flex-1 text-center px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Go
                to dashboard</a>
            <button id="another"
                class="flex-1 px-4 py-2 rounded-lg bg-gray-200 text-indigo-900 font-semibold hover:bg-gray-300">Upload
                another</button>
        </div>
    </div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const token = localStorage.getItem('token');
        if (!token) window.location.href = './login';

        const MAX_MB = 50;
        const ALLOWED = ['rdf', 'owl', 'xml', 'ttl', 'n3', 'nt', 'jsonld'];
        const $ = (id) => document.getElementById(id);
        const fileInput = $('file'), dropzone = $('dropzone'), submitBtn = $('submitBtn'), status = $('status');
        let file = null;

        function setStatus(msg, kind) {
            status.textContent = msg;
            status.className = 'mt-4 text-sm rounded-lg p-3 ' + ({ ok: 'bg-green-50 text-green-700', err: 'bg-red-50 text-red-700', info: 'bg-indigo-50 text-indigo-700' }[kind]);
        }

        function setFile(f) {
            const ext = (f?.name.split('.').pop() || '').toLowerCase();
            if (!f) return;
            if (!ALLOWED.includes(ext)) { setStatus(`"${f.name}" is not a supported RDF format (${ALLOWED.join(', ')}).`, 'err'); return; }
            if (f.size > MAX_MB * 1024 * 1024) { setStatus(`File is ${(f.size / 1048576).toFixed(1)} MB; the limit is ${MAX_MB} MB.`, 'err'); return; }
            file = f;
            $('fileName').textContent = f.name;
            $('fileMeta').textContent = `${ext.toUpperCase()} · ${(f.size / 1024).toFixed(0)} KB`;
            $('dropIdle').classList.add('hidden'); $('dropFile').classList.remove('hidden');
            dropzone.classList.add('has-file');
            submitBtn.disabled = false;
            status.classList.add('hidden');
        }
        function clearFile() {
            file = null; fileInput.value = '';
            $('dropIdle').classList.remove('hidden'); $('dropFile').classList.add('hidden');
            dropzone.classList.remove('has-file');
            submitBtn.disabled = true;
        }

        fileInput.addEventListener('change', () => setFile(fileInput.files[0]));
        $('clearFile').addEventListener('click', (e) => { e.preventDefault(); clearFile(); });
        ['dragenter', 'dragover'].forEach(ev => dropzone.addEventListener(ev, (e) => { e.preventDefault(); dropzone.classList.add('over'); }));
        ['dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, (e) => { e.preventDefault(); dropzone.classList.remove('over'); }));
        dropzone.addEventListener('drop', (e) => setFile(e.dataTransfer.files[0]));

        // XHR so we get upload progress
        function upload(formData) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', `${window.apiBaseUrl}/files/upload`);
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                xhr.upload.onprogress = (e) => { if (e.lengthComputable) $('progress').style.width = (e.loaded / e.total * 100) + '%'; };
                xhr.onload = () => {
                    let data = {}; try { data = JSON.parse(xhr.responseText); } catch (_) { }
                    if (xhr.status === 401) { localStorage.removeItem('token'); window.location.href = './login'; return; }
                    xhr.status >= 200 && xhr.status < 300 ? resolve(data) : reject(new Error(data.detail ? (typeof data.detail === 'string' ? data.detail : JSON.stringify(data.detail)) : xhr.statusText));
                };
                xhr.onerror = () => reject(new Error('Network error — is the backend running?'));
                xhr.send(formData);
            });
        }

        $('uploadForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!file) return;
            submitBtn.disabled = true;
            $('btnLabel').innerHTML = '<span class="spinner"></span> Uploading…';
            $('progressWrap').classList.remove('hidden');
            $('progress').style.width = '0%';

            const formData = new FormData();
            formData.append('uploaded_file', file);
            formData.append('public', $('public').checked);

            try {
                const data = await upload(formData);
                let msg = `Uploaded "${data.filename}".`;
                if ($('parseNow').checked) {
                    $('btnLabel').innerHTML = '<span class="spinner"></span> Parsing…';
                    const res = await fetch(`${window.apiBaseUrl}/files/${data.id}/parse`, { method: 'POST', headers: { Authorization: 'Bearer ' + token } });
                    const p = await res.json().catch(() => ({}));
                    if (res.ok) msg += ` Parsed ${p.triples_count} triples (${p.source_format}). It's ready to use in a project.`;
                    else { setStatus(`${msg} But parsing failed: ${p.detail || res.statusText}. The file is saved — you can fix it and re-upload.`, 'err'); finish(); return; }
                } else {
                    msg += ' Remember to parse it from the dashboard before using it in a project.';
                }
                setStatus(msg, 'ok');
                finish();
            } catch (err) {
                setStatus('Upload failed: ' + err.message, 'err');
                submitBtn.disabled = false;
                $('btnLabel').textContent = 'Upload';
                $('progressWrap').classList.add('hidden');
            }
        });

        function finish() {
            $('uploadForm').classList.add('hidden');
            $('done').classList.remove('hidden');
        }
        $('another').addEventListener('click', () => {
            clearFile(); $('public').checked = false;
            $('btnLabel').textContent = 'Upload';
            $('progressWrap').classList.add('hidden');
            status.classList.add('hidden');
            $('done').classList.add('hidden');
            $('uploadForm').classList.remove('hidden');
        });
    </script>
</body>

</html>