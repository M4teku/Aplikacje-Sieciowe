<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Wyświetlanie listy użytkowników
     */
    public function users(Request $request)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('home')->with('error', 'Brak uprawnień administracyjnych.');
        }
        
        // Pobieranie użytkowników z ich rolami
        $query = User::with('roles');
        
        // Wyszukiwanie użytkowników
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('login', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        $users = $query->paginate(20);
        $roles = Role::where('is_active', true)->get();
        
        return view('admin.users', compact('users', 'roles'));
    }
    
    /**
     * Aktualizacja roli użytkownika
     */
    public function updateUserRole(Request $request, $userId)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return response()->json(['error' => 'Brak uprawnień'], 403);
        }
        
        $user = User::findOrFail($userId);
        
        // Sprawdzenie czy próba zmiany uprawnień admina
        if ($user->id_user == Session::get('user_id')) {
            return response()->json(['error' => 'Nie możesz zmienić swoich własnych uprawnień'], 400);
        }
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'role_id' => 'required|exists:role,id_role',
            'action' => 'required|in:add,remove',
        ]);
        
        // Obsługa dodawania/usuwań roli
        if ($validated['action'] == 'add') {
            // Sprawdzenie czy użytkownik już ma tę rolę
            $existing = DB::table('user_role')
                         ->where('id_user', $userId)
                         ->where('id_role', $validated['role_id'])
                         ->exists();
            
            if (!$existing) {
                DB::table('user_role')->insert([
                    'id_user' => $userId,
                    'id_role' => $validated['role_id'],
                    'assigned_at' => now(),
                ]);
            }
        } else {
            // Usuwanie roli
            DB::table('user_role')
              ->where('id_user', $userId)
              ->where('id_role', $validated['role_id'])
              ->delete();
        }
        
        return response()->json(['success' => 'Rola zaktualizowana']);
    }
    
    /**
     * Resetowanie hasła użytkownika
     */
    public function resetPassword(Request $request, $userId)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('admin.users')->with('error', 'Brak uprawnień.');
        }
        
        $user = User::findOrFail($userId);
        
        // Generowanie nowego hasła
        $newPassword = str_random(10);
        
        // Aktualizacja hasła użytkownika
        $user->password = Hash::make($newPassword);
        $user->save();
        
        // W rzeczywistej aplikacji tutaj byłaby wysyłka emaila z nowym hasłem
        // Na potrzeby projektu zwracamy hasło w komunikacie
        return back()->with('success', 'Hasło zresetowane. Nowe hasło: ' . $newPassword);
    }
    
    /**
     * Dezaktywacja/aktywacja użytkownika
     */
    public function toggleUserStatus($userId)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('admin.users')->with('error', 'Brak uprawnień.');
        }
        
        $user = User::findOrFail($userId);
        
        // Sprawdzenie czy próba dezaktywacji samego siebie
        if ($user->id_user == Session::get('user_id')) {
            return back()->with('error', 'Nie możesz dezaktywować swojego własnego konta.');
        }
        
        // TODO: Dodanie pola is_active w tabeli user
        // Na razie symulacja poprzez usunięcie wszystkich ról
        
        if ($user->roles()->count() > 0) {
            // Dezaktywacja - usunięcie wszystkich ról
            DB::table('user_role')->where('id_user', $userId)->delete();
            $message = 'Konto użytkownika dezaktywowane';
        } else {
            // Aktywacja - dodanie domyślnej roli Czytelnik
            $readerRole = Role::where('name', 'Czytelnik')->first();
            if ($readerRole) {
                DB::table('user_role')->insert([
                    'id_user' => $userId,
                    'id_role' => $readerRole->id_role,
                    'assigned_at' => now(),
                ]);
            }
            $message = 'Konto użytkownika aktywowane';
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Wyświetlanie statystyk systemu
     */
    public function statistics()
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('home')->with('error', 'Brak uprawnień administracyjnych.');
        }
        
        // Pobieranie statystyk systemu
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_reviews' => DB::table('review')->count(),
            'active_today' => User::whereDate('last_login', now()->toDateString())->count(),
        ];
        
        // Pobieranie najnowszych użytkowników
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        // Pobieranie najnowszych książek
        $recentBooks = Book::with('creator')->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('admin.statistics', compact('stats', 'recentUsers', 'recentBooks'));
    }
    
    /**
     * Zarządzanie rolami systemowymi
     */
    public function roles()
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('home')->with('error', 'Brak uprawnień administracyjnych.');
        }
        
        $roles = Role::all();
        
        return view('admin.roles', compact('roles'));
    }
    
    /**
     * Dodawanie nowej roli
     */
    public function addRole(Request $request)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('admin.roles')->with('error', 'Brak uprawnień.');
        }
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'name' => 'required|string|max:60|unique:role,name',
        ]);
        
        // Tworzenie nowej roli
        Role::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);
        
        return back()->with('success', 'Rola dodana pomyślnie');
    }
    
    /**
     * Aktualizacja statusu roli
     */
    public function toggleRoleStatus($roleId)
    {
        // Weryfikacja uprawnień administratora
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('admin.roles')->with('error', 'Brak uprawnień.');
        }
        
        $role = Role::findOrFail($roleId);
        
        // Sprawdzenie czy próba dezaktywacji podstawowych ról
        $basicRoles = ['Admin', 'Moderator', 'Czytelnik'];
        if (in_array($role->name, $basicRoles)) {
            return back()->with('error', 'Nie można dezaktywować podstawowych ról systemowych.');
        }
        
        // Przełączenie statusu aktywacji
        $role->is_active = !$role->is_active;
        $role->save();
        
        $status = $role->is_active ? 'aktywowana' : 'dezaktywowana';
        
        return back()->with('success', "Rola {$role->name} {$status}");
    }
}