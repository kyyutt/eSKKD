<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Kesehatan - <?= $d['nama_lengkap'] ?></title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        /* Container disesuaikan ke F4 */
        .container {
            width: 215mm;
            min-height: 330mm;
            /* Pakai min-height agar fleksibel */
            padding: 10mm 25mm 20mm 25mm;
            margin: 10px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
        }

        /* HEADER SECTION */
        .header {
            text-align: center;
            border-bottom: 4px double black;
            padding-bottom: 8px;
            margin-bottom: 15px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-left,
        .logo-right {
            position: absolute;
            top: 0;
            width: 90px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
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
            /* Biar gak gepeng */
        }

        .header-text {
            width: 100%;
            padding: 0 50px;
            box-sizing: border-box;
            text-align: center;
        }

        .header-text h1,
        .header-text h2 {
            font-size: 14pt !important;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            line-height: 1.1;
        }

        .header-text h3 {
            font-size: 18pt !important;
            margin: 2px 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header-text p.address {
            font-size: 11pt !important;
            margin: 0;
        }

        .header-text p.footer-header {
            font-size: 9pt !important;
            margin: 0;
        }

        .title-section {
            text-align: center;
            /* Reset margin agar tidak terlalu turun dari garis kop */
            margin-top: 20px;
            margin-bottom: 35px;
        }

        .title-section h4 {
            font-size: 13pt;
            text-decoration: underline;
            /* Paksa margin top ke 0 agar mepet ke garis kop surat */
            margin: 0;
            text-transform: uppercase;
        }

        .title-section p {
            margin: 0;
            font-size: 11pt;
            line-height: 1.2;
        }

        .content {
            font-size: 12pt;
            line-height: 1.5;
        }

        .data-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 140px;
        }

        .separator {
            width: 15px;
        }

        /* CHECKBOX SECTION */
        .results-container {
            margin: 15px 0;
            display: flex;
            flex-wrap: wrap;
            row-gap: 10px;
        }

        .result-item {
            width: 50%;
            display: flex;
            align-items: center;
        }

        .checkbox-rect {
            width: 35px;
            height: 13px;
            border: 3px solid black;
            border-radius: 2px;
            /* Tebal sesuai permintaan */
            display: inline-block;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .indent-tab {
            margin-left: 1.2cm;
            margin-top: 15px;
        }

        .signature-section {
            margin-top: 40px;
            float: right;
            width: 220px;
            text-align: left;
            /* Teks di dalam blok tetap rata kiri */
            margin-right: 0;
        }

        .signature-section p {
            margin: 0;
            line-height: 1.2;
            /* Dibuat lebih mepet lagi sesuai permintaan */
            font-size: 11pt;
        }

        .signature-name {
            /* Gunakan margin-top untuk memberi ruang tanda tangan */
            margin-top: 60px !important;
            text-decoration: underline;
            text-transform: uppercase;
            display: block;
            /* Memastikan teks nama jadi blok tersendiri */
        }

        .footer-note {
            clear: both;
            padding-top: 50px;
            font-size: 9pt;
            font-style: italic;
        }

        /* Tombol Print */
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
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .request-info {
            margin: 15px 0;
            /* Jarak blok ini dengan teks di atas & bawahnya */
        }

        .request-info p {
            margin: 0;
            /* Melekatkan baris atas dan bawah */
            line-height: 1.4;
            /* Jarak antar baris yang ideal */
            font-size: 11pt;
        }

        @media print {
            body {
                background: white;
                margin: 0;
            }

            .container {
                margin: 0 auto;
                box-shadow: none;
                width: 215mm;
                height: 330mm;
            }

            .no-print,
            .ci_logo,
            .debug-bar,
            .codeigniter-debug-bar,
            #debug-icon,
            #debug-bar,
            .display-errors,
            img[src*="logo-ci"] {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }
    </style>
</head>

<body>

    <button id="tombolCetak" class="btn-print no-print" onclick="window.print()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
            <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z" />
        </svg>
        <span>Cetak Halaman</span>
    </button>

    <div class="container">
        <div class="header">
            <div class="logo-left">
                <img src="<?= base_url('assets/images/logo-jpr.png') ?>" alt="Logo Jayapura">
            </div>
            <div class="header-text">
                <h1>Pemerintah Kota Jayapura</h1>
                <h2>Dinas Kesehatan</h2>
                <h3>UPTD Puskesmas Elly Uyo</h3>
                <p class="address">Jl. Ardipura III Polimak, Distrik Jayapura Selatan</p>
                <p class="address">KOTA JAYAPURA - PAPUA</p>
                <p class="footer-header">Kode Pos 992234, No. Tlp (0967)532364 / HP 082197581196, Email: puskesmasellyuyo@gmail.com</p>
            </div>
            <div class="logo-right">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Kemenkes">
            </div>
        </div>

        <div class="title-section">
            <h4>SURAT KETERANGAN KESEHATAN</h4>
            <p>NO. <?= $d['nomor_surat'] ?></p>
        </div>

        <div class="content">
            <p style="text-indent: 2em; text-align: justify;">Dokter Penguji Kesehatan di Puskesmas Elly Uyo, dengan mengingat sumpah/janji yang telah diucapkan pada waktu menerima jabatan menerangkan bahwa :</p>

            <table class="data-table" style="line-height: 1.2; margin-top: 5px; margin-bottom: 5px;">
                <tr>
                    <td class="label" style="padding: 1px 0;">Nama</td>
                    <td class="separator" style="padding: 1px 0;">:</td>
                    <td style="text-transform: uppercase; padding: 1px 0;"><?= $d['nama_lengkap'] ?></td>
                </tr>
                <tr>
                    <td class="label" style="padding: 1px 0;">NIK</td>
                    <td class="separator" style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= $d['nik'] ?></td>
                </tr>
                <tr>
                    <td class="label" style="padding: 1px 0;">Tempat/Tgl Lahir</td>
                    <td class="separator" style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= strtoupper($d['tempat_lahir']) ?>,
                        <?php
                        $bulan = ['01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'];
                        echo date('d', strtotime($d['tanggal_lahir'])) . ' ' . $bulan[date('m', strtotime($d['tanggal_lahir']))] . ' ' . date('Y', strtotime($d['tanggal_lahir']));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding: 1px 0;">Pekerjaan</td>
                    <td class="separator" style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= strtoupper($d['pekerjaan'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="label" style="padding: 1px 0;">Alamat</td>
                    <td class="separator" style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= strtoupper($d['alamat']) ?></td>
                </tr>
            </table>

            <div class="request-info">
                <p>Telah diperiksa dengan teliti atas permintaan <b><i>SENDIRI</i></b></p>
                <p>
                    <span>Tanggal :
                        <?php
                        $bulan = ['01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'];
                        echo date('d', strtotime($d['tgl_terbit'])) . ' ' . $bulan[date('m', strtotime($d['tgl_terbit']))] . ' ' . date('Y', strtotime($d['tgl_terbit']));
                        ?>
                    </span>
                    <span style="padding-left: 100px;">Nomor : -</span>
                </p>
            </div>

            <p>Dan berdasarkan hasil :</p>
            <div class="results-container">
                <div class="result-item"><span class="checkbox-rect"></span> Anamnesa/Wawancara</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Fisik/Badan</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Laboratorium</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan THT</div>
                <div class="result-item"><span class="checkbox-rect"></span> Pemeriksaan Tambahan</div>
            </div>

            <div class="indent-tab">
                <p>* Yang bersangkutan dinyatakan : <strong>SEHAT / TIDAK SEHAT</strong></p>
                <p>Memenuhi persyaratan untuk : <strong><i>" <?= strtoupper($d['keperluan_surat']) ?> "</i></strong></p>
            </div>

            <p>Demikian Surat Kesehatan ini dipergunakan sebagaimana mestinya.</p>

            <table class="data-table" style="width: 70%; margin-top: 10px; margin-bottom: 5px; line-height: 1.2;">
                <tr>
                    <td style="width: 150px; padding: 1px 0;">Buta Warna</td>
                    <td style="width: 20px; padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;">Ya / Tidak</td>
                </tr>
                <tr>
                    <td style="padding: 1px 0;">Mata</td>
                    <td style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;">Normal / Tidak Normal</td>
                </tr>
                <tr>
                    <td style="padding: 1px 0;">Tinggi Badan</td>
                    <td style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= (int)$d['tinggi_badan'] ?>&nbsp; Cm</td>
                </tr>
                <tr>
                    <td style="padding: 1px 0;">Berat Badan</td>
                    <td style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= (int)$d['berat_badan'] ?>&nbsp;&nbsp;&nbsp; Kg</td>
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
                    <td style="padding: 1px 0;">Tekanan Darah</td>
                    <td style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;"><?= $d['tekanan_darah'] ?> &nbsp; MmHg</td>
                </tr>
                <tr>
                    <td style="padding: 1px 0;">*Keterangan</td>
                    <td style="padding: 1px 0;">:</td>
                    <td style="padding: 1px 0;">&nbsp;</td>
                </tr>
            </table>

            <div class="signature-section">
                <p>Dikeluarkan di : Jayapura</p>
                <p>Pada Tanggal :
                    <?php
                    $bulan_indo = [
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember'
                    ];
                    $tgl_raw = strtotime($d['tgl_terbit']);
                    echo date('d', $tgl_raw) . ' ' . strtoupper($bulan_indo[date('m', $tgl_raw)]) . ' ' . date('Y', $tgl_raw);
                    ?>
                </p>
                <p>Dokter Yang Memeriksa,</p>

                <p class="signature-name"><?= $d['nama_dokter'] ?></p>

                <p><?= $d['nomor_identitas'] ?></p>
            </div>
            <div style="clear: both;"></div>

            <div class="footer-note">
                * Coret yang tidak perlu
            </div>
        </div>
    </div>

    <script>
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 500);
        };
    </script>
</body>

</html>