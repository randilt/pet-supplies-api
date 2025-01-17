<?php

class SubscriptionController
{
    private $subscriptionModel;
    private $auth;

    public function __construct(SubscriptionModel $subscriptionModel, Auth $auth)
    {
        $this->subscriptionModel = $subscriptionModel;
        $this->auth = $auth;
    }

    public function getAllPlans()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $plans = $this->subscriptionModel->getAllPlans();
            Response::json(['plans' => $plans]);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();
            $userId = $_SESSION['user_id'];

            $data = json_decode(file_get_contents('php://input'), true);
            $this->validateSubscribeData($data);

            $subscription = $this->subscriptionModel->createSubscription(
                $userId,
                $data['plan_id']
            );

            Response::json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'subscription' => $subscription
            ], 201);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage(), 'success' => false], 500);
        }
    }

    public function getUserSubscriptions()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();
            $userId = $_SESSION['user_id'] ?? null;

            if (!$userId) {
                Response::json(['error' => 'User ID is required'], 400);
            }

            $subscriptions = $this->subscriptionModel->getUserSubscriptions($userId);
            Response::json(['subscriptions' => $subscriptions]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getActiveSubscription()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();
            $userId = $_SESSION['user_id'] ?? null;

            if (!$userId) {
                $subscriptions = $this->subscriptionModel->getActiveSubscriptions();
                Response::json(['subscriptions' => $subscriptions]);
            }

            $subscription = $this->subscriptionModel->getActiveSubscriptions($userId);
            Response::json(['subscription' => $subscription]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancel()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();
            $userId = $_SESSION['user_id'];

            $subscriptionId = $_GET['id'] ?? null;
            if (!$subscriptionId) {
                Response::json(['error' => 'Subscription ID is required'], 400);
            }

            $subscription = $this->subscriptionModel->cancelSubscription($subscriptionId, $userId);
            Response::json([
                'message' => 'Subscription cancelled successfully',
                'subscription' => $subscription
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function createPlan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAdmin();

            $data = json_decode(file_get_contents('php://input'), true);
            $this->validatePlanData($data);

            $plan = $this->subscriptionModel->createPlan($data);

            Response::json([
                'message' => 'Subscription plan created successfully',
                'plan' => $plan
            ], 201);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePlan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAdmin();

            $planId = $_GET['id'] ?? null;
            if (!$planId) {
                Response::json(['error' => 'Plan ID is required'], 400);
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $this->validatePlanData($data);

            $plan = $this->subscriptionModel->updatePlan($planId, $data);

            Response::json([
                'message' => 'Subscription plan updated successfully',
                'plan' => $plan
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePlan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAdmin();

            $planId = $_GET['id'] ?? null;
            if (!$planId) {
                Response::json(['error' => 'Plan ID is required'], 400);
            }

            $this->subscriptionModel->deletePlan($planId);

            Response::json([
                'message' => 'Subscription plan deleted successfully',
                'success' => true
            ]);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    private function validatePlanData($data)
    {
        $errors = [];

        if (!isset($data['name']) || empty($data['name'])) {
            $errors[] = "Plan name is required";
        }

        if (!isset($data['description']) || empty($data['description'])) {
            $errors[] = "Plan description is required";
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
            $errors[] = "Valid price is required";
        }

        if (!isset($data['duration_months']) || !is_numeric($data['duration_months']) || $data['duration_months'] < 1) {
            $errors[] = "Valid duration in months is required";
        }

        if (!empty($errors)) {
            Response::json(['errors' => $errors], 400);
            exit;
        }
    }


    private function validateSubscribeData($data)
    {
        if (!isset($data['plan_id'])) {
            Response::json(['error' => 'Plan ID is required'], 400);
            exit;
        }
    }
}