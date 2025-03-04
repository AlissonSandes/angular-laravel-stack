<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * User registering
     */
    public function register(Request $request)
    {
        try {
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'cpf' => ['required', 'string', 'size:14', 'unique:users', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            ], [
                'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.',
                'password.regex' => 'A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula e um número.'
            ]);
    
            // Chama o service para criar o usuário
            $user = $this->userService->createUser($validated);
    
            return response()->json([
                'message' => 'Usuário registrado com sucesso',
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * User Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Auth user
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
