<?php


//__DIR__ : constante especial do PHP que representa o diretório onde está o arquivo atual.
require __DIR__ . '/vendor/autoload.php';

//criando um objeto do phpdotenv. "Crie um carregador de variáveis de ambiente e procure o .env neste diretório."
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

//Agora ele carrega as informações do .env
$dotenv->load();

//PDO significa PHP Data Objects. Responsável por fazer conexão ao banco.
$pdo = new PDO(
    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
);