<?php 
namespace App\Controllers\App;

use config\Session;
use CodeIgniter\Controller;
use config\Database;

class Home extends Controller{
    public function index(){
        $session = session();
        if(!$session->get('isLoggedIn')){
            return redirect()->to('auth/login');
        }
        
        return view('app/home');
    }
    public function home(){
        return view('app/home');
    }
}

?>