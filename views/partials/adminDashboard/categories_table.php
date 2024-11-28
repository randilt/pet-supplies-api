<?php
require_once 'functions.php';
$categories = fetchCategories();
?>

<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-semibold mb-4">Category Management</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">Description</th>
                    <th class="py-2 px-4 border-b text-left">Created At</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="5" class="py-4 px-4 border-b text-center text-gray-500">No categories found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= $category['id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($category['name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($category['description'] ?? 'N/A') ?></td>
                            <td class="py-2 px-4 border-b"><?= $category['created_at'] ?? 'N/A' ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="./dashboard?action=edit_category&id=<?= $category['id'] ?>"
                                    class="text-blue-500 hover:underline mr-2">Edit</a>
                                <button onclick="deleteCategory(<?= $category['id'] ?>)"
                                    class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                fetch(`http://localhost/pawsome/api/categories/delete_category.php?id=${categoryId}`, { method: 'DELETE' })
                    .then(response => {
                        response.json();
                        console.log(response)
                        if (response.status === 200) {
                            alert('Category deleted successfully.');
                            location.reload();
                        } else {
                            alert('Failed to delete the category. Please try again.');
                        }
                    }
                    )
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the category.');
                    });
            }
        }
    </script>
</div>