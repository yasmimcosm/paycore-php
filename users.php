<?php

require 'db.php';

$stmt = $pdo->prepare(
    "SELECT id, name, email, created_at
    FROM users"
);

$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

http_response_code(200);

echo json_encode($users);