<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplyController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(static function (): void {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(static function (): void {
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/', [MainController::class, 'menu'])->name('main.menu');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::middleware('role:manager')->group(static function (): void {
    Route::resource('providers', ProviderController::class);
    Route::resource('supplies', SupplyController::class);

    Route::resource('stores', StoreController::class)->only(['index', 'edit', 'update']);
    Route::get('stores/{store}/catalog', [StoreController::class, 'catalog'])->name('stores.catalog');
    Route::get('stores/{store}/order', [StoreController::class, 'order'])->name('stores.order');
    Route::post('stores/{store}/order', [StoreController::class, 'storeOrder'])->name('stores.store-order');
    Route::get('stores/{store}/acceptance', [StoreController::class, 'acceptance'])->name('stores.acceptance');
    Route::post('stores/{store}/acceptance', [StoreController::class, 'storeAcceptance'])->name('stores.store-acceptance');
    Route::get('stores/{store}/move-supplies', [StoreController::class, 'moveSupplies'])->name('stores.move-supplies');
    Route::post('stores/{store}/move-supplies', [StoreController::class, 'storeMoveSupplies'])->name('stores.store-move-supplies');
    Route::get('stores/{store}/write-off-supplies', [StoreController::class, 'writeOffSupplies'])->name('stores.write-off-supplies');
    Route::post('stores/{store}/write-off-supplies', [StoreController::class, 'storeWriteOffSupplies'])->name('stores.store-write-off-supplies');

    Route::get('statistic', static function (): void {
        // TODO later
    })->name('statistic');
});

Route::middleware('role:salesperson')->group(static function (): void {
    Route::get('sales', [SaleController::class, 'active'])->name('sales.active');
    Route::post('sales', [SaleController::class, 'storePosition'])->name('sales.position');
    Route::delete('sales/{position}', [SaleController::class, 'destroyPosition'])->name('sales.destroy-position');
    Route::patch('sales', [SaleController::class, 'complete'])->name('sales.complete');
    Route::delete('sales', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::resource('customers', CustomerController::class)->except(['destroy', 'show']);
    Route::resource('returns', ReturnController::class)->only(['store', 'index']);
});
