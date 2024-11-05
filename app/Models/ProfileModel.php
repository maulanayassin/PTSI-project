<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'users'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key tabel
    protected $allowedFields = ['username', 'email', 'password']; // Field yang diperbolehkan untuk di edit
    protected $useTimestamps = true;

    // Menyediakan metode untuk mengambil semua data pengguna
    public function getUsers() {
        return $this->findAll(); // Mengambil semua data dari tabel users
    }
    // // Menghapus user 
    // public function deleteUserById($id){
    //     return $this->delete($id);
    // }
    public function updateUser($id, $data){
        return $this->update($id,$data);
    }
    //  public function getProfile($id)
    // {
    //     return $this->where('id', $id)->first();
    // }
    public function getUserById($id)
    {
        return $this->where(['id' => $id])->first();
    }
}
?>