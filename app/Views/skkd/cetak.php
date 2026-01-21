<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Kesehatan - <?= $d['nama_lengkap'] ?></title>
    <style>
        /* CSS ASLI TETAP DIJAGA */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        .container {
            width: 210mm;
            height: 297mm;
            padding: 10mm 15mm;
            margin: 10px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            border-bottom: 4px double black;
            padding-bottom: 8px;
            margin-bottom: 15px;
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

        .title-section {
            text-align: center;
            margin-bottom: 12px;
        }

        .title-section h4 {
            font-size: 13pt;
            text-decoration: underline;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }

        .title-section p {
            margin: 0;
            font-weight: bold;
            font-size: 11pt;
        }

        .content {
            font-size: 11pt;
            line-height: 1.4;
            text-align: justify;
        }

        .data-table {
            width: 100%;
            margin: 8px 0;
            border-collapse: collapse;
        }

        .data-table td {
            vertical-align: top;
            padding: 1.5px 0;
        }

        .label {
            width: 140px;
        }

        .separator {
            width: 15px;
        }

        .results-container {
            margin: 8px 0;
            display: flex;
            flex-wrap: wrap;
        }

        .result-item {
            width: 50%;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
        }

        .checkbox-rect {
            width: 30px;
            height: 12px;
            border: 2px solid black;
            display: inline-block;
            margin-right: 8px;
        }

        .indent-tab {
            margin-left: 1.2cm;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .indent-tab p {
            margin: 4px 0;
        }

        .physical-stats {
            margin-top: 10px;
            width: 60%;
        }

        .signature-section {
            position: absolute;
            bottom: 40mm;
            right: 15mm;
            width: 220px;
            text-align: left;
        }

        .signature-section p {
            margin: 2px 0;
        }

        .footer-note {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            font-size: 9pt;
            font-style: italic;
        }

        @media print {
            body {
                background-color: white;
            }

            .container {
                margin: 0;
                box-shadow: none;
                border: none;
            }

            .no-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            /* Warna Abu-abu Elegan */
            background: #475569;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);

            /* Layout Icon dan Teks */
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            background: #334155;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-print:active {
            transform: translateY(0);
        }

        .btn-print svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }
    </style>
</head>

<body>

    <button class="btn-print no-print" onclick="window.print()">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6 14h12v8H6v-8z" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span>Cetak Halaman</span>
    </button>

    <div class="container">
        <div class="header">
            <div class="logo-left" style="width: 100px; height: 85px;">
                <img src="<?= base_url('assets/images/logo-jpr.png') ?>"
                    alt="Logo Jayapura"
                    style="width: 100%; height: 100%; object-fit: fill;"
                    onerror="this.style.display='none'">
            </div>

            <div class="header-text">
                <h1>Pemerintah Kota Jayapura</h1>
                <h2>Dinas Kesehatan</h2>
                <h3>Puskesmas Elly Uyo</h3>
                <p>Jl. Ardipura III Polimak, Distrik Jayapura Selatan</p>
                <p>KOTA JAYAPURA - PAPUA</p>
                <p>Kode Pos 992234, No. Tlp (0967)532364 / HP 082197581196, Email: puskesmasellyuyo@gmail.com</p>
            </div>

            <div class="logo-right">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Kemeskes" onerror="this.style.display='none'">
            </div>
        </div>

        <div class="title-section">
            <h4>SURAT KETERANGAN KESEHATAN</h4>
            <p>NO. <?= $d['nomor_surat'] ?></p>
        </div>

        <div class="content">
            <p style="margin-bottom: 5px;">Dokter Penguji Kesehatan di Puskesmas Elly Uyo, dengan mengingat sumpah/janji yang telah diucapkan pada waktu menerima jabatan menerangkan bahwa :</p>

            <table class="data-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="separator">:</td>
                    <td style="text-transform: uppercase;"><?= $d['nama_lengkap'] ?></td>
                </tr>
                <tr>
                    <td class="label">NIK</td>
                    <td class="separator">:</td>
                    <td><?= $d['nik'] ?></td>
                </tr>
                <tr>
                    <td class="label">Tempat/Tgl Lahir</td>
                    <td class="separator">:</td>
                    <td><?= strtoupper($d['tempat_lahir']) ?>, <?= strtoupper(date('d F Y', strtotime($d['tanggal_lahir']))) ?></td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="separator">:</td>
                    <td><?= strtoupper($d['pekerjaan'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="separator">:</td>
                    <td><?= strtoupper($d['alamat']) ?></td>
                </tr>
            </table>

            <p style="margin: 5px 0;">Telah diperiksa dengan teliti atas permintaan <i style="font-weight: bold;">SENDIRI</i></p>
            <p style="margin: 5px 0;">Tanggal : <?= strtoupper(date('d F Y', strtotime($d['tgl_terbit']))) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nomor : -</p>

            <p style="margin: 5px 0;">Dan berdasarkan hasil :</p>
            <div class="results-container">
                <div class="result-item"><span class="checkbox-rect"></span> Anamnesa/Wawancara</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Fisik/Badan</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Laboratorium</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan THT</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Tambahan</div>
            </div>

            <div class="indent-tab">
                <p>* Yang bersangkutan dinyatakan : <strong>SEHAT</strong> / <strong>TIDAK SEHAT</strong></p>
                <p>Memenuhi persyaratan untuk : <strong style="font-style: italic;">" <?= strtoupper($d['keperluan_surat']) ?> "</strong></p>
            </div>

            <p style="margin: 5px 0;">Demikian Surat Kesehatan ini dipergunakan sebagaimana mestinya.</p>

            <table class="data-table physical-stats">
                <tr>
                    <td style="width: 130px;">Buta Warna</td>
                    <td style="width: 15px;">:</td>
                    <td>Ya / Tidak</td>
                </tr>
                <tr>
                    <td>Mata</td>
                    <td>:</td>
                    <td>Normal / Tidak Normal</td>
                </tr>
                <tr>
                    <td>Tinggi Badan</td>
                    <td>:</td>
                    <td><?= $d['tinggi_badan'] ?> Cm</td>
                </tr>
                <tr>
                    <td>Berat Badan</td>
                    <td>:</td>
                    <td><?= $d['berat_badan'] ?> Kg</td>
                </tr>
                <tr>
                    <td>Golongan Darah</td>
                    <td>:</td>
                    <td style="display: flex; align-items: center; gap: 5px;">
                        <?php
                        $list_golongan = ['A', 'B', 'AB', 'O'];
                        foreach ($list_golongan as $index => $goldar) :
                            $is_selected = (strtoupper($d['golongan_darah']) == $goldar);
                        ?>
                            <span style="
                display: inline-block;
                width: 22px;
                height: 22px;
                line-height: 20px; /* Sedikit dikurangi agar pas di tengah */
                text-align: center;
                border: <?= $is_selected ? '1.5px solid black' : 'none' ?>;
                border-radius: 50%;
                font-weight: <?= $is_selected ? 'bold' : 'normal' ?>;
                box-sizing: border-box;
            ">
                                <?= $goldar ?>
                            </span>

                            <?php if ($index < count($list_golongan) - 1) : ?>
                                <span style="margin: 0 2px;">/</span>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </td>
                </tr>

                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td><?= $d['tekanan_darah'] ?> MmHg</td>
                </tr>
            </table>

            <div class="signature-section">
                <p>Dikeluarkan di : Jayapura</p>
                <p>Pada Tanggal : <?= date('d F Y', strtotime($d['tgl_terbit'])) ?></p>
                <p>Dokter Yang Memeriksa,</p>
                <br><br><br>
                <p><strong><?= $d['nama_dokter'] ?></strong></p>
                <p><?= $d['nomor_identitas'] ?></p>
            </div>

            <div class="footer-note">
                * Coret yang tidak perlu
            </div>
        </div>
    </div>

</body>
<script>
    window.onafterprint = function() {
        setTimeout(function() {
            window.close();
        }, 500);
    };
</script>

</html>