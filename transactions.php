<?php

//lembra de pesquisar sobre 
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    $input = json_decode(file_get_contents("php://input"), true);

    if (
        !isset($input['description']) ||
        !isset($input['amount']) ||
        !isset($input['type']) ||
        !isset($input['transaction_date'])
    ) {
        http_response_code(400); // 400 Bad Request - Dados inválidos

        echo json_encode([
            'message' => 'Todos os campos sao obrigatorios.'
        ]);

        exit;
    }

    $description = $input['description'];
    $amount = $input['amount'];
    $type = $input['type'];
    $transaction_date = $input['transaction_date'];

    if (trim($description) === '') { //remove espaços em branco do começo e do final
        http_response_code(400);

        echo json_encode([
            'message' => 'Digite uma descricao válida.'
        ]);

        exit;
    }
    
    if(strlen($description) < 4){
        http_response_code(400);

        echo json_encode([
            'message' => 'Digite uma descricao mais que 4 caracteres.'
        ]);

        exit;
    }

    if($amount <= 0){
        http_response_code(400);

        echo json_encode([
            'message' => 'Digite um valor valido'
        ]);

        exit;
    }

    if($type != "entrada" && $type != "saida"){
        http_response_code(400);

        echo json_encode([
            'message' => 'Digite um tipo valido (entrada/saida)'
        ]);

        exit;
    }

    $date = DateTime::createFromFormat('Y-m-d', $transaction_date);

    if (!$date || $date->format('Y-m-d') !== $transaction_date) {
        http_response_code(400);

        echo json_encode([
            'message' => 'Digite uma data valida no formato Ano-Mes-Dia.'
        ]);

        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO transactions (description, amount, type, transaction_date)
        VALUES (:description, :amount, :type, :transaction_date)"
    );

    $stmt->execute([
        'description' => $description,
        'amount' => $amount,
        'type' => $type,
        'transaction_date' => $transaction_date
    ]);

    http_response_code(201);

    echo json_encode([
        'message' => 'Novo registro cadastrado com sucesso.'
    ]);

} else if($method == 'GET'){

} else if($method == 'PUT'){

} else if($method == 'DELETE'){

}