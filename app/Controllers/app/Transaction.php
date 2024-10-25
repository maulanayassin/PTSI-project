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
            'year_2019' => 'required', 
            'year_2020' => 'required', 
            'domain' => 'required|in_list[1,2,3]', // Validasi domain harus salah satu dari pilihan yang ada
        ])) {
            // Cek apakah ID ada di database
            $row = $db->table('transaction')->where('id', $id)->get()->getRow();
            
            // Jika tidak ada data dengan ID tersebut, berarti kita melakukan insert
            if ($row == null) {
                $db->table('transaction')->insert([
                    'goal' => $this->request->getPost('goal'),
                    'year_2019' => $this->request->getPost('year_2019'),
                    'year_2020' => $this->request->getPost('year_2020'),
                    'domain' => $this->request->getPost('domain'),
                    'created_at' => date('Y-m-d H:i:s'), // Menambahkan timestamp saat data dibuat
                    'updated_at' => date('Y-m-d H:i:s'), // Menambahkan timestamp saat data diupdate
                ]);
            } else {
                // Jika ada, lakukan update
                $db->table('transaction')->update([
                    'goal' => $this->request->getPost('goal'),
                    'year_2019' => $this->request->getPost('year_2019'),
                    'year_2020' => $this->request->getPost('year_2020'),
                    'domain' => $this->request->getPost('domain'),
                    'updated_at' => date('Y-m-d H:i:s'), // Update timestamp
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
        $data['transaction'] = $this->transactionModel->find($id); // Change to 'transaction'
        if (!$data['transaction']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data transaksi dengan ID $id tidak ditemukan");
        }

        // Ambil data provinsi untuk dropdown
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
}