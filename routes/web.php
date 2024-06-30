<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');
Route::get('/subscribed', function () {
   return Inertia::render('Subscribed');
})->name('subscribed');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email test routes
//Route::get('/mail/thank-you', function () {
//    $email = 'test@example.com';
//    return view('mail.thank-you-for-subscribing', compact('email'));
//});


//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//Route::get('/sikretos', [SikretoController::class, 'index'])->middleware('auth')->name('sikretos.index');
//Route::get('/about', function () {
//    return view('about');
//})->name('about');
//
//Route::resource('recipes', RecipeController::class)->middleware('auth');
//
//Route::post('/recipes/{recipe}/send', [RecipeController::class, 'send'])->name('recipes.send');

//Route::middleware('auth')->group(function () {
////    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
//    Route::get('/recipes', [RecipeController::class, 'show'])->name('recipes.show');
//    Route::get('/recipes', [RecipeController::class, 'edit'])->name('recipes.edit');
//    Route::patch('/recipes', [RecipeController::class, 'update'])->name('recipes.update');
//    Route::delete('/recipes', [RecipeController::class, 'destroy'])->name('recipes.destroy');
//});

require __DIR__.'/auth.php';
