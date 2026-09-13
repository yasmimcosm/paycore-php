<?php

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
    if (!isset($_GET['id'])) {
        http_response_code(400);

        echo json_encode([
            'message' => 'ID do usuario e obrigatorio.'
        ]);

        exit;
    }

    $id = $_GET['id']; //pega um parâmetro enviado na URL

    $stmt = $pdo->prepare(
        "SELECT id, name, email, created_at
        FROM users
        WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);

        echo json_encode([
            'message' => 'Usuario nao encontrado.'
        ]);

        exit;
    }

    http_response_code(200);

    echo json_encode($user);




} elseif ($method == 'PUT') {

    if (!isset($_GET['id'])) {
        http_response_code(400);

        echo json_encode([
            'message' => 'ID do usuário é obrigatório.'
        ]);

        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (
        !isset($input['name']) ||
        !isset($input['email'])
    ) {
    
        http_response_code(400);

        echo json_encode([
            'message' => 'Nome e e-mail sao obrigatórios.'
        ]);

        exit;
    }

    $name = $input['name'];
    $email = $input['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);

        echo json_encode([
            'message' => 'E-mail inválido.'
        ]);

        exit;
    }

    $id = $_GET['id'];

    $stmt = $pdo->prepare(
        "SELECT id
        FROM users
        WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);

        echo json_encode([
            'message' => 'Usuário não encontrado.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "SELECT id
        FROM users
        WHERE email = :email
        AND id != :id"
    );

    $stmt->execute([
        'email' => $email,
        'id' => $id
    ]);

    $userWithEmail = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userWithEmail) {
        http_response_code(409);

        echo json_encode([
            'message' => 'E-mail ja cadastrado.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE users
        SET name = :name,
            email = :email
        WHERE id = :id"
    );

    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'id' => $id
    ]);


    http_response_code(200);

    echo json_encode([
        'message' => 'Usuario atualizado com sucesso.'
    ]);

} elseif ($method == 'DELETE') {

    if (!isset($_GET['id'])) {
        http_response_code(400);

        echo json_encode([
            'message' => 'ID do usuário é obrigatório.'
        ]);

        exit;
    }

    $id = $_GET['id'];

    $stmt = $pdo->prepare(
        "SELECT id
        FROM users
        WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);

        echo json_encode([
            'message' => 'Usuário não encontrado.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "DELETE FROM users
        WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    http_response_code(200);

    echo json_encode([
        'message' => 'Usuário excluído com sucesso.'
    ]);
}
