<?php
require_once 'config/app_config.php';
define('API_BASE_URL', 'http://app/api/v1');
// echo ENV;
function fetchProducts($minPrice = null, $maxPrice = null, $categoryId = null, $search = null, $limit = 20, $isAdmin = false, $page = null)
{
    $queryParams = array('limit' => $limit);

    if ($page !== null) {
        $queryParams['page'] = $page;
    }

    if ($minPrice !== null) {
        $queryParams['min_price'] = $minPrice;
    }

    if ($maxPrice !== null) {
        $queryParams['max_price'] = $maxPrice;
    }

    if ($categoryId !== null) {
        $queryParams['category_id'] = $categoryId;
    }

    if ($search !== null) {
        $queryParams['search'] = $search;
    }

    $apiUrl = API_BASE_URL . '/products.php?' . http_build_query($queryParams);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Failed to parse JSON: ' . json_last_error_msg());
    }

    if ($isAdmin) {
        return $data;
    }
    return $data['products'] ?? [];
}

function fetchProductsById($id)
{
    $apiUrl = API_BASE_URL . '/products.php?id=' . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $error = 'Curl error' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }
    return $response ?? null;
}

function fetchCategories()
{
    $apiUrl = API_BASE_URL . '/categories.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Failed to parse JSON: ' . json_last_error_msg());
    }

    return $data['categories'] ?? [];
}

function handleLogout()
{
    // only process POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ./dashboard.php');
        exit;
    }

    // clear all session data
    $_SESSION = array();

    // destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // destroy the session
    session_destroy();

    // redirect to login page
    header('Location: ./login');
    exit;
}

// function to process the logout API call
function logoutUser()
{
    $apiUrl = API_BASE_URL . '/users.php/logout';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    curl_close($ch);

    header('Location: ./login');
    exit;
}

function fetchUserOrders($status = null)
{
    $queryParams = array();

    if ($status !== null) {
        $queryParams['status'] = $status;
    }

    $apiUrl = API_BASE_URL . '/orders.php?user=true';
    if (!empty($queryParams)) {
        $apiUrl .= '?' . http_build_query($queryParams);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Failed to parse JSON: ' . json_last_error_msg());
    }


    return $data['orders'] ?? ['error' => 'No orders found'];
}

function fetchAllOrders($status = null, $sort = 'latest')
{
    $queryParams = array();

    if ($status !== null) {
        $queryParams['status'] = $status;
    }
    if ($sort !== null) {
        $queryParams['sort'] = $sort;
    }

    $apiUrl = API_BASE_URL . '/orders.php';
    if (!empty($queryParams)) {
        $apiUrl .= '?' . http_build_query($queryParams);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Failed to parse JSON: ' . json_last_error_msg());
    }

    return $data['orders'] ?? [];
}