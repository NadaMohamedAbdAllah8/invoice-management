# Invoice Management API

Laravel-based multi-tenant invoice management API.

## Requirements

- PHP 8.2+
- Composer
- SQLite (default in this project) or another supported DB

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Run

```bash
php artisan serve
```

API base URL (local): `http://127.0.0.1:8000/api`

## Testing

```bash
php artisan test
```

## Authentication

Use:

- `POST /api/login`

Then pass bearer token for protected routes:

- `Authorization: Bearer <token>`

## Main Endpoints

- `POST /api/contracts`
- `GET /api/contracts/{contract}/summary`
- `POST /api/contracts/{contract}/invoices`
- `GET /api/contracts/{contract}/invoices`
- `POST /api/invoices/{invoice}/payments`
- `GET /api/invoices/{invoice}`

## Notes

- Tenant isolation is enforced by middleware and model scope.
- Contract summary includes invoice aggregates:
  - `invoices_count`
  - `total_invoiced`
  - `total_paid`
  - `outstanding_balance`
  - `latest_invoice_date`
