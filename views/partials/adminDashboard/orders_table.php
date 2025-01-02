<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-4">Order Management</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Order ID</th>
                    <th class="py-2 px-4 border-b text-left">User ID</th>
                    <th class="py-2 px-4 border-b text-left">Total Amount</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                    <th class="py-2 px-4 border-b text-left">Created At</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <tr>
                    <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">Loading orders...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/order_management.js"></script>