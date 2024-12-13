<?php
namespace App\Controllers\App;

use App\Models\HomeModel;
use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('auth/login');
        }

        $homeModel = new HomeModel();

        // Ambil data pencapaian
        $achievementData = $homeModel->getAchievementData();

        // Ambil region dari query string (default: null jika tidak ada)
        $region = $this->request->getVar('region');
        $chartType = $this->request->getVar('chartType'); // This will define which chart filter is applied

        // Filter data berdasarkan region untuk masing-masing chart
        if ($region) {
            if ($chartType === 'top10') {
                $achievementData = array_filter($achievementData, function ($achievement) use ($region) {
                    return $achievement['region'] === $region;
                });
            } elseif ($chartType === 'distribution') {
                $achievementData = array_filter($achievementData, function ($achievement) use ($region) {
                    return $achievement['region'] === $region;
                });
            } elseif ($chartType === 'sdg') {
                $achievementData = array_filter($achievementData, function ($achievement) use ($region) {
                    return $achievement['region'] === $region;
                });
            }
        }

        // Filter and sort Top 10 cities by rating
        usort($achievementData, function ($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });

        $topAchievements = array_slice($achievementData, 0, 10);

        // Prepare data for Top 10 chart
        $cityNames = array_column($topAchievements, 'city_name');
        $ratings = array_column($topAchievements, 'rating');

        // Prepare regions data
        $regions = array_unique(array_column($achievementData, 'region'));

        // SDG goal labels
        $goalLabels = [
            'Goal 1: No Poverty',
            'Goal 2: Zero Hunger',
            'Goal 3: Good Health and Well-being',
            'Goal 4: Quality Education',
            'Goal 5: Gender Equality',
            'Goal 6: Clean Water and Sanitation',
            'Goal 7: Affordable and Clean Energy',
            'Goal 8: Decent Work and Economic Growth',
            'Goal 9: Industry, Innovation, and Infrastructure',
            'Goal 10: Reduced Inequality',
            'Goal 11: Sustainable Cities and Communities',
            'Goal 12: Responsible Consumption and Production',
            'Goal 13: Climate Action',
            'Goal 14: Life Below Water',
            'Goal 15: Life on Land',
            'Goal 16: Peace, Justice, and Strong Institutions',
            'Goal 17: Partnerships for the Goals'
        ];

        // Fetch average scores for SDG goals
        $db = \Config\Database::connect();
        $goalRatings = $this->getAverageScores($db);

        // Pass data to the view
        $data = [
            'achievementData' => $achievementData,
            'cityNames' => $cityNames,
            'ratings' => $ratings,
            'goalLabels' => $goalLabels,
            'regions' => $regions,
            'selectedRegion' => $region,
            'goalRatings' => $goalRatings
        ];

        return view('app/home', $data);
    }

    

    /**
     * Mengambil nilai rata-rata skor dari database untuk masing-masing SDG goal
     *
     * @param object $db Database connection instance
     * @return array
     */
    public function getAverageScores($db)
    {
        // Query untuk mengambil nilai rata-rata skor berdasarkan masing-masing goal
        $query = $db->table('grading')
            ->select('goal, AVG(score) as average_score')
            ->groupBy('goal')
            ->get();

        // Ambil hasil query
        $results = $query->getResult();

        // Persiapkan data hasil sebagai array
        $goalRatings = [];
        foreach ($results as $result) {
            $goalRatings[$result->goal] = round($result->average_score); // Rata-rata dibulatkan
        }

        return $goalRatings;
    }
}