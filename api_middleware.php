<?php
header('Content-Type: application/json');

function requireAuth() {
    $headers = getallheaders();
    $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    if (empty($auth_header) || !preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized: No token provided']);
        exit();
    }
    
    $token = $matches[1];
    // Verify token here (implement your JWT validation)
    return $token;
}
?>