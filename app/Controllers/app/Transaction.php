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
        $provinsi = $this->provinceModel->findAll();

        $data = [
            'provinsi' => $provinsi,
            'transaction' => $id ? $this->transactionModel->find($id) : null,
        ];

        // If editing, load cities for the selected province
        if ($id && $data['transaction']) {
            $data['cities'] = $this->cityModel->where('kemendagri_code', $data['transaction']['provinsi'])->findAll();
        }

        return view('app/transaction_form', $data);
    }

    // Handle form submission (insert or update transaction data)
    public function submit()
    {
        // Koneksi ke database
        $db = \Config\Database::connect();

        // Aturan validasi untuk input
        $validationRules = [
            'provinsi' => 'required',
            'kota' => 'required',
            'tahun' => 'required|numeric',
            'nilai' => 'required|numeric', // Pastikan 'nilai' adalah angka
        ];

        // Jika validasi gagal, kembali ke form dengan pesan kesalahan
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyusun data dari input untuk disimpan ke database
        $data = [
            'province_id' => $this->request->getPost('provinsi'),
            'city_id' => $this->request->getPost('kota'),
            'year' => $this->request->getPost('tahun'),
            'domain' => $this->request->getPost('domain'),
            'indicator_name' => $this->request->getPost('indikator_name'),
            'goal' => $this->request->getPost('goal'),
            'value_fix' => $this->request->getPost('nilai'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Cek apakah ini adalah operasi update atau insert berdasarkan ID
        $id = $this->request->getPost('id');

        try {
            if ($id) {
                // Jika ada ID, lakukan update data
                $updateQuery = $db->table('transaction')->update($data, ['id' => $id]);
                if ($updateQuery) {
                    $message = 'Transaksi berhasil diperbarui';
                } else {
                    throw new \Exception('Gagal memperbarui transaksi');
                }
            } else {
                // Jika tidak ada ID, lakukan insert data
                $insertQuery = $db->table('transaction')->insert($data);
                if ($insertQuery) {
                    $message = 'Transaksi berhasil dibuat';
                } else {
                    throw new \Exception('Gagal membuat transaksi baru');
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }

        // Jika berhasil, redirect ke halaman transaksi dengan pesan sukses
        return redirect()->to('/app/transaction')->with('success', $message);
    }



    // Function to edit a transaction by ID
    public function edit($id)
    {
        // Menghubungkan ke database
        $db = \Config\Database::connect();

        // Menarik data transaksi berdasarkan ID
        $transaction = $this->transactionModel->find($id);
        
        if (!$transaction) {
            return redirect()->to('/app/transaction')->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Mengambil data provinsi
        $provinsi = $this->provinceModel->findAll();

        // Jika transaksi memiliki provinsi, ambil daftar kota berdasarkan provinsi tersebut
        $cities = [];
        if (isset($transaction['provinsi'])) {
            // Mengambil data kota berdasarkan kemendagri_code provinsi
            $cities = $this->cityModel->where('kemendagri_code', $transaction['provinsi'])->findAll();
        }

        // Menyiapkan data untuk tampilan
        $data = [
            'transaction' => $transaction,
            'provinsi' => $provinsi,
            'cities' => $cities,
        ];

        // Mengirim data ke tampilan (view)
        return view('app/transaction_form', $data);
    }


    // Update the transaction after editing
    public function update($id)
    {
        // Validation rules
        $validationRules = [
            'provinsi' => 'required',
            'kota' => 'required',
            'tahun' => 'required',
            'domain' => 'required',
            'indikator_name' => 'required',
            'no_indikator' => 'required',
            'goal' => 'required',
            'nilai' => 'required',
        ];

        // Validate input data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get data from form input
        $data = [
            'provinsi' => $this->request->getPost('provinsi'),
            'kota' => $this->request->getPost('kota'),
            'year' => $this->request->getPost('tahun'),
            'domain' => $this->request->getPost('domain'),
            'indicator_name' => $this->request->getPost('indikator_name'),
            'indicator_id' => $this->request->getPost('no_indikator'),
            'goal' => $this->request->getPost('goal'),
            'value_fix' => $this->request->getPost('nilai'),
            'growth_rate' => $this->request->getPost('growth_rate'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Update the transaction in the database
        $this->transactionModel->update($id, $data);

        return redirect()->to('/app/transaction')->with('success', 'Transaksi berhasil diperbarui');
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

    public function getCitiesByProvince($provinceId)
    {
        $cities = $this->cityModel->where('province_id', $provinceId)->findAll();
        return $this->response->setJSON($cities);
    }


    // Function to fetch transaction data based on year and city name
    public function processGrowth($year, $city_id, $province_id, $domain_id)
    {
       $db = \Config\Database::connect();
        // Perhitungan growth_rate hanya untuk domain = 1
        if ($domain_id == 1) {
            $updateGrowthRateSql = "
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

            // Eksekusi query UPDATE growth_rate
            $db->query($updateGrowthRateSql, [$province_id, $city_id, $year, $domain_id]);
        }
        // SQL untuk UPDATE nilai_akhir berdasarkan domain
        if ($domain_id == 1) {
            $updateDomain1Sql = "
                UPDATE sdg_ptsi.transaction t
                SET t.nilai_akhir = (
                    SELECT 
                        CASE
                            WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate AND 
                                sumber.min_growth_rate + ((sumber.max_growth_rate - sumber.min_growth_rate) / 3) THEN 0
                            WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate + ((sumber.max_growth_rate - sumber.min_growth_rate) / 3) AND 
                                sumber.min_growth_rate + (2 * ((sumber.max_growth_rate - sumber.min_growth_rate) / 3)) THEN 1
                            WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate + (2 * ((sumber.max_growth_rate - sumber.min_growth_rate) / 3)) AND 
                                sumber.max_growth_rate THEN 2
                            ELSE NULL
                        END AS nilai_akhir
                    FROM sdg_ptsi.transaction t_inner
                    LEFT JOIN (
                        SELECT 
                            indicator_id,
                            domain, 
                            MIN(growth_rate) AS min_growth_rate, 
                            MAX(growth_rate) AS max_growth_rate 
                        FROM 
                            sdg_ptsi.transaction 
                        WHERE domain = 1
                        GROUP BY indicator_id, domain
                    ) AS sumber 
                    ON t_inner.indicator_id = sumber.indicator_id
                    AND t_inner.domain = sumber.domain
                    WHERE 
                        t_inner.year = 2020
                        AND t_inner.domain = 1
                        AND t.indicator_id = t_inner.indicator_id
                        AND t.city_name = t_inner.city_name
                )
                WHERE t.domain = 1 AND t.year = 2020;
            ";
            $db->query($updateDomain1Sql);
        } elseif ($domain_id == 2) {
            $updateDomain2Sql = "
                UPDATE sdg_ptsi.transaction t
                SET t.nilai_akhir = (
                    SELECT 
                        CASE
                            WHEN t_inner.verification = 'TRUE' THEN t_inner.value_fix * 2
                            ELSE t_inner.value_fix
                        END AS nilai_akhir
                    FROM sdg_ptsi.transaction t_inner
                    WHERE 
                        t_inner.year = 2020
                        AND t_inner.domain = 2
                        AND t_inner.value_fix <> 0
                        AND t.indicator_id = t_inner.indicator_id
                        AND t.city_name = t_inner.city_name
                    GROUP BY 
                        t_inner.indicator_id, 
                        t_inner.city_name, 
                        t_inner.domain, 
                        t_inner.verification, 
                        t_inner.value_fix
                )
                WHERE t.domain = 2 AND t.year = 2020;
            ";
            $db->query($updateDomain2Sql);
        } elseif ($domain_id == 3) {
            $updateDomain3Sql = "
                UPDATE sdg_ptsi.transaction t
                SET t.nilai_akhir = (
                    SELECT 
                        CASE
                            WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix AND 
                                sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) THEN 0
                            WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) AND 
                                sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) THEN 1
                            WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) AND 
                                sumber.max_value_fix THEN 2
                            ELSE NULL
                        END AS nilai_akhir
                    FROM 
                        sdg_ptsi.transaction t_inner
                    LEFT JOIN (
                        SELECT 
                            indicator_id, 
                            domain, 
                            MIN(value_fix) AS min_value_fix, 
                            MAX(value_fix) AS max_value_fix
                        FROM 
                            sdg_ptsi.transaction
                        WHERE 
                            domain = 3 
                        GROUP BY 
                            indicator_id, 
                            domain
                    ) AS sumber
                    ON t_inner.indicator_id = sumber.indicator_id  
                    AND t_inner.domain = sumber.domain
                    WHERE 
                        t_inner.year = 2020 
                        AND t_inner.domain = 3 
                        AND t.indicator_id = t_inner.indicator_id
                        AND t.city_name = t_inner.city_name
                )
                WHERE t.domain = 3 
                AND t.year = 2020;
            ";
            $db->query($updateDomain3Sql);
        }

        // SQL untuk SELECT data yang telah diperbarui
        $selectSql = "
            SELECT t.id, t.year, t.province_id, t.city_id, t.city_name, i.indicator_name, 
                t.indicator_id, t.goal, t.domain, t.value_fix, t.polaritas, t.nilai_akhir,
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
