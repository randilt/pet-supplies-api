<?php
class SubscriptionModel
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createSubscription($userId, $planId)
    {
        $conn = $this->db->getConnection();
        $conn->beginTransaction();

        try {
            // Get plan details
            $plan = $this->getPlan($planId);
            if (!$plan) {
                throw new Exception("Invalid subscription plan");
            }

            // Check if user has active subscription
            $activeSubscription = $this->getActiveSubscription($userId);
            if ($activeSubscription) {
                throw new Exception("User already has an active subscription");
            }

            // Calculate dates
            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime("+{$plan['duration_months']} months"));

            // Create subscription
            $stmt = $conn->prepare("
                INSERT INTO customer_subscriptions 
                (user_id, plan_id, start_date, end_date, status, created_at)
                VALUES (?, ?, ?, ?, 'active', NOW())
            ");
            $stmt->execute([$userId, $planId, $startDate, $endDate]);
            $subscriptionId = $conn->lastInsertId();

            $subscription = $this->getSubscription($subscriptionId);

            $conn->commit();
            return $subscription;

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function getAllPlans()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT id, name, description, price, duration_months, created_at
            FROM subscription_plans
            ORDER BY price ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlan($planId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT id, name, description, price, duration_months
            FROM subscription_plans WHERE id = ?
        ");
        $stmt->execute([$planId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserSubscriptions($userId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT cs.*, sp.name as plan_name, sp.description as plan_description, 
                   sp.price as plan_price, sp.duration_months
            FROM customer_subscriptions cs
            JOIN subscription_plans sp ON cs.plan_id = sp.id
            WHERE cs.user_id = ?
            ORDER BY cs.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveSubscription($userId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT cs.*, sp.name as plan_name, sp.description as plan_description, 
                   sp.price as plan_price, sp.duration_months
            FROM customer_subscriptions cs
            JOIN subscription_plans sp ON cs.plan_id = sp.id
            WHERE cs.user_id = ? AND cs.status = 'active' 
            AND cs.end_date > NOW()
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelSubscription($subscriptionId, $userId)
    {
        $conn = $this->db->getConnection();

        // Verify subscription belongs to user
        $stmt = $conn->prepare("
            SELECT id FROM customer_subscriptions 
            WHERE id = ? AND user_id = ? AND status = 'active'
        ");
        $stmt->execute([$subscriptionId, $userId]);
        if (!$stmt->fetch()) {
            throw new Exception("Subscription not found or already cancelled");
        }

        // Cancel subscription
        $stmt = $conn->prepare("
            UPDATE customer_subscriptions 
            SET status = 'cancelled', end_date = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$subscriptionId]);

        return $this->getSubscription($subscriptionId);
    }

    public function createPlan($data)
    {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare("
        INSERT INTO subscription_plans 
        (name, description, price, duration_months, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");

        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['duration_months']
        ]);

        return $this->getPlan($conn->lastInsertId());
    }

    public function updatePlan($planId, $data)
    {
        $conn = $this->db->getConnection();

        // Check if plan exists and has active subscriptions
        $stmt = $conn->prepare("
        SELECT COUNT(*) as active_count
        FROM customer_subscriptions
        WHERE plan_id = ? AND status = 'active' AND end_date > NOW()
    ");
        $stmt->execute([$planId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['active_count'] > 0) {
            throw new Exception("Cannot modify plan with active subscriptions");
        }

        $stmt = $conn->prepare("
        UPDATE subscription_plans 
        SET name = ?, 
            description = ?, 
            price = ?, 
            duration_months = ?
        WHERE id = ?
    ");

        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['duration_months'],
            $planId
        ]);

        return $this->getPlan($planId);
    }

    public function deletePlan($planId)
    {
        $conn = $this->db->getConnection();

        // Check for active subscriptions
        $stmt = $conn->prepare("
        SELECT COUNT(*) as active_count
        FROM customer_subscriptions
        WHERE plan_id = ? AND status = 'active' AND end_date > NOW()
    ");
        $stmt->execute([$planId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['active_count'] > 0) {
            throw new Exception("Cannot delete plan with active subscriptions");
        }

        $stmt = $conn->prepare("DELETE FROM subscription_plans WHERE id = ?");
        $stmt->execute([$planId]);

        return true;
    }

    private function getSubscription($subscriptionId)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT cs.*, sp.name as plan_name, sp.description as plan_description, 
                   sp.price as plan_price, sp.duration_months
            FROM customer_subscriptions cs
            JOIN subscription_plans sp ON cs.plan_id = sp.id
            WHERE cs.id = ?
        ");
        $stmt->execute([$subscriptionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
