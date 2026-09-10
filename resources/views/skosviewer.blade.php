<!doctype html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SKOS Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/skosviewer.css" />
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-7xl mx-auto my-4 sm:my-10 bg-white p-4 sm:p-8 rounded-2xl shadow-2xl" x-data="skosViewer()"
        x-init="init()" x-cloak>

        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
            <h1
                class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                SKOS Viewer</h1>
            <span class="text-gray-600 text-sm">📄 <strong x-text="fileName || ('File ' + fileId)"></strong>
                <span x-show="data.length" x-text="'· ' + data.length + ' concepts'"></span></span>
        </div>

        <a href="../dashboard"
            class="inline-flex items-center gap-2 text-indigo-600 font-medium hover:text-indigo-800 transition mb-4">
            <img src="../img/back-icon.png" alt="" class="w-5 h-5"> <span>Return to Dashboard</span>
        </a>

        <p x-show="error" class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm" x-text="error"></p>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6 flex gap-4">
            <button @click="activeTab = 'list'"
                :class="activeTab === 'list' ? 'border-indigo-600 text-indigo-600 border-b-2' : 'text-gray-500 hover:text-indigo-600'"
                class="flex items-center gap-2 pb-2 text-lg font-medium">
                <img src="../img/list.png" alt="" class="w-5 h-5"><span>List</span>
            </button>
            <button @click="activeTab = 'tree'; if (!tree.length) buildTree()"
                :class="activeTab === 'tree' ? 'border-indigo-600 text-indigo-600 border-b-2' : 'text-gray-500 hover:text-indigo-600'"
                class="flex items-center gap-2 pb-2 text-lg font-medium">
                <img src="../img/tree-list.png" alt="" class="w-5 h-5"><span>Tree</span>
            </button>
        </div>

        <!-- TAB: List -->
        <div x-show="activeTab === 'list'">
            <div class="mb-4 space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <input x-model="filter" type="search" placeholder="Search label or URI…"
                        class="p-2 border border-gray-300 rounded-lg w-full sm:w-80 focus:ring focus:ring-indigo-300" />
                    <span class="text-sm text-gray-500" x-text="filteredItems().length + ' shown'"></span>
                    <button @click="reload()"
                        class="ml-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        :disabled="loading">
                        <span x-text="loading ? 'Loading…' : '🔄 Reload'"></span>
                    </button>
                </div>
                <div class="flex flex-wrap gap-1 justify-center border-t border-gray-200 pt-3">
                    <template x-for="char in alphabet" :key="char">
                        <button @click="setLetterFilter(char)"
                            class="px-2 py-1 text-sm rounded-md border border-gray-200 hover:bg-indigo-100 hover:text-indigo-700 transition"
                            :class="{ 'bg-indigo-600 text-white border-indigo-600': letterFilter === char }"
                            x-text="char"></button>
                    </template>
                    <button @click="setLetterFilter('')"
                        class="px-3 py-1 ml-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100"
                        :class="{ 'bg-indigo-600 text-white border-indigo-600': letterFilter === '' }">Όλα</button>
                </div>
            </div>

            <div class="overflow-y-auto border rounded-md shadow-sm" style="max-height: 60vh" x-show="!selected">
                <table class="min-w-full border-collapse">
                    <thead class="sticky top-0">
                        <tr class="bg-indigo-600 text-white text-sm">
                            <th class="px-4 py-2 text-left w-1/2">Label</th>
                            <th class="px-4 py-2 text-left w-1/2 hidden sm:table-cell">URI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in filteredItems()" :key="item.subject">
                            <tr @click="selectConcept(item)"
                                class="hover:bg-indigo-50 cursor-pointer transition border-b">
                                <td class="px-4 py-2 font-medium text-gray-800">
                                    <span x-text="item.label"></span>
                                    <template x-for="l in item.labels.filter(l => l.value !== item.label)"
                                        :key="l.value + l.lang">
                                        <span class="text-gray-500 font-normal text-sm"> · <span
                                                x-text="l.value"></span><span class="lang" x-show="l.lang"
                                                x-text="l.lang"></span></span>
                                    </template>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600 truncate max-w-xs hidden sm:table-cell"
                                    x-text="item.subject" :title="item.subject"></td>
                            </tr>
                        </template>
                        <tr x-show="!loading && filteredItems().length === 0">
                            <td colspan="2" class="text-center text-gray-500 py-6">No results found</td>
                        </tr>
                        <tr x-show="loading">
                            <td colspan="2" class="text-center text-gray-500 py-6">Loading…</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Concept details -->
            <template x-if="selected">
                <div
                    class="bg-gradient-to-br from-indigo-50 to-purple-50 p-4 sm:p-6 rounded-2xl shadow-lg border border-indigo-100">
                    <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold text-indigo-700" x-text="selected.Label"></h2>
                        <button @click="selected = null"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md transition">←
                            Επιστροφή</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <template x-for="(value, key) in selected" :key="key">
                            <div class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm">
                                <dt class="text-gray-700 font-semibold" x-text="formatKey(key)"></dt>
                                <dd class="mt-1 text-gray-900 text-sm leading-relaxed break-words"
                                    x-html="formatValue(value)"></dd>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- TAB: Tree -->
        <div x-show="activeTab === 'tree'">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <h2 class="text-xl font-semibold text-indigo-700">SKOS Tree View</h2>
                <div class="ml-auto flex gap-2">
                    <button @click="toggleAll(true)"
                        class="px-3 py-1 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Expand
                        all</button>
                    <button @click="toggleAll(false)"
                        class="px-3 py-1 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Collapse
                        all</button>
                </div>
            </div>
            <div id="treeBox" class="bg-gray-50 border rounded-lg p-3 overflow-y-auto" style="max-height: 70vh">
                <p x-show="treeLoading" class="text-gray-500 italic">Loading tree…</p>
                <p x-show="!treeLoading && tree.length === 0" class="text-gray-500 italic">No SKOS hierarchy found in
                    this file (concepts need <code>skos:Concept</code> type and
                    <code>skos:broader</code>/<code>narrower</code>).
                </p>
                <div class="space-y-2">
                    <template x-for="(node, i) in tree" :key="node.uri + i">
                        <div x-html="renderNode(node)"></div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const norm = (s) => String(s || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().replace(/ς/g, 'σ');
        const fmt = (v) => { v = String(v); return v.startsWith('http') ? `<a href="${esc(v)}" target="_blank" rel="noopener" class="text-indigo-600 underline break-all">${esc(v)}</a>` : esc(v); };

        function renderNode(node) {
            const details = node.details && Object.keys(node.details).length
                ? `<div class="mt-1 pl-2 border-l border-gray-200 space-y-1">${Object.entries(node.details).map(([k, v]) =>
                    `<div><span class="font-semibold text-gray-800">${esc(k)}:</span> <span class="text-gray-700">${(Array.isArray(v) ? v : [v]).map(fmt).join(', ')}</span></div>`).join('')}</div>` : '';
            const kids = node.children?.length ? `<div class="ml-4 border-l border-gray-200 pl-2 mt-2 space-y-2">${node.children.map(renderNode).join('')}</div>` : '';
            return `<details class="bg-white p-2 rounded-md shadow-sm border border-gray-200 ${node.children?.length ? '' : 'leaf'}">
                <summary class="cursor-pointer text-indigo-700 font-medium hover:text-indigo-900">${esc(node.label)}${node.children?.length ? ` <span class="text-xs text-gray-400">(${node.children.length})</span>` : ''}</summary>
                <div class="ml-4 mt-2 text-sm">
                    <div class="text-xs text-gray-500 mb-2 break-all">${fmt(node.uri)}</div>
                    ${details}${kids}
                </div></details>`;
        }

        function skosViewer() {
            return {
                fileId: "{{ $fileId }}",
                fileName: "",
                token: localStorage.getItem('token'),
                data: [], tree: [], selected: null,
                filter: "", letterFilter: "", activeTab: 'list',
                loading: false, treeLoading: false, error: "",
                alphabet: [..."ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ", ..."ABCDEFGHIJKLMNOPQRSTUVWXYZ"],

                async api(path) {
                    const res = await fetch(window.apiBaseUrl + path, { headers: { Authorization: 'Bearer ' + this.token } });
                    if (res.status === 401) { localStorage.removeItem('token'); window.location.href = '../login'; return; }
                    if (!res.ok) { let m = res.statusText; try { m = (await res.json()).detail || m; } catch (_) { } throw new Error(m); }
                    return res.json();
                },

                async init() {
                    if (!this.token) { window.location.href = '../login'; return; }
                    this.api(`/files/${this.fileId}`).then(f => this.fileName = f.filename).catch(() => { });
                    await this.loadSKOS();
                },

                async reload() { this.selected = null; this.tree = []; await this.loadSKOS(); if (this.activeTab === 'tree') await this.buildTree(); },

                async loadSKOS() {
                    this.loading = true; this.error = "";
                    try {
                        const json = await this.api(`/files/${this.fileId}/skos`);
                        this.data = (json.labels || []).map(i => ({ ...i, labels: i.labels || [{ value: i.label, lang: null }] }));
                        this.data.sort((a, b) => norm(a.label).localeCompare(norm(b.label), 'el'));
                    } catch (err) { this.error = 'Could not load concepts: ' + err.message; }
                    finally { this.loading = false; }
                },

                filteredItems() {
                    const f = norm(this.filter.trim());
                    const letter = norm(this.letterFilter);
                    return this.data.filter(i =>
                        (!f || norm(i.label).includes(f) || norm(i.subject).includes(f) || i.labels.some(l => norm(l.value).includes(f))) &&
                        (!letter || i.labels.some(l => norm(l.value).startsWith(letter))));
                },

                setLetterFilter(char) { this.letterFilter = this.letterFilter === char ? "" : char; },

                async selectConcept(item) {
                    const selected = { Label: item.label, URI: item.subject };
                    try {
                        const json = await this.api(`/node-details-skostree/?file_id=${this.fileId}&uri=${encodeURIComponent(item.subject)}`);
                        for (const key in json.details) {
                            const values = [...new Set([].concat(json.details[key]))];
                            selected[key] = values.length === 1 ? values[0] : values;
                        }
                    } catch (err) { this.error = err.message; }
                    this.selected = selected;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                formatKey(key) {
                    const map = {
                        subject: "URI", prefLabel: "Preferred label", altLabel: "Alternative label", hiddenLabel: "Hidden label",
                        definition: "Definition", scopeNote: "Scope note", broader: "Broader", narrower: "Narrower", related: "Related",
                        inScheme: "Scheme", topConceptOf: "Top concept of", notation: "Notation", type: "Type", created: "Created", modified: "Modified"
                    };
                    return map[key] || key;
                },

                formatValue(value) {
                    if (Array.isArray(value)) return value.map(fmt).join('<br>');
                    return value ? fmt(value) : '<span class="text-gray-400">(κενό)</span>';
                },

                async buildTree() {
                    this.treeLoading = true; this.error = "";
                    try { this.tree = await this.api(`/files/${this.fileId}/skos-tree`); }
                    catch (err) { this.error = 'Could not load tree: ' + err.message; this.tree = []; }
                    finally { this.treeLoading = false; }
                },

                toggleAll(open) { document.querySelectorAll('#treeBox details').forEach(d => d.open = open); },
            };
        }
    </script>
</body>

</html>