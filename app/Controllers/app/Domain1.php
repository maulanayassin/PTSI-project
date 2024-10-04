<?php
namespace App\Controllers\App;

use App\Models\Domain1Model;
use CodeIgniter\Controller;

class Domain1 extends Controller
{
    public function index(){
        $model = new Domain1Model();
        $data['domain1'] = $model->findAll();
        return view('app/domain1', $data);
    }
    public function form($id=0)
    {
        $data['record_domain1'] = null;
        if ($id !== 0) {
            $db = \Config\Database::connect();
            $data['record_domain1'] = $db->table('domain1')->get()->getRow();
        }
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];
        return view('app/domain1_form', $data);
    }
    public function edit($id)
    {
        $db = \Config\Database::connect();
        // Mengambil data berdasarkan ID
        $data['record_domain1'] = $db->table('domain1')->where('id', $id)->get()->getRow();
        
        // Cek jika data ditemukan
        if (!$data['record_domain1']) {
            return redirect()->to('/app/domain1')->with('error', 'Data tidak ditemukan');
        }

        // Load JavaScript jika diperlukan
        // $data['scripts'] = [
        //     '/js/app_indicator.js',
        // ];

        // Menampilkan form edit dengan data yang diambil
        return view('app/domain1_form', $data);
    }
    public function submit(){
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $row = $db->table('domain1')->where('id', $id)->get()->getRow();
        if ($row == null) {
            $db->table('domain1')->insert([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            
        } else {
            $db->table('domain1')->update([
                'indicator_name' => $this->request->getPost('indicator_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id' => $id,
            ]);
            
        }
        return redirect()->to('/app/domain1');
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $row = $db->table('domain1')->where('id', $id)->get()->getRow();

        // Jika data tidak ditemukan
        if (!$row) {
            return redirect()->to('/app/domain1')->with('error', 'Data tidak ditemukan');
        }

        // Jika data ditemukan, hapus data
        $db->table('domain1')->where('id', $id)->delete();
        return redirect()->to('/app/domain1')->with('success', 'Data berhasil dihapus');
    }
}
