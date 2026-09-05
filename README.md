# 🏦 PayCore PHP - Engine Financeira & Contábil

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![Framework](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

O **PayCore PHP** é uma API financeira focada em controle de saldo, simulação de transferências e registros contábeis imutáveis (Double-Entry Bookkeeping / Partidas Dobradas). 

Este projeto foi desenvolvido como estudo prático para aplicar conceitos avançados de backend em PHP moderno, segurança e consistência de dados.

---

## 🎯 Objetivos e Conceitos Aplicados

- **Autenticação Segura:** Login, cadastro e proteção de rotas com tokens de acesso (JWT / Laravel Sanctum).
- **Consistência em Transações (ACID):** Garante que o dinheiro só saia de uma conta se efetivamente entrar na outra, evitando divergências em caso de falha.
- **Histórico Imutável (Ledger):** Todas as movimentações geram um registro contábil auditável de entrada e saída.
- **Segurança de Dados:** Uso de Prepared Statements via PDO para prevenção total de SQL Injection e hash seguro para senhas (`bcrypt`/`Argon2`).
