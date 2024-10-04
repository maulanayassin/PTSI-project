<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Database;

class Auth extends Controller
{
    public function index(){
        $session = session();

        // cek user login 
        if(!$session->get('isLoggedIn')){
            return redirect()->to('/auth/login');
        }
        else{
            return redirect()->to('/app');
        }
    }

    public function login(){
        $session = session();
        //
        if(!$session->get('isLoggedIn')){
            return view('login');
        }
    }
    public function do_validate(){  
        $session = session();
        //$model = new UserModel();
        
        // simulasi login user dengan data di database
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        // $role = ''; // ganti sesuai role yang dimiliki user (admin/user)
        // $user = $model->getUserByUsernameAndPassword($username, $password);

        $db = Database::connect();
        $row_user = $db->table('users')
            ->where('username', $username)
            ->where('password', $password)
            //->where('role', $role)
            ->get()->getRow();
        
        // Login
        //Login berhasil 
        if($row_user !== null){
            $session->set([
                'isLoggedIn' => true,
                'id'         => $row_user->id,
                // 'nama'       => $row_user->nama,
                // 'email'      => $row_user->email,
                'username'   => $username,
                'password'   => $password,
                'role'       => $row_user->role,
                //'role'     => $user,
            ]);
            //mengarahkan ke dashboard
            return redirect()->to('/app');
        }else{
            // Login gagal 
            return view('login', ['error' => 'Username or password is incorrect']);
        }    
    }

    public function logout(){
        // mematikan sesi login
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
