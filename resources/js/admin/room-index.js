/**
 * Room Index Page - Collapsible buildings and modal handling
 */

document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");

    // Debounce function
    let debounceTimer;
    function debounce(func, delay) {
        return function (...args) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(this, args), delay);
        };
    }

    // Toggle building collapse
    window.toggleBuilding = function (buildingId) {
        const roomsDiv = document.getElementById(`rooms-${buildingId}`);
        const chevron = document.getElementById(`chevron-${buildingId}`);

        if (roomsDiv.classList.contains("hidden")) {
            roomsDiv.classList.remove("hidden");
            chevron.classList.add("rotate-180");
        } else {
            roomsDiv.classList.add("hidden");
            chevron.classList.remove("rotate-180");
        }
    };

    // Filter function
    function filterContent() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedType = typeFilter.value;

        const buildingCards = document.querySelectorAll(".building-card");

        buildingCards.forEach((card) => {
            const buildingName = card.dataset.buildingName || "";
            const buildingCode = card.dataset.buildingCode || "";
            const roomRows = card.querySelectorAll(".room-row");

            let buildingMatches = false;
            let hasVisibleRooms = false;

            // Check if building matches search
            if (searchTerm) {
                buildingMatches =
                    buildingName.includes(searchTerm) ||
                    buildingCode.includes(searchTerm);
            } else {
                buildingMatches = true;
            }

            // Filter rooms within building
            roomRows.forEach((row) => {
                const roomName = row.dataset.roomName || "";
                const roomCode = row.dataset.roomCode || "";
                const roomType = row.dataset.roomType || "";

                let matchesSearch = true;
                let matchesType = true;

                if (searchTerm) {
                    matchesSearch =
                        roomName.includes(searchTerm) ||
                        roomCode.includes(searchTerm) ||
                        buildingMatches;
                }

                if (selectedType) {
                    matchesType = roomType === selectedType;
                }

                if (matchesSearch && matchesType) {
                    row.style.display = "";
                    hasVisibleRooms = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Show building if it matches search or has visible rooms
            if (buildingMatches || hasVisibleRooms) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    }

    // Event listeners for filtering
    if (searchInput) {
        searchInput.addEventListener("input", debounce(filterContent, 300));
    }
    if (typeFilter) {
        typeFilter.addEventListener("change", filterContent);
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = ["successAlert", "errorAlert", "validationAlert"];
        alerts.forEach((id) => {
            const alert = document.getElementById(id);
            if (alert) {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            }
        });
    }, 5000);

    // Make functions globally accessible
    window.editBuilding = editBuilding;
    window.deleteBuilding = deleteBuilding;
    window.viewRoom = viewRoom;
    window.editRoom = editRoom;
    window.deleteRoom = deleteRoom;

    // Edit building
    async function editBuilding(buildingId) {
        try {
            const response = await fetch(`/admin/buildings/${buildingId}`);
            const building = await response.json();

            if (building.error) {
                alert("Gagal memuat data gedung");
                return;
            }

            // Populate form
            document.getElementById("editBuildingCode").value = building.code;
            document.getElementById("editBuildingName").value = building.name;
            document.getElementById("editBuildingFloors").value =
                building.total_floors;
            document.getElementById("editBuildingDescription").value =
                building.description || "";

            // Set form action
            document.getElementById("editBuildingForm").action =
                `/admin/buildings/${building.id}`;

            // Open modal
            window.dispatchEvent(
                new CustomEvent("open-modal", {
                    detail: "edit-building-modal",
                }),
            );
        } catch (error) {
            console.error("Error loading building for edit:", error);
            alert("Gagal memuat data gedung");
        }
    }

    // Delete building
    function deleteBuilding(buildingId, buildingName) {
        document.getElementById("deleteBuildingName").textContent =
            buildingName;
        document.getElementById("deleteBuildingForm").action =
            `/admin/buildings/${buildingId}`;

        window.dispatchEvent(
            new CustomEvent("open-modal", { detail: "delete-building-modal" }),
        );
    }

    // View room details
    async function viewRoom(roomId) {
        try {
            const response = await fetch(`/admin/rooms/${roomId}`);
            const room = await response.json();

            if (room.error) {
                alert("Gagal memuat data ruangan");
                return;
            }

            const content = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-800/30 p-5 rounded-xl border border-gray-100 dark:border-gray-700">
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kode Ruangan</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">${room.code}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Ruangan</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">${room.name}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Gedung / Lokasi</label>
                        <div class="flex items-center gap-2">
                           <span class="p-1 rounded bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                           </span>
                           <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${room.building_name || "Tidak Terikat Gedung"}</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Lantai</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${room.floor !== null ? 'Lantai ' + room.floor : "-"}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kapasitas</label>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">${room.capacity ?? "0"}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Siswa</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tipe Ruangan</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                            ${room.type ? room.type.charAt(0).toUpperCase() + room.type.slice(1) : "-"}
                        </span>
                    </div>
                    <div class="col-span-1 md:col-span-2 space-y-2 pt-2 border-t border-gray-100 dark:border-gray-700 mt-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status Operasional</label>
                        <div class="flex items-center gap-2">
                            ${room.is_active
                    ? '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400"><span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>Aktif & Tersedia</span>'
                    : '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">Nonaktif</span>'
                }
                        </div>
                    </div>
                </div>
                ${room.notes
                    ? `
                    <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-xl border border-amber-100 dark:border-amber-900/30">
                        <label class="text-xs font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400 flex items-center gap-1.5 mb-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Catatan Penting
                        </label>
                        <p class="text-sm text-amber-800 dark:text-amber-200 italic leading-relaxed">"${room.notes}"</p>
                    </div>
                `
                    : ""
                }
            `;

            document.getElementById("viewRoomContent").innerHTML = content;
            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "view-room-modal" }),
            );
        } catch (error) {
            console.error("Error viewing room:", error);
            alert("Gagal memuat data ruangan");
        }
    }

    // Edit room
    async function editRoom(roomId) {
        try {
            const response = await fetch(`/admin/rooms/${roomId}`);
            const room = await response.json();

            if (room.error) {
                alert("Gagal memuat data ruangan");
                return;
            }

            // Populate form
            document.getElementById("editRoomCode").value = room.code;
            document.getElementById("editRoomName").value = room.name;
            document.getElementById("editRoomBuilding").value =
                room.building_id;
            document.getElementById("editRoomFloor").value = room.floor ?? "";
            document.getElementById("editRoomCapacity").value =
                room.capacity ?? "";
            document.getElementById("editRoomType").value = room.type;
            document.getElementById("editRoomNotes").value = room.notes || "";
            document.getElementById("editIsActive").checked = room.is_active;

            // Set form action
            document.getElementById("editRoomForm").action =
                `/admin/rooms/${room.id}`;

            // Open modal
            window.dispatchEvent(
                new CustomEvent("open-modal", { detail: "edit-room-modal" }),
            );
        } catch (error) {
            console.error("Error loading room for edit:", error);
            alert("Gagal memuat data ruangan");
        }
    }

    // Delete room
    function deleteRoom(roomId, roomName) {
        document.getElementById("deleteRoomName").textContent = roomName;
        document.getElementById("deleteRoomForm").action =
            `/admin/rooms/${roomId}`;

        window.dispatchEvent(
            new CustomEvent("open-modal", { detail: "delete-room-modal" }),
        );
    }
});
