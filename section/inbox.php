<div class="flex flex-col gap-4">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Inbox</h2>
        <div class="flex items-center space-x-4 mb-4">
            <!-- Detail Pesanan -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold">Nama Pembeli: John Doe</h3>
                <p>Pesanan: Nasi Goreng Spesial</p>
                <p>Waktu <span>2025-01-10 08:46:32</span></span></p>
                <p>Total Harga: Rp 50.000</p>
            </div>
            <!-- Tombol Lihat -->
            <form method="POST" class="space-y-4">
                <label for="status" class="block text-gray-700 font-semibold">Update Status</label>
                <select name="status" id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="COMPLETED" class="text-green-600 font-bold">COMPLETED</option>
                    <option value="pending" class="text-yellow-500 font-bold">PENDING</option>
                    <option value="canceled" class="text-red-500 font-bold">CANCELED</option>
                </select>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
            </form>
        </div>
    </div>
</div>