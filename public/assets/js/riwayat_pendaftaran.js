/* ==========================================================================
   GLOBAL STATE
   ========================================================================== */
let currentPage = 1;
let currentLimit = 10;
let currentSearch = "";
let selectedId = null; // Menyimpan ID saat Edit/Hapus

/* ==========================================================================
   1. INIT & EVENT LISTENER
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
  // Load data pertama kali
  loadPendaftaran();

  // ----------------------------------------------------------------------
  // A. HANDLE SEARCH (PENCARIAN)
  // ----------------------------------------------------------------------
  const searchInput = document.querySelector("#searchPendaftaran");
  if (searchInput) {
    searchInput.addEventListener(
      "keyup",
      debounce((e) => {
        currentSearch = e.target.value;
        currentPage = 1;
        loadPendaftaran();
      }, 400),
    );
  }

  // ----------------------------------------------------------------------
  // B. HANDLE LIMIT (JUMLAH BARIS)
  // ----------------------------------------------------------------------
  const limitSelect = document.querySelector("#limitPendaftaran");
  if (limitSelect) {
    limitSelect.addEventListener("change", (e) => {
      currentLimit = e.target.value;
      currentPage = 1;
      loadPendaftaran();
    });
  }

  // ----------------------------------------------------------------------
  // C. HANDLE FORM SUBMIT (EDIT DATA)
  // (Form Tambah DIHILANGKAN sesuai request)
  // ----------------------------------------------------------------------
  const formEdit = document.querySelector("#formEditPendaftaran");
  if (formEdit) {
    formEdit.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      // URL Update mengarah ke Controller RiwayatPendaftaran
      fetch(`/riwayat_skkd/update/${selectedId}`, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalEditPendaftaran"); // Tutup modal
            loadPendaftaran(); // Refresh tabel
            alert("Data pendaftaran berhasil diperbarui!");
          } else {
            alert(res.message || "Gagal mengupdate data.");
          }
        })
        .catch((err) => console.error("Error update:", err));
    });
  }
});

/* ==========================================================================
   2. GLOBAL FUNCTIONS
   ========================================================================== */

// --- MODAL HANDLER ---
function toggleModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) {
    console.error(`Modal dengan ID '${modalId}' tidak ditemukan.`);
    return;
  }

  if (modal.classList.contains("hidden")) {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  } else {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }
}

// --- LOAD DATA (AJAX) ---
function loadPendaftaran() {
  // URL List mengarah ke Controller RiwayatPendaftaran
  fetch(
    `/riwayat_skkd/ajaxList?page=${currentPage}&limit=${currentLimit}&search=${encodeURIComponent(
      currentSearch,
    )}`,
  )
    .then((res) => res.json())
    .then((res) => {
      renderTable(res.data, res.pagination);
      renderPagination(res.pagination);
    })
    .catch((err) => console.error("Error loadPendaftaran:", err));
}

// --- RENDER TABEL ---
function renderTable(data, pagination) {
  const tbody = document.querySelector("#tbodyPendaftaran");
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-8 text-center text-slate-400 italic bg-slate-50/50 rounded-lg">
                    Data riwayat tidak ditemukan
                </td>
            </tr>
        `;
    return;
  }

  function renderAdminAction(row) {
    // 1. Ambil status, jika null default ke string kosong
    // 2. Kecilkan semua hurufnya (.toLowerCase)
    // 3. Buang spasi yang tidak sengaja terbawa (.trim)
    const status = row.status ? row.status.toLowerCase().trim() : "";

    // Bandingkan dengan huruf kecil semua
    if (status === "menunggu") {
        return `
            <button onclick="verifikasiPendaftaran(${row.id_pendaftaran})" 
                class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-lg transition-all" title="Verifikasi Kehadiran">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>`;
    }

    // Jika status adalah 'terverifikasi' atau 'selesai', kembalikan string kosong
    return "";
}

  // 2. Loop Data Anda
  data.forEach((row, index) => {
    console.log(row);
    const no = pagination.from + index;
    const tglPeriksa = formatDate(row.tanggal_periksa);

    tbody.innerHTML += `
      <tr class="hover:bg-emerald-50/40 transition-colors group border-b border-slate-50 last:border-0">
        <td class="px-6 py-4 text-center text-slate-500 font-medium text-xs">
          ${no}
        </td>
        
        <td class="px-6 py-4">
          <div class="flex flex-col">
            <span class="text-xs font-mono text-emerald-600 font-bold">${row.nik}</span>
            <span class="text-sm font-semibold text-slate-700 capitalize">${row.nama_pasien}</span>
          </div>
        </td>

        <td class="px-6 py-4">
          <div class="flex flex-col">
            <span class="text-xs text-slate-500 font-medium">Dokter:</span>
            <span class="text-sm text-slate-700 font-bold">${row.nama_dokter || '<span class="italic text-slate-400">Belum dipilih</span>'}</span>
          </div>
        </td>
        
        <td class="px-6 py-4">
          <div class="text-sm text-slate-600">
            ${tglPeriksa}
          </div>
        </td>

         <td class="px-6 py-4">
          <span class="inline-flex px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded border border-blue-100 font-medium capitalize">
            ${row.keperluan_surat}
          </span>
        </td>
        <td class="px-6 py-4">
          <span class="inline-flex px-2 py-1 ${row.status === "Menunggu" ? "bg-yellow-50 text-yellow-600" : row.status === "Terverifikasi" ? "bg-blue-50 text-blue-600" : row.status === "Selesai" ? "bg-green-50 text-green-600" : "bg-slate-50 text-slate-600"} text-xs rounded border ${row.status === "Menunggu" ? "border-yellow-100" : row.status === "Terverifikasi" ? "border-blue-100" : row.status === "Selesai" ? "border-green-100" : "border-slate-100"} font-medium capitalize">
            ${row.status}
          </span>
        </td>
        <td class="px-8 py-6 text-right whitespace-nowrap">
          <div class="flex justify-end items-center space-x-2">
            
            ${role === "Admin" ? renderAdminAction(row) : ""}

            <button onclick="detailPendaftaran(${row.id_pendaftaran})" 
              class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Detail">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>

            <button onclick="editPendaftaran(${row.id_pendaftaran})" 
              class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-lg transition-all" title="Edit Data Fisik">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </button>

            <button onclick="hapusPendaftaran(${row.id_pendaftaran})" 
              class="p-2 text-red-500 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all" title="Hapus">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
          </div>
        </td>
      </tr>
      `;
  });
}

// --- PAGINATION ---
function renderPagination(p) {
  const info = document.querySelector(".pagination-info");
  const nav = document.querySelector(".pagination-nav");

  if (!info || !nav) return;

  info.innerHTML = `Menampilkan <span class="text-emerald-950 font-black">${p.from} - ${p.to}</span> dari <span class="text-emerald-950 font-black">${p.total}</span> data`;
  nav.innerHTML = "";

  for (let i = 1; i <= p.total_page; i++) {
    nav.innerHTML += `
            <button onclick="goPage(${i})"
                class="w-8 h-8 rounded-lg ${
                  i === p.page
                    ? "bg-emerald-950 text-white shadow-lg shadow-emerald-900/20"
                    : "text-slate-500 hover:bg-emerald-50"
                } text-xs font-bold transition-all">
                ${i}
            </button>
        `;
  }
}

function goPage(page) {
  currentPage = page;
  loadPendaftaran();
}

// --- FITUR: DETAIL PENDAFTARAN ---
function detailPendaftaran(id) {
  fetch(`/riwayat_skkd/show/${id}`)
    .then((res) => res.json())
    .then((data) => {
      // Map data ke Element HTML di Modal Detail
      document.getElementById("detail_nama_pasien").innerText =
        data.nama_pasien || "-";
      document.getElementById("detail_nik").innerText = data.nik || "-";
      document.getElementById("detail_dokter").innerText =
        data.nama_dokter || "-";
      document.getElementById("detail_tgl").innerText = formatDate(
        data.tanggal_periksa,
      );
      document.getElementById("detail_keperluan").innerText =
        data.keperluan_surat || "-";

      // Data Fisik
      document.getElementById("detail_tb").innerText = data.tinggi_badan
        ? data.tinggi_badan + " cm"
        : "-";
      document.getElementById("detail_bb").innerText = data.berat_badan
        ? data.berat_badan + " kg"
        : "-";
      document.getElementById("detail_td").innerText = data.tekanan_darah
        ? data.tekanan_darah + " mmHg"
        : "-";
      document.getElementById("detail_gd").innerText =
        data.golongan_darah || "-";

      const elStatus = document.getElementById("detail_status");
      if (elStatus) {
        elStatus.innerText = data.status || "-";
        elStatus.className = "";
        if (data.status === "Menunggu") {
          elStatus.classList.add(
            "inline-flex",
            "px-2",
            "py-1",
            "bg-yellow-50",
            "text-yellow-600",
            "text-xs",
            "rounded",
            "border",
            "border-yellow-100",
            "font-medium",
            "capitalize",
          );
        } else if (data.status === "Terverifikasi") {
          elStatus.classList.add(
            "inline-flex",
            "px-2",
            "py-1",
            "bg-blue-50",
            "text-blue-600",
            "text-xs",
            "rounded",
            "border",
            "border-blue-100",
            "font-medium",
            "capitalize",
          );
        } else if (data.status === "completed") {
          elStatus.classList.add(
            "inline-flex",
            "px-2",
            "py-1",
            "bg-green-50",
            "text-green-600",
            "text-xs",
            "rounded",
            "border",
            "border-green-100",
            "font-medium",
            "capitalize",
          );
        } else {
          elStatus.classList.add(
            "inline-flex",
            "px-2",
            "py-1",
            "bg-slate-50",
            "text-slate-600",
            "text-xs",
            "rounded",
            "border",
            "border-slate-100",
            "font-medium",
            "capitalize",
          );
        }
      }

      // Audit Trail
      const elCreatedBy = document.getElementById("detail_created_by");
      const elUpdatedBy = document.getElementById("detail_updated_by");

      if (elCreatedBy)
        elCreatedBy.innerText = data.nama_pembuat
          ? `${data.nama_pembuat} (${formatDate(data.created_at)})`
          : "-";
      if (elUpdatedBy)
        elUpdatedBy.innerText = data.nama_pengedit
          ? `${data.nama_pengedit} (${formatDate(data.updated_at)})`
          : "-";

      toggleModal("modalDetailPendaftaran");
    })
    .catch((err) => console.error("Error detail:", err));
}

// --- FITUR: EDIT PENDAFTARAN ---
function editPendaftaran(id) {
  fetch(`/riwayat_skkd/show/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id;
      const form = document.querySelector("#formEditPendaftaran");

      if (form) {
        // Isi Form input
        form.elements["id_dokter"].value = data.id_dokter;
        form.elements["tinggi_badan"].value = data.tinggi_badan;
        form.elements["berat_badan"].value = data.berat_badan;
        form.elements["tekanan_darah"].value = data.tekanan_darah;
        form.elements["golongan_darah"].value = data.golongan_darah;
        form.elements["keperluan_surat"].value = data.keperluan_surat;
      }
      toggleModal("modalEditPendaftaran");
    })
    .catch((err) => console.error("Error edit:", err));
}

// --- FITUR: HAPUS PENDAFTARAN ---
function hapusPendaftaran(id) {
  selectedId = id;
  toggleModal("modalHapusPendaftaran");
}

function confirmDelete() {
  fetch(`/riwayat_skkd/delete/${selectedId}`, {
    method: "DELETE",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then((res) => {
      toggleModal("modalHapusPendaftaran");
      loadPendaftaran();
      alert(res.message || "Data berhasil dihapus");
    })
    .catch((err) => console.error("Error delete:", err));
}

function verifikasiPendaftaran(id) {
  selectedId = id;
  toggleModal("modalVerifikasiPendaftaran");
}

function confirmVerifikasi() {
  fetch(`/riwayat_skkd/update_status/${selectedId}?status=Terverifikasi`, {
    method: "POST",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then((res) => {
      toggleModal("modalVerifikasiPendaftaran");
      loadPendaftaran();
      alert(res.message || "Data berhasil diverifikasi");
    })
    .catch((err) => console.error("Error verifikasi:", err));
}

// --- UTILITIES ---
function formatDate(dateString) {
  if (!dateString) return "-";
  const options = { day: "numeric", month: "long", year: "numeric" };
  return new Date(dateString).toLocaleDateString("id-ID", options);
}

function debounce(func, timeout = 300) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      func.apply(this, args);
    }, timeout);
  };
}
