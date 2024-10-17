<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table = 'city'; // Change this to your cities table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['city_name', 'province_id'];

    public function getCityWithProvince()
    {
        return $this->select('city.id, city.city_name, city.kemendagri_code, city.bps_code, province.province_name')
                    ->join('province', 'province.kemendagri_code = city.province_id') // Adjust according to your table structure
                    ->findAll();
    }
    public function getProvince()
    {
        return $this->findAll();  // Mengambil semua data dari tabel
    }
}