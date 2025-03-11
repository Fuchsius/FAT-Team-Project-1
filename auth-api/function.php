<?php
require 'dbcon.php';

// Error handling function
function error422($message) {
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

// User Registration
function signup($userInput) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $userInput['name']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    // Validation
    if (empty(trim($name))) {
        return error422('Enter Your name');
    } elseif (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($password))) {
        return error422('Enter your password');
    }

    // Password hashing for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        return error422('Email is already registered');
    }

     
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 201,
            'message' => 'User registered successfully',
        ];
        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } else {
        return error422('Internal Server Error');
    }
}

// User Login
function signin($userInput) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $password = mysqli_real_escape_string($conn, $userInput['password']);

    // Validation
    if (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($password))) {
        return error422('Enter your password');
    }

    // Check if user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        return error422('User not found');
    }

    $user = mysqli_fetch_assoc($result);
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        $data = [
            'status' => 200,
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ]
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);
    } else {
        return error422('Incorrect password');
    }
}


function storeCustomer($customerInput) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name))) {
        return error422('Enter your name');
    } elseif (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($phone))) {
        return error422('Enter your phone');
    }

    $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = ['status' => 201, 'message' => 'Customer Created Successfully'];
        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } else {
        return error422('Internal Server Error');
    }
}

// Fetch all customers
function getCustomerList() {
    global $conn;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customers Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

// Edit customer details
function editCustomer($customerInput, $id) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name))) {
        return error422('Enter Your name');
    } elseif (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($phone))) {
        return error422('Enter your phone');
    } else {
        $query = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Customer Updated Successfully',
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

// Delete customer by ID
function deleteCustomer($id) {
    global $conn;

    // Check if the customer exists
    $checkQuery = "SELECT * FROM customers WHERE id=$id";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $data = [
            'status' => 404,
            'message' => 'Customer Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }

    // Proceed with deletion
    $query = "DELETE FROM customers WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Customer Deleted Successfully',
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


?>
