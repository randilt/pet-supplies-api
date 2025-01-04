<?php

class CategoryModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $conn = $this->db->getConnection();

        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $description = $data['description'] ?? null;
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('Failed to create category');
        }

        return $conn->lastInsertId();
    }

    public function delete(int $categoryId): bool
    {
        $conn = $this->db->getConnection();

        // check for existing products
        $checkQuery = "SELECT COUNT(*) FROM products WHERE category_id = :id";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $checkStmt->execute();

        $productCount = $checkStmt->fetchColumn();
        if ($productCount > 0) {
            throw new Exception("This category contains {$productCount} product(s). Please remove or reassign these products first.");
        }

        // deletion
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function getAll(): array
    {
        $conn = $this->db->getConnection();

        $query = "SELECT id, name, description, created_at FROM categories";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}