<?php

include('./services/database.php');
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kuantitas = $_POST['kuantitas'];
    $tipe = $_POST['tipe'];

    // Remove ID_PRODUCT from the SQL query if it's no longer required
    $sql = "INSERT INTO product (NAME, PRICE, STOCK, TYPE) VALUES ('$nama', '$harga', '$kuantitas', '$tipe')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product added successfully!');</script>";
        // Refresh page after 3 seconds
        echo "<meta http-equiv='refresh' content='1'>";
    } else {
        echo "<script>alert('Failed to add product: " . mysqli_error($conn) . "');</script>";
    }
}

?>



<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-xl p-6 m-20">
    <h2 class="text-2xl font-bold mb-6">Form Produk</h2>
    <form method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nama Barang -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                    Nama Barang
                </label>
                <input type="text" id="nama" name="nama"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Harga Barang -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="harga">
                    Harga Barang
                </label>
                <input type="number" id="harga" name="harga"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Kuantitas -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="kuantitas">
                    Kuantitas Barang
                </label>
                <input type="number" id="kuantitas" name="kuantitas"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Tipe Barang -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tipe">
                    Tipe Barang
                </label>
                <select id="tipe" name="tipe"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Tipe Barang</option>
                    <option value="minuman">Minuman</option>
                    <option value="makanan">Makanan</option>
                </select>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-4 mt-6">
            <button type="reset"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none">
                Batal
            </button>
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">
                Tambah
            </button>
        </div>
    </form>
</div>