<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4">Add New Category</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add_category">
        <div class="mb-4">
            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-1">Category
                Name</label>
            <input type="text" id="category_name" name="category_name" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]">
        </div>
        <div class="mb-4">
            <label for="category_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="category_description" name="category_description" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#FF9800] focus:border-[#FF9800]"></textarea>
        </div>
        <button type="submit"
            class="w-full bg-[#FF9800] text-white py-2 px-4 rounded-md hover:bg-[#F57C00] focus:outline-none focus:ring-2 focus:ring-[#FF9800] focus:ring-opacity-50 transition duration-300">
            Add Category
        </button>
    </form>
</div>