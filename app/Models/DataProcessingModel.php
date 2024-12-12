<?php

namespace App\Models;

use CodeIgniter\Model;

class DataProcessingModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','city_name', 'indicator_id', 'goal', 'year', 'city_id'];
}