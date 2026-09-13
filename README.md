# 🏦 PayCore PHP

> ⚠️ Projeto pessoal em desenvolvimento para fins de estudo backend.

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat\&logo=php\&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

API backend desenvolvida em PHP e MySQL, atualmente focada na construção da base da aplicação e no gerenciamento de usuários. O projeto será evoluído gradualmente para uma API financeira e contábil.

## Tecnologias

* PHP 8.2+
* MySQL 8.0+
* PDO
* Composer
* phpdotenv
* Postman

## Funcionalidades atuais

* Cadastro de usuários
* Listagem de usuários
* Busca de usuário por ID
* Atualização de usuário
* Exclusão de usuário
* Validação de dados de entrada
* Hash seguro de senhas
* Proteção contra SQL Injection utilizando PDO Prepared Statements
* Configuração de credenciais através de variáveis de ambiente

## Endpoints

### Usuários

| Método   | Endpoint            | Descrição                |
| -------- | ------------------- | ------------------------ |
| `POST`   | `/register.php`     | Cadastra um novo usuário |
| `GET`    | `/users.php`        | Lista todos os usuários  |
| `GET`    | `/user.php?id={id}` | Busca um usuário pelo ID |
| `PUT`    | `/user.php?id={id}` | Atualiza nome e e-mail   |
| `DELETE` | `/user.php?id={id}` | Exclui um usuário        |

## Estrutura atual

```text
php_backend/
├── db.php
├── register.php
├── users.php
├── user.php
├── composer.json
├── composer.lock
└── .gitignore
```

## Próximos passos

* Melhorar a organização da API
* Adicionar autenticação
* Implementar funcionalidades financeiras
* Implementar transferências
* Estruturar operações contábeis de dupla entrada
* Adicionar testes automatizados
