<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $table = 'achievement'; // Tabel achievement
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'city_name', 'region', 'domain1', 'domain2', 'domain3a', 'domain3b', 'rating', 'champion_grade'];

    public function getAchievementData()
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('year, city_name, region, domain1, domain2, domain3a, domain3b, rating, champion_grade');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
