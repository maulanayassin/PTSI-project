<?php
namespace App\Controllers\App;

use App\Models\IndicatorModel;
use CodeIgniter\Controller;

class Indicator extends Controller
{
    // menampilkan daftar kota
        
    public function index()
    {
        $model = new IndicatorModel();
        $data['data_indicator'] = $model->findAll();
        $data['scripts'] = [
            '/js/app_indicator.js',
        ];return view('app/indicator', $data);
    }

    // menampilkan form 
    public function form($id=0)
    {
        $data['record_indicator'] = null;
        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_indicator'] = $db->table('indicator')->get()->getRow();
        }
        $data['scripts'] = [
            '/js/app_indicator.js',
        ];
        return view('app/indicator_form', $data);
    }

    // saat form di submit
    public function submit()
    {
        // // insert menggunakan model
        // $model = new IndicatorModel();
        // $model->save([
        //     'indicator_name' => $this->request->getPost('indicator_name'),
        // ]);

        // insert menggunakan Query Builder
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $row = $db->table('indicator')->where('id', $id)->get()->getRow();
        if ($row == null) {
            $db->table('indicator')->insert([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
        } else {
            $db->table('indicator')->update([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id' => $id,
            ]);
            
        }
        return redirect()->to('/app/indicator');
    }
    // Function to handle the edit form
    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_indicator'] = $db->table('indicator')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_indicator']) {
            return redirect()->to('/app/indicator')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan
        $data['scripts'] = [
            '/js/app_indicator.js',
        ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/indicator_form', $data);
    }
    // Function to handle deleting an indicator
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $row = $db->table('indicator')->where('id', $id)->get()->getRow();

        // Jika data tidak ditemukan
        if (!$row) {
            return redirect()->to('/app/indicator')->with('error', 'Data tidak ditemukan');
        }

        // Jika data ditemukan, hapus data
        $db->table('indicator')->where('id', $id)->delete();
        return redirect()->to('/app/indicator')->with('success', 'Data berhasil dihapus');
    }

}
