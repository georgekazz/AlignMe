<!doctype html>
<html lang="el">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SKOS Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body class="bg-gray-100 font-sans">
    <div class="max-w-7xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-2xl" x-data="skosViewer()" x-init="init()">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent animate-pulse">SKOS Viewer</h1>
            <span class="text-gray-600">📄 File ID: <strong x-text="fileId"></strong></span>
        </div>

        <!-- Back Button -->
        <div class="mb-4">
            <a href="../dashboard"
            class="inline-flex items-center gap-2 text-indigo-600 font-medium hover:text-indigo-800 transition">
                <img src="../img/back-icon.png" alt="List Icon" class="w-5 h-5">
                <span>Επιστροφή στην αρχική</span>
            </a>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6 flex space-x-4">
            <button @click="activeTab = 'list'"
                :class="activeTab === 'list' ? 'border-indigo-600 text-indigo-600 border-b-2' : 'text-gray-500 hover:text-indigo-600'"
                class="flex items-center gap-2 pb-2 text-lg font-medium">
                <img src="../img/list.png" alt="List Icon" class="w-5 h-5">
                <span>List</span>
            </button>

            <button @click="activeTab = 'tree'"
                :class="activeTab === 'tree' ? 'border-indigo-600 text-indigo-600 border-b-2' : 'text-gray-500 hover:text-indigo-600'"
                class="flex items-center gap-2 pb-2 text-lg font-medium">
                <img src="../img/tree-list.png" alt="Tree Icon" class="w-5 h-5">
                <span>Tree</span>
            </button>
        </div>


        <!-- TAB 1: Λίστα -->
        <div x-show="activeTab === 'list'">
            <div class="mb-6 space-y-4">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <input x-model="filter" placeholder="🔍 Αναζήτηση label ή URI..."
                        class="p-2 border border-gray-300 rounded-lg w-80 focus:ring focus:ring-indigo-300" />
                    <button @click="loadSKOS()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        🔄 Επαναφόρτωση
                    </button>
                </div>

                <div class="flex flex-wrap gap-1 justify-center border-t border-gray-200 pt-3">
                    <template x-for="char in alphabet" :key="char">
                        <button @click="setLetterFilter(char)"
                            class="px-2.5 py-1 text-sm rounded-md border border-gray-200 hover:bg-indigo-100 hover:text-indigo-700 transition"
                            :class="{ 'bg-indigo-600 text-white border-indigo-600': letterFilter === char }"
                            x-text="char">
                        </button>
                    </template>
                    <button @click="setLetterFilter('')"
                        class="px-3 py-1 ml-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100"
                        :class="{ 'bg-indigo-600 text-white border-indigo-600': letterFilter === '' }">
                        Όλα
                    </button>
                </div>
            </div>

            <!-- Πίνακας labels -->
            <div class="overflow-y-auto max-h-[500px] border rounded-md shadow-sm" x-show="!selected">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-indigo-600 text-white text-sm uppercase">
                            <th class="border px-4 py-2 text-left w-1/2">Label</th>
                            <th class="border px-4 py-2 text-left w-1/2">URI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in filteredItems()" :key="item.subject">
                            <tr @click="selectConcept(item)"
                                class="hover:bg-indigo-50 cursor-pointer transition border-b">
                                <td class="px-4 py-2 font-medium text-gray-800" x-text="item.label"></td>
                                <td class="px-4 py-2 text-sm text-gray-600 truncate" x-text="item.subject"></td>
                            </tr>
                        </template>
                        <tr x-show="filteredItems().length === 0">
                            <td colspan="2" class="text-center text-gray-500 py-4">Δεν βρέθηκαν αποτελέσματα</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Λεπτομέρειες Concept -->
            <template x-if="selected">
                <div
                    class="mt-10 bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl shadow-lg border border-indigo-100 animate-fadeIn">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">Λεπτομέρειες Concept</h2>
                        <button @click="selected = null"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md transition">
                            ← Επιστροφή
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="(value, key) in selected" :key="key">
                            <div
                                class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                                <dt class="text-gray-700 font-semibold" x-text="formatKey(key)"></dt>
                                <dd class="mt-2 text-gray-900 text-sm leading-relaxed" x-html="formatValue(value)"></dd>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- TAB 2: Δενδρική Προβολή -->
        <div x-show="activeTab === 'tree'" x-transition>
        <h2 class="text-xl font-semibold text-indigo-700 mb-4">Δενδρική Προβολή SKOS</h2>

        <div class="bg-gray-50 border rounded-lg p-4 max-h-[600px] overflow-y-auto">
            <template x-if="tree.length === 0">
            <p class="text-gray-500 italic">Δεν υπάρχει διαθέσιμη δενδρική δομή ακόμη.</p>
            </template>

            <template x-for="node in tree" :key="node.uri">
            <div class="ml-4 mt-2">
                <details class="bg-white p-2 rounded-md shadow-sm border border-gray-200">
                <summary class="cursor-pointer text-indigo-700 font-medium" x-text="node.label"></summary>

                <div class="ml-4 mt-2 text-sm text-gray-700">
                    
                    <div class="text-xs text-gray-500 mb-1">
                    <a :href="node.uri" target="_blank" class="underline text-indigo-600" x-text="node.uri"></a>
                    </div>

                    <template x-if="node.details && Object.keys(node.details).length">
                    <div class="mt-1 pl-2 border-l border-gray-200 space-y-1">
                        <template x-for="[key, val] in Object.entries(node.details)" :key="key">
                        <div>
                            <span class="font-semibold text-gray-800" x-text="key + ':'"></span>
                            <span x-html="
                            Array.isArray(val)
                                ? val.map(v => v.startsWith('http') ? `<a href='${v}' target='_blank' class='text-indigo-600 underline'>${v}</a>` : v).join(', ')
                                : (val.startsWith('http') ? `<a href='${val}' target='_blank' class='text-indigo-600 underline'>${val}</a>` : val)
                            "></span>
                        </div>
                        </template>
                    </div>
                    </template>

                    <!-- Παιδιά -->
                    <template x-if="node.children && node.children.length">
                    <div class="ml-6 border-l border-gray-200 pl-3 mt-2">
                        <template x-for="child in node.children" :key="child.uri">
                        <div class="mt-1">
                            <div x-data="{ childNode: child }">
                            
                            <details class="bg-white p-2 rounded-md shadow-sm border border-gray-200">
                                <summary class="cursor-pointer text-indigo-600 font-medium" x-text="childNode.label"></summary>
                                <div class="ml-4 mt-1 text-sm text-gray-700">
                                <div class="text-xs text-gray-500 mb-1">
                                    <a :href="childNode.uri" target="_blank" class="underline text-indigo-600" x-text="childNode.uri"></a>
                                </div>
                                <template x-if="childNode.details && Object.keys(childNode.details).length">
                                    <div class="mt-1 pl-2 border-l border-gray-200 space-y-1">
                                    <template x-for="[key, val] in Object.entries(childNode.details)" :key="key">
                                        <div>
                                        <span class="font-semibold text-gray-800" x-text="key + ':'"></span>
                                        <span x-html="
                                            Array.isArray(val)
                                            ? val.map(v => v.startsWith('http') ? `<a href='${v}' target='_blank' class='text-indigo-600 underline'>${v}</a>` : v).join(', ')
                                            : (val.startsWith('http') ? `<a href='${val}' target='_blank' class='text-indigo-600 underline'>${val}</a>` : val)
                                        "></span>
                                        </div>
                                    </template>
                                    </div>
                                </template>

                                <template x-if="childNode.children && childNode.children.length">
                                    <div class="ml-6 border-l border-gray-200 pl-3 mt-2">
                                    <template x-for="subchild in childNode.children" :key="subchild.uri">
                                        <div x-data="{ childNode: subchild }">
                                        <!-- αναδρομικά -->
                                        </div>
                                    </template>
                                    </div>
                                </template>

                                </div>
                            </details>
                            </div>
                        </div>
                        </template>
                    </div>
                    </template>

                </div>
                </details>
            </div>
            </template>
        </div>
        </div>

    </div>

    <script>
        window.apiBaseUrl = "{{ config('api.base_url') }}";
        function skosViewer() {
            return {
                fileId: "{{ $fileId }}",
                token: localStorage.getItem('token'),
                projectId: 2,
                data: [],
                tree: [],
                selected: null,
                filter: "",
                letterFilter: "",
                activeTab: 'list',
                alphabet: [..."ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ", ..."ABCDEFGHIJKLMNOPQRSTUVWXYZ"],

                async init() {
                    await this.loadSKOS();
                    this.buildTree();
                },

                async loadSKOS() {
                    try {
                        const res = await fetch(`${window.apiBaseUrl}/files/${this.fileId}/skos`, {
                            headers: { 'Authorization': 'Bearer ' + this.token }
                        });
                        if (!res.ok) throw new Error('Αποτυχία φόρτωσης SKOS');
                        const json = await res.json();
                        this.data = json.labels || [];
                    } catch (err) {
                        alert('Σφάλμα φόρτωσης SKOS: ' + err.message);
                    }
                },

                filteredItems() {
                    const f = this.filter.toLowerCase().trim();
                    let filtered = this.data.filter(i =>
                        (!f || i.label?.toLowerCase().includes(f) || i.subject?.toLowerCase().includes(f))
                    );

                    if (this.letterFilter) {
                        const letter = this.letterFilter.toLowerCase();
                        filtered = filtered.filter(i => (i.label?.toLowerCase() || "").startsWith(letter));
                    }

                    return filtered;
                },

                setLetterFilter(char) {
                    this.letterFilter = this.letterFilter === char ? "" : char;
                },

                async selectConcept(item) {
                    try {
                        const encodedURI = encodeURIComponent(item.subject);
                        const res = await fetch(`${window.apiBaseUrl}/node-details/?project_id=${this.projectId}&uri=${encodedURI}`, {
                            headers: { 'Authorization': 'Bearer ' + this.token }
                        });
                        if (!res.ok) throw new Error('Δεν βρέθηκαν λεπτομέρειες');
                        const json = await res.json();
                        const selected = { Label: item.label, URI: item.subject };
                        for (const key in json.details) {
                            const values = Array.isArray(json.details[key])
                                ? [...new Set(json.details[key])]
                                : [json.details[key]];
                            selected[key] = values.length === 1 ? values[0] : values;
                        }
                        this.selected = selected;
                    } catch (err) {
                        alert('⚠️ ' + err.message);
                        this.selected = { Label: item.label, URI: item.subject };
                    }
                },

                formatKey(key) {
                    const map = {
                        subject: "URI",
                        prefLabel: "PrefLabel",
                        altLabel: "AltLabel",
                        definition: "Definition",
                        broader: "Broader",
                        narrower: "Narrower",
                        created: "Created",
                        modified: "Modified"
                    };
                    return map[key] || key;
                },

                formatValue(value) {
                    if (Array.isArray(value)) {
                        return value.map(v =>
                            v.startsWith('http')
                                ? `<a href="${v}" target="_blank" class="text-indigo-600 underline">${v}</a>`
                                : v
                        ).join('<br>');
                    }
                    if (typeof value === 'string' && value.startsWith('http')) {
                        return `<a href="${value}" target="_blank" class="text-indigo-600 underline">${value}</a>`;
                    }
                    return value || '<span class="text-gray-400">(κενό)</span>';
                },

                async buildTree() {
                    try {
                        const res = await fetch(`${window.apiBaseUrl}/files/${this.fileId}/skos-tree`, {
                            headers: { 'Authorization': 'Bearer ' + this.token }
                        });
                        if (!res.ok) throw new Error('Αποτυχία φόρτωσης δενδρικής δομής');
                        this.tree = await res.json();
                    } catch (err) {
                        alert('Σφάλμα: ' + err.message);
                        this.tree = [];
                    }
                }

            };
        }
    </script>
</body>

</html>