<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city_name', 'indicator_id', 'goal', 'year_2019', 'year_2020', 'city_id'];
}
