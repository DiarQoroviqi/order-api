# 📦 Order Management API with Dynamic Discounts

A clean and extensible Laravel 12-based API for managing customers, products, orders, and applying dynamic discounts using Chain of Responsibility pattern.

---

## ⚙️ Tech Stack

- PHP 8.2+
- Laravel 12
- Docker & Laravel Sail
- MySQL
- PHPUnit for testing
- SOLID & Clean Architecture principles

---

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/DiarQoroviqi/order-api.git
cd order-api
```

### 2. Start the Environment and Install Dependencies
```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
```

### 3. Configure Environment and Generate Key
```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

### 4. Create Databases
```bash
order_managment for app
testing for testing
```

### 5. Rung migrations and seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

### To run unit tests
```bash
cp .env.testing .env
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan migrate --env=testing
./vendor/bin/sail test
```
