<?php

require 'db.php';

$input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input['name']) ||
    !isset($input['email']) ||
    !isset($input['password'])
) {
    http_response_code(400); // 400 Bad Request - Dados inválidos

    echo json_encode([
        'message' => 'Todos os campos são obrigatórios.'
    ]);

    exit;
}

$name = $input['name'];
$email = $input['email'];
$password = $input['password'];

if (trim($name) === '') {
    http_response_code(400);

    echo json_encode([
        'message' => 'Nome é obrigatório.'
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // 400 Bad Request - Dados inválidos

    echo json_encode([
        'message' => 'E-mail inválido.'
    ]);

    exit;
}

if (strlen($password) < 8) {
    http_response_code(400); // 400 Bad Request - Dados inválidos

    echo json_encode([
        'message' => 'Senha inválida. A senha deve ter pelo menos 8 caracteres.'
    ]);


    exit;
}

$stmt = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE email = :email"
);

$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);
 

if ($user) {
    http_response_code(409); //Conflit - E-mail já cadastrado

    echo json_encode([
        'message' => 'E-mail já cadastrado.'
    ]);

    exit;
}



$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    "INSERT INTO users (name, email, password_hash)
     VALUES (:name, :email, :password_hash)"
);

$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password_hash' => $password_hash
]);



http_response_code(201);

echo json_encode([
    'message' => 'Usuário criado com sucesso.'
]);