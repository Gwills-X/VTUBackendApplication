# VTU System Audit and Developer Guide

## Overview

This document provides a full audit of the current VTU backend application and a professional developer guide for building a similar VTU software system.

The codebase is built on Laravel 12 with PHP 8.2, using Sanctum for API authentication, a wallet-based transaction ledger, and an external VTU provider integration.

---

## 1. System Architecture

### Core Technologies

- PHP 8.2
- Laravel 12
- Laravel Sanctum (`auth:sanctum`) for API auth
- Eloquent ORM for models and relationships
- HTTP Client (`Illuminate\Support\Facades\Http`) for external provider calls
- Soft deletes for plan lifecycle management

### Primary Domains

- Authentication
- User wallet management
- Transaction processing
- Airtime purchase
- Data purchase
- Electricity purchase
- Admin management
- Webhook reconciliation

### Important Files

- `routes/api.php` — main API routing for auth, admin, user, and webhook endpoints
- `app/Services/VtuService.php` — core VTU provider integration and purchase processing
- `app/Models/User.php` — user model and wallet relation
- `app/Models/Wallet.php` — user wallet model
- `app/Models/Transaction.php` — transaction ledger
- `app/Models/AvailableDataPlan.php` — available data plans
- `app/Http/Middleware/EnsureUserIsAdmin.php` — admin route protection
- `app/Http/Middleware/EnsureTransactionPinIsSet.php` — transaction PIN enforcement
- `app/Http/Controllers/Webhook/VtuWebhookController.php` — webhook callback handler
- `config/services.php` — VTU provider configuration

---

## 2. Data Model and Business Flow

### User and Wallet

- `User` has one `Wallet`.
- `User::created()` automatically creates a wallet with `balance = 0`.
- The wallet balance is the single source of truth for user purchasing power.

### Transactions

- Every purchase or wallet action is recorded as a `Transaction`.
- Key `Transaction` fields:
    - `user_id`
    - `type` (`wallet_fund`, `buy_data`, `buy_airtime`, `buy_electricity`, `credit`, `debit`)
    - `amount`
    - `status` (`pending`, `success`, `failed`)
    - `reference`
    - `phone_number`
    - `meta` JSON for provider details

### Data Plan Catalog

- `AvailableDataPlan` stores plan metadata and relationships to:
    - `PlanCategory`
    - `NetworkPlanCategory`
- Admin users can create, update, soft-delete, restore, and toggle active status for plans.

### Electricity Providers

- `ElectricityProvider` stores available electricity vendors.
- User can fetch providers and purchase electricity through the same VTU service flow.

---

## 3. API and User Flows

### Authentication

- `POST /register` — create account
- `POST /login` — user login
- `POST /logout` — logout (authenticated)
- Password reset and email verification routes are also present

### User Routes

Authenticated routes under `/user` include:

- `/profile` and profile management
- `/wallet/balance`
- `/wallet/fund`
- `/topup/airtime`
- `/topup/data`
- `/electricityPurchase`
- `/transactions`
- `/dataplans`
- `/dataplans/{id}`
- `/electricityProvider`

### Admin Routes

Admin-only routes under `/admin` include:

- user management
- transaction monitoring
- wallet credit/debit
- data plan management
- plan category and network category management
- electricity provider management

### Webhook

- `POST /webhook/vtu` — external VTU provider callback
- Updates transaction status and refunds wallet balance for failed transactions

---

## 4. VTU Service Layer

### `VtuService.php`

This is the central integration point for external provider requests.

#### Features:

- `buyAirtime()`
- `buyData()`
- `buyElectricity()`
- Shared `process()` or `processElectricity()` workflow
- Creates a `Transaction` record with status `pending`
- Calls the external provider with `Authorization: Token ...`
- Interprets provider response status
- Deducts wallet balance only on confirmed success
- Uses DB transactions for consistency

### External configuration

- `config/services.php` declares:
    - `vtu.key` from `VTU_API_KEY`
    - `vtu.purchase_url` from `VTU_PURCHASE_URL`

### Provider endpoints used

- `purchase_url + topup`
- `purchase_url + data`
- `purchase_url + electricity`

---

## 5. Audit Findings and Recommendations

### Strengths

- Clear separation of concerns: controllers remain thin; provider logic is in `VtuService`
- Transaction ledger captures every monetary action
- Wallet auto-created for users
- Middleware enforces admin-only access and transaction PIN usage
- Soft delete support for available plans
- Admin network/category management supports plan classification

### Issues and Risks

1. **Webhook authentication missing**
    - `VtuWebhookController` accepts status updates without verifying provider signatures.
    - Recommendation: validate a shared webhook secret or HMAC signature.

2. **Potential table/model mismatch**
    - `TopupController` uses `App\Models\DataPlan` and the `data_plans` table.
    - Admin data plan management uses `App\Models\AvailableDataPlan` and `available_data_plans`.
    - Recommendation: verify if both tables are intentional; standardize plan access.

3. **Migration bug**
    - `2026_03_02_181736_create_avalaible_data_plans_table.php` drops `data_plans` in `down()` instead of `available_data_plans`.
    - Recommendation: fix migration rollback.

4. **Wallet funding logic is inconsistent**
    - `WalletController::fund()` increments balance and creates a `wallet_fund` transaction with status `pending`.
    - This suggests pending approval, but the balance is already available.
    - Recommendation: either mark funds as pending in a separate account or only credit after admin approval.

5. **Concurrency and race conditions**
    - Wallet decrement operations are used, but there is no explicit locking for high-frequency purchases.
    - Recommendation: use row-level locking or atomic `decrement()` operations inside a transaction.

6. **Provider response handling**
    - The system checks only HTTP success and top-level `status` values.
    - Recommendation: add stricter validation for response shape, error codes, and missing fields.

7. **Sensitive credentials in `.env`**
    - The repository contains a real-looking `VTU_API_KEY` value.
    - Recommendation: remove committed secrets and rotate keys.

8. **No rate limiting for purchase routes**
    - Modern VTU apps should throttle top-up requests to prevent abuse.
    - Recommendation: apply `throttle` middleware to sensitive endpoints.

---

## 6. Developer Onboarding: Build a VTU App Like This

### Step 1: Define the Domain Model

Start with the core entities:

- User
- Wallet
- Transaction
- DataPlan
- AvailableDataPlan / Network categories
- ElectricityProvider

Define relationships:

- `User` → `Wallet` (1:1)
- `User` → `Transaction` (1:n)
- `AvailableDataPlan` → `PlanCategory` (n:1)
- `AvailableDataPlan` → `NetworkPlanCategory` (n:1)

### Step 2: Scaffold the Laravel App

- `composer create-project laravel/laravel vtu-app "^12.0"`
- Use Sanctum for API auth
- Register middleware in `app/Http/Kernel.php`

### Step 3: Implement Authentication and Wallet

- Use Laravel Breeze or manual auth controllers
- Auto-create a wallet for each user
- Add wallet balance endpoints

### Step 4: Add Transaction Ledger

- Create `Transaction` model with `type`, `status`, `amount`, `reference`, `meta`
- Log every wallet action and provider purchase
- Use consistent status transitions: `pending` → `success` / `failed`

### Step 5: Build VTU Provider Service

- Centralize API calls in a service class like `VtuService`
- Keep controllers thin by injecting the service
- Handle airtime, data, and electricity separately but share common logic
- Store provider responses in transaction metadata

### Step 6: Add User Purchase Endpoints

- Validate request input carefully
- Enforce transaction PIN for purchases
- Check wallet balance before calling provider
- Keep provider calls within DB transactions

### Step 7: Add Admin Control Panel APIs

- Manage users, wallets, transactions
- Manage plan catalog and categories
- Manage electricity providers
- Provide toggles for `active` state

### Step 8: Add Webhook Support

- Create a webhook route for provider callbacks
- Match transactions by `reference`
- Update transaction status and refund on failure
- Secure webhooks with HMAC/shared secret verification

### Step 9: Configure Environment and Deployment

- Add `VTU_API_KEY` and `VTU_PURCHASE_URL` in `.env`
- Keep secrets out of source control
- Run migrations
- Use queues if provider calls become slow or need retry

---

## 7. Setup Instructions for This Repository

### Local Setup

1. `composer install`
2. Copy `.env.example` to `.env`
3. Set `APP_KEY` and VTU service env values:
    - `VTU_API_KEY`
    - `VTU_PURCHASE_URL`
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan serve`

### Recommended Commands

- `composer run test` — run tests
- `php artisan migrate --force` — migrate database
- `php artisan tinker` — inspect models interactively

---

## 8. Key Files and What They Do

- `app/Services/VtuService.php` — external provider communication and purchase processing.
- `routes/api.php` — API routing, authentication, user and admin endpoints, webhook.
- `app/Models/User.php` — user wallet initialization and admin check.
- `app/Models/Wallet.php` — wallet balance management.
- `app/Models/Transaction.php` — transaction ledger and metadata.
- `app/Models/AvailableDataPlan.php` — data plan catalog.
- `app/Http/Middleware/EnsureUserIsAdmin.php` — admin route guard.
- `app/Http/Middleware/EnsureTransactionPinIsSet.php` — transaction PIN validation.
- `app/Http/Controllers/Webhook/VtuWebhookController.php` — webhook callback handler.

---

## 9. Recommended Improvements

1. Add request validation and authorization to every controller.
2. Secure webhook endpoints with a provider signature.
3. Use queue jobs for external provider calls if latency grows.
4. Add comprehensive feature tests for purchase flows.
5. Fix migration rollback and table/model consistency.
6. Add API documentation for frontend integration.
7. Apply rate limiting to top-up/electricity purchase routes.

---

## 10. Conclusion

This repository already contains the essential VTU building blocks: wallet accounting, transaction tracking, provider integration, and admin catalog management.

A new developer should focus on:

- understanding the `VtuService` workflow,
- verifying data plan model consistency,
- securing webhook and purchase endpoints,
- and improving wallet approval flows.

With the recommendations above, this backend can be hardened into a production-grade VTU system.
