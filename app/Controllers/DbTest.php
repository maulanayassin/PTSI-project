<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DbTest extends Controller
{
    public function index()
    {
        // memerikas koneksi ke database
        try{
            $db = Database::connect();
            echo "Connected to database: ". $db->getDatabase();
        }
        catch(\Exception $e){
            echo "Error: ". $e->getMessage();
        }
    }
}
