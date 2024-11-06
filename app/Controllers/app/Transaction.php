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

    public function index()
    {
        $data['transaksi'] = [];
        $data['provinsi'] = $this->provinceModel->findAll();
        return view('app/transaction', $data);
    }

    public function form($id = 0)
    {
        $data = [];
        if ($id != 0) {
            $data['transaction'] = $this->transactionModel->find($id); // Change to 'transaction'
        }
        $data['provinsi'] = $this->provinceModel->findAll(); // Menambahkan data provinsi untuk dropdown
        
        return view('app/transaction_form', $data);
    }

    public function submit()
    {
        // Menghubungkan ke database
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id'); // Mengambil ID dari form

        // Validasi data yang diterima
        if ($this->validate([
            'goal' => 'required',
            'domain' => 'required|in_list[1,2,3]', // Validasi domain harus salah satu dari pilihan yang ada
        ])) {
            // Ambil nilai tahun 2019 dan 2020 dari tabel
            $value2019 = $db->table('transaction')->where('year', 2019)->get()->getRow();
            $value2020 = $db->table('transaction')->where('year', 2020)->get()->getRow();

            // Hitung growth_rate
            $growth_rate = null; // Default null jika data tahun tidak tersedia

            if ($value2019 && $value2020) {
                if ($value2019->value >= $value2020->value) {
                    $growth_rate = $value2019->value - $value2020->value;
                } else {
                    $growth_rate = $value2020->value - $value2019->value;
                }
            }

            // Cek apakah ID ada di database
            $row = $db->table('transaction')->where('id', $id)->get()->getRow();

            if ($row == null) {
                $db->table('transaction')->insert([
                    'goal' => $this->request->getPost('goal'),
                    'year_2019' => $value2019 ? $value2019->value : null,
                    'year_2020' => $value2020 ? $value2020->value : null,
                    'growth_rate' => $growth_rate, // Simpan nilai growth_rate
                    'domain' => $this->request->getPost('domain'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $db->table('transaction')->update([
                    'goal' => $this->request->getPost('goal'),
                    'year_2019' => $value2019 ? $value2019->value : null,
                    'year_2020' => $value2020 ? $value2020->value : null,
                    'growth_rate' => $growth_rate, // Update nilai growth_rate
                    'domain' => $this->request->getPost('domain'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ], [
                    'id' => $id, // Menentukan ID yang akan diupdate
                ]);
            }

            // Redirect setelah sukses
            return redirect()->to('/app/transaction')->with('success', 'Data berhasil disimpan.');
        }

        // Jika validasi gagal, redirect kembali ke form dengan input dan pesan error
        log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    public function edit($id)
    {
        $data['transaction'] = $this->transactionModel->find($id);
        if (!$data['transaction']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data transaksi dengan ID $id tidak ditemukan");
        }

        $data['provinsi'] = $this->provinceModel->findAll();

        return view('app/transaction_form', $data);
    }

    public function delete($id)
    {
        $this->transactionModel->delete($id);
        return redirect()->to('/app/transaction')->with('success', 'Data berhasil dihapus.');
    }

    public function getTransactionsByCity()
    {
        $request = $this->request->getJSON();
        $cityCode = $request->cityCode;
        

        // Ambil data transaksi berdasarkan city_id
        $transaksi = $this->transactionModel->where('city_id', $cityCode)->findAll();

        return $this->response->setJSON($transaksi);
    }

    public function getCities()
    {
        $request = $this->request->getJSON();
        $provinceCode = $request->provinceCode;

        // Ambil data kota berdasarkan province_code
        $cities = $this->cityModel->where('province_id', $provinceCode)->findAll(); // Pastikan kolom yang digunakan benar

        // Debugging
        if (empty($cities)) {
            log_message('error', 'No cities found for province: ' . $provinceCode);
        }
        return $this->response->setJSON($cities);
    }
    
    public function getTransactionsByCityAndDomain()
    {
        if ($this->request->isAJAX()) {
            $cityCode = $this->request->getPost('cityCode');
            $domain = $this->request->getPost('domain');

            // Ambil data transaksi berdasarkan cityCode dan domain
            $transactionModel = new TransactionModel();
            $transactions = $transactionModel->where('city_id', $cityCode)
                                            ->where('domain', $domain) // Filter berdasarkan domain
                                            ->findAll();

            return $this->response->setJSON($transactions);
        }
    }

    public function processTransactions()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id'); // Mengambil ID dari form

        // Periksa apakah request ini merupakan request AJAX
        if ($this->request->isAJAX()) {
            $request = $this->request->getJSON();
            $transactions = $request->transactions;

            // Array untuk menyimpan hasil transaksi yang diproses
            $processedTransactions = [];

            foreach ($transactions as $transaction) {
                $year2019 = $transaction->year_2019;
                $year2020 = $transaction->year_2020;
                $polaritas = $transaction->polaritas; // Asumsi bahwa field polaritas ada di database

                $growthRate = null;

                // Hitung growth rate berdasarkan polaritas
                if ($year2019 !== null && $year2020 !== null) {
                    if ($polaritas === 'negatif') {
                        $growthRate = $year2019 - $year2020;
                    } elseif ($polaritas === 'positif') {
                        $growthRate = $year2020 - $year2019;
                    }
                }

                // Simpan data yang sudah diproses ke dalam array
                $processedTransactions[] = [
                    'id' => $transaction->id,
                    'city_name' => $transaction->city_name,
                    'indicator_id' => $transaction->indicator_id,
                    'goal' => $transaction->goal,
                    'year_2019' => $year2019,
                    'year_2020' => $year2020,
                    'growth_rate' => $growthRate
                ];

                // Update nilai growth rate di database
                $this->transactionModel->update($transaction->id, ['growth_rate' => $growthRate]);
            }

            // Kembalikan data yang sudah diproses ke view
            return $this->response->setJSON([
                'success' => true,
                'transactions' => $processedTransactions
            ]);
        }

        // Jika bukan request AJAX, kembalikan respons gagal
        return $this->response->setJSON(['success' => false]);
    }
}