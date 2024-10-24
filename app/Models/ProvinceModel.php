<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $table = 'province'; // Change this to your cities table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'province_name', 'kemendagri_code'];
    public function getProvince()
    {
        return $this->findAll();  // Mengambil semua data dari tabel
    }
    // protected $allowedFields = ['province_name'];

    // public function getCityWithProvince()
    // {
    //     return $this->select('city.id, city.city_name, province.province_name')
    //                 ->join('province', 'province.id = city.province_id') // Adjust according to your table structure
    //                 ->findAll();
    // }
}