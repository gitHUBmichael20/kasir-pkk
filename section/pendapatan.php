<?php
include 'services/database.php';

if (!isset($_SESSION["is_login"]) || $_SESSION["is_login"] !== true) {
  header("Location: /kasir-pkk/index.php");
  exit;
  }

// Fungsi format rupiah
function formatRupiah($angka) {
  // Jika nilai null atau 0, kembalikan Rp 0
  if ($angka === null || $angka === 0) {
      return "Rp 0";
  }
  return "Rp " . number_format($angka, 0, ',', '.');
}

// Inisialisasi variabel filter tanggal
$where_clause = "";
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

if ($start_date && $end_date) {
  $where_clause = "WHERE DATE(transaction_date) BETWEEN ? AND ?";
}

// Query untuk mendapatkan total pendapatan
$sql_total = "SELECT 
    SUM(total_amount) as total_pendapatan,
    COUNT(*) as total_transaksi,
    MIN(total_amount) as transaksi_terkecil,
    MAX(total_amount) as transaksi_terbesar,
    AVG(total_amount) as rata_rata_transaksi
FROM transactions " . $where_clause;

$stmt = $conn->prepare($sql_total);
if ($where_clause) {
    $stmt->bind_param("ss", $start_date, $end_date);
}
$stmt->execute();
$result_total = $stmt->get_result()->fetch_assoc();

// Query untuk detail transaksi per hari
$sql_daily = "SELECT 
    DATE(transaction_date) as tanggal,
    COUNT(*) as jumlah_transaksi,
    SUM(total_amount) as total_harian
FROM transactions " . $where_clause . "
GROUP BY DATE(transaction_date)
ORDER BY tanggal DESC";

$stmt_daily = $conn->prepare($sql_daily);
if ($where_clause) {
    $stmt_daily->bind_param("ss", $start_date, $end_date);
}
$stmt_daily->execute();
$result_daily = $stmt_daily->get_result();
?>


    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Laporan Pendapatan</h1>
            
            <!-- Filter Form -->
            <form class="bg-white p-4 rounded-lg shadow-md mb-6 flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="<?= $start_date ?>" 
                           class="border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>" 
                           class="border rounded px-3 py-2">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Filter
                </button>
            </form>

            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-600">Total Pendapatan</h3>
                    <p class="text-2xl font-bold text-green-600"><?= formatRupiah($result_total['total_pendapatan']) ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-600">Total Transaksi</h3>
                    <p class="text-2xl font-bold text-blue-600"><?= $result_total['total_transaksi'] ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-600">Rata-rata Transaksi</h3>
                    <p class="text-2xl font-bold text-purple-600"><?= formatRupiah($result_total['rata_rata_transaksi']) ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-600">Transaksi Terbesar</h3>
                    <p class="text-2xl font-bold text-orange-600"><?= formatRupiah($result_total['transaksi_terbesar']) ?></p>
                </div>
            </div>

            <!-- Tabel Detail Transaksi per Hari -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <h2 class="text-xl font-bold p-4 bg-gray-50">Detail Pendapatan Harian</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php while ($row = $result_daily->fetch_assoc()): ?>
                            <tr>
                                <td class="px-6 py-4"><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                <td class="px-6 py-4"><?= $row['jumlah_transaksi'] ?></td>
                                <td class="px-6 py-4"><?= formatRupiah($row['total_harian']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol ke Dashboard -->
        <div class="fixed bottom-4 left-4">
            <a href="../dashboard.php" 
               class="bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </div>
    </div>