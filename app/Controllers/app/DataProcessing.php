<?php

namespace App\Controllers\App;

use CodeIgniter\Controller;

class DataProcessing extends Controller
{
    public function index()
    {
        return view('app/data_processing');
    }

    public function processData()
    {
        ini_set('max_execution_time',300);
        $selectedDomains = $this->request->getPost('domains') ?? [];

        if (empty($selectedDomains)) {
            return redirect()->to('app/dataprocessing')->with('error', 'Anda harus memilih setidaknya satu domain untuk diproses.');
        }

        $db = \Config\Database::connect();

        try {
            $db->transStart();

            foreach ($selectedDomains as $domain) {
                $this->processDomain($db, $domain); // Memanggil fungsi tunggal
            }

            // Setelah semua domain diproses, lakukan kalkulasi Achievement dan Grading
            $this->calculateAchievement($db);
            $this->calculateGrading($db);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to('app/dataprocessing')->with('success', 'Pemrosesan selesai dengan sukses!');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $db->transRollback();
            return redirect()->to('app/dataprocessing')->with('error', 'Pemrosesan gagal.');
        }
    }

    private function processDomain($db, $domain)
    {
        $sql = "";

        switch ($domain) {
            case 'domain_1':
                $sql = "
                    UPDATE sdg_ptsi.transaction t
                    SET t.nilai_akhir = (
                        SELECT 
                            CASE
                                WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate AND 
                                    sumber.min_growth_rate + ((sumber.max_growth_rate - sumber.min_growth_rate) / 3) THEN 0
                                WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate + ((sumber.max_growth_rate - sumber.min_growth_rate) / 3) AND 
                                    sumber.min_growth_rate + (2 * ((sumber.max_growth_rate - sumber.min_growth_rate) / 3)) THEN 1
                                WHEN MAX(t_inner.growth_rate) BETWEEN sumber.min_growth_rate + (2 * ((sumber.max_growth_rate - sumber.min_growth_rate) / 3)) AND 
                                    sumber.max_growth_rate THEN 2
                                ELSE NULL
                            END AS nilai_akhir
                        FROM sdg_ptsi.transaction t_inner
                        LEFT JOIN (
                            SELECT 
                                indicator_id,
                                domain, 
                                MIN(growth_rate) AS min_growth_rate, 
                                MAX(growth_rate) AS max_growth_rate 
                            FROM sdg_ptsi.transaction 
                            WHERE domain = 1
                            GROUP BY indicator_id, domain
                        ) AS sumber 
                        ON t_inner.indicator_id = sumber.indicator_id
                        AND t_inner.domain = sumber.domain
                        WHERE 
                            t_inner.year = 2020
                            AND t_inner.domain = 1
                            AND t.indicator_id = t_inner.indicator_id
                            AND t.city_name = t_inner.city_name
                    )
                    WHERE t.domain = 1 AND t.year = 2020;
                ";
                break;

            case 'domain_2':
                $sql = "
                    UPDATE sdg_ptsi.transaction t
                    SET t.nilai_akhir = (
                        SELECT 
                            CASE
                                WHEN t_inner.verification = 'TRUE' THEN t_inner.value_fix * 2
                                ELSE t_inner.value_fix
                            END AS nilai_akhir
                        FROM sdg_ptsi.transaction t_inner
                        WHERE 
                            t_inner.year = 2020
                            AND t_inner.domain = 2
                            AND t_inner.value_fix <> 0
                            AND t.indicator_id = t_inner.indicator_id
                            AND t.city_name = t_inner.city_name
                        GROUP BY 
                            t_inner.indicator_id, 
                            t_inner.city_name, 
                            t_inner.domain, 
                            t_inner.verification, 
                            t_inner.value_fix
                    )
                    WHERE t.domain = 2 AND t.year = 2020;
                ";
                break;

            case 'domain_3A':
                $sql = "
                    UPDATE sdg_ptsi.transaction t
                    SET t.nilai_akhir = (
                        SELECT 
                            CASE
                                WHEN t_inner.verification = 'TRUE' THEN t_inner.value_fix * 2
                                ELSE t_inner.value_fix
                            END AS nilai_akhir
                        FROM sdg_ptsi.transaction t_inner
                        WHERE 
                            t_inner.year = 2020
                            AND t_inner.domain = 3.1
                            AND t_inner.value_fix <> 0
                            AND t.indicator_id = t_inner.indicator_id
                            AND t.city_name = t_inner.city_name
                        GROUP BY 
                            t_inner.indicator_id, 
                            t_inner.city_name, 
                            t_inner.domain, 
                            t_inner.verification, 
                            t_inner.value_fix
                    )
                    WHERE t.domain = 3.1 AND t.year = 2020;
                ";
                break;

            case 'domain_3B':
                $sql = "
                    UPDATE sdg_ptsi.transaction t
                    SET t.nilai_akhir = (
                        SELECT 
                            CASE
                                WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix AND 
                                    sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) THEN 0
                                WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) AND 
                                    sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) THEN 1
                                WHEN MAX(t_inner.value_fix) BETWEEN sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) AND 
                                    sumber.max_value_fix THEN 2
                                ELSE NULL
                            END AS nilai_akhir
                        FROM 
                            sdg_ptsi.transaction t_inner
                        LEFT JOIN (
                            SELECT 
                                indicator_id, 
                                domain, 
                                MIN(value_fix) AS min_value_fix, 
                                MAX(value_fix) AS max_value_fix
                            FROM 
                                sdg_ptsi.transaction
                            WHERE 
                                domain = 3 
                            GROUP BY 
                                indicator_id, 
                                domain
                        ) AS sumber
                        ON t_inner.indicator_id = sumber.indicator_id  
                        AND t_inner.domain = sumber.domain
                        WHERE 
                            t_inner.year = 2020 
                            AND t_inner.domain = 3 
                            AND t.indicator_id = t_inner.indicator_id
                            AND t.city_name = t_inner.city_name
                    )
                    WHERE t.domain = 3 
                    AND t.year = 2020;
                ";
                break;

            default:
                throw new \Exception("Invalid domain provided.");
        }

        if (!empty($sql)) {
            $db->query($sql);
        }
    }

    private function calculateAchievement($db)
    {
        $sql = "
            UPDATE sdg_ptsi.achievement g
            JOIN (
                SELECT 
                    city_name, 
                    SUM(CASE WHEN domain = 'Domain 1' THEN total_nilai END) / 58 * 100 AS domain_1,
                    SUM(CASE WHEN domain = 'Domain 2' THEN total_nilai END) / 136 * 100 AS domain_2,
                    SUM(CASE WHEN domain = 'Domain 3A' THEN total_nilai END) / 90 * 50 AS domain_3A,
                    SUM(CASE WHEN domain = 'Domain 3B' THEN total_nilai END) / 92 * 50 AS domain_3B,
                    SUM(total_nilai) / 3 AS rating, 
                    CASE
                        WHEN SUM(total_nilai) / 3 >= 10 AND SUM(total_nilai) / 3 < 50 THEN 'EXCITER'
                        WHEN SUM(total_nilai) / 3 >= 50 AND SUM(total_nilai) / 3 < 60 THEN 'ENCOURAGER'
                        WHEN SUM(total_nilai) / 3 >= 60 AND SUM(total_nilai) / 3 < 70 THEN 'ADVOCATOR'
                        WHEN SUM(total_nilai) / 3 >= 70 AND SUM(total_nilai) / 3 < 80 THEN 'INNOVATOR'
                        WHEN SUM(total_nilai) / 3 >= 80 AND SUM(total_nilai) / 3 <= 100 THEN 'REVOLUTIONER'
                        ELSE 'UNDEFINED'
                    END AS champion_grade
                FROM (
                    SELECT 
                        'Domain 1' AS domain, 
                        city_name, 
                        SUM(nilai_akhir) AS total_nilai
                    FROM sdg_ptsi.`transaction` t
                    WHERE domain = 1 AND nilai_akhir > 0
                    GROUP BY city_name
                    UNION ALL
                    SELECT 
                        'Domain 2' AS domain, 
                        city_name, 
                        SUM(nilai_akhir) AS total_nilai
                    FROM sdg_ptsi.`transaction` t
                    WHERE domain = 2 AND nilai_akhir > 0
                    GROUP BY city_name
                    UNION ALL
                    SELECT 
                        'Domain 3A' AS domain, 
                        city_name, 
                        SUM(nilai_akhir) AS total_nilai
                    FROM sdg_ptsi.`transaction` t
                    WHERE domain = 3.1 AND nilai_akhir > 0
                    GROUP BY city_name
                    UNION ALL
                    SELECT 
                        'Domain 3B' AS domain, 
                        city_name, 
                        SUM(nilai_akhir) AS total_nilai
                    FROM sdg_ptsi.`transaction` t
                    WHERE domain = 3 AND nilai_akhir > 0
                    GROUP BY city_name
                ) domain_totals
                GROUP BY city_name
            ) dt ON g.city_name = dt.city_name
            SET 
                g.domain1 = dt.domain_1,
                g.domain2 = dt.domain_2,
                g.domain3A = dt.domain_3A,
                g.domain3B = dt.domain_3B,
                g.rating = dt.rating,
                g.champion_grade = dt.champion_grade;
            "; // Kalkulasi Achievement
        $db->query($sql);
    }

    private function calculateGrading($db)
    {
        $sql = "
            UPDATE sdg_ptsi.grading g
            JOIN (
                SELECT 
                    goal, -- Identifikasi goal
                    city_name, 
                    SUM(nilai_akhir) AS total_nilai,
                    SUM(score_total) AS total_score
                FROM sdg_ptsi.`transaction` t
                WHERE nilai_akhir > 0 AND score_total > 0 
                GROUP BY goal, city_name
            ) gt ON g.city_name = gt.city_name AND g.goal = gt.goal
            SET 
                g.score = gt.total_nilai / gt.total_score * 100"; // Kalkulasi Grading
        $db->query($sql);
    }
}
