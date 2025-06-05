<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function login() {

        return view('auth/login');
    }

    public function loginPost(LoginRequest $request) :  RedirectResponse {

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('home.index', absolute: false));
    }

    public function logout(Request $request) : RedirectResponse {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    public function edit() {

        $user = Auth::user();
        return view('auth/profile', ['user' => $user]);
        // return view('auth/profile', compact($user));
    }

    public function update(Request $request) {

        // dd($request->all());

        Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'document' => 'required',
        ], [
            'first_name.required' => 'Los nombres son requeridos.',
            'last_name.required' => 'Los apellidos son requeridos.',
            'document.required' => 'El documento es requerido.',
        ])->validate();

        try {

            $user = Auth::user();

            $user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'document' => $request->document
            ]);

            Session::flash('message', ['content' => 'Información actualizada con éxito', 'type' => 'success']);

            return redirect()->route('home.index');

        } catch(Exception $ex) {

            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }

    }

    public function changePassword() {

        return view('auth/changePassword');
    }

    public function updatePassword(Request $request) {

        Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es requerida.',
            'new_password.required' => 'La nueva contraseña es requerida.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ])->validate();

        try {

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {

                Session::flash('message', ['content' => 'La contraseña actual es incorrecta', 'type' => 'error']);
                return redirect()->back();
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            Session::flash('message', ['content' => 'Contraseña actualizada con éxito', 'type' => 'success']);

            return redirect()->route('home.index');

        } catch(Exception $ex) {

            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    public function forgotPassword() {

        return view('auth/forgotPassword');
    }

    public function recoveryPassword(Request $request) {

        Validator::make($request->all(), [
            'email' => 'required|email'
        ], [
            'email.required' => 'El email es requerido.',
            'email.email' => 'Debe digitar un email válido',
        ])->validate();

        try {

            $status = Password::sendResetLink($request->only('email'));

            if ($status == Password::RESET_LINK_SENT) {

                Session::flash('message', ['content' => 'Se ha enviado un link de recuperación a su email', 'type' => 'success']);
                return redirect()->route('login');
            }

            if ($status == Password::RESET_THROTTLED) {

                Session::flash('message', ['content' => 'Intente nuevamente en unos minutosd', 'type' => 'error']);
                return redirect()->back();
            }

            Session::flash('message', ['content' => $status, 'type' => 'error']);
            return redirect()->back();

        } catch(Exception $ex) {
            dd($ex);
            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    public function resetPassword(Request $request, $token) {

        return view('auth/resetPassword', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPasswordPost(Request $request) {

        Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ], [
            'token.required' => 'El token es requerido.',
            'email.required' => 'El email es requerido.',
            'email.email' => 'Debe digitar un email válido',
            'password.required' => 'La nueva contraseña es requerida.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ])->validate();

        try {

            $status = Password::reset(

                $request->only('email', 'password', 'password_confirmation', 'token'),

                function($user, $password) {

                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60)
                    ])->save();
                }
            );

            if ($status == Password::PASSWORD_RESET) {

                Session::flash('message', ['content' => 'Contraseña restablecida con éxito.', 'type' => 'success']);
                return redirect()->route('login');
            }

            Session::flash('message', ['content' => $status, 'type' => 'error']);
            return redirect()->back();

        } catch(Exception $ex) {
            dd($ex);
            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }


}
