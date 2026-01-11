<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;

// Strona główna = lista książek
Route::get('/', [BookController::class, 'index'])->name('home');

// Autentykacja
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Książki
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

// Profil
Route::get('/profile', [AuthController::class, 'profile'])->name('profile.show');

// Debug routes
Route::get('/debug-admin', function() {
    $user = \App\Models\User::where('login', 'admin')->first();
    
    if (!$user) {
        return '❌ Admin nie istnieje w bazie';
    }
    
    $check = \Illuminate\Support\Facades\Hash::check('admin123', $user->password);
    
    $output = "Admin: " . $user->login . "<br>";
    $output .= "Password check: " . ($check ? '✅ OK' : '❌ FAIL') . "<br>";
    $output .= "Password hash: " . $user->password . "<br>";
    $output .= "<hr>";
    
    // Zresetuj hasło jeśli nie działa
    if (!$check) {
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->save();
        $output .= "✅ Hasło zresetowane do: admin123<br>";
    }
    
    return $output;
});

Route::get('/debug-db', function() {
    try {
        \DB::connection()->getPdo();
        $tables = \DB::select('SHOW TABLES');
        
        $output = "✅ Baza danych OK<br>";
        $output .= "Tabele:<br>";
        
        foreach ($tables as $table) {
            foreach ($table as $key => $value) {
                $count = \DB::table($value)->count();
                $output .= "- $value: $count rekordów<br>";
            }
        }
        
        return $output;
    } catch (\Exception $e) {
        return "❌ Błąd bazy: " . $e->getMessage();
    }
});

Route::get('/fix-admin', function() {
    // 1. Sprawdź czy admin istnieje
    $user = \App\Models\User::where('login', 'admin')->first();
    
    if (!$user) {
        // Stwórz admina
        $user = new \App\Models\User();
        $user->login = 'admin';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->email = 'admin@booktracker.pl';
        $user->save();
        
        $output = "✅ Admin utworzony<br>";
    } else {
        $output = "✅ Admin już istnieje (ID: {$user->id_user})<br>";
    }
    
    // 2. Przypisz rolę Admin
    $adminRole = \App\Models\Role::where('name', 'Admin')->first();
    
    if ($adminRole) {
        // Sprawdź czy już ma rolę
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
            $output .= "✅ Rola Admin przypisana<br>";
        } else {
            $output .= "✅ Rola Admin już przypisana<br>";
        }
    } else {
        $output .= "❌ Rola Admin nie istnieje w bazie<br>";
    }
    
    return $output;
});