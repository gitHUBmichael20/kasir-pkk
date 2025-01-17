<?php
session_start();
include '../services/database.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Fungsi format rupiah
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Fungsi untuk mendapatkan info produk
function getProdukInfo($conn, $id_produk) {
    $stmt = $conn->prepare("SELECT * FROM product WHERE ID_PRODUCT = ?");
    $stmt->bind_param("s", $id_produk);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Handle tambah ke keranjang
if (isset($_POST['tambah_ke_keranjang'])) {
    $id_produk = $_POST['produk'];
    $jumlah = (int)$_POST['jumlah'];
    
    $produk = getProdukInfo($conn, $id_produk);
    
    if ($produk && $jumlah > 0 && $jumlah <= $produk['STOCK']) {
        $item = [
            'id' => $produk['ID_PRODUCT'],
            'nama' => $produk['NAME'],
            'harga' => $produk['PRICE'],
            'jumlah' => $jumlah,
            'subtotal' => $produk['PRICE'] * $jumlah
        ];
        
        $_SESSION['keranjang'][] = $item;
        $_SESSION['pesan'] = "Produk berhasil ditambahkan ke keranjang.";
    } else {
        $_SESSION['pesan'] = "Gagal menambahkan produk. Periksa stok.";
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle hapus dari keranjang
if (isset($_POST['hapus_item'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['keranjang'][$index])) {
        unset($_SESSION['keranjang'][$index]);
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // Reindex array
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle proses pembayaran
if (isset($_POST['proses_pembayaran'])) {
    $total = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total += $item['subtotal'];
    }
    
    $uang_diterima = (int)$_POST['uang_diterima'];
    
    if ($uang_diterima >= $total && !empty($_SESSION['keranjang'])) {
        // Mulai transaksi
        $conn->begin_transaction();
        
        try {
            // Insert ke tabel transaksi
            $sql_transaksi = "INSERT INTO transactions (total_amount, payment_amount) VALUES (?, ?)";
            $stmt = $conn->prepare($sql_transaksi);
            $stmt->bind_param("ii", $total, $uang_diterima);
            $stmt->execute();
            $id_transaksi = $conn->insert_id;
            
            // Insert detail transaksi dan update stok
            foreach ($_SESSION['keranjang'] as $item) {
                // Insert detail
                $sql_detail = "INSERT INTO transaction_details (transaction_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_detail);
                $stmt->bind_param("iiid", $id_transaksi, $item['id'], $item['jumlah'], $item['harga']);
                $stmt->execute();
                
                // Update stok
                $sql_stok = "UPDATE product SET STOCK = STOCK - ? WHERE ID_PRODUCT = ?";
                $stmt = $conn->prepare($sql_stok);
                $stmt->bind_param("is", $item['jumlah'], $item['id']);
                $stmt->execute();
            }
            
            $conn->commit();
            $_SESSION['keranjang'] = []; // Kosongkan keranjang
            $_SESSION['pesan_sukses'] = "Pembayaran berhasil! Kembalian: " . formatRupiah($uang_diterima - $total);
            
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['pesan_error'] = "Gagal memproses pembayaran: " . $e->getMessage();
        }
    } else {
        $_SESSION['pesan_error'] = "Pembayaran gagal. Periksa uang yang diberikan.";
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua produk yang tersedia
$sql = "SELECT ID_PRODUCT, NAME, PRICE, STOCK FROM product WHERE STOCK > 0";
$result = $conn->query($sql);

// Hitung total
$total_belanja = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_belanja += $item['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4">
                <?= $_SESSION['pesan']; ?>
                <?php unset($_SESSION['pesan']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['pesan_sukses'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <?= $_SESSION['pesan_sukses']; ?>
                <?php unset($_SESSION['pesan_sukses']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['pesan_error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?= $_SESSION['pesan_error']; ?>
                <?php unset($_SESSION['pesan_error']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bagian Kiri - Pemilihan Produk -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Pilih Produk</h2>
                
                <form method="POST" action="">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Produk</label>
                        <select name="produk" class="w-full p-2 border rounded" required id="productSelect">
                            <option value="">Pilih Produk</option>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <option value="<?= $row['ID_PRODUCT'] ?>">
                                    <?= $row['NAME'] ?> - <?= formatRupiah($row['PRICE']) ?> 
                                    (Stok: <?= $row['STOCK'] ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Jumlah</label>
                        <input type="number" name="jumlah" min="1" value="1" 
                               class="w-full p-2 border rounded" required>
                    </div>
                    
                    <button type="submit" name="tambah_ke_keranjang" 
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>

            <!-- Bagian Kanan - Keranjang dan Pembayaran -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Keranjang Belanja</h2>
                
                <div class="mb-4 max-h-96 overflow-y-auto">
                    <table class="w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="py-2">Produk</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2">Subtotal</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['keranjang'] as $index => $item): ?>
                                <tr class="border-b">
                                    <td class="py-2"><?= $item['nama'] ?></td>
                                    <td class="py-2 text-center"><?= $item['jumlah'] ?></td>
                                    <td class="py-2 text-right"><?= formatRupiah($item['harga']) ?></td>
                                    <td class="py-2 text-right"><?= formatRupiah($item['subtotal']) ?></td>
                                    <td class="py-2 text-center">
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" name="hapus_item" 
                                                    class="text-red-500 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold"><?= formatRupiah($total_belanja) ?></span>
                    </div>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Uang Diterima</label>
                            <input type="number" name="uang_diterima" 
                                   class="w-full p-2 border rounded" required>
                        </div>
                        
                        <button type="submit" name="proses_pembayaran" 
                                class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                            Proses Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tombol ke Dashboard (Disederhanakan) -->
        <div class="fixed bottom-4 left-4">
            <a href="../dashboard.php" 
               class="bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700 ">
               <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </div>
    </div>

</body>
</html>
    <!-- Script untuk pencarian di dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('productSelect');
            
            // Tambahkan event listener untuk pencarian
            productSelect.addEventListener('keyup', function(e) {
                const searchText = e.target.value.toLowerCase();
                const options = productSelect.options;
                
                for (let i = 0; i < options.length; i++) {
                    const option = options[i];
                    const text = option.text.toLowerCase();
                    
                    if (text.includes(searchText)) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            });
        });
    </script>