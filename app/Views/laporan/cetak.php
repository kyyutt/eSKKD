<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Cetak Laporan' ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 15mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            color: #000;
        }

        /* CONTAINER UTAMA */
        .container {
            width: 297mm;
            /* Lebar A4 Landscape */
            min-height: 210mm;
            padding: 10mm 15mm;
            margin: 10px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
        }

        /* --- HEADER (KOP SURAT) --- */
        .header {
            text-align: center;
            border-bottom: 4px double black;
            padding-bottom: 8px;
            margin-bottom: 20px;
            position: relative;
            min-height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-left,
        .logo-right {
            position: absolute;
            top: 0;
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .logo-left {
            left: 0;
        }

        .logo-right {
            right: 0;
        }

        .logo-left img,
        .logo-right img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .header-text {
            width: 100%;
            padding: 0 90px;
            /* Memberi ruang agar tidak menabrak logo */
            box-sizing: border-box;
        }

        .header h1 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header h2 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header h3 {
            font-size: 13pt;
            margin: 1px 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header p {
            font-size: 9pt;
            margin: 1px 0;
            line-height: 1.1;
            white-space: nowrap;
        }

        /* --- JUDUL LAPORAN --- */
        .title-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .title-section h4 {
            font-size: 14pt;
            text-decoration: underline;
            margin: 5px 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .title-section p {
            margin: 2px 0;
            font-size: 11pt;
        }

        /* --- TABEL DATA --- */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-bottom: 20px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid black;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .report-table th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        .report-table td {
            text-align: left;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        /* --- SUMMARY BOX (STATISTIK) --- */
        .summary-box {
            margin-bottom: 15px;
            border: 1px solid black;
            padding: 10px;
            display: inline-block;
            font-size: 10pt;
        }

        /* --- SIGNATURE (TTD) --- */
        .signature-section {
            float: right;
            width: 250px;
            text-align: left;
            /* Rata kiri di dalam box kanan */
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-section p {
            margin: 4px 0;
            font-size: 11pt;
        }

        /* --- TOMBOL PRINT (HIDDEN SAAT PRINT) --- */
        @media print {
            body {
                background-color: white;
            }

            .container {
                margin: 0;
                box-shadow: none;
                border: none;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            /* Paksa background color (untuk header tabel) tercetak */
            .report-table th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #475569;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            z-index: 100;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-print:hover {
            background: #334155;
        }
    </style>
</head>

<body>

    <button class="btn-print no-print" onclick="window.print()">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        <span>Cetak Laporan</span>
    </button>

    <div class="container">
        <div class="header">
            <div class="logo-left">
                <img src="<?= base_url('assets/images/logo-jpr.png') ?>" alt="Logo Jayapura" onerror="this.style.display='none'">
            </div>

            <div class="header-text">
                <h1>Pemerintah Kota Jayapura</h1>
                <h2>Dinas Kesehatan</h2>
                <h3>Puskesmas Elly Uyo</h3>
                <p>Jl. Ardipura III Polimak, Distrik Jayapura Selatan</p>
                <p>KOTA JAYAPURA - PAPUA</p>
                <p>Kode Pos 992234, Tlp (0967)532364 / HP 082197581196, Email: puskesmasellyuyo@gmail.com</p>
            </div>

            <div class="logo-right">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Kemenkes" onerror="this.style.display='none'">
            </div>
        </div>

        <div class="title-section">
            <h4>LAPORAN REKAPITULASI PENERBITAN SURAT KETERANGAN KESEHATAN</h4>
            <?php if (!empty($periode['start']) && !empty($periode['end'])) : ?>
                <p>Periode: <?= date('d F Y', strtotime($periode['start'])) ?> s/d <?= date('d F Y', strtotime($periode['end'])) ?></p>
            <?php else : ?>
                <p>Periode: Seluruh Data</p>
            <?php endif; ?>
        </div>

        <div class="summary-box">
            <strong>Ringkasan Data:</strong><br>
            Total SKKD Terbit: <?= $statistik['total_skkd'] ?> dokumen.<br>
            Laki-laki: <?= $statistik['total_laki'] ?> | Perempuan: <?= $statistik['total_perempuan'] ?>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 18%;">No. SKKD</th>
                    <th style="width: 20%;">Nama Pasien</th>
                    <th style="width: 15%;">NIK</th>
                    <th style="width: 10%;">L/P</th>
                    <th style="width: 20%;">Dokter Pemeriksa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data_skkd)) : ?>
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 20px;">
                            <i>Tidak ada data pada periode ini.</i>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1;
                    foreach ($data_skkd as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_terbit'])) ?></td>
                            <td><?= $row['nomor_surat'] ?></td>
                            <td style="text-transform: uppercase;">
                                <strong><?= $row['nama_pasien'] ?></strong>
                            </td>
                            <td class="text-center"><?= $row['nik'] ?></td>
                            <td class="text-center">
                                <?= ($row['jenis_kelamin'] == 'L' || $row['jenis_kelamin'] == 'Laki-laki') ? 'L' : 'P' ?>
                            </td>
                            <td><?= $row['nama_dokter'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="signature-section">
            <p>Dikeluarkan di : Jayapura</p>
            <p>Pada Tanggal : <?= date('d F Y') ?></p>
            <br>
            <p>Kepala Puskesmas Elly Uyo,</p>
            <br><br><br><br>
            <p style="text-decoration: underline; font-weight: bold;">( .................................................. )</p>
            <p>NIP. ..........................................</p>
        </div>

        <div style="clear: both;"></div>
    </div>

</body>

<script>
    window.onafterprint = function() {

    };
</script>

</html>