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
            $data['transaksi'] = $this->transactionModel->find($id);
        }
        $data['provinsi'] = $this->provinceModel->findAll(); // Menambahkan data provinsi untuk dropdown
        return view('transaction/form', $data);
    }

    public function submit()
    {
        $postData = $this->request->getPost();
        if ($this->validate([
            'city_id' => 'required', // Menggunakan city_id
            'indicator_id' => 'required',
            'goal' => 'required',
        ])) {
            if (isset($postData['id'])) {
                $this->transactionModel->update($postData['id'], $postData);
            } else {
                $this->transactionModel->insert($postData);
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

        // Ambil data transaksi berdasarkan city_id
        $transaksi = $this->transactionModel->where('city_id', $cityCode)->findAll();

        return $this->response->setJSON($transaksi);
    }

    public function getCities()
    {
        $request = $this->request->getJSON();
        $provinceCode = $request->provinceCode;

        // Ambil data kota berdasarkan province_code
        $cities = $this->cityModel->where('province_code', $provinceCode)->findAll(); // Pastikan kolom yang digunakan benar

        // Debugging
        if (empty($cities)) {
            log_message('error', 'No cities found for province: ' . $provinceCode);
        }
        return $this->response->setJSON($cities);
    }

}