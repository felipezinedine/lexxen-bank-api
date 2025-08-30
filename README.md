# Lexxen Bank API

API de gestão bancária desenvolvida em **Laravel**, como parte do desafio prático para desenvolvedor pleno. O sistema permite o gerenciamento de usuários, contas bancárias e transferências, seguindo boas práticas de desenvolvimento e arquitetura **DDD (Domain-Driven Design)**.

---

## 📌 Funcionalidades

- **CRUD de usuários**  
- **Gerenciamento de contas bancárias**  
  - Cada usuário possui **uma conta**  
  - Número da conta gerado automaticamente e único  
  - Controle de saldo  
  - Status da conta (ativa/inativa)  
- **Transferências entre contas**  
  - Registro automático de extrato (statements)  
  - Validação de saldo  
  - Histórico de transferências  

---

## 🛠 Tecnologias

- **PHP 8+**  
- **Laravel 12**  
- **MySQL**  
- **Composer**  

---

## ⚡ Estrutura do Projeto

O projeto segue a arquitetura **DDD (Domain-Driven Design)**, separando camadas de:

- **Domain**: repositórios, entidades e regras de negócio  
- **Application**: DTOs e serviços  
- **Infrastructure**: persistência (Eloquent)  
- **API**: rotas e controladores  

---

## 📄 Endpoints e Parâmetros Obrigatórios

### Registrar Usuário
POST /api/register
Campos obrigatórios: `name`, `email`, `password`, `cpf`  

## Comando para alterar status do usuário criado
php artisan user:status emailcadastrado@email.com approved

### Após trocar o status atráves do terminal, você já vai poder fazer login

### Usuários
**Criar usuário**  
`POST /api/users/create/`  
Campos obrigatórios: `name`, `email`, `password`, `cpf`  

### Contas
**Criar conta**  
`POST /api/accounts/store`  
Campos obrigatórios: `user_id`  

**Alterar status da conta**  
`POST /api/accounts/deactive`  
Campos obrigatórios: `user_id`, `number`, ['status' => ['active', 'blocked']] 

### Transferências
**Realizar transferência**  
`POST /api/transfers/`  
Campos obrigatórios:  
- `from_account_id` → conta que está enviando  
- `to_account_id` → conta que vai receber  
- `value` → valor da transação  
- `user_id` → id do usuário da conta que está enviando  

---

## 🚀 Instalação

1. Clone o repositório:

```bash
git clone https://github.com/felipezinedine/lexxen-bank-api.git
cd lexxen-bank-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
