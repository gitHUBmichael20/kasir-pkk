<?php
// Include your database connection
include './services/database.php'; // Ensure this path is correct

// Fetch data from the database
$sql = "SELECT ID_PRODUCT, NAME, STOCK, PRICE, TYPE FROM product";
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error); // Add error handling for the query
}
?>

<section class="container mx-auto">
    <div class="bg-white rounded-xl shadow-[8px_8px_16px_#d1d1d1,_-8px_-8px_16px_#ffffff] p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Produk</h2>
        <form class="max-w-md ">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search inventory store / id product ..." required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="py-4 px-4 text-left text-gray-700">ID Barang</th>
                        <th class="py-4 px-4 text-left text-gray-700">Nama Barang</th>
                        <th class="py-4 px-4 text-left text-gray-700">Harga</th>
                        <th class="py-4 px-4 text-left text-gray-700">Status</th>
                        <th class="py-4 px-4 text-left text-gray-700">Kuantitas</th>
                        <th class="py-4 px-4 text-left text-gray-700">Aksi</th>
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
                                    <button
                                        class="<?= $row['STOCK'] > 0
                                                    ? 'bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600'
                                                    : 'bg-gray-400 text-black px-4 py-2 rounded cursor-not-allowed'; ?>"
                                        <?= $row['STOCK'] > 0 ? '' : 'disabled'; ?>>
                                        Add to Cart
                                    </button>
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