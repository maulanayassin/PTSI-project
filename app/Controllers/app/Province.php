<?php
namespace App\Controllers\App;

use App\Models\ProvinceModel;
use CodeIgniter\Controller;

class Province extends Controller{
    public function index(){
        // Menampilkan daftar provinsi
        $model = new ProvinceModel();
        $data['province'] = $model->findAll();
        return view('app/province', $data);
    }
    public function form($id = 0)
    {
        // Tampilkan form tambah atau edit provinsi
        $data['record_province'] = null;
        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_province'] = $db->table('province')->get()->getRow();
        }
        // $data['scripts'] = [
        //     '/js/app_province.js',
        // ];
        return view('app/province_form', $data);
    }
    public function submit(){
        // simpan data setelah pengisian form 
        // $model = new ProvinceModel();
        // $data = [
        //     'province_name' => $this->request->getPost('province_name')
        // ];
        // $model->insert($data);
        // return redirect()->to('/app/province');
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $row = $db->table('province')->where('id', $id)->get()->getRow();
        if ($row == null) {
            $db->table('province')->insert([
                'province_name' => $this->request->getPost('province_name'),
                'kemendagri_code' => $this->request->getPost('kemendagri_code'),
                'bps_code' => $this->request->getPost('bps_code'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
        } else {
            $db->table('province')->update([
                'province_name' => $this->request->getPost('province_name'),
                'kemendagri_code' => $this->request->getPost('kemendagri_code'),
                'bps_code' => $this->request->getPost('bps_code'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id' => $id,
            ]);
            
        }
        return redirect()->to('/app/province');
    }
    public function edit($id = null)
    {
        // Tampilkan form tambah atau edit 
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_province'] = $db->table('province')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_province']) {
            return redirect()->to('/app/province')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan
        $data['scripts'] = [
            '/js/app_province.js',
        ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/province_form', $data);
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $row = $db->table('province')->where('id', $id)->get()->getRow();

        // Jika data tidak ditemukan
        if (!$row) {
            return redirect()->to('/app/province')->with('error', 'Data tidak ditemukan');
        }

        // Jika data ditemukan, hapus data
        $db->table('province')->where('id', $id)->delete();
        return redirect()->to('/app/province')->with('success', 'Data berhasil dihapus');
    }
    

}

?>