<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'studentId' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $client = new \GuzzleHttp\Client();
        $req = $client->get('http://localhost:9000/api/auca/student/' . request('studentId'));
        $response = json_decode($req->getBody());
        if (isset($response) && !empty($response)) {
            $user = User::create([
                'studentId' => $request->studentId,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Student::create([
                'studentId' => $request->studentId,
                'email' => $request->email,
            ]);
        } else {
            return back()->withErrors(["unregisteredStudent" => "Your student id is not registered in the school system"]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
