<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmation;
use App\Models\Charge;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
            'comment' => ['required'],
            'ref_number' => ['required'],
            'bank_slip' => ['required'],
        ]);
        // check duplicate reference number
        $ref_number = Payment::where('ref_number',request('ref_number'))->first();

        if ($ref_number) {
            return back()->with('error','reference number already used');
        }else{
            // get uploaded file
        if ($request->hasfile('bank_slip')) {
            $bank_slip_name = time() . '_' . $request->file('bank_slip')->getClientOriginalName();
            $bank_slip_path = $request->file('bank_slip')->move('files', $bank_slip_name);
        }
        // ADD TRANSACTION TO PAYMENTS TABLE
        $payment = Payment::create([
            'student_id' => Student::where('studentId', auth()->user()->studentId)->value('id'),
            'paymentDate' => Carbon::now()->format('Y-m-d'),
            'amount' => request('amount'),
            'comment' => request('comment'),
            'bank_slip' => $bank_slip_name,
            'ref_number' => request('ref_number'),
        ]);
        return back()->with(["success" => "Successfully uploaded bank slip."]);
        }
    }
}
