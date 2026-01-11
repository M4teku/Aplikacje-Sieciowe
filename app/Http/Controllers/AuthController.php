<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('user_id')) {
            return redirect()->route('home')->with('info', 'Jesteś już zalogowany!');
        }
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        \Log::info('LOGIN ATTEMPT:', ['login' => $request->login]);
        
        $request->validate([
            'login' => 'required|string|min:3|max:60',
            'password' => 'required|string|min:8',
        ], [
            'login.required' => 'Login jest wymagany',
            'login.min' => 'Login musi mieć przynajmniej 3 znaki',
            'password.required' => 'Hasło jest wymagane',
            'password.min' => 'Hasło musi mieć przynajmniej 8 znaków',
        ]);
        
        $user = User::where('login', $request->login)->first();
        
        \Log::info('USER FOUND:', ['user' => $user ? $user->id_user : 'null']);
        
        if (!$user) {
            \Log::warning('USER NOT FOUND:', ['login' => $request->login]);
            return back()->withErrors(['login' => 'Nieprawidłowy login lub hasło'])->withInput();
        }
        
        $passwordCheck = Hash::check($request->password, $user->password);
        \Log::info('PASSWORD CHECK:', ['result' => $passwordCheck, 'input' => $request->password]);
        
        if (!$passwordCheck) {
            \Log::warning('WRONG PASSWORD for user:', ['id' => $user->id_user]);
            return back()->withErrors(['password' => 'Nieprawidłowy login lub hasło'])->withInput();
        }
        
        $roles = $user->roles()->pluck('name')->toArray();
        \Log::info('USER ROLES:', $roles);
        
        Session::put('user_id', $user->id_user);
        Session::put('user_login', $user->login);
        Session::put('user_email', $user->email);
        Session::put('user_roles', $roles);
        
        \Log::info('LOGIN SUCCESS:', ['user_id' => $user->id_user]);
        
        return redirect()->route('home')
                         ->with('success', 'Zalogowano pomyślnie! Witaj ' . $user->login . '!');
    }
    
    public function showRegister()
    {
        if (Session::has('user_id')) {
            return redirect()->route('home')->with('info', 'Jesteś już zalogowany!');
        }
        
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        \Log::info('REGISTER START', $request->all());
        
        try {
            $validated = $request->validate([
                'login' => 'required|string|min:3|max:60|unique:user,login',
                'email' => 'required|email|max:100|unique:user,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ], [
                'login.unique' => 'Ten login jest już zajęty',
                'email.unique' => 'Ten email jest już zarejestrowany',
                'password.confirmed' => 'Hasła nie są identyczne',
                'password.min' => 'Hasło musi mieć przynajmniej 8 znaków',
            ]);
            
            \Log::info('VALIDATION PASSED');
            
            $forbiddenLogins = ['admin', 'administrator', 'root'];
            foreach ($forbiddenLogins as $forbidden) {
                if (stripos($validated['login'], $forbidden) !== false) {
                    return back()->withErrors([
                        'login' => 'Login zawiera niedozwolone słowo'
                    ])->withInput();
                }
            }
            
            DB::beginTransaction();
            
            $user = User::create([
                'login' => $validated['login'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), // TUTAJ POPRAWIĆ - DODAĆ Hash::make
            ]);
            
            \Log::info('USER CREATED', ['id' => $user->id_user]);
            
            $readerRole = Role::where('name', 'Czytelnik')->first();
            
            if (!$readerRole) {
                throw new \Exception('Rola Czytelnik nie istnieje w bazie');
            }
            
            DB::table('user_role')->insert([
                'id_user' => $user->id_user,
                'id_role' => $readerRole->id_role,
                'assigned_at' => now(),
            ]);
            
            DB::commit();
            
            \Log::info('REGISTRATION SUCCESS', ['user_id' => $user->id_user]);
            
            Session::put('user_id', $user->id_user);
            Session::put('user_login', $user->login);
            Session::put('user_email', $user->email);
            Session::put('user_roles', ['Czytelnik']);
            
            return redirect()->route('home')
                             ->with('success', 'Rejestracja zakończona sukcesem!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('REGISTRATION ERROR: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withErrors([
                'error' => 'Błąd rejestracji: ' . $e->getMessage()
            ])->withInput();
        }
    }
    
    public function logout()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Nie jesteś zalogowany.');
        }
        
        $login = Session::get('user_login', 'Użytkowniku');
        
        Session::flush();
        
        return redirect()->route('home')
                         ->with('success', 'Wylogowano pomyślnie. Do zobaczenia ' . $login . '!');
    }
    
    public function profile()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Musisz się zalogować.');
        }
        
        $user = User::with(['roles', 'reviews', 'trackedBooks'])
                    ->find(Session::get('user_id'));
        
        if (!$user) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Sesja wygasła.');
        }
        
        return view('profile.show', [
            'user' => $user,
            'is_admin' => in_array('Admin', Session::get('user_roles', [])),
            'is_moderator' => in_array('Moderator', Session::get('user_roles', [])),
        ]);
    }
}