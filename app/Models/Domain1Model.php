<?php

namespace App\Models;

use CodeIgniter\Model;

// class ProvinceModel extends Model
// {
//     protected $table            = '';
//     protected $primaryKey       = '';
//     protected $useAutoIncrement = true;
//     protected $returnType       = 'array';
//     protected $useSoftDeletes   = false;
//     protected $protectFields    = true;
//     protected $allowedFields    = [];

//     protected bool $allowEmptyInserts = false;
//     protected bool $updateOnlyChanged = true;

//     protected array $casts = [];
//     protected array $castHandlers = [];

//     // Dates
//     protected $useTimestamps = false;
//     protected $dateFormat    = 'datetime';
//     protected $createdField  = 'created_at';
//     protected $updatedField  = 'updated_at';
//     // protected $deletedField  = 'deleted_at';

//     // Validation
//     protected $validationRules      = [];
//     protected $validationMessages   = [];
//     protected $skipValidation       = false;
//     protected $cleanValidationRules = true;

//     // Callbacks
//     protected $allowCallbacks = true;
//     protected $beforeInsert   = [];
//     protected $afterInsert    = [];
//     protected $beforeUpdate   = [];
//     protected $afterUpdate    = [];
//     protected $beforeFind     = [];
//     protected $afterFind      = [];
//     protected $beforeDelete   = [];
//     protected $afterDelete    = [];
// }

class Domain1Model extends Model
{
    protected $table = 'domain1'; // Change this to your cities table name
    protected $primaryKey = 'id';
    // protected $allowedFields = ['province_name'];

    // public function getCityWithProvince()
    // {
    //     return $this->select('city.id, city.city_name, province.province_name')
    //                 ->join('province', 'province.id = city.province_id') // Adjust according to your table structure
    //                 ->findAll();
    // }
}