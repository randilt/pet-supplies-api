<?php
class ProductController
{
    private $model;
    private $auth;

    public function __construct(ProductModel $model, Auth $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
    }

    public function get()
    {
        try {
            // check if a specific product ID is requested
            $product_id = isset($_GET['id']) ? (int) $_GET['id'] : null;

            if ($product_id) {
                $product = $this->model->getProduct($product_id);
                if (!$product) {
                    Response::json(['error' => 'Product not found'], 404);
                }
                Response::json(['product' => $product]);
                return;
            }

            // get query parameters with defaults
            $filters = [
                'category_id' => isset($_GET['category_id']) ? (int) $_GET['category_id'] : null,
                'search' => isset($_GET['search']) ? trim($_GET['search']) : null,
                'min_price' => isset($_GET['min_price']) ? (float) $_GET['min_price'] : null,
                'max_price' => isset($_GET['max_price']) ? (float) $_GET['max_price'] : null,
                'in_stock' => isset($_GET['in_stock']) ? (bool) $_GET['in_stock'] : null
            ];

            $sorting = [
                'sort_by' => isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at',
                'sort_order' => isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'ASC' ? 'ASC' : 'DESC'
            ];

            $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
            $limit = isset($_GET['limit']) ? min(50, max(1, (int) $_GET['limit'])) : 10;
            $offset = ($page - 1) * $limit;

            $pagination = [
                'limit' => $limit,
                'offset' => $offset
            ];

            $products = $this->model->getProducts($filters, $sorting, $pagination);
            $total = $this->model->getTotalCount($filters);
            $stats = $this->model->getStats();

            Response::json([
                'products' => $products,
                'pagination' => [
                    'total' => (int) $total,
                    'page' => $page,
                    'limit' => $limit,
                    'total_pages' => ceil($total / $limit)
                ],
                'filters' => $filters,
                'sorting' => $sorting,
                'stats' => $stats,
                'success' => true
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        try {
            // $this->auth->requireAuth();
            $this->auth->requireAdmin();

            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $product = $this->model->createProduct($data);

            Response::json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);

        } catch (Exception $e) {
            $code = in_array($e->getCode(), [400, 404, 409]) ? $e->getCode() : 500;
            Response::json(['error' => $e->getMessage()], $code);
        }
    }

    public function update()
    {
        try {
            // $this->auth->requireAuth();
            $this->auth->requireAdmin();

            $product_id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (!$product_id) {
                Response::json(['error' => 'Product ID is required'], 400);
            }

            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (empty($data)) {
                Response::json(['error' => 'No data provided for update'], 400);
            }

            $product = $this->model->updateProduct($product_id, $data);

            Response::json([
                'message' => 'Product updated successfully',
                'product' => $product
            ]);

        } catch (Exception $e) {
            $code = in_array($e->getCode(), [400, 404, 409]) ? $e->getCode() : 500;
            Response::json(['error' => $e->getMessage(), 'success' => false], $code);
        }
    }

    public function delete()
    {
        try {
            // $this->auth->requireAuth();
            $this->auth->requireAdmin();

            $product_id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (!$product_id) {
                Response::json(['error' => 'Product ID is required'], 400);
            }

            $result = $this->model->deleteProduct($product_id);
            Response::json($result);

        } catch (Exception $e) {
            $code = in_array($e->getCode(), [400, 404]) ? $e->getCode() : 500;
            Response::json(['error' => $e->getMessage()], $code);
        }
    }
}