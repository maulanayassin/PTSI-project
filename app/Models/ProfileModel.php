<?php

// namespace App\Models;

// use CodeIgniter\Model;

// class UserModel extends Model
// {
//     protected $table            = 'users';
//     protected $primaryKey       = 'id';
//     protected $useAutoIncrement = true;
//     protected $returnType       = 'array';
//     protected $useSoftDeletes   = false;
//     protected $protectFields    = true;
//     protected $allowedFields    = [];

//     protected bool $allowEmptyInserts = false;
//     protected bool $updateOnlyChanged = true;

//     protected array $casts = [];
//     protected array $castHandlers = [];

//     // Dates
//     protected $useTimestamps = false;
//     protected $dateFormat    = 'datetime';
//     protected $createdField  = 'created_at';
//     protected $updatedField  = 'updated_at';
//     // protected $deletedField  = 'deleted_at';

//     // Validation
//     protected $validationRules      = [];
//     protected $validationMessages   = [];
//     protected $skipValidation       = false;
//     protected $cleanValidationRules = true;

//     // Callbacks
//     protected $allowCallbacks = true;
//     protected $beforeInsert   = [];
//     protected $afterInsert    = [];
//     protected $beforeUpdate   = [];
//     protected $afterUpdate    = [];
//     protected $beforeFind     = [];
//     protected $afterFind      = [];
//     protected $beforeDelete   = [];
//     protected $afterDelete    = [];

// class UserModel extends Model
// {
//     protected $table = 'users'; // nama table
//     protected $primaryKey = 'id';
//     protected $allowedFields = ['email'];
// }


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