<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'LandingPage'])->name("landing");

Route::get('/login', [\App\Http\Controllers\UsersController::class, 'login'])->name("login");
Route::post("/login", [\App\Http\Controllers\UsersController::class, "auth"]);

Route::get("/registration", [\App\Http\Controllers\UsersController::class, "create"])->name("registration");
Route::post("/registration", [\App\Http\Controllers\UsersController::class, "store"]);

Route::get("/email/verify", [\App\Http\Controllers\UsersController::class, "verify_notice"])->name("email.verify");

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('logout', [\App\Http\Controllers\UsersController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [\App\Http\Controllers\UsersController::class, 'forgot_password'])->middleware(['guest'])->name('forgot.password');
Route::post('/forgot-password', [\App\Http\Controllers\UsersController::class, 'send_password'])->middleware(['guest']);
Route::get('/reset-password/{token}', [\App\Http\Controllers\UsersController::class, 'reset_password'])->middleware(['guest'])->name("reset.password");
Route::post('/reset-password/{token}', [\App\Http\Controllers\UsersController::class, 'update_password'])->middleware(['guest']);

Route::get("/home");

Route::get("/shop/create", [\App\Http\Controllers\ShopsCreateController::class, "create"])->middleware(['auth'])->name("shop.create");
Route::post("/shop/create", [\App\Http\Controllers\ShopsCreateController::class, "store"])->middleware(['auth']);

Route::get("/shop/phone-activation/{shop_id}", [\App\Http\Controllers\ShopsCreateController::class, "phone_activation"])->middleware(['auth', 'check.owner'])->name("phone.activation");
Route::get("/shop/legal-information/{shop_id}", [\App\Http\Controllers\ShopsCreateController::class, "legal_information"])->middleware(['auth', 'check.owner'])->name("legal.information");
Route::post("/shop/legal-information/{shop_id}", [\App\Http\Controllers\ShopsCreateController::class, "legal_store"])->middleware(['auth', 'check.owner'])->name("legal.information");
Route::get("/shop/resend-code/{shop_id}", [\App\Http\Controllers\ShopsCreateController::class, "resend_code"])->middleware(['auth', 'check.owner'])->name("resend.code");
Route::post("/shop/phone-activation/{shop_id}", [\App\Http\Controllers\ShopsCreateController::class, "check_code"])->middleware(['auth', 'check.owner']);
Route::get("/shop/{shop_id}", [\App\Http\Controllers\ShopsController::class, "show"])->name("shop.show");
Route::get("/shop/edit/{shop_id}", [\App\Http\Controllers\ShopsController::class, "edit"])->middleware(['auth'])->name("shop.edit");
Route::post("/shop/edit/{shop_id}", [\App\Http\Controllers\ShopsController::class, "update"])->middleware(['auth']);

Route::get("/item/create/{shop_id}", [\App\Http\Controllers\ItemsController::class, "create"])->middleware(['auth'])->name("item.create");
Route::get("/item/{item_id}", [\App\Http\Controllers\ItemsController::class, "show"])->name("item.show");
Route::get("/item/edit/{item_id}", [\App\Http\Controllers\ItemsController::class, "edit"])->middleware(['auth'])->name("item.edit");
Route::post("/item/edit/{item_id}", [\App\Http\Controllers\ItemsController::class, "update"])->middleware(['auth']);
Route::post("/item/create/{shop_id}", [\App\Http\Controllers\ItemsController::class, "store"])->middleware(['auth']);

Route::get("/catalog", [\App\Http\Controllers\CatalogController::class, "index"]);
Route::get("/catalog/reset", [\App\Http\Controllers\CatalogController::class, "reset"])->name("catalog.reset");
Route::get("/catalog/category/{category_id}", [\App\Http\Controllers\CatalogController::class, "category"])->name("catalog.category");
Route::post("/json/category", [\App\Http\Controllers\Ajax\Catalog::class, "filter"])->name("ajax.category");

Route::get("messages", [\App\Http\Controllers\MessagesController::class, "index"])->middleware("auth")->name("messages.index");
Route::get("messages/{user_id}", [\App\Http\Controllers\MessagesController::class, "show"])->middleware("auth")->name("messages.show");
Route::post("messages/{user_id}", [\App\Http\Controllers\MessagesController::class, "store"])->middleware("auth");
Route::get("messages/order/{item_id}", [\App\Http\Controllers\MessagesController::class, "order"])->middleware("auth")->name("messages.order");
Route::post("messages/order", [\App\Http\Controllers\MessagesController::class, "storeOrder"])->middleware("auth")->name("messages.storeOrder");

Route::get("search", [\App\Http\Controllers\SearchController::class, "index"]);
Route::post("search", [\App\Http\Controllers\SearchController::class, "query"])->name("search");
