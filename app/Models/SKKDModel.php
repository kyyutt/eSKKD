<?php

namespace App\Models;

use CodeIgniter\Model;

class SKKDModel extends Model
{
    protected $table            = 'skkd';
    protected $primaryKey       = 'id_skkd';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nomor_surat','id_pendaftaran', 'created_by', 'updated_by'];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getLastUrutan()
    {
        return $this->select('nomor_surat')
            ->orderBy('id_skkd', 'DESC')
            ->first();
    }

}
