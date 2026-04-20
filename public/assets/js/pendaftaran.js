document.addEventListener("DOMContentLoaded", () => {
  // Set Tanggal Hari Ini secara otomatis
  const dateInput = document.getElementById("inputTanggal");
  if (dateInput) {
    dateInput.value = new Date().toISOString().split("T")[0];
  }
});

/* ============================
   LOGIKA MODAL & UI
   ============================ */

function openSearchModal() {
  const modal = document.getElementById("modalCariPasien");
  modal.classList.remove("hidden");
  modal.classList.add("flex"); // Pastikan flex agar centered
  // Reset input pencarian
  document.getElementById("searchNama").value = "";
  document.getElementById("searchNIK").value = "";
  document.getElementById("searchResultArea").classList.add("hidden");
}

function closeSearchModal() {
  const modal = document.getElementById("modalCariPasien");
  modal.classList.add("hidden");
  modal.classList.remove("flex");
}

/* ============================
   LOGIKA PENCARIAN PASIEN
   ============================ */

/* ============================
   LOGIKA PENCARIAN PASIEN (FIXED)
   ============================ */
function doSearch() {
  const nama = document.getElementById("searchNama").value;
  const nik = document.getElementById("searchNIK").value;
  const keyword = nama || nik;

  if (!keyword) {
    alert("Masukkan Nama atau NIK terlebih dahulu");
    return;
  }

  const area = document.getElementById("searchResultArea");
  const tbody = document.querySelector("#searchResultArea tbody");

  // Tampilkan loading & area tabel
  area.classList.remove("hidden");
  tbody.innerHTML =
    '<tr><td colspan="3" class="p-4 text-center text-emerald-600 font-bold animate-pulse">Sedang mencari data...</td></tr>';

  // URL INI SUDAH TERBUKTI BENAR DI CONSOLE LOG KAMU TADI
  fetch(
    `/pendaftaran_skkd/cari-pasien?keyword=${encodeURIComponent(keyword)}`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
    },
  )
    .then((res) => {
      if (!res.ok) throw new Error(res.statusText);
      return res.json();
    })
    .then((data) => {
      tbody.innerHTML = "";

      if (data.length === 0) {
        tbody.innerHTML =
          '<tr><td colspan="3" class="p-4 text-center text-gray-500 italic">Data tidak ditemukan</td></tr>';
        return;
      }

      data.forEach((pasien) => {
        // Kita render baris tabelnya
        tbody.innerHTML += `
                <tr class="hover:bg-emerald-50 transition-colors border-b border-emerald-50 cursor-pointer group" 
                    onclick="selectPasien('${pasien.nama_lengkap}', '${pasien.nik}', '${pasien.id_pasien}')">
                    
                    <td class="px-4 py-3 text-emerald-600 font-bold text-sm bg-emerald-50/50 rounded-l-lg">
                        ${pasien.nik}
                    </td>
                    
                    <td class="px-4 py-3 text-emerald-900 text-sm">
                        ${pasien.nama_lengkap}
                    </td>
                    
                    <td class="px-4 py-3 text-right rounded-r-lg">
                        <button type="button" class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg font-bold hover:bg-emerald-600 hover:text-white transition-all text-[10px] uppercase tracking-wider shadow-sm group-hover:shadow-md">
                            Pilih
                        </button>
                    </td>
                </tr>
            `;
      });
    })
    .catch((err) => {
      console.error("Error:", err);
      tbody.innerHTML =
        '<tr><td colspan="3" class="p-4 text-center text-red-500 text-xs">Gagal memuat data. Cek Console.</td></tr>';
    });
}

// Pastikan fungsi ini tetap ada untuk menangani klik "Pilih"
function selectPasien(nama, nik, id) {
  document.getElementById("displayPasien").value = `${nik} - ${nama}`;
  document.getElementById("selectedPasienId").value = id;
  closeSearchModal(); // Tutup modal setelah memilih
}

function selectPasien(nama, nik, id) {
  document.getElementById("displayPasien").value = `${nik} - ${nama}`;
  document.getElementById("selectedPasienId").value = id; // ID Database untuk disimpan
  closeSearchModal();
}

/* ============================
   LOGIKA KONFIRMASI & SIMPAN
   ============================ */

function openConfirmation() {
  // 1. Ambil Value
  const idPasien = document.getElementById("selectedPasienId").value;
  const idDokter = document.getElementById("inputDokter").value;
  const keperluan = document.getElementById("inputKeperluan").value;

  // Validasi Sederhana
  if (!idPasien) {
    alert("Harap pilih pasien terlebih dahulu!");
    return;
  }
  if (!idDokter) {
    alert("Harap pilih dokter pemeriksa!");
    return;
  }
  if (!keperluan) {
    alert("Harap isi keperluan surat!");
    return;
  }

  // 2. Isi Modal Konfirmasi
  const pasienText = document.getElementById("displayPasien").value;
  const dokterText =
    document.getElementById("inputDokter").options[
      document.getElementById("inputDokter").selectedIndex
    ].text;
  const tinggi = document.getElementById("inputTinggi").value || "-";
  const berat = document.getElementById("inputBerat").value || "-";
  const tensi = document.getElementById("inputTensi").value || "-";

  // Ambil Radio Button Golongan Darah
  const goldarEl = document.querySelector('input[name="goldar"]:checked');
  const goldar = goldarEl ? goldarEl.value : "-";

  document.getElementById("summaryPasien").innerText = pasienText;
  document.getElementById("summaryDokter").innerText = dokterText;
  document.getElementById("summaryFisik").innerText =
    `TB: ${tinggi} cm / BB: ${berat} kg`;
  document.getElementById("summaryKesehatan").innerText =
    `Goldar: ${goldar} | Tensi: ${tensi}`;
  document.getElementById("summaryKeperluan").innerText = keperluan;

  // 3. Tampilkan Modal
  const modal = document.getElementById("modalKonfirmasi");
  modal.classList.remove("hidden");
  modal.classList.add("flex");
}

function closeConfirmation() {
  const modal = document.getElementById("modalKonfirmasi");
  modal.classList.add("hidden");
  modal.classList.remove("flex");
}

/* ============================
   FUNGSI SIMPAN KE DATABASE
   ============================ */
function saveData() {
  const btnSimpan = document.querySelector(
    '#modalKonfirmasi button[onclick="saveData()"]',
  );
  const originalText = btnSimpan.innerText;
  btnSimpan.innerText = "Menyimpan...";
  btnSimpan.disabled = true;

  // Siapkan FormData
  const formData = new FormData();
  formData.append(
    "id_pasien",
    document.getElementById("selectedPasienId").value,
  );
  formData.append("id_dokter", document.getElementById("inputDokter").value);
  formData.append(
    "tanggal_periksa",
    document.getElementById("inputTanggal").value,
  );
  formData.append("tinggi_badan", document.getElementById("inputTinggi").value);
  formData.append("berat_badan", document.getElementById("inputBerat").value);
  formData.append("tekanan_darah", document.getElementById("inputTensi").value);
  formData.append(
    "keperluan_surat",
    document.getElementById("inputKeperluan").value,
  );

  const goldarEl = document.querySelector('input[name="goldar"]:checked');
  if (goldarEl) formData.append("goldar", goldarEl.value);

  // UPDATE URL CONTROLLER DI SINI
  fetch("/pendaftaran_skkd/store", {
    method: "POST",
    body: formData,
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then((res) => {
      if (res.status) {
        alert("Sukses! " + res.message);
        // Refresh ke halaman utama controller
        window.location.href = "/pendaftaran_skkd";
      } else {
        let msg = "Gagal menyimpan:\n";
        if (res.errors) {
          for (const [key, value] of Object.entries(res.errors)) {
            msg += `- ${value}\n`;
          }
        } else {
          msg += res.message;
        }
        alert(msg);
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Terjadi kesalahan sistem.");
    })
    .finally(() => {
      btnSimpan.innerText = originalText;
      btnSimpan.disabled = false;
      closeConfirmation();
    });
}
