<?php

namespace App\Controllers\App;

use App\Models\GradingModel;
use App\Models\GoalModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;

class Grading extends Controller
{
    public function detail($city_name = 'DefaultCity')
    {
        // Validasi parameter
        if (empty($city_name)) {
            throw new \InvalidArgumentException("Parameter 'city_name' harus diberikan.");
        }

        // Instansiasi model
        $gradingModel = new GradingModel();
        $goalModel = new GoalModel();

        // Ambil data SDG berdasarkan nama kota
        $data['sdgData'] = $gradingModel->where('city_name', $city_name)->findAll();
        $data['sdgDataCount'] = count($data['sdgData']);

        // Jika data tidak ditemukan, tampilkan pesan error
        if (empty($data['sdgData'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Data SDG tidak ditemukan untuk kota: $city_name."
            );
        }

        // Ambil nama provinsi berdasarkan nama kota
        $cityData = $gradingModel->getCityWithProvince($city_name);
        $data['selectedProvince'] = $cityData['province_name'] ?? 'DefaultProvince';

        // Ambil logo provinsi
        $data['provinceLogo'] = $gradingModel->getProvinceLogo($data['selectedProvince']);

        // Ambil data goal dari database
        $goals = $goalModel->findAll();
        $goalMap = [];

        // Buat mapping goal berdasarkan data yang ada
        foreach ($goals as $goal) {
            if (!empty($goal['goal']) && !empty($goal['goal_name'])) {
                $goalMap[$goal['goal']] = $goal['goal_name'];
            }
        }

        // Proses setiap data SDG untuk menambahkan informasi tambahan
        foreach ($data['sdgData'] as &$item) {
            // Tetapkan goal_name berdasarkan goalMap
            $item['goal_name'] = $goalMap[$item['goal']] ?? 'Keterangan Tidak Tersedia';

            // Tentukan rating berdasarkan score
            $item['rating'] = isset($item['score']) && $item['score'] !== null 
                ? $this->determineRating($item['score']) 
                : 'N/A';
        }

        // Tambahkan data tambahan untuk view
        $data['selectedCity'] = $city_name;

        $data['query_rank'] = $this->request->getGet('rank');

        // Ambil nilai rating dari tabel achievement untuk kota yang dipilih
        $db = \Config\Database::connect(); // Hubungkan ke database
        $builder = $db->table('achievement'); // Nama tabel achievement
        $builder->select('rating');
        $builder->where('city_name', $city_name); // Filter berdasarkan nama kota
        $query = $builder->get();
        $result = $query->getRow();

        // Pastikan data dikirim ke view
        $rating = $result ? $result->rating : 0; // Default 0 jika tidak ditemukan
        $data['query_score'] = $rating;

        // Hitung total jumlah nama kota unik di tabel achievement
        $builder = $db->table('achievement');
        $builder->select('city_name');
        $builder->distinct(); // Hanya ambil nama kota yang unik
        $query = $builder->get();
        $data['sdgDataCount'] = $query->getNumRows(); // Hitung total nama kota unik

        $data['queryRankByProvince'] = $this->calculateRankByProvince($db, $data['selectedProvince'], $city_name);

                
        // Render view dengan data
        return view('app/grading', $data);
    }


    /**
     * Menentukan rating berdasarkan nilai skor
     *
     * @param int $score
     * @return string
     */
    private function determineRating($score)
    {
        if ($score < 50) {
            return 'EXCITER';
        } elseif ($score >= 50 && $score < 60) {
            return 'ENCOURAGER';
        } elseif ($score >= 60 && $score < 70) {
            return 'ADVOCATOR';
        } elseif ($score >= 70 && $score < 80) {
            return 'INNOVATOR';
        } elseif ($score >= 80 && $score <= 100) {
            return 'REVOLUTIONER';
        }
        return 'N/A';
    }
    function getGoalImage($goal) {
        $goalImages = [
            1 => base_url('public/dist/img/1.png'),
            2 => base_url('public/dist/img/2.png'),
            3 => base_url('public/dist/img/3.png'),
            4 => base_url('public/dist/img/4.png'),
            5 => base_url('public/dist/img/5.png'),
            6 => base_url('public/dist/img/6.png'),
            7 => base_url('public/dist/img/7.png'),
            8 => base_url('public/dist/img/8.png'),
            9 => base_url('public/dist/img/9.png'),
            10 => base_url('public/dist/img/10.png'),
            11 => base_url('public/dist/img/11.png'),
            12 => base_url('public/dist/img/12.png'),
            13 => base_url('public/dist/img/13.png'),
            14 => base_url('public/dist/img/14.png'),
            15 => base_url('public/dist/img/15.png'),
            16 => base_url('public/dist/img/16.png'),
            17 => base_url('public/dist/img/17.png'),
        ];

        return $goalImages[$goal] ?? base_url('public/assets/img/goals/default.png'); // Gambar default jika tidak cocok
    }
    private function calculateRankByProvince($db, $province, $currentCity)
    {
        // Ambil semua data rating untuk semua kota di provinsi yang sama
        $builder = $db->table('achievement');
        $builder->select('city_name, rating');
        $builder->where('province_name', $province); // Filter berdasarkan nama provinsi
        $query = $builder->get();
        $citiesInProvince = $query->getResultArray();

        // Debug: Log hasil data dari database
        error_log(print_r($citiesInProvince, true));

        // Hitung skor rata-rata setiap kota
        $cityRatings = [];
        foreach ($citiesInProvince as $city) {
            if (isset($city['city_name'], $city['rating']) && $city['rating'] !== null) {
                $cityRatings[$city['city_name']] = $city['rating'];
            }
        }

        // Debug: Log rating kota sebelum sorting
        error_log(print_r($cityRatings, true));

        // Urutkan kota berdasarkan rating (dari tertinggi ke terendah)
        arsort($cityRatings);

        // Debug: Log hasil setelah sorting
        error_log(print_r($cityRatings, true));

        // Cari peringkat untuk kota yang dipilih
        $rank = 1;
        foreach ($cityRatings as $cityName => $rating) {
            if ($cityName === $currentCity) {
                return $rank; // Kembalikan peringkat kota yang dipilih
            }
            $rank++;
        }

        return 0; // Jika kota tidak ditemukan, kembalikan 0
    }

}
