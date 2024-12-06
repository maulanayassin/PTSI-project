<?php
namespace App\Controllers\App;

use App\Models\GradingModel;
use App\Models\AchievementModel;
use CodeIgniter\Controller;

class Grading extends Controller{
    // public function index()
    // {
    //     $model = new GradingModel();
    //     $data['sdgData'] = $model->where('city_name', 'KOTA BANDA ACEH')
    //                               ->where('year', 2020)
    //                               ->findAll();
    //     return view('app/grading', $data);
    // }
    public function detail($city_name)
    {
        // Ambil data berdasarkan city_name dari tabel grading
        $gradingModel = new GradingModel();
        $achievementModel = new AchievementModel();

        // Cari data di tabel grading berdasarkan city_name
        $data['sdgData'] = $gradingModel->where('city_name', $city_name)->findAll();

        // Jika tidak ada data di grading untuk city_name yang diberikan, tampilkan pesan error
        if (empty($data['sdgData'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data SDG tidak ditemukan untuk kota: $city_name.");
        }

        // Dapatkan data achievement yang relevan dari tabel achievement untuk city_name yang sama
        $data['achievementData'] = $achievementModel->where('city_name', $city_name)->findAll();

        return view('app/grading', $data);
    }
}
?>