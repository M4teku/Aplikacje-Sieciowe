<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserBookController;

Route::get('/', [BookController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('books', BookController::class);
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');


Route::post('/books/{bookId}/add-to-list', [UserBookController::class, 'store'])->name('books.add-to-list');

Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/books/{book}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/mybooks', [UserBookController::class, 'myBooks'])->name('userbooks.mybooks');


Route::post('/books/{bookId}/track', [UserBookController::class, 'store'])->name('userbooks.store');
Route::put('/books/{bookId}/track', [UserBookController::class, 'update'])->name('userbooks.update');
Route::delete('/books/{bookId}/track', [UserBookController::class, 'destroy'])->name('userbooks.destroy');

Route::resource('reviews', ReviewController::class)->except(['index', 'show']);

Route::get('/mybooks/{bookId}/edit', [UserBookController::class, 'edit'])->name('userbooks.edit');
// Debug routes
Route::get('/debug-admin', function() {
    $user = \App\Models\User::where('login', 'admin')->first();
    
    if (!$user) {
        return 'Admin nie istnieje w bazie';
    }
    
    $check = \Illuminate\Support\Facades\Hash::check('admin123', $user->password);
    
    $output = "Admin: " . $user->login . "<br>";
    $output .= "Password check: " . ($check ? 'OK' : 'FAIL') . "<br>";
    $output .= "Password hash: " . $user->password . "<br>";
    $output .= "<hr>";
    
    if (!$check) {
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->save();
        $output .= "Hasło zresetowane do: admin123<br>";
    }
    
    return $output;
});

Route::get('/debug-db', function() {
    try {
        \DB::connection()->getPdo();
        $tables = \DB::select('SHOW TABLES');
        
        $output = "Baza danych OK<br>";
        $output .= "Tabele:<br>";
        
        foreach ($tables as $table) {
            foreach ($table as $key => $value) {
                $count = \DB::table($value)->count();
                $output .= "- $value: $count rekordów<br>";
            }
        }
        
        return $output;
    } catch (\Exception $e) {
        return "Błąd bazy: " . $e->getMessage();
    }
});

Route::get('/fix-admin', function() {
    $user = \App\Models\User::where('login', 'admin')->first();
    
    if (!$user) {
        $user = new \App\Models\User();
        $user->login = 'admin';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->email = 'admin@booktracker.pl';
        $user->save();
        
        $output = "Admin utworzony<br>";
    } else {
        $output = "Admin już istnieje (ID: {$user->id_user})<br>";
    }
    
    $adminRole = \App\Models\Role::where('name', 'Admin')->first();
    
    if ($adminRole) {
        $hasRole = \DB::table('user_role')
                     ->where('id_user', $user->id_user)
                     ->where('id_role', $adminRole->id_role)
                     ->exists();
        
        if (!$hasRole) {
            \DB::table('user_role')->insert([
                'id_user' => $user->id_user,
                'id_role' => $adminRole->id_role,
                'assigned_at' => now(),
            ]);
            $output .= "Rola Admin przypisana<br>";
        } else {
            $output .= "Rola Admin już przypisana<br>";
        }
    } else {
        $output .= "Rola Admin nie istnieje w bazie<br>";
    }
    
    return $output;
});

Route::get('/reading-statuses', function() {
    return \App\Models\ReadingStatus::all();
});