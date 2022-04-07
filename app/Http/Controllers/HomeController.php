<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Faker\Generator as Faker;

class HomeController extends Controller
{

    public function index(Faker $faker)
    {
        // DECLARE A NEW GUZZLE HTTP CLIENT TO MAKE API REQUESTS
        $client = new \GuzzleHttp\Client();
        // GET STUDENT
        $req = $client->get('http://localhost:9000/api/auca/student/' . auth()->user()->studentId);
        $response = json_decode($req->getBody());
        $student = $response[0];

        // GET STUDENT'S FACULTY
        $req = $client->get('http://localhost:9000/api/auca/student/faculty/' . auth()->user()->studentId);
        $response = json_decode($req->getBody());
        $faculty = $response[0];

        // GET STUDENT'S DEPARTMENT
        $req = $client->get('http://localhost:9000/api/auca/student/department/' . auth()->user()->studentId);
        $response = json_decode($req->getBody());
        $department = $response[0];

        // GET STUDENT'S REGISTRATION
        $req = $client->get('http://localhost:9000/api/auca/registration/' . auth()->user()->studentId);
        $response = json_decode($req->getBody());
        if (isset($response) && !empty($response)) {

            $registration = $response[0];
            $registrationYear = Carbon::parse($registration->created_at)->year;

            // GET STUDENT REGISTRATION'S COURSES
            $req = $client->get('http://localhost:9000/api/auca/registration/courses/' . auth()->user()->studentId);
            $response = json_decode($req->getBody());
            $courses = $response;
        } else {
            // STUDENT HAS NO REGISTRATION AND/OR COURSES
            $registration = [];
            $registrationYear = 0;
            $courses = [];
        }

        $group = $faker->randomElement(['A', 'E']);
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
        $paidFee = 0;

        //GET STUDENT PAYMENTS
        $stud = Student::where('studentId', auth()->user()->studentId)->first();
        $payments = $stud->payments()->orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('student', 'payments', 'faculty', 'department', 'registration', 'courses', 'group', 'creditCost', 'totalCredits', 'otherFees', 'tuitionFee', 'totalFee', 'paidFee', 'registrationYear'));
    }
}
