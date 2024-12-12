<?php
namespace App\Controllers\App;

use App\Models\ProfileModel;
use CodeIgniter\Controller;

class Profile extends Controller
{
    public function index()
    {
        // Mengambil ID user dari session
        $userId = session()->get('id');

        // Load model
        $model = new ProfileModel();

        // Ambil data user berdasarkan ID
        $userData = $model->getUserById($userId);

        if (!$userData) {
            return redirect()->to('/app/login')->with('error', 'User tidak ditemukan.');
        }

        // Kirim data user ke view
        return view('app/profile', ['user' => $userData]);
    }
    public function update()
    {
        // Load model
        $model = new ProfileModel();

        // Ambil ID user dari session
        $userId = session()->get('id');

        // Ambil data user dari database
        $currentUser = $model->getUserById($userId);
        if (!$currentUser) {
            return redirect()->to('/app/profile')->with('error', 'User tidak ditemukan.');
        }

        // Validasi Input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[6]', // Password opsional
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', $validation->getErrors())->withInput();
        }

        // Data yang akan diupdate
        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Jika password diisi, hash terlebih dahulu
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password; // Tidak di-hash, langsung disimpan
        }

        // Update data di database
        if ($model->updateUser($userId, $data)) {
            // Update session data
            session()->set([
                'username' => $data['username'],
                'email'    => $data['email'],
            ]);

            return redirect()->to('/app/profile')->with('success', 'Profile berhasil diupdate.');
        } else {
            return redirect()->to('/app/profile')->with('error', 'Gagal mengupdate profile.');
        }
    }

}
