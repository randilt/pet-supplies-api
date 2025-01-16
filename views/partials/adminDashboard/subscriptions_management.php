<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-4">Subscription Management</h2>
    <div class="mb-4">
        <button id="createSubscriptionBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Subscription Plan
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Plan ID</th>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Description</th>
                    <th class="py-2 px-4 border-b text-left">Price</th>
                    <th class="py-2 px-4 border-b text-left">Duration (Months)</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="subscriptionPlansTableBody">
                <tr>
                    <td colspan="6" class="py-4 px-4 border-b text-center text-gray-500">Loading subscription plans...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-4">User Subscriptions</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Subscription ID</th>
                    <th class="py-2 px-4 border-b text-left">User ID</th>
                    <th class="py-2 px-4 border-b text-left">Plan Name</th>
                    <th class="py-2 px-4 border-b text-left">Start Date</th>
                    <th class="py-2 px-4 border-b text-left">End Date</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="userSubscriptionsTableBody">
                <tr>
                    <td colspan="7" class="py-4 px-4 border-b text-center text-gray-500">Loading user subscriptions...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/subscription_management.js"></script>