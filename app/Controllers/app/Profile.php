<?php
namespace App\Controllers\App;

use App\Models\ProfileModel;
use CodeIgniter\Controller;

class Profile extends Controller
{
    public function index(){
        // Mengambil ID user dari session
        $userId = session()->get('id');
         
        // Load model
        $model = new ProfileModel();
        
        // Ambil data user berdasarkan ID
        $userData = $model->getUserById($userId);
        
        // Kirim data user ke view
        return view('app/profile', ['user' => $userData]);
    }
    public function update()
    {
        // Load model
        $model = new ProfileModel();
        
        // Ambil ID user dari session
        $userId = session()->get('id');
        
        // Ambil data dari form
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'updated_at'=> date('Y-m-d H:i:s')
        ];
        
        // Update data di database
        if ($model->updateUser($userId, $data)) {
            // Ambil data terbaru dari database
            $updatedUserData = $model->getUserById($userId);
        
            // Update session dengan data terbaru
            session()->set([
                'username' => $updatedUserData['username'],
                'email'    => $updatedUserData['email'],
                'role'     => $updatedUserData['role'],
            ]);
            return redirect()->to('/app/profile')->with('success', 'Profile berhasil diupdate.');
        } else {
            return redirect()->to('/app/profile')->with('error', 'Gagal mengupdate profile.');
        }
    }
}