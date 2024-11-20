<?php

function fetchProducts($limit = 20)
{
    $apiUrl = 'http://localhost/pawsome/api/products/get_products.php?limit=' . $limit;

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

    return $data['products'] ?? [];
}


function fetchProductsById($id)
{
    $apiUrl = 'http://localhost/pawsome/api/products/get_products.php?id=' . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('
    Content-Type: application/json'
    ));
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
    $apiUrl = 'http://localhost/pawsome/api/categories/get_categories.php';

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