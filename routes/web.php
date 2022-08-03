<?php

use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::resource("assemblies", AssemblyController::class, [
    "except" => ["index", "show"],
    "middleware" => ["auth.admin", "auth", "verified"],
]);
Route::get("assemblies", [AssemblyController::class, "index"])->name("assemblies.index");
Route::get("assemblies/{assembly}",  [AssemblyController::class, "show"])->middleware(["auth", "verified"])->name("assemblies.show");

Route::resource("components", ComponentController::class, [
    "except" => ["index", "show"],
    "middleware" => ["auth.admin", "auth", "verified"],
]);
Route::get("components", [ComponentController::class, "index"])->name("components.index");
Route::get("components/{assembly}",  [ComponentController::class, "show"])->middleware(["auth", "verified"])->name("components.show");


Route::get("search", SearchController::class)->name("search");

require __DIR__.'/auth.php';
