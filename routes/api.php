<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\WalletController as AdminWalletController;
use App\Http\Controllers\Admin\DataPlanController as AdminDataPlanController;
use App\Http\Controllers\Admin\NetworkPlanCategoryController;
use App\Http\Controllers\Admin\ElectricityController as AdminElectricityController;

use App\Http\Controllers\User\UserController as NormalUserController;
use App\Http\Controllers\User\WalletController as NormalWalletController;
use App\Http\Controllers\User\TopupController;
use App\Http\Controllers\User\Transactions;
use App\Http\Controllers\User\DataPlanController as UserDataController;
use App\Http\Controllers\User\ElectricityController as UserElectricityController;
use App\Http\Controllers\Webhook\VtuWebhookController;
// ensuring the logged in person is an admin
use App\Http\Middleware\EnsureUserIsAdmin;
/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth:sanctum', 'signed', 'throttle:6,1']);

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:6,1']);

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->group(function () {

        // Users Management
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::get('/users/{id}', [AdminUserController::class, 'show']);
        Route::put('/users/{id}', [AdminUserController::class, 'update']);
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
        Route::post('/users/{id}/restore', [AdminUserController::class, 'restore']);

        // Transactions Monitoring
        Route::get('/transactions', [AdminTransactionController::class, 'index']);
        Route::get('/transactions/{id}', [AdminTransactionController::class, 'show']);
        Route::put('/transactions/{id}/status', [AdminTransactionController::class, 'updateStatus']);
        Route::get('/transactions/user/{user_id}', [AdminTransactionController::class, 'showUserTransaction']);
        Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy']);

        // Wallet Monitoring
        Route::get('/wallets', [AdminWalletController::class, 'index']);
        Route::get('/wallets/{user_id}', [AdminWalletController::class, 'show']);
        Route::post('/wallets/fund', [AdminWalletController::class, 'credit']);
        Route::post('/wallets/debit', [AdminWalletController::class, 'debit']);

        // -------------------------
        // DATA PLAN MANAGEMENT
        // -------------------------
        Route::get('/dataplans', [AdminDataPlanController::class, 'index']);
        Route::post('/dataplans', [AdminDataPlanController::class, 'store']);
        Route::put('/dataplans/{dataPlan}', [AdminDataPlanController::class, 'update']);
        Route::delete('/dataplans/{dataPlan}', [AdminDataPlanController::class, 'destroy']);
        Route::post('/dataplans/{id}/restore', [AdminDataPlanController::class, 'restore']);
        Route::get('/plan-categories', [AdminDataPlanController::class, 'filterOptions']);
        Route::put('/dataplans/{dataPlan}/toggle-active', [AdminDataPlanController::class, 'toggleActive']);
        Route::get('/plan-categories/all', [NetworkPlanCategoryController::class, 'index']);
        Route::post('/network-plan-categories', [NetworkPlanCategoryController::class, 'store']);
        Route::post('/plan-categories/{id}/toggle', [NetworkPlanCategoryController::class, 'togglePlanCategory']);
        Route::post('/network-plan-categories/{id}/toggle', [NetworkPlanCategoryController::class, 'toggleNetworkCategory']);


        // the apis for electricity
  Route::get('/electricity', [AdminElectricityController::class, 'index']);

    Route::post('/electricity', [AdminElectricityController::class, 'store']);

    Route::put('/electricity/{id}', [AdminElectricityController::class, 'update']);

    Route::patch('/electricity/{id}/toggle', [AdminElectricityController::class, 'toggle']);

    Route::delete('/electricity/{id}', [AdminElectricityController::class, 'destroy']);
    });

/*
|--------------------------------------------------------------------------
| USER ROUTES (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])
    ->prefix('user')
    ->group(function () {

        // Profile
        Route::get('/profile', [NormalUserController::class, 'profile']);
        Route::post("/profile/setTransactionPin", [NormalUserController::class, "setTransactionPin"]);
        Route::put('/profile/updateName', [NormalUserController::class, 'updateName']);
        Route::put('/profile/updateEmail', [NormalUserController::class, 'updateEmail']);
        Route::put('/profile/updatePassword', [NormalUserController::class, 'updatePassword']);
        Route::delete('/profile/delete', [NormalUserController::class, 'deleteAccount']);

        // -------------------------
        // WALLET ROUTES
        // -------------------------
        Route::get('/wallet/balance', [NormalWalletController::class, 'balance']);
        Route::post('/wallet/fund', [NormalWalletController::class, 'fund']);

        // -------------------------
        // TOP-UP / PURCHASE ROUTES
        // -------------------------
        Route::middleware(['pin.set'])->group(function () {
            Route::post('/topup/airtime', [TopupController::class, 'buyAirtime']);
            Route::post('/topup/data', [TopupController::class, 'buyData']);
            Route::post("/electricityPurchase", [UserElectricityController::class, "purchase"]);
        });

        // Transaction history
        Route::get('/transactions', [Transactions::class, 'myTransactions']);


        Route::get('/dataplans', [UserDataController::class, 'index']);
        Route::get('/dataplans/{id}', [UserDataController::class, 'show']);

        Route::get("/electricityProvider", [UserElectricityController::class, "providers"]);
    });

// Webhook
Route::post('/webhook/vtu', [VtuWebhookController::class, 'handle']);
