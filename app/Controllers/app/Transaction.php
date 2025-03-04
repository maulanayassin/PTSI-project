<?php

namespace App\Controllers\App;

use App\Models\TransactionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use CodeIgniter\Controller;

class Transaction extends Controller
{
    protected $transactionModel;
    protected $provinceModel;
    protected $cityModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->provinceModel = new ProvinceModel();
        $this->cityModel = new CityModel();
    }

    // Main index function for displaying transaction data
    public function index()
    {
        $data['transaksi'] = [];
        $data['provinsi'] = $this->provinceModel->findAll();
        return view('app/transaction', $data);
    }

    // Function to display form for adding or editing a transaction
   public function form($id = null)
    {
        $provinsi = $this->provinceModel->findAll();

        $data = [
            'provinsi' => $provinsi,
            'transaction' => $id ? $this->transactionModel->find($id) : null,
        ];

        // If editing, load cities for the selected province
        if ($id && $data['transaction']) {
            $data['cities'] = $this->cityModel->where('kemendagri_code', $data['transaction']['provinsi'])->findAll();
        }

        return view('app/transaction_form', $data);
    }

    // Handle form submission (insert or update transaction data)
    public function submit()
    {
        // Koneksi ke database
        $db = \Config\Database::connect();

        // Aturan validasi untuk input
        $validationRules = [
            'provinsi' => 'required',
            'kota' => 'required',
            'tahun' => 'required|numeric',
            'ket_nilai' => 'required',
            'nilai' => 'required|numeric', // Pastikan 'nilai' adalah angka
        ];

        // Jika validasi gagal, kembali ke form dengan pesan kesalahan
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyusun data dari input untuk disimpan ke database
        $data = [
            'province_id' => $this->request->getPost('provinsi'),
            'city_id' => $this->request->getPost('kota'),
            'year' => intval($this->request->getPost('tahun')), // Ubah menjadi integer
            'domain' => intval($this->request->getPost('domain')),
            'indicator_name' => $this->request->getPost('indikator_name'),
            'goal' => $this->request->getPost('goal'),
            'value' => $this->request->getPost('ket_nilai'),
            'value_fix' => intval(str_replace(',', '', $this->request->getPost('nilai'))), // Bersihkan nilai dan ubah menjadi integer
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Cek apakah ini adalah operasi update atau insert berdasarkan ID
        $id = $this->request->getPost('id');

        try {
            if ($id) {
                // Jika ada ID, lakukan update data
                $updateQuery = $db->table('transaction')->update($data, ['id' => $id]);
                if ($updateQuery) {
                    $message = 'Transaksi berhasil diperbarui';
                } else {
                    throw new \Exception('Gagal memperbarui transaksi');
                }
            } else {
                // Jika tidak ada ID, lakukan insert data
                $insertQuery = $db->table('transaction')->insert($data);
                if ($insertQuery) {
                    $message = 'Transaksi berhasil dibuat';
                } else {
                    throw new \Exception('Gagal membuat transaksi baru');
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }

        // Jika berhasil, redirect ke halaman transaksi dengan pesan sukses
        return redirect()->to('/app/transaction')->with('success', $message);
    }



    // Function to edit a transaction by ID
    public function edit($id)
    {
        // Menghubungkan ke database
        $db = \Config\Database::connect();

        // Menarik data transaksi berdasarkan ID
        $transaction = $this->transactionModel->find($id);
        
        if (!$transaction) {
            return redirect()->to('/app/transaction')->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Mengambil data provinsi
        $provinsi = $this->provinceModel->findAll();

        // Jika transaksi memiliki provinsi, ambil daftar kota berdasarkan provinsi tersebut
        $cities = [];
        if (isset($transaction['provinsi'])) {
            // Mengambil data kota berdasarkan kemendagri_code provinsi
            $cities = $this->cityModel->where('kemendagri_code', $transaction['provinsi'])->findAll();
        }

        // Menyiapkan data untuk tampilan
        $data = [
            'transaction' => $transaction,
            'provinsi' => $provinsi,
            'cities' => $cities,
        ];

        // Mengirim data ke tampilan (view)
        return view('app/transaction_form', $data);
    }


    // Update the transaction after editing
    public function update($id)
    {
        // Validation rules
        $validationRules = [
            'provinsi' => 'required',
            'kota' => 'required',
            'tahun' => 'required',
            'domain' => 'required',
            'indikator_name' => 'required',
            'no_indikator' => 'required',
            'goal' => 'required',
            'nilai' => 'required',
        ];

        // Validate input data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get data from form input
        $data = [
            'provinsi' => $this->request->getPost('provinsi'),
            'kota' => $this->request->getPost('kota'),
            'year' => $this->request->getPost('tahun'),
            'domain' => $this->request->getPost('domain'),
            'indicator_name' => $this->request->getPost('indikator_name'),
            'indicator_id' => $this->request->getPost('no_indikator'),
            'goal' => $this->request->getPost('goal'),
            'value_fix' => $this->request->getPost('nilai'),
            'growth_rate' => $this->request->getPost('growth_rate'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Update the transaction in the database
        $this->transactionModel->update($id, $data);

        return redirect()->to('/app/transaction')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function batal()
    {
        // Ambil data dari query string
        $selectedProvinsi = rawurlencode($this->request->getGet('provinsi') ?? '');
        $selectedKota = rawurlencode($this->request->getGet('kota') ?? '');
        $selectedTahun = rawurlencode($this->request->getGet('tahun') ?? '');
        
        // Ganti karakter titik dengan angka biasa untuk menghindari error
        $selectedDomain = rawurlencode(str_replace('.', '', $this->request->getGet('domain') ?? ''));

        // Debug Log - Cek jika data sudah valid
        log_message('error', "Provinsi: $selectedProvinsi, Kota: $selectedKota, Tahun: $selectedTahun, Domain: $selectedDomain");

        return redirect()->to('/app/transaction?' . http_build_query([
            'provinsi' => $selectedProvinsi,
            'kota'     => $selectedKota,
            'tahun'    => $selectedTahun,
            'domain'   => $selectedDomain,
        ]));
    }

    // Function to delete a transaction by ID
    public function delete($id)
    {
        $this->transactionModel->delete($id);
        return redirect()->to('/app/transaction')->with('success', 'Data berhasil dihapus.');
    }

    // Function to get transactions based on city code (AJAX request)
    public function getTransactionsByCity()
    {
        $request = $this->request->getJSON();
        $cityCode = $request->cityCode;
        $transactions = $this->transactionModel->where('city_id', $cityCode)->findAll();
        return $this->response->setJSON($transactions);
    }

    // Function to get cities based on province code (AJAX request)
    public function getCities()
    {
        $request = $this->request->getJSON();
        $provinceCode = $request->provinceCode;
        $cities = $this->cityModel->where('province_id', $provinceCode)->findAll();
        
        if (empty($cities)) {
            log_message('error', 'No cities found for province: ' . $provinceCode);
        }

        return $this->response->setJSON($cities);
    }

    // Function to get transactions by city and domain (AJAX request)
    public function getTransactionsByCityAndDomain()
    {
        if ($this->request->isAJAX()) {
            $cityCode = $this->request->getPost('cityCode');
            $domain = $this->request->getPost('domain');

            $transactions = $this->transactionModel
                ->where('city_id', $cityCode)
                ->where('domain', $domain)
                ->findAll();

            return $this->response->setJSON($transactions);
        }
    }

    public function getCitiesByProvince($provinceId)
    {
        $cities = $this->cityModel->where('province_id', $provinceId)->findAll();
        return $this->response->setJSON($cities);
    }


    // Function to fetch transaction data based on year and city name
    public function processGrowth($year, $city_id, $province_id, $domain_id)
    {
        $db = \Config\Database::connect();

        // SQL untuk SELECT data yang telah diperbarui
        $selectSql = "";
        switch ($domain_id) {
            case "1":
                $selectSql = "
                    SELECT t.id, t.year, t.province_id, t.city_id, t.city_name, i.indicator_name, 
                        t.indicator_id, t.goal, t.domain, t.value_fix, t.polaritas,
                        (
                            SELECT MAX(value_fix) 
                            FROM sdg_ptsi.transaction AS t1 
                            WHERE t1.year = t.year - 1 
                            AND t1.city_id = t.city_id 
                            AND t1.province_id = t.province_id 
                            AND t1.indicator_id = t.indicator_id
                        ) AS value_sebelumnya,
                        CASE 
                            WHEN t.polaritas = 'Negatif' THEN 
                                (SELECT MAX(value_fix) 
                                FROM sdg_ptsi.transaction AS t1 
                                WHERE t1.year = t.year - 1 
                                AND t1.city_id = t.city_id 
                                AND t1.province_id = t.province_id 
                                AND t1.indicator_id = t.indicator_id) - t.value_fix
                            ELSE 
                                t.value_fix - 
                                (SELECT MAX(value_fix) 
                                FROM sdg_ptsi.transaction AS t1 
                                WHERE t1.year = t.year - 1 
                                AND t1.city_id = t.city_id 
                                AND t1.province_id = t.province_id 
                                AND t1.indicator_id = t.indicator_id)
                        END AS growth_rate
                    FROM sdg_ptsi.transaction t 
                    LEFT JOIN sdg_ptsi.indicator i 
                    ON t.indicator_id = i.no_indicator
                    WHERE t.province_id = ? 
                    AND t.city_id = ? 
                    AND t.year = ?    
                    AND t.domain = ?;
                ";
                break;
            case "2":
            $selectSql = "
                SELECT 
                    t.id,
                    t.indicator_id, 
                    i.indicator_name, 
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    MAX(t.value_fix) AS nilai_utama, 
                    t.value_fix, 
                    t.verification AS growth_rate,
                    CASE
                        WHEN t.verification = 'TRUE' THEN t.value_fix * 2
                        ELSE t.value_fix
                    END AS nilai_akhir
                FROM sdg_ptsi.transaction t
                LEFT JOIN sdg_ptsi.indicator i 
                    ON t.indicator_id = i.no_indicator
                WHERE 
                    t.province_id = ? 
                    AND t.city_id = ? 
                    AND t.year = ? 
                    AND t.domain = ? 
                    AND t.value_fix <> 0
                GROUP BY 
                    t.id,
                    t.indicator_id, 
                    i.indicator_name, 
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    t.verification, 
                    t.value_fix;
            ";
            break;
        case "3":
            $selectSql = "
                SELECT 
                    t.id,
                    t.indicator_id, 
                    i.indicator_name, 
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    MAX(t.value_fix) AS value_fix, 
                    t.value_fix AS original_value_fix,
                    sumber.min_value_fix,
                    sumber.max_value_fix,
                    (sumber.max_value_fix - sumber.min_value_fix) / 3 AS rentang, 
                    sumber.min_value_fix AS score0_batas_bawah,
                    sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) AS score0_batas_atas,
                    sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) AS score1_batas_bawah,
                    sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) AS score1_batas_atas,
                    sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) AS score2_batas_bawah,
                    sumber.max_value_fix AS score2_batas_atas, 
                    CASE
                        WHEN MAX(t.value_fix) BETWEEN sumber.min_value_fix AND 
                            sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) THEN 0
                        WHEN MAX(t.value_fix) BETWEEN sumber.min_value_fix + ((sumber.max_value_fix - sumber.min_value_fix) / 3) AND 
                            sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) THEN 1
                        WHEN MAX(t.value_fix) BETWEEN sumber.min_value_fix + (2 * ((sumber.max_value_fix - sumber.min_value_fix) / 3)) AND 
                            sumber.max_value_fix THEN 2
                        ELSE NULL
                    END AS growth_rate
                FROM sdg_ptsi.transaction t
                LEFT JOIN sdg_ptsi.indicator i 
                    ON t.indicator_id = i.no_indicator
                LEFT JOIN (
                    SELECT 
                        indicator_id, 
                        domain, 
                        MIN(value_fix) AS min_value_fix, 
                        MAX(value_fix) AS max_value_fix
                    FROM sdg_ptsi.transaction 
                    WHERE domain = 3 
                    GROUP BY indicator_id, domain
                ) AS sumber 
                    ON t.indicator_id = sumber.indicator_id AND t.domain = sumber.domain
                WHERE 
                    t.province_id = ? 
                    AND t.city_id = ? 
                    AND t.year = ? 
                    AND t.domain = ?
                GROUP BY 
                    t.id,
                    t.indicator_id, 
                    i.indicator_name, 
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    t.value_fix,
                    sumber.min_value_fix, 
                    sumber.max_value_fix;
            ";
            break;
        case "3.1":
            $selectSql = "
                SELECT 
                    t.id,
                    t.indicator_id, 
                    t.indicator_name,
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    MAX(t.value_fix) AS nilai_utama, 
                    t.value_fix, 
                    t.verification AS growth_rate,
                    CASE
                        WHEN t.verification = 'TRUE' THEN t.value_fix * 2
                        ELSE t.value_fix
                    END AS nilai_akhir
                FROM sdg_ptsi.transaction t
                WHERE 
                    t.province_id = ? 
                    AND t.city_id = ? 
                    AND t.year = ? 
                    AND t.domain = ? 
                    AND t.value_fix <> 0
                GROUP BY 
                    t.id,
                    t.indicator_id, 
                    t.indicator_name,
                    t.city_name, 
                    t.domain, 
                    t.goal, 
                    t.verification, 
                    t.value_fix;
            ";
            break;
            default:
                return $this->response->setJSON(['error' => 'Domain tidak valid']);
        }

        // Eksekusi query SELECT untuk mendapatkan data yang telah diperbarui
        $query = $db->query($selectSql, [$province_id, $city_id, $year, $domain_id]);
        
        // Mengembalikan hasil dalam format JSON
        return $this->response->setJSON($query->getResult());
    }

}
