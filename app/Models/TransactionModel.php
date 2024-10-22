<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city_id', 'indicator_id', 'year_2019', 'year_2020', 'created_at', 'updated_at'];
}
