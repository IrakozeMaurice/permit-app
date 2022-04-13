<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Charge;
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
            $StudentNames = $response[0]->names;
            // STUDENT EXISTS IN SCHOOL SYSTEM
            $user = User::create([
                'studentId' => $request->studentId,
                'names' => $StudentNames,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $Student = Student::create([
                'studentId' => $request->studentId,
                'names' => $StudentNames,
                'email' => $request->email,
            ]);
            // CHECK IF STUDENT IS REGISTERED I.E HAS REGISTRATION FORM
            $req = $client->get('http://localhost:9000/api/auca/registration/' . $Student->studentId);
            $response = json_decode($req->getBody());
            if (isset($response) && !empty($response)) {

                // STUDENT IS REGISTERED I.E HAS REGISTRATION FORM
                $registration = $response[0];

                // CALCULATE STUDENT CHARGES
                // GET STUDENT REGISTRATION'S COURSES
                $req = $client->get('http://localhost:9000/api/auca/registration/courses/' . $Student->studentId);
                $response = json_decode($req->getBody());
                $courses = $response;
                $creditCost = 15875;
                $totalCredits = 0;
                foreach ($courses as $course) {
                    $totalCredits += $course->credits;
                }

                //otherFees
                if (empty($registration)) {
                    $graduationFee = 0;
                } else {
                    $graduationFee = $registration->semester > 7 ? 45000 : 0;
                }
                $otherFees = [
                    'registrationFee' => 20000,
                    'lateFineFee' => 0,
                    'facilityFee' => 0,
                    'researchManualFee' => 0,
                    'studentCardFee' => 0,
                    'graduationFee' => $graduationFee,
                    'libraryCardFee' => 2500,
                    'sanitationFee' => 10000,
                ];

                $tuitionFee = 0;
                foreach ($courses as $course) {
                    $tuitionFee += $course->credits * $creditCost;
                }
                $totalFee = $tuitionFee + $otherFees['registrationFee'] + $otherFees['lateFineFee'] + $otherFees['facilityFee'] + $otherFees['researchManualFee'] + $otherFees['studentCardFee'] + $otherFees['graduationFee'] + $otherFees['libraryCardFee'] + $otherFees['sanitationFee'];
                // SAVE STUDENT CHARGES
                Charge::create([
                    'student_id' => $Student->id,
                    'total_charges' => $totalFee,
                    'amount_paid' => 0,
                    'amount_due' => $totalFee
                ]);
            }
        } else {
            return back()->withErrors(["unregisteredStudent" => "You are not registered in the school system"]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
