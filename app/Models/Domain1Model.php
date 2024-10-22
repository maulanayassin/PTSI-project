<?php

namespace App\Models;

use CodeIgniter\Model;

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