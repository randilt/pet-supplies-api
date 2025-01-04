<?php

class CategoryController
{
    private $model;
    private $auth;

    public function __construct(CategoryModel $model, Auth $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
    }

    public function create(): void
    {
        // $this->auth->requireAuth();
        $this->auth->requireAdmin();

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name']) || empty($data['name'])) {
            Response::json(['error' => 'Category name is required'], 400);
        }

        try {
            $categoryId = $this->model->create($data);
            Response::json([
                'message' => 'Category created successfully',
                'categoryId' => $categoryId
            ], 201);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(): void
    {
        // $this->auth->requireAuth();
        $this->auth->requireAdmin();

        $categoryId = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($categoryId === null || $categoryId <= 0) {
            Response::json(['error' => 'Invalid category ID'], 400);
        }

        try {
            $result = $this->model->delete($categoryId);
            if ($result) {
                Response::json([
                    'success' => true,
                    'message' => 'Category deleted successfully',
                    'categoryId' => $categoryId
                ]);
            } else {
                Response::json(['success' => false, 'error' => 'Category not found'], 404);
            }
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'error' => $e->getMessage()
            ], 409);
        }
    }

    public function get(): void
    {
        try {
            $categories = $this->model->getAll();
            Response::json(['categories' => $categories]);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }
}