<?php
// Include your database connection
include './services/database.php';

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id_product = $_POST['id_product'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $type = $_POST['type'];

    // Validasi input
    if (empty($id_product) || empty($name) || !is_numeric($price) || !is_numeric($stock) || empty($type)) {
        echo "<script>alert('Invalid input data.');</script>";
    } else {
        // Update query
        $sql_update = "UPDATE product SET NAME = ?, PRICE = ?, STOCK = ?, TYPE = ? WHERE ID_PRODUCT = ?";
        $stmt = $conn->prepare($sql_update);

        // Change bind_param types to match your data typesed
        $stmt->bind_param("siiss", $name, $price, $stock, $type, $id_product);

        if ($stmt->execute()) {
            echo "<script>
                alert('Product updated successfully!');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
            </script>";
            exit();
        } else {
            echo "<script>alert('Failed to update product: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Handle form submission for deletion - Menambahkan pengecekan untuk delete_product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product']) && isset($_POST['id_product'])) {
    $id_product = $_POST['id_product'];

    // Validasi ID produk
    if (empty($id_product)) {
        echo "Error: Invalid product ID.";
    } else {
        // Delete query
        $sql_delete = "DELETE FROM product WHERE ID_PRODUCT = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("s", $id_product);

        if ($stmt->execute()) {
            echo "<script>alert('Product deleted successfully!');</script>";
            // Redirect or refresh the page
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

$sql = "SELECT ID_PRODUCT, NAME, STOCK, PRICE, TYPE FROM product";
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}
?>

<section class="container mx-auto">
    <div class="bg-white rounded-xl shadow-[8px_8px_16px_#d1d1d1,_-8px_-8px_16px_#ffffff] p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Produk</h2>
        <div class="mb-4">
        <div class="relative">
            <input type="text" 
                   id="searchInput" 
                   placeholder="Cari produk..." 
                   class="w-full px-4 py-2 pl-10 pr-8 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="py-4 px-4 text-left text-gray-700">ID Barang</th>
                        <th class="py-4 px-4 text-left text-gray-700">Nama Barang</th>
                        <th class="py-4 px-4 text-left text-gray-700">Harga</th>
                        <th class="py-4 px-4 text-left text-gray-700">Status</th>
                        <th class="py-4 px-4 text-left text-gray-700">Kuantitas</th>
                        <th class="py-4 px-4 text-left text-gray-700">Update</th>
                        <th class="py-4 px-4 text-left text-gray-700">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="bg-white border-b hover:bg-gray-100">
                                <td class="px-4 py-2 text-sm font-medium text-gray-700"><?= htmlspecialchars($row['ID_PRODUCT']); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($row['NAME']); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-600">Rp <?= number_format($row['PRICE'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-2 text-sm">
                                    <?= $row['STOCK'] > 0
                                        ? '<span class="text-green-600 font-semibold">Available</span>'
                                        : '<span class="text-red-600 font-semibold">Out of Stock</span>'; ?>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($row['STOCK']); ?></td>
                                <td class="px-4 py-2">
                                    <!-- Button to trigger the update modal -->
                                    <button type="button" class="bg-blue-500 text-white px-4 py-1 my-1 rounded hover:bg-blue-600" onclick="openUpdateModal(<?= $row['ID_PRODUCT']; ?>, '<?= htmlspecialchars($row['NAME']); ?>', <?= $row['PRICE']; ?>, <?= $row['STOCK']; ?>, '<?= htmlspecialchars($row['TYPE']); ?>')">
                                        Update
                                    </button>
                                </td>
                                <td class="px-4 py-2">
                                    <!-- Form untuk delete -->
                                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        <input type="hidden" name="id_product" value="<?= htmlspecialchars($row['ID_PRODUCT']); ?>">
                                        <input type="hidden" name="delete_product" value="1">
                                        <button type="submit" class="bg-red-500 text-black px-5 py-1 my-1 rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                No products found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Update Product -->
<div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-xl w-1/3">
        <h2 class="text-xl font-bold mb-4">Update Product</h2>
        <form method="POST" id="updateForm">
            <input type="hidden" name="id_product" id="modalIdProduct">
            <div class="mb-4">
                <label for="modalName" class="block text-gray-700">Product Name</label>
                <input type="text" id="modalName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="modalPrice" class="block text-gray-700">Price</label>
                <input type="number" id="modalPrice" name="price" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="modalStock" class="block text-gray-700">Stock</label>
                <input type="number" id="modalStock" name="stock" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="modalType" class="block text-gray-700">Product Type</label>
                <select id="modalType" name="type" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Tipe Barang</option>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                </select>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none" onclick="closeUpdateModal()">Cancel</button>
                <button type="submit" name="update_product" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if(text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>