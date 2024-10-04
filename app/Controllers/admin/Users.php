<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;
use App\Models\UserModel;

class Users extends Controller
{
    public function index()
    {
        $model = new UserModel();
        try {
            $db = Database::connect();
            echo "Connected to database: " . $db->getDatabase();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        $data['users'] = $model->findAll();
        return view('app/admin/users', $data);
    }
    public function create()
    {
        return view('app/admin/users_form');
        // try {
        //     $db = Database::connect();
        //     echo "Create : Connected to database: " . $db->getDatabase();
        // } catch (\Exception $e) {
        //     echo "Error: " . $e->getMessage();
        // }
    }
    public function delete($id)
    {
        $model = new UserModel();
        if ($model->find($id)) {
            // Hapus pengguna
            if ($model->deleteUserById($id)) {
                return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
            } else {
                return redirect()->to('/admin/users')->with('error', 'Gagal menghapus user.');
            }
        } else {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }
    }
    public function submit(){
        $model = new UserModel();
        $password = bin2hex(random_bytes(4)); // membuat password acak untuk pengguna
        $hashedPassword   = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'password'  => $hashedPassword,
            'password_plain' => $password
        ];
        if($model->save($data)){
            return redirect()->to('/admin/users')->with('success', 'User berhasil disimpan.');
        }else{
            return redirect()->to('/admin/users/create')->with('error', 'Gagal menyimpan user.');
        }
    }
    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id); // Temukan user berdasarkan ID

        // Cek jika user ditemukan
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Kirim data user ke view edit
        $data['user'] = $user;
        return view('app/admin/users_edit', $data);
    }
    public function update($id){
        $model = new UserModel();
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'updated_at'=> date('Y-m-d H:i:s')
        ];
        if($model->update($id, $data)){
            return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
        }else{
            return redirect()->to('/admin/users_edit')->with('error', 'Gagal mengupdate user.');
        }
    }
}