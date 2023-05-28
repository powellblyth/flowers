<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'can_retain_data' => 'nullable|integer|min:0|max:1',
            'can_email' => 'nullable|integer|min:0|max:1',
            'can_sms' => 'nullable|integer|min:0|max:1',
            'can_post' => 'nullable|integer|min:0|max:1',
        ]);

        Auth::login(
            $user = User::create(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'can_retain_data' => $request->can_retain_data,
                    'can_email' => $request->can_email,
                    'can_sms' => $request->can_sms,
                    'can_post' => $request->can_post,
                ]
            )
        );

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
