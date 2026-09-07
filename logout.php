<?php

session_start();

//Remove os dados armazenados na sessão
session_unset();
//Destrói a sessão no servidor.
session_destroy();

http_response_code(200);

echo json_encode([
    'message' => 'Logout realizado com sucesso.'
]);