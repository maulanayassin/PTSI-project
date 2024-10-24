<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city_name', 'indicator_id', 'goal', 'year_2019', 'year_2020', 'city_id'];

    protected $validationRules = [
        'city_name' => 'required|min_length[3]',
        'indicator_id' => 'required',
        'goal' => 'required',
    ];

    protected $validationMessages = [
        'city_name' => [
            'required' => 'Nama kota wajib diisi.',
            'min_length' => 'Nama kota minimal 3 karakter.'
        ],
        'indicator_id' => [
            'required' => 'No indikator wajib diisi.'
        ],
        'goal' => [
            'required' => 'Goal wajib diisi.'
        ]
    ];
}
