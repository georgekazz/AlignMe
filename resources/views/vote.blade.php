<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Links Voting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 min-h-screen p-6 font-[Inter]">

    <div class="w-full p-6 bg-white/90 backdrop-blur rounded-xl shadow-lg animate-fadeIn">
        <!-- Back Button -->
        <div class="mb-4">
            <button onclick="window.location.href='./dashboard'"
                class="inline-flex items-center gap-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition shadow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span class="text-sm">Back to Dashboard</span>
            </button>
        </div>

        <h2 class="text-3xl font-bold mb-6 text-indigo-900 text-center">Links <span class="text-pink-500">Voting</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-md">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm">
                    <tr>
                        <th class="px-3 py-2 text-left">Source</th>
                        <th class="px-3 py-2 text-left">Target</th>
                        <th class="px-3 py-2 text-left">Type</th>
                        <th class="px-3 py-2 text-center">Score</th>
                        <th class="px-3 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="linksTable" class="divide-y divide-gray-200 text-sm">
                    <!-- Dynamically populated -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const token = localStorage.getItem("token");

        async function loadLinks() {
            try {
                const res = await fetch("http://127.0.0.1:8000/links-vote", {
                    headers: { "Authorization": "Bearer " + token }
                });
                const data = await res.json();

                const table = document.getElementById("linksTable");
                table.innerHTML = "";

                data.forEach(link => {
                    const row = document.createElement("tr");
                    row.className = "hover:bg-indigo-50 transition duration-300";

                    row.innerHTML = `
            <td class="px-6 py-4 text-gray-800 font-medium">${link.source_node}</td>
            <td class="px-6 py-4 text-gray-800">${link.target_node}</td>
            <td class="px-6 py-4 text-gray-600 italic">
                ${link.link_type?.inner || link.link_type_id}
            </td>
            <td class="px-6 py-4 text-center font-bold text-indigo-700">${link.suggestion_score}</td>
            <td class="px-6 py-4 text-center">
              <div class="flex flex-col items-center gap-2">
                <div class="flex items-center gap-1 text-green-600 font-semibold">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                  </svg>
                  <span id="upvote-${link.id}">${link.upvote}</span>
                </div>
                <div class="flex items-center gap-1 text-red-600 font-semibold">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                  </svg>
                  <span id="downvote-${link.id}">${link.downvote}</span>
                </div>
                <div class="flex gap-3 mt-3">
                  <button id="upvote-btn-${link.id}" class="flex items-center gap-1 px-3 py-1.5 bg-green-500 text-white rounded-lg hover:bg-green-600 active:scale-95 transition"
                    onclick="vote(${link.id}, 'upvote')">
                    👍 Upvote
                  </button>
                  <button id="downvote-btn-${link.id}" class="flex items-center gap-1 px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 active:scale-95 transition"
                    onclick="vote(${link.id}, 'downvote')">
                    👎 Downvote
                  </button>
                </div>
              </div>
            </td>
          `;
                    table.appendChild(row);
                });

            } catch (err) {
                console.error("Failed to load links:", err);
            }
        }

        async function vote(linkId, type) {
            const upBtn = document.getElementById(`upvote-btn-${linkId}`);
            const downBtn = document.getElementById(`downvote-btn-${linkId}`);
            if (!upBtn || !downBtn) return;

            upBtn.disabled = true;
            downBtn.disabled = true;

            try {
                const res = await fetch(`http://127.0.0.1:8000/links/${linkId}/vote`, {
                    method: "POST",
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ type })
                });

                if (!res.ok) throw new Error("Failed to vote");

                const data = await res.json();
                document.getElementById(`upvote-${linkId}`).textContent = data.upvote;
                document.getElementById(`downvote-${linkId}`).textContent = data.downvote;

                // μικρό notification
                alert("✅ Ευχαριστούμε για την ψήφο!");
            } catch (err) {
                console.error(err);
                alert("❌ Κάτι πήγε στραβά με την ψήφο.");
                upBtn.disabled = false;
                downBtn.disabled = false;
            }
        }

        loadLinks();
    </script>
</body>

</html>