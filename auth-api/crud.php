<?php
require 'function.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$inputData = json_decode(file_get_contents("php://input"), true);

if ($requestMethod == "POST") {
    if (isset($inputData['action'])) {
        if ($inputData['action'] == 'signup') {
            
            $response = signup($inputData);
            echo $response;
        } elseif ($inputData['action'] == 'signin') {
            
            $response = signin($inputData);
            echo $response;
        }
    } else {
        echo "Error: Missing action for sign up or sign in";
    }
} elseif ($requestMethod == "GET") {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'getCustomerList') {
            echo getCustomerList();
        }
    }
} elseif ($requestMethod == "PUT") {
    if (isset($inputData['action']) && $inputData['action'] == 'editCustomer') {
        echo editCustomer($inputData, $_GET['id']);
    }
} elseif ($requestMethod == "DELETE") {
    if (isset($_GET['id'])) {
        echo deleteCustomer($_GET['id']);
    }
} else {
    $data = [
        'status' => 405,
        'message' => 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}


// POST Request 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        echo "Error: Input is empty";
        exit();
    } else {
        echo storeCustomer($inputData); 
    }
}

// GET 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo getCustomerList();
}

// PUT 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    $customerId = $_GET['id']; 

    if (empty($inputData) || !$customerId) {
        echo "Error: Input is empty or ID is missing";
        exit();
    } else {
        echo editCustomer($inputData, $customerId); 
    }
}

// DELETE 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $customerId = $_GET['id'];

    if (!$customerId) {
        echo "Error: ID is missing";
        exit();
    } else {
        echo deleteCustomer($customerId);
    }
}
?>
