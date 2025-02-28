<?php
error_reporting(E_ALL); 
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST, PUT, DELETE, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With'); 

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (empty($inputData)) {
        echo "Error: Input is empty";
        exit();
    } else {
        $storeCustomer = storeCustomer($inputData);
        echo $storeCustomer; 
    }
} elseif ($requestMethod == "GET") {
    $customerList = getCustomerList();
    echo $customerList;
} elseif ($requestMethod == "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    $customerId = $_GET['id']; 

    if (empty($inputData) || !$customerId) {
        echo "Error: Input is empty or ID is missing";
        exit();
    } else {
        $editCustomer = editCustomer($inputData, $customerId);
        echo $editCustomer; 
    }
} elseif ($requestMethod == "DELETE") {
    $customerId = $_GET['id'];

    if (!$customerId) {
        echo "Error: ID is missing";
        exit();
    } else {
        $deleteCustomer = deleteCustomer($customerId);
        echo $deleteCustomer;
    }
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>
