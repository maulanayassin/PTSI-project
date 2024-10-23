<?php

namespace App\Controllers\App;

use App\Models\TransactionModel;
use CodeIgniter\Controller;

class Transaction extends Controller
{
    public function index()
    {
        $cityId = session()->get('selectedCityId');
        $model = new TransactionModel();
        // Cek apakah ada ID kota yang dipilih dalam session
        if ($cityId) {
            // Jika ID kota ada, ambil transaksi untuk kota tersebut
            $data['transaksi'] = $model->where('city_id', $cityId)->findAll();
        } else {
            // Jika tidak ada kota yang dipilih, ambil semua transaksi
            $data['transaksi'] = $model->findAll();
        }

        return view('app/transaction', $data);
    }
    
    public function form($id=0) {
        $data['record_transaction'] = null;
        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_transaction'] = $db->table('transaction')->get()->getRow();
        }
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];
        return view('app/transaction_form', $data);
    }

    public function submit() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $row = $db->table('transaction')->where('id', $id)->get()->getRow();
        if ($row == null) {
            $db->table('transaction')->insert([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
        } else {
            $db->table('transaction')->update([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id' => $id,
            ]);
            
        }
        return redirect()->to('/app/transaction');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_transaction'] = $db->table('transaction')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_transaction']) {
            return redirect()->to('/app/transaction')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan 
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/transaction_form', $data);
    }

    public function delete($id) {
        $model = new TransactionModel();
        $model->delete($id);
        return redirect()->to('/app/Transaction');
    }
}
