<?php
namespace App\Controllers\App;

use App\Models\AchievementModel;
use CodeIgniter\Controller;

class Achievement extends Controller{
     public function index()
    {
        $achievementModel = new AchievementModel();

        // Ambil data filter dari query string
        $filters = [
            'city_name' => $this->request->getGet('search-kabupaten'),
            'region' => $this->request->getGet('region-dropdown'),
            'year' => $this->request->getGet('year-dropdown'),
        ];

        // Ambil data berdasarkan filter
        $data['achievement'] = $achievementModel->getAchievements($filters);
        $data['filters'] = $filters; // Kirim filter kembali ke view untuk mempertahankan nilai input

        return view('app/achievement', $data);
    }
}
?>