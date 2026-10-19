<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/db.php';

use Ramsey\Uuid\Uuid;

$stmt = $pdo->query(
    "SELECT id FROM transactions WHERE uuid IS NULL"
);

$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$update = $pdo->prepare(
    "UPDATE transactions SET uuid = :uuid WHERE id = :id"
);

foreach ($transactions as $transaction) {
    $uuid = Uuid::uuid4()->toString();

    $update->execute([
        'uuid' => $uuid,
        'id' => $transaction['id']
    ]);

    echo "Transação {$transaction['id']}: {$uuid}\n";
}