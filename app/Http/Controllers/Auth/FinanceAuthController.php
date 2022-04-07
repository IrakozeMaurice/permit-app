<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceAuthController extends Controller
{


    public function showLoginForm()
    {
        if (Auth::guard('finance')->check()) {
            return redirect()->route('finance.dashboard');
        } else {
            return view('auth.financeLogin');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('finance')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = auth()->user();

            return redirect()->intended(url('/finance/dashboard'));
        } else {
            return redirect()->back()->withErrors(['financeLoginError' => 'Credentials doesn\'t match.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('finance')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
