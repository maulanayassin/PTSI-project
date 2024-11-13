<?php

namespace App\Controllers\App;

use App\Models\TransactionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use CodeIgniter\Controller;

class Transaction extends Controller
{
    protected $transactionModel;
    protected $provinceModel;
    protected $cityModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->provinceModel = new ProvinceModel();
        $this->cityModel = new CityModel();
    }

    // Main index function for displaying transaction data
    public function index()
    {
        $data['transaksi'] = [];
        $data['provinsi'] = $this->provinceModel->findAll();
        return view('app/transaction', $data);
    }

    // Function to display form for adding or editing a transaction
    public function form($id = null)
    {
        
        // Initialize the transaction data
        $data['transaksi'] = null;

        // If an ID is provided, fetch the transaction details for editing
        if ($id) {
            $data['transaksi'] = $this->transactionModel->find($id);
        }
        // Fetch province and city data for the form dropdowns
        $data['provinsi'] = $this->provinceModel->findAll();
        $data['kota'] = $this->cityModel->findAll();

        // Load the form view
        return view('app/transaction_form', $data);
    }

    // Function to submit transaction data (insert or update)
    public function submit()
    {
        $id = $this->request->getPost('id');

        if ($this->validate([
            'goal' => 'required',
            'domain' => 'required|in_list[1,2,3]', // Validate 'domain' must be one of the listed values
        ])) {
            $db = \Config\Database::connect();

            // Retrieve values for 2019 and 2020 from the transaction table
            $value2019 = $db->table('transaction')->where('year', 2019)->get()->getRow();
            $value2020 = $db->table('transaction')->where('year', 2020)->get()->getRow();

            // Calculate growth rate
            $growth_rate = null;
            if ($value2019 && $value2020) {
                $growth_rate = abs($value2019->value - $value2020->value);
            }

            // Data to save or update
            $data = [
                'goal' => $this->request->getPost('goal'),
                'year_2019' => $value2019 ? $value2019->value : null,
                'year_2020' => $value2020 ? $value2020->value : null,
                'growth_rate' => $growth_rate,
                'domain' => $this->request->getPost('domain'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($id) {
                // Update existing transaction
                $this->transactionModel->update($id, $data);
            } else {
                // Insert new transaction
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->transactionModel->save($data);
            }

            return redirect()->to('/app/transaction')->with('success', 'Data berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Function to edit a transaction by ID
    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Ambil data transaksi berdasarkan ID
        $transaction = $this->transactionModel->find($id);
        if (!$transaction) {
            return redirect()->to('/app/transaction')->with('error', 'Transaction not found.');
        }

        // Kirimkan data transaksi ke view
        $data['transaction'] = $transaction;
        $data['provinsi'] = $this->provinceModel->findAll();
        $data['cities'] = $this->cityModel->findAll();

        // Tampilkan form edit
        return view('app/transaction_form', $data);
    }

    public function update($id)
    {
        $validationRules = [
            'provinsi' => 'required',
            'kota' => 'required',
            'tahun' => 'required',
            'domain' => 'required',
            'indikator_name' => 'required',
            'no_indikator' => 'required',
            'goal' => 'required',
            'nilai' => 'required',
            'growth_rate' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get data from the form
        $data = [
            'provinsi' => $this->request->getPost('provinsi'),
            'kota' => $this->request->getPost('kota'),
            'year' => $this->request->getPost('tahun'),
            'domain' => $this->request->getPost('domain'),
            'indicator_name' => $this->request->getPost('indikator_name'),
            'indicator_id' => $this->request->getPost('no_indikator'),
            'goal' => $this->request->getPost('goal'),
            'value_fix' => $this->request->getPost('nilai'),
            'growth_rate' => $this->request->getPost('growth_rate')
        ];

        // Update the transaction
        $this->transactionModel->update($id, $data);

        return redirect()->to('/app/transaction')->with('success', 'Transaction updated successfully');
    }

    // Function to delete a transaction by ID
    public function delete($id)
    {
        $this->transactionModel->delete($id);
        return redirect()->to('/app/transaction')->with('success', 'Data berhasil dihapus.');
    }

    // Function to get transactions based on city code (AJAX request)
    public function getTransactionsByCity()
    {
        $request = $this->request->getJSON();
        $cityCode = $request->cityCode;
        $transactions = $this->transactionModel->where('city_id', $cityCode)->findAll();
        return $this->response->setJSON($transactions);
    }

    // Function to get cities based on province code (AJAX request)
    public function getCities()
    {
        $request = $this->request->getJSON();
        $provinceCode = $request->provinceCode;
        $cities = $this->cityModel->where('province_id', $provinceCode)->findAll();
        
        if (empty($cities)) {
            log_message('error', 'No cities found for province: ' . $provinceCode);
        }

        return $this->response->setJSON($cities);
    }

    // Function to get transactions by city and domain (AJAX request)
    public function getTransactionsByCityAndDomain()
    {
        if ($this->request->isAJAX()) {
            $cityCode = $this->request->getPost('cityCode');
            $domain = $this->request->getPost('domain');

            $transactions = $this->transactionModel
                ->where('city_id', $cityCode)
                ->where('domain', $domain)
                ->findAll();

            return $this->response->setJSON($transactions);
        }
    }
    // Function to fetch transaction data based on year and city name
    public function processGrowth($year, $city_id, $province_id, $domain_id)
    {
        $db = \Config\Database::connect();
        
        // SQL untuk UPDATE growth_rate
        $updateSql = "
            UPDATE sdg_ptsi.transaction t
            SET 
                growth_rate = CASE 
                    WHEN t.polaritas = 'Negatif' THEN 
                        (SELECT MAX(value_fix) 
                        FROM sdg_ptsi.transaction AS t1 
                        WHERE t1.year = t.year - 1 
                        AND t1.city_id = t.city_id 
                        AND t1.province_id = t.province_id 
                        AND t1.indicator_id = t.indicator_id) - t.value_fix
                    ELSE 
                        t.value_fix - (SELECT MAX(value_fix) 
                                    FROM sdg_ptsi.transaction AS t1 
                                    WHERE t1.year = t.year - 1 
                                        AND t1.city_id = t.city_id 
                                        AND t1.province_id = t.province_id 
                                        AND t1.indicator_id = t.indicator_id)
                END
            WHERE 
                t.province_id = ? 
                AND t.city_id = ? 
                AND t.year = ?    
                AND t.domain = ?;
        ";
        
        // Eksekusi query UPDATE
        $db->query($updateSql, [$province_id, $city_id, $year, $domain_id]);

        // SQL untuk SELECT data yang telah diperbarui
        $selectSql = "
            SELECT t.id, t.year, t.province_id, t.city_id, t.city_name, i.indicator_name, 
                t.indicator_id, t.goal, t.domain, t.value_fix, t.polaritas,
                (SELECT MAX(value_fix) FROM sdg_ptsi.transaction AS t1 
                    WHERE t1.year = t.year - 1 
                    AND t1.city_id = t.city_id 
                    AND t1.province_id = t.province_id 
                    AND t1.indicator_id = t.indicator_id) AS value_sebelumnya,
                CASE 
                    WHEN t.polaritas = 'Negatif' THEN 
                        (SELECT MAX(value_fix) FROM sdg_ptsi.transaction AS t1 
                            WHERE t1.year = t.year - 1 
                            AND t1.city_id = t.city_id 
                            AND t1.province_id = t.province_id 
                            AND t1.indicator_id = t.indicator_id) - t.value_fix
                    ELSE 
                        t.value_fix - (SELECT MAX(value_fix) FROM sdg_ptsi.transaction AS t1 
                                        WHERE t1.year = t.year - 1 
                                            AND t1.city_id = t.city_id 
                                            AND t1.province_id = t.province_id 
                                            AND t1.indicator_id = t.indicator_id) 
                END AS growth_rate
            FROM sdg_ptsi.transaction t 
            LEFT OUTER JOIN sdg_ptsi.`indicator` i ON t.indicator_id = i.no_indicator
            WHERE 
                t.province_id = ? 
                AND t.city_id = ? 
                AND t.year = ?    
                AND t.domain = ?;
        ";

        // Eksekusi query SELECT untuk mendapatkan data yang telah diperbarui
        $query = $db->query($selectSql, [$province_id, $city_id, $year, $domain_id]);
        
        // Mengembalikan hasil dalam format JSON
        return $this->response->setJSON($query->getResult());
    }

}
