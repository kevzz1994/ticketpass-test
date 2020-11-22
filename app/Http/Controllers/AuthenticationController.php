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
     * The password validator
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
        // Validate incoming request:
        $data = $request->validate([
            'email' => 'email',
            'password' => 'required'
        ]);
        // Try to login:
        if (!Auth::attempt($data)) {
            return Redirect::route('auth.login')->with('error', 'Invalid username or password.');
        }
        // Validate the password:
        $strongPassword = $this->passwordValidator->validate($data['password']);
        // Redirect the user to the home view with alert:
        if (!$strongPassword) {
            return Redirect::route('home')->with('warning', 'Your current password is not safe enough. We encourage changing it.');
        }
        // Redirect to home:
        return Redirect::route('home');
    }

    public function register(Request $request)
    {
        // Validate data:
        $data = $request->validate([
            'email' => ['email', 'required', Rule::unique('users', 'email')],
            'name' => 'required',
            'password' => 'required'
        ]);
        // Validate the password and return error in the view:
        if (!$this->passwordValidator->validate($data['password'])) {
            return Inertia::render('auth/Register', [
                'errors' => ['password' => 'Password is not strong enough.']
            ]);
        }
        // Create the user:
        User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => \Hash::make($data['password'])
        ]);
        // Redirect the user to login:
        return Redirect::route('auth.login');
    }

    public function showRegister()
    {
        return Inertia::render('auth/Register');
    }

    public function logout()
    {
        // Log the user out:
        Auth::logout();
        // Redirect the user to login:
        return Redirect::route('auth.login');
    }
}
