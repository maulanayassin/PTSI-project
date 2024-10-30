<?php
namespace App\Controllers\App;

use App\Models\CityModel;
use App\Models\ProvinceModel;
use CodeIgniter\Controller;

class City extends Controller
{
    public function index()
    {
        // Menampilkan daftar kota
        $model = new CityModel();
        $data['data_city'] = $model->getCityWithProvince();
        return view('app/city', $data);
    }

    public function form($id = 0)
    {
        $data['record_city'] = null;
        $provinceModel = new ProvinceModel();
        $data['province'] = $provinceModel->getProvince(); // Pindahkan ke luar kondisi if

        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_city'] = $db->table('city')->where('id', $id)->get()->getRow();
        }

        return view('app/city_form', $data);
    }

    // saat form di submit
    public function submit()
    {
        $model = new CityModel();
        $model->save([
            'city_name' => $this->request->getPost('city_name'),
            'province_id' => $this->request->getPost('province_id'),
        ]);
        return redirect()->to('/app/city');
    }
    public function edit($id = null)
    {
        // Tampilkan form tambah atau edit 
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_city'] = $db->table('city')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_city']) {
            return redirect()->to('/app/city')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan
        $data['scripts'] = [
            '/js/app_city.js',
        ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/city_form', $data);
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $row = $db->table('city')->where('id', $id)->get()->getRow();

        // Jika data tidak ditemukan
        if (!$row) {
            return redirect()->to('/app/city')->with('error', 'Data tidak ditemukan');
        }

        // Jika data ditemukan, hapus data
        $db->table('city')->where('id', $id)->delete();
        return redirect()->to('/app/city')->with('success', 'Data berhasil dihapus');
    }

    
    
}
