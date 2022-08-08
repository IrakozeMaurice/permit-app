<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Models\Claim;
use App\Models\PermitRelease;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use PDF;

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

            // STUDENT IS REGISTERED I.E HAS REGISTRATION FORM
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
        $charge = $stud->charge;
        $contract = $stud->contract;
        if ($contract) {
            $date1 = Carbon::parse($contract->created_at)->addMonths(1)->format('d F Y');
            $date2 = Carbon::parse($contract->created_at)->addMonths(2)->format('d F Y');
            $date3 = Carbon::parse($contract->created_at)->addMonths(3)->format('d F Y');
            $date = Carbon::now()->format('d F Y');
        }else{
            $date1 = Carbon::now()->format('d F Y');
            $date2 = Carbon::now()->format('d F Y');
            $date3 = Carbon::now()->format('d F Y');
            $date = Carbon::now()->format('d F Y');
        }
        $payments = $stud->payments()->orderBy('created_at', 'desc')->get();
        $release_date = PermitRelease::where('key','key')->first()->release_date;
        $firstDate = Carbon::now()->format('Y-m-d');
        if (Carbon::parse($firstDate)->greaterThanOrEqualTo(Carbon::parse($release_date))) { 
            $permitReleased = true;
        } else {
            $permitReleased = false;
        }

        //check if student can claim late of contract
        $claim = $stud->claim;
        $canClaim = false;
        if (!$contract && !$claim && count($stud->payments) > 0)
            $canClaim = true;

        // dd($canClaim);
        session()->put('totalCredits',$totalCredits);
        return view('dashboard', compact('student', 'payments','charge','contract','date1','date2','date3','date', 'faculty', 'department', 'registration', 'courses', 'group', 'creditCost', 'totalCredits', 'otherFees', 'tuitionFee', 'totalFee', 'paidFee', 'registrationYear','permitReleased','canClaim'));
    }

    public function download_permit()
    {
        $student = Student::where('studentId',auth()->user()->studentId)->first();

        $pdf = PDF::loadView('download_permit', compact('student'))->setPaper('A5', 'portrait');

        return $pdf->download($student->studentId . '_exam_permit.pdf');
    }

    public function download_contract()
    {
        $student = Student::where('studentId',auth()->user()->studentId)->first();
        $contract = $student->contract;
        $date1 = Carbon::parse($contract->created_at)->addMonths(1)->format('d F Y');
        $date2 = Carbon::parse($contract->created_at)->addMonths(2)->format('d F Y');
        $date3 = Carbon::parse($contract->created_at)->addMonths(3)->format('d F Y');
        $date = Carbon::now()->format('d F Y');

        $pdf = PDF::loadView('download_contract', compact('student','contract','date1','date2','date3','date'))->setPaper('A4', 'portrait');

        return $pdf->download($student->studentId . '_contract_of_payment.pdf');
    }

    public function signContract()
    {
        $student = Student::where('studentId', auth()->user()->studentId)->first();
        $contract = $student->contract;
        $contract->signed = true;
        $contract->update();

        return back()->with('message','successfully signed contract');
    }

    public function claimContract()
    {
        $student = Student::where('studentId', auth()->user()->studentId)->first();
        $claim = Claim::where('student_id',$student->id)->first();
        if ($claim) {
            return back()->with('error','claim already submitted');
        }else{
            Claim::create([
                'student_id' => $student->id,
                'type' => 'late of contract'
            ]);
        return back()->with('message','claim sent successfully');
        }
    }
}
