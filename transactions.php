<?php
 
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($input['description']) ||
            !isset($input['amount']) ||
            !isset($input['type']) ||
            !isset($input['category']) ||
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
        $category = $input['category'];
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
                'message' => 'Digite uma descricao com pelo menos 4 caracteres.'
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

        if (trim($category) === '') { //remove espaços em branco do começo e do final
            http_response_code(400);

            echo json_encode([
                'message' => 'Digite uma categoria válida.'
            ]);

            exit;
        }
        
        if(strlen($category) < 4){
            http_response_code(400);

            echo json_encode([
                'message' => 'Digite uma categoria com pelo menos 4 caracteres.'
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
            "INSERT INTO transactions (description, amount, type, category, transaction_date)
            VALUES (:description, :amount, :type, :category, :transaction_date)"
        );

        $stmt->execute([
            'description' => $description,
            'amount' => $amount,
            'type' => $type,
            'category' => $category,
            'transaction_date' => $transaction_date
        ]);

        http_response_code(201);

        echo json_encode([
            'message' => 'Novo registro cadastrado com sucesso.'
        ]);
        break;

    case 'GET':
        $filter = '';

        if (isset($_GET['type'])) {
            $filter = 'type';

        } elseif (isset($_GET['category'])) {
            $filter = 'category';
        }

        switch ($filter) {

            case 'type':
                $type = $_GET['type'];

                if ($type != "entrada" && $type != "saida") {
                    http_response_code(400);

                    echo json_encode([
                        'message' => 'Digite um tipo valido (entrada/saida).'
                    ]);

                    exit;
                }

                $stmt = $pdo->prepare(
                    "SELECT id, description, amount, type, category, transaction_date, created_at
                    FROM transactions
                        WHERE type = :type
                    ORDER BY created_at DESC
                    LIMIT 5"
                );

                $stmt->execute([
                    'type' => $type
                ]);

                $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                http_response_code(200);

                echo json_encode($transactions, JSON_PRETTY_PRINT);

                break;

            case 'category':
                $category = $_GET['category'];


                $stmt = $pdo->prepare(
                    "SELECT id, description, amount, type, category, transaction_date, created_at
                    FROM transactions
                        WHERE category = :category
                    ORDER BY created_at DESC
                    LIMIT 5"
                );

                $stmt->execute([
                    'category' => $category
                ]);

                $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                http_response_code(200);

                echo json_encode($transactions, JSON_PRETTY_PRINT);

                break;

            default:
                $stmt = $pdo->prepare(
                    "SELECT id, description, amount, type, category, transaction_date, created_at
                    FROM transactions
                    ORDER BY created_at DESC
                    LIMIT 5"
                );

                $stmt->execute();

                $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                http_response_code(200);

                echo json_encode($transactions, JSON_PRETTY_PRINT);

                break;
        }

        break;

    case 'PUT':
            if (!isset($_GET['id'])) {
                http_response_code(400);

                echo json_encode([
                    'message' => 'ID do registro e obrigatorio.'
                ]);

                exit;
            }

            $input = json_decode(file_get_contents("php://input"), true);

            if (
                !isset($input['description']) ||
                !isset($input['amount']) ||
                !isset($input['type']) ||
                !isset($input['category']) ||
                !isset($input['transaction_date'])
            ) {
            
                http_response_code(400);

                echo json_encode([
                    'message' => 'Todas as informacoes sao obrigatorias.'
                ]);

                exit;
            }

            $description = $input['description'];
            $amount = $input['amount'];
            $type = $input['type'];
            $category = $input['category'];
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
                    'message' => 'Digite uma descricao com pelo menos 4 caracteres.'
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

        if (trim($category) === '') { //remove espaços em branco do começo e do final
            http_response_code(400);

            echo json_encode([
                'message' => 'Digite uma categoria válida.'
            ]);

            exit;
        }
        
        if(strlen($category) < 4){
            http_response_code(400);

            echo json_encode([
                'message' => 'Digite uma categoria com pelo menos 4 caracteres.'
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

        $id = $_GET['id'];

        $stmt = $pdo->prepare(
            "SELECT id
            FROM transactions
            WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $transactions = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$transactions) {
            http_response_code(404); // Não encontrado

            echo json_encode([
                'message' => 'Registro nao encontrado.'
            ]);

            exit;
        }

        $stmt = $pdo->prepare(
            "UPDATE transactions
            SET description = :description,
                amount = :amount,
                type = :type,
                category = :category,
                transaction_date = :transaction_date
            WHERE id = :id"
        );

        $stmt->execute([
            'description' => $description,
            'amount' => $amount,
            'type' => $type,
            'category' => $category,
            'transaction_date' => $transaction_date,
            'id' => $id
        ]);


        http_response_code(200);

        echo json_encode([
            'message' => 'Transacao atualizada com sucesso.'
        ]);

        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);

            echo json_encode([
                'message' => 'ID da transacao e obrigatorio.'
            ]);

            exit;
        }


        $id = $_GET['id'];

        $stmt = $pdo->prepare(
            "SELECT id
            FROM transactions
            WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $transactions = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$transactions) {
            http_response_code(404);

            echo json_encode([
                'message' => 'Transacao nao encontrada.'
            ]);

            exit;
        }

        $stmt = $pdo->prepare(
            "DELETE FROM transactions
            WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        http_response_code(200);

        echo json_encode([
            'message' => 'Transacao excluida com sucesso.'
        ]);        

        break;

    default:
        http_response_code(405);
        echo json_encode([
            'message' => 'Método não permitido.'
        ]);
}