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
                'message' => 'Subscription created successfully',
                'subscription' => $subscription
            ], 201);

        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserSubscriptions()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::json(['error' => 'Method not allowed'], 405);
        }

        try {
            $this->auth->requireAuth();
            $userId = $_SESSION['user_id'];

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
            $userId = $_SESSION['user_id'];

            $subscription = $this->subscriptionModel->getActiveSubscription($userId);
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

    private function validateSubscribeData($data)
    {
        if (!isset($data['plan_id'])) {
            Response::json(['error' => 'Plan ID is required'], 400);
            exit;
        }
    }
}