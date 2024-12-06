<?php

namespace App\Models;

use CodeIgniter\Model;

class AchievementModel extends Model
{
    protected $table      = 'achievement'; // Nama tabel yang digunakan
    protected $primaryKey = 'id'; // Primary key tabel (sesuaikan jika berbeda)
    protected $allowedFields = ['city_name', 'rating', 'champion_grade']; // Kolom yang dapat diambil

    public function getAchievements($filters = [])
    {
        // Filter berdasarkan parameter yang diterima
        $builder = $this->builder();

        if (!empty($filters['region'])) {
            $builder->where('region', $filters['region']); // filter berdasarkan wilayah
        }

        if (!empty($filters['year'])) {
            $builder->where('year', $filters['year']); // filter berdasarkan tahun
        }

        if (!empty($filters['city_name'])) {
            $builder->like('city_name', $filters['city_name']); // filter pencarian berdasarkan nama kota
        }

        // Mengurutkan berdasarkan rating secara menurun
        $builder->orderBy('rating', 'DESC'); 

        return $builder->get()->getResultArray(); // Mengambil hasil dalam bentuk array
    }
}