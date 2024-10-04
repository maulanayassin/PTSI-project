<?php
namespace App\Controllers\App;

use App\Models\Domain2Model;
use CodeIgniter\Controller;

class Domain2 extends Controller
{
    public function index(){
        $model = new Domain2Model();
        $data['domain2'] = $model->findAll();
        return view('app/domain2', $data);
    }
    public function form($id=0)
    {
        $data['record_domain2'] = null;
        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_domain2'] = $db->table('domain2')->get()->getRow();
        }
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];
        return view('app/domain2_form', $data);
    }
    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_domain2'] = $db->table('domain2')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_domain2']) {
            return redirect()->to('/app/domain2')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/domain2_form', $data);
    }
    public function submit(){
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $row = $db->table('domain2')->where('id', $id)->get()->getRow();
        if ($row == null) {
            $db->table('domain2')->insert([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
        } else {
            $db->table('domain2')->update([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id' => $id,
            ]);
            
        }
        return redirect()->to('/app/domain2');
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $row = $db->table('domain2')->where('id', $id)->get()->getRow();

        // Jika data tidak ditemukan
        if (!$row) {
            return redirect()->to('/app/domain2')->with('error', 'Data tidak ditemukan');
        }

        // Jika data ditemukan, hapus data
        $db->table('domain2')->where('id', $id)->delete();
        return redirect()->to('/app/domain2')->with('success', 'Data berhasil dihapus');
    }
}
