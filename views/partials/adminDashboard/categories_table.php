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
                                <!-- <a href="./dashboard?action=edit_category&id=<?= $category['id'] ?>"
                                    class="text-blue-500 hover:underline mr-2">Edit</a> -->
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
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://localhost/pawsome/api/categories/delete_category.php?id=${categoryId}`, { method: 'DELETE' })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Category has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || 'Failed to delete category',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the category.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
</div>