<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Orders List</h2>
        <span class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-sm">
            Active Orders
        </span>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">ID_PURCHASE</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">ID_PRODUCT</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">BUYER</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">TOTAL_PRICE</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">PURCHASE_TIME</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-purple-400 rounded-full"></span>
                                <span class="text-sm text-gray-700">ORD-2025011001</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700">PRD-NGS001</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-700">John Doe</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">Rp 50.000</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">2025-01-10 08:46:32</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="addPurchaseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Add New Purchase</h2>
            <form id="addPurchaseForm" method="POST" action="add_purchase.php">
                <!-- ID_PRODUCT -->
                <div class="mb-4">
                    <label for="id_product" class="block text-sm font-medium text-gray-700">ID Product</label>
                    <input
                        type="number"
                        name="id_product"
                        id="id_product"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- BUYER -->
                <div class="mb-4">
                    <label for="buyer" class="block text-sm font-medium text-gray-700">Buyer</label>
                    <input
                        type="text"
                        name="buyer"
                        id="buyer"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- TOTAL_PRICE -->
                <div class="mb-4">
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input
                        type="number"
                        step="0.01"
                        name="total_price"
                        id="total_price"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- PURCHASE_TIME -->
                <div class="mb-4">
                    <label for="purchase_time" class="block text-sm font-medium text-gray-700">Purchase Time</label>
                    <input
                        type="datetime-local"
                        name="purchase_time"
                        id="purchase_time"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- STATUS -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Submit and Close Buttons -->
                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                        onclick="closeModal()">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating Button -->
    <button 
        class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition-all focus:outline-none focus:ring-2 focus:ring-blue-300"
        onclick="openModal()"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </button>
</div>

<script>
    function openModal() {
        document.getElementById('addPurchaseModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addPurchaseModal').classList.add('hidden');
    }
</script>