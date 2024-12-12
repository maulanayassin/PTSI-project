<?php

namespace App\Models;

use CodeIgniter\Model;

class GradingModel extends Model
{
    protected $table = 'grading'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key tabel
    protected $allowedFields = ['year', 'city_name', 'region', 'province_name', 'goal', 'score']; // Kolom yang dapat diisi
    protected $validationRules = [
        'city_name' => 'required|string|max_length[255]',
        'province_name' => 'required|string|max_length[255]',
        'goal' => 'required|integer',
        'score' => 'permit_empty|decimal',
    ];

    /**
     * Mengambil nama kota dan provinsi berdasarkan nama kota
     *
     * @param string $city_name
     * @return array|null
     */
    public function getCityWithProvince($city_name)
    {
        return $this->where('city_name', $city_name)
                    ->select('city_name, province_name')
                    ->get()
                    ->getRowArray();
    }

    /**
     * Mengambil path logo berdasarkan nama provinsi
     *
     * @param string $provinceName
     * @return string
     */
    public function getProvinceLogo($provinceName)
    {
        // Format nama file (huruf kecil dan spasi diganti tanda hubung)
        $fileName = strtolower(str_replace(' ', '-', $provinceName)) . '.png';

        // Path ke direktori logo
        $logoPath = "dist/img/provinces/{$fileName}";

        // Periksa apakah file ada
        if (file_exists(FCPATH . $logoPath)) {
            return base_url($logoPath);
        }

        // Jika file tidak ditemukan, gunakan logo default
        return base_url('dist/img/provinces/default.png');
    }
}
