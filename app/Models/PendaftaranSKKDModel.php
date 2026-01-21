<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranSKKDModel extends Model
{
    protected $table            = 'pendaftaran_skkd';
    protected $primaryKey       = 'id_pendaftaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tanggal_periksa','tinggi_badan','berat_badan','golongan_darah','tekanan_darah','keperluan_surat','id_pasien','id_dokter', 'created_by', 'updated_by', 'status'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

}
