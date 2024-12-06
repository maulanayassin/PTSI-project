<?php

namespace App\Models;

use CodeIgniter\Model;

class GradingModel extends Model
{
    protected $table = 'grading'; // Ganti dengan nama tabel Anda
    protected $primaryKey = 'id'; // Ganti dengan primary key tabel Anda
    protected $allowedFields = ['year', 'city_name', 'region', 'province_name', 'goal', 'score']; // Kolom yang dapat diisi
}
