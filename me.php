<?php

session_start();

require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    
    echo json_encode([
        'message' => 'Você não está logada.',
    ]);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, name, email
     FROM users
     WHERE id = :id"
);

$stmt->execute([
    'id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    http_response_code(200);

    echo json_encode([
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ]);

} else {
    http_response_code(404); // Unauthorized = as credenciais não permitiram autenticação.

    echo json_encode([
        'message' => 'Falhou.'
    ]);

    exit;
}