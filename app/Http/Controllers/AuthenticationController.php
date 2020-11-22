<?php

namespace App\Http\Controllers;

use App\Plugins\PasswordValidation\IPasswordValidator;
use App\Rules\Password;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AuthenticationController extends Controller
{

    /**
     * @var IPasswordValidator
     */
    private $passwordValidator;

    public function __construct(IPasswordValidator $passwordValidator)
    {
        $this->passwordValidator = $passwordValidator;
    }

    public function index()
    {
        return Inertia::render('auth/Login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($data)) {
            return Redirect::route('auth.login')->with('error', 'Invalid username or password.');
        }

        $strongPassword = $this->passwordValidator->validate($data['password']);
        if (!$strongPassword) {
            return Redirect::route('home')->with('warning', 'Your current password is not safe enough. We encourage changing it.');
        }
        return Redirect::route('home');

    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['email', 'required', Rule::unique('users', 'email')],
            'name' => 'required',
            'password' => 'required'
        ]);

        if (!$this->passwordValidator->validate($data['password'])) {
            return Inertia::render('auth/Register', [
                'errors' => ['password' => 'Password is not strong enough.']
            ]);
        }

        User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => \Hash::make($data['password'])
        ]);

        return Redirect::route('auth.login');
    }

    public function showRegister()
    {
        return Inertia::render('auth/Register');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('auth.login');
    }
}
