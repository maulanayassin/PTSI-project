<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','city_name', 'indicator_id', 'goal', 'year', 'city_id'];

    // protected $validationRules = [
    //     'city_name' => 'required|min_length[3]',
    //     'indicator_id' => 'required',
    //     'goal' => 'required',
    // ];

    // protected $validationMessages = [
    //     'city_name' => [
    //         'required' => 'Nama kota wajib diisi.',
    //         'min_length' => 'Nama kota minimal 3 karakter.'
    //     ],
    //     'indicator_id' => [
    //         'required' => 'No indikator wajib diisi.'
    //     ],
    //     'goal' => [
    //         'required' => 'Goal wajib diisi.'
    //     ]
    // ];

    // public function getTransactionsWithGrowthRate($cityCode)
    // {
    //     // Get transactions for the specified city
    //     $transactions = $this->where('city_id', $cityCode)->findAll();

    //     // Process the transactions to calculate growth rate
    //     foreach ($transactions as &$transaction) {
    //         $value2019 = $transaction['year_2019'];
    //         $value2020 = $transaction['year_2020'];

    //         // Calculate growth rate based on the polarity
    //         if ($value2019 !== null && $value2020 !== null) {
    //             if ($transaction['polaritas'] == 'negatif') {
    //                 $transaction['growth_rate'] = $value2019 - $value2020;
    //             } else {
    //                 $transaction['growth_rate'] = $value2020 - $value2019;
    //             }
    //         } else {
    //             $transaction['growth_rate'] = null; // Handle cases where values are missing
    //         }
    //     }

    //     return $transactions;
    // }
}
