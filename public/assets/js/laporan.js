/* ==========================================================================
   GLOBAL STATE
   (Menyimpan status filter dan halaman saat ini)
   ========================================================================== */
let currentPage = 1;
let currentLimit = 10;
let filterStartDate = "";
let filterEndDate = "";

/* ==========================================================================
   1. INIT & EVENT LISTENER
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
    // Load data default saat halaman dibuka
    loadLaporan();

    // ----------------------------------------------------------------------
    // A. HANDLE TOMBOL "TAMPILKAN LAPORAN"
    // ----------------------------------------------------------------------
    const btnFilter = document.getElementById("btnFilter");
    if (btnFilter) {
        btnFilter.addEventListener("click", () => {
            // Ambil value dari input tanggal
            const startInput = document.getElementById("startDate").value;
            const endInput = document.getElementById("endDate").value;

            // Update Global State
            filterStartDate = startInput;
            filterEndDate = endInput;
            currentPage = 1; // Reset ke halaman 1 setiap filter baru

            loadLaporan();
        });
    }

    // ----------------------------------------------------------------------
    // B. HANDLE TOMBOL "RESET"
    // ----------------------------------------------------------------------
    const btnReset = document.getElementById("btnReset");
    if (btnReset) {
        btnReset.addEventListener("click", () => {
            // Kosongkan input
            document.getElementById("startDate").value = "";
            document.getElementById("endDate").value = "";

            // Reset State
            filterStartDate = "";
            filterEndDate = "";
            currentPage = 1;

            loadLaporan();
        });
    }

    // ----------------------------------------------------------------------
    // C. HANDLE TOMBOL "CETAK LAPORAN"
    // ----------------------------------------------------------------------
    const btnCetak = document.getElementById("btnCetak");
    if (btnCetak) {
        btnCetak.addEventListener("click", () => {
            // Buka tab baru ke Controller fungsi cetak() dengan parameter filter
            const url = `/laporan/cetak?start_date=${filterStartDate}&end_date=${filterEndDate}`;
            window.open(url, '_blank');
        });
    }
});

/* ==========================================================================
   2. GLOBAL FUNCTIONS (AJAX & RENDER)
   ========================================================================== */

// --- LOAD DATA UTAMA ---
function loadLaporan() {
    // Tampilkan indikator loading (opsional, bisa ditambahkan spinner di tabel)
    const tbody = document.querySelector("#tbodyLaporan");
    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-10 text-slate-400">Memuat data...</td></tr>`;

    // Fetch ke Controller Laporan::getData()
    const url = `/laporan/getData?page=${currentPage}&start_date=${filterStartDate}&end_date=${filterEndDate}`;

    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                // 1. Update Kartu Ringkasan (Atas)
                updateSummaryCards(res.summary);
                
                // 2. Render Tabel Data
                renderTable(res.data, res.pager);
                
                // 3. Render Pagination (Bawah)
                renderPagination(res.pager);
            }
        })
        .catch(err => console.error("Error loadLaporan:", err));
}

// --- UPDATE SUMMARY CARDS ---
function updateSummaryCards(stats) {
    // Pastikan ID di HTML sudah sesuai (lihat instruksi di bawah kode JS ini)
    document.getElementById("summaryTotal").innerText = stats.total_skkd;
    document.getElementById("summaryLaki").innerText = stats.total_laki;
    document.getElementById("summaryPerempuan").innerText = stats.total_perempuan;
    document.getElementById("summaryRata").innerText = stats.rata_rata;
}

// --- RENDER TABEL ---
function renderTable(data, pager) {
    const tbody = document.querySelector("#tbodyLaporan");
    tbody.innerHTML = "";

    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-8 text-center text-slate-400 italic bg-slate-50/50">
                    Tidak ada data laporan pada periode ini.
                </td>
            </tr>
        `;
        return;
    }

    // Hitung nomor urut (pagination aware)
    // Formula: (halaman_skrg - 1) * limit + index + 1
    const startNo = (pager.current_page - 1) * 10 + 1;

    data.forEach((row, index) => {
        const no = startNo + index;
        
        // Format Tanggal (Helper function di bawah)
        const tgl = formatDate(row.tanggal_terbit);

        tbody.innerHTML += `
        <tr class="hover:bg-emerald-50/30 transition-colors border-b border-slate-50 last:border-0 group">
            <td class="px-8 py-6 text-center text-slate-300 font-medium group-hover:text-slate-500 transition-colors">
                ${no}
            </td>
            <td class="px-8 py-6 font-bold text-slate-600 whitespace-nowrap">
                ${tgl}
            </td>
            <td class="px-8 py-6">
                <span class="font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-1 rounded text-xs whitespace-nowrap">
                    ${row.nomor_surat}
                </span>
            </td>
            <td class="px-8 py-6 font-black text-slate-800 uppercase text-xs tracking-wide">
                ${row.nama_pasien}
            </td>
            <td class="px-8 py-6 font-mono tracking-widest text-sm">
                ${row.nik}
            </td>
            <td class="px-8 py-6 text-sm">
                ${row.nama_dokter}
            </td>
            <td class="px-8 py-6 text-right">
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[9px] font-black uppercase tracking-wider shadow-sm">
                    ${row.status}
                </span>
            </td>
        </tr>
        `;
    });
}

// --- RENDER PAGINATION ---
function renderPagination(pager) {
    const infoContainer = document.querySelector("#paginationInfo");
    const navContainer = document.querySelector("#paginationNav");

    if (!infoContainer || !navContainer) return;

    // Info Text: "Total Data: 124 Rekaman"
    infoContainer.innerHTML = `Total Data: <span class="text-emerald-950 font-black">${pager.total_items} Rekaman</span>`;

    // Tombol Navigasi
    navContainer.innerHTML = "";
    
    // Logic simple untuk pagination: Tampilkan semua page (bisa di-improve kalau pagenya ratusan)
    for (let i = 1; i <= pager.total_pages; i++) {
        navContainer.innerHTML += `
            <button onclick="goPage(${i})"
                class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-bold transition-all
                ${i === pager.current_page 
                    ? 'bg-emerald-950 text-white shadow-lg shadow-emerald-950/20' 
                    : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-700'}">
                ${i}
            </button>
        `;
    }
}

// Function Navigasi Halaman
function goPage(page) {
    currentPage = page;
    loadLaporan();
}

// --- HELPER: FORMAT TANGGAL ---
function formatDate(dateString) {
    if (!dateString) return "-";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).format(date);
}