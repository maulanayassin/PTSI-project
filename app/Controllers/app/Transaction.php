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

    public function form($id = null)
    {
        $data = [];

        if ($id) {
            $data['transaction'] = $this->transactionModel->find($id);
            if (!$data['transaction']) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Data transaksi dengan ID $id tidak ditemukan");
            }
        }

        $data['provinsi'] = $this->provinceModel->findAll(); // Menambahkan data provinsi untuk dropdown
        return view('app/transaction_form', $data);
    }

    public function submit()
    {
        $id = $this->request->getPost('id'); // Mengambil ID dari form

        if ($this->validate([
            'goal' => 'required',
            'domain' => 'required|in_list[1,2,3]', // Validasi domain harus salah satu dari pilihan yang ada
        ])) {
            $db = \Config\Database::connect();

            // Ambil nilai tahun 2019 dan 2020 dari tabel
            $value2019 = $db->table('transaction')->where('year', 2019)->get()->getRow();
            $value2020 = $db->table('transaction')->where('year', 2020)->get()->getRow();

            // Hitung growth_rate
            $growth_rate = null;
            if ($value2019 && $value2020) {
                $growth_rate = abs($value2019->value - $value2020->value);
            }

            // Simpan atau update data transaksi
            $data = [
                'goal' => $this->request->getPost('goal'),
                'year_2019' => $value2019 ? $value2019->value : null,
                'year_2020' => $value2020 ? $value2020->value : null,
                'growth_rate' => $growth_rate, // Simpan nilai growth_rate
                'domain' => $this->request->getPost('domain'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($id) {
                // Update data transaksi
                $this->transactionModel->update($id, $data);
            } else {
                // Insert new data transaksi
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->transactionModel->save($data);
            }

            return redirect()->to('/app/transaction')->with('success', 'Data berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    public function edit($id)
    {
        return $this->form($id);
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
        $transactions = $this->transactionModel->where('city_id', $cityCode)->findAll();
        return $this->response->setJSON($transactions);
    }

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
}
