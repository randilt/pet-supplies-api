<?php

class ProductModel
{
    private $db;
    private $conn;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->conn = $db->getConnection();
    }

    public function getProduct($id)
    {
        $query = "
            SELECT 
                p.*,
                c.name as category_name,
                c.description as category_description
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProducts($filters = [], $sorting = [], $pagination = [])
    {
        // base query
        $query = "
            SELECT 
                p.id,
                p.category_id,
                p.name,
                p.description,
                p.long_description,
                p.price,
                p.stock_quantity,
                p.image_url,
                p.variants,
                p.created_at,
                p.updated_at,
                c.name as category_name,
                c.description as category_description
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1=1
        ";

        $params = [];
        $types = [];

        // add filters
        if (!empty($filters['category_id'])) {
            $query .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
            $types[] = PDO::PARAM_INT;
        }

        if (!empty($filters['search'])) {
            $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = "%{$filters['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types[] = PDO::PARAM_STR;
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['min_price'])) {
            $query .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['max_price'])) {
            $query .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query .= " AND p.stock_quantity > 0";
        }

        // add sorting
        $allowed_sort_fields = ['name', 'price', 'created_at', 'stock_quantity'];
        $sort_by = in_array($sorting['sort_by'] ?? '', $allowed_sort_fields) ? $sorting['sort_by'] : 'created_at';
        $sort_order = (isset($sorting['sort_order']) && strtoupper($sorting['sort_order']) === 'ASC') ? 'ASC' : 'DESC';
        $query .= " ORDER BY p.{$sort_by} {$sort_order}";

        // add pagination
        $query .= " LIMIT ? OFFSET ?";
        $params[] = $pagination['limit'];
        $params[] = $pagination['offset'];
        $types[] = PDO::PARAM_INT;
        $types[] = PDO::PARAM_INT;

        // execute query
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, $types[$key] ?? PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount($filters = [])
    {
        $query = "SELECT COUNT(*) as total FROM products p WHERE 1=1";
        $params = [];
        $types = [];

        // add the same filters as getProducts()
        if (!empty($filters['category_id'])) {
            $query .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
            $types[] = PDO::PARAM_INT;
        }

        if (!empty($filters['search'])) {
            $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $searchTerm = "%{$filters['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types[] = PDO::PARAM_STR;
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['min_price'])) {
            $query .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['max_price'])) {
            $query .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query .= " AND p.stock_quantity > 0";
        }

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, $types[$key] ?? PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getStats()
    {
        $query = "
            SELECT 
                COUNT(*) as total_products,
                COUNT(DISTINCT category_id) as total_categories,
                MIN(price) as min_price,
                MAX(price) as max_price,
                AVG(price) as avg_price,
                SUM(CASE WHEN stock_quantity > 0 THEN 1 ELSE 0 END) as in_stock_count
            FROM products
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($data)
    {
        $this->validateProduct($data);
        $this->checkCategoryExists($data['category_id']);
        $this->checkNameUnique($data['name']);

        $variants_json = $this->processVariants($data['variants'] ?? null);

        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare("
                INSERT INTO products (
                    category_id, name, description, long_description,
                    price, stock_quantity, image_url, variants,
                    created_at, updated_at
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
                )
            ");

            $stmt->bindValue(1, $data['category_id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(3, $data['description'], PDO::PARAM_STR);
            $stmt->bindValue(4, $data['long_description'], PDO::PARAM_STR);
            $stmt->bindValue(5, $data['price'], PDO::PARAM_STR);
            $stmt->bindValue(6, $data['stock_quantity'], PDO::PARAM_INT);
            $stmt->bindValue(7, $data['image_url'] ?? null, isset($data['image_url']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(8, $variants_json, $variants_json === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

            $stmt->execute();
            $product_id = $this->conn->lastInsertId();

            $this->conn->commit();
            return $this->getProduct($product_id);

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function updateProduct($id, $data)
    {
        $existing_product = $this->getProduct($id);
        if (!$existing_product) {
            throw new Exception("Product not found", 404);
        }

        $updates = [];
        $params = [];
        $types = [];

        if (isset($data['category_id'])) {
            $this->checkCategoryExists($data['category_id']);
            $updates[] = "category_id = ?";
            $params[] = $data['category_id'];
            $types[] = PDO::PARAM_INT;
        }

        if (isset($data['name'])) {
            $this->validateName($data['name']);
            $this->checkNameUnique($data['name'], $id);
            $updates[] = "name = ?";
            $params[] = $data['name'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($data['long_description'])) {
            $this->validateLongDescription($data['long_description']);
            $updates[] = "long_description = ?";
            $params[] = $data['long_description'];
            $types[] = PDO::PARAM_STR;
        }
        if (isset($data['price'])) {
            $this->validatePrice($data['price']);
            $updates[] = "price = ?";
            $params[] = $data['price'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($data['stock_quantity'])) {
            $this->validateStockQuantity($data['stock_quantity']);
            $updates[] = "stock_quantity = ?";
            $params[] = $data['stock_quantity'];
            $types[] = PDO::PARAM_INT;
        }

        if (isset($data['image_url'])) {
            $updates[] = "image_url = ?";
            $params[] = $data['image_url'];
            $types[] = PDO::PARAM_STR;
        }

        if (isset($data['variants'])) {
            $variants_json = $this->processVariants($data['variants']);
            $updates[] = "variants = ?";
            $params[] = $variants_json;
            $types[] = PDO::PARAM_STR;
        }


        if (isset($data['description'])) {
            $this->validateDescription($data['description']);
            $updates[] = "description = ?";
            $params[] = $data['description'];
            $types[] = PDO::PARAM_STR;
        }


        if (empty($updates)) {
            throw new Exception("No valid fields to update", 400);
        }

        $updates[] = "updated_at = NOW()";

        $this->conn->beginTransaction();

        try {
            $query = "UPDATE products SET " . implode(", ", $updates) . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key + 1, $value, $types[$key]);
            }
            $stmt->bindValue(count($params) + 1, $id, PDO::PARAM_INT);

            $stmt->execute();
            $this->conn->commit();

            return $this->getProduct($id);

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function deleteProduct($id)
    {
        $product = $this->getProduct($id);
        if (!$product) {
            throw new Exception("Product not found", 404);
        }

        $this->conn->beginTransaction();

        try {
            // check if product is in any orders
            $stmt = $this->conn->prepare("SELECT id FROM order_items WHERE product_id = ? LIMIT 1");
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->fetch()) {
                // soft delete if product is in orders
                $stmt = $this->conn->prepare("UPDATE products SET status = 'inactive', updated_at = NOW() WHERE id = ?");
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $this->conn->commit();
                return ['message' => 'Product marked as inactive due to existing orders', 'product' => $product];
            } else {
                // hard delete if product is not in any orders
                $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $this->conn->commit();
                return ['message' => 'Product deleted successfully', 'product' => $product];
            }
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    // helper methods
    private function validateProduct($data)
    {
        $required_fields = ['category_id', 'name', 'description', 'price', 'stock_quantity', 'long_description'];
        $errors = [];

        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || ($data[$field] === '' && $data[$field] !== 0)) {
                $errors[] = "Field '{$field}' is required";
            }
        }

        if (!empty($errors)) {
            throw new Exception(json_encode(['errors' => $errors]), 400);
        }

        $this->validateName($data['name']);
        $this->validateDescription($data['description']);
        $this->validatePrice($data['price']);
        $this->validateStockQuantity($data['stock_quantity']);
        $this->validateLongDescription($data['long_description']);
    }

    private function validateName($name)
    {
        if (strlen($name) < 2 || strlen($name) > 100) {
            throw new Exception("Name must be between 2 and 100 characters", 400);
        }
    }

    private function validateDescription($description)
    {
        if (strlen($description) < 10 || strlen($description) > 1000) {
            throw new Exception("Description must be between 10 and 1000 characters", 400);
        }
    }

    private function validateLongDescription($long_description)
    {
        if (strlen($long_description) < 50) {
            throw new Exception("Long description must be at least 50 characters", 400);
        }
    }

    private function validatePrice($price)
    {
        if ($price <= 0) {
            throw new Exception("Price must be greater than 0", 400);
        }
    }

    private function validateStockQuantity($quantity)
    {
        if ($quantity < 0) {
            throw new Exception("Stock quantity cannot be negative", 400);
        }
    }

    private function checkCategoryExists($category_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE id = ?");
        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new Exception("Category not found", 404);
        }
    }

    private function checkNameUnique($name, $exclude_id = null)
    {
        $query = "SELECT id FROM products WHERE name = ?";
        $params = [$name];

        if ($exclude_id !== null) {
            $query .= " AND id != ?";
            $params[] = $exclude_id;
        }

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();

        if ($stmt->fetch()) {
            throw new Exception("A product with this name already exists", 409);
        }
    }

    private function processVariants($variants)
    {
        if ($variants === null) {
            return null;
        }

        if (!is_array($variants)) {
            throw new Exception("Variants must be an array", 400);
        }

        foreach ($variants as &$variant) {
            if (!isset($variant['type']) || !isset($variant['values'])) {
                throw new Exception("Each variant must have a type and values", 400);
            }

            if (!is_array($variant['values'])) {
                throw new Exception("Variant values must be an array", 400);
            }

            // normalize variant structure
            $variant = [
                'type' => trim($variant['type']),
                'values' => array_map('trim', $variant['values']),
                'price_adjustments' => isset($variant['price_adjustments']) ?
                    array_map('floatval', $variant['price_adjustments']) :
                    array_fill(0, count($variant['values']), 0.0)
            ];
        }

        $variants_json = json_encode($variants, JSON_UNESCAPED_UNICODE);
        if ($variants_json === false) {
            throw new Exception("Invalid variants format", 400);
        }

        return $variants_json;
    }
}