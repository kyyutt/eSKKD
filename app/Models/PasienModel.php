<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id_pasien';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'alamat', 'created_by', 'updated_by'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
