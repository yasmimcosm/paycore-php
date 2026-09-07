<?php

session_start();

require 'db.php';

 $input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input['email']) ||
    !isset($input['password'])
) {
    http_response_code(400); // 400 Bad Request - Dados inválidos

    echo json_encode([
        'message' => 'Todos os campos sao obrigatorios.'
    ]);

    exit;
}

$email = $input['email'];
$password = $input['password'];

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
    "SELECT id, password_hash
     FROM users
     WHERE email = :email"
);

$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(401); // Unauthorized = as credenciais não permitiram autenticação.

    echo json_encode([
        'message' => 'Credenciais inválidas.'
    ]);

    exit;
}

if (password_verify($password, $user['password_hash'])) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];

    echo "Login realizado!";

} else {

    http_response_code(401);

    echo json_encode([
        'message' => 'Credenciais inválidas.'
    ]);
}
