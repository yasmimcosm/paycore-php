# 🏦 PayCore - Financial Ledger & Transaction Engine

[![CI Pipeline](https://github.com/usuario/paycore-financial-ledger/actions/workflows/ci.yml/badge.svg)](https://github.com/usuario/paycore-financial-ledger/actions)
[![Coverage Status](https://img.shields.io/badge/coverage-92%25-brightgreen)](./tests)

O **PayCore** é um motor financeiro de alta consistência e baixa latência focado no processamento de transferências Pix/P2P, controle de saldo e registros contábeis imutáveis através de partidas dobradas (*Double-Entry Bookkeeping*).

---

## 🎯 Problemas Resolvidos & Arquitetura

Este sistema foi projetado para lidar com cenários onde **perda de dados ou inconsistência financeira não são toleradas**:

- **Garantia de Idempotência:** Processamento seguro de requisições duplicadas via `X-Idempotency-Key`.
- **Partidas Dobradas (Double-Entry Bookkeeping):** Toda movimentação gera registros equivalentes de débito e crédito, garantindo auditoria em tempo real.
- **Tratamento de Concorrência:** Proteção contra *race conditions* no saldo usando bloqueio otimista/pessimista e transações relacional com isolamento adequado.
- **Arquitetura Orientada a Eventos:** Separação entre a execução do pagamento e o envio de notificações/auditoria usando Outbox Pattern + Kafka.

---

## 🛠️ Tech Stack

- **Linguagem & Runtime:** Node.js / Go / Java (Escolha o seu)
- **Banco de Dados Principal:** PostgreSQL (Transações ACID)
- **Caching & Locks Distribuídos:** Redis
- **Mensageria & Eventos:** Apache Kafka / RabbitMQ
- **Observabilidade:** Prometheus + Grafana + OpenTelemetry (Jaeger)
- **Infraestrutura:** Docker, Docker Compose, GitHub Actions (CI/CD)

---

## 📊 Arquitetura do Sistema

```mermaid
graph TD
    Client[Cliente / App] -->|HTTP REST| API[API Gateway / Core Engine]
    API -->|Validação & Lock| Redis[(Redis)]
    API -->|Transação ACID| DB[(PostgreSQL)]
    API -->|Outbox Pattern| Kafka[Kafka Cluster]
    Kafka -->|Consumer| LedgerAudit[Audit & Analytics Service]
    Kafka -->|Consumer| Notification[Notification Service]
