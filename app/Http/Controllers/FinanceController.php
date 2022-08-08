<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Claim;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Contract;
use App\Models\PermitRelease;
use App\Models\PaymentExcel;
use App\Mail\PaymentConfirmation;
use App\Exports\PaymentExport;
use Carbon\Carbon;
use PDF;

class FinanceController extends Controller
{
    public function index()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        // GET ALL REGISTERED STUDENTS
        $charges = Charge::all();
        $claims = Claim::all();
        $expectedPayments = Charge::sum('total_charges');
        $completedPayments = Charge::sum('amount_paid');
        if ($expectedPayments > 0) {
            $completedPaymentsPercentage = round($completedPayments * 100 / $expectedPayments, 2);
        } else {
            $completedPaymentsPercentage = 0;
        }
        return view('financeDashboard', compact('charges','claims', 'completedPaymentsPercentage', 'expectedPayments', 'time'));
    }

    public function approvePayment(Payment $payment)
    {
        $payment->accepted = true;
        $payment->update();
        $student = $payment->student;
        $charge = $student->charge;
        // UPDATE STUDENT CHARGES
        $charge->amount_paid += $payment->amount;
        $charge->update();
        $charge->amount_due = $charge->total_charges - $charge->amount_paid;
        $charge->update();
        $charge->percentage = $charge->amount_paid * 100 / $charge->total_charges;
        $charge->update();

        // GENERATE STUDENT CONTRACT
        $contract = Contract::where('student_id',$student->id)->first();
        if (!$contract && $payment->amount < $student->charge->total_charges && $student->charge->percentage < 100) {
            $contract = Contract::create([
                'student_id' => $student->id,
                'total_to_be_paid' => $student->charge->total_charges,
                'payment_made' => $payment->amount,
                'remain' => $student->charge->total_charges - $payment->amount,
                'installment_one' => ($student->charge->total_charges - $payment->amount) / 3,
                'installment_two' => ($student->charge->total_charges - $payment->amount) / 3,
                'installment_three' => ($student->charge->total_charges - $payment->amount) / 3
            ]);
        }

        // INSERT INTO PAYMENT EXCEL
        PaymentExcel::create([
            'Date' => Carbon::now()->format('y-m-d'),
            'Ref' => $payment->ref_number,
            'Acc' => '102420',
            'Names' => $payment->student->names . '#' . $payment->student->studentId,
            'Amount' => $payment->amount,
            'Deb_Cr' => 'D',
        ]);
        PaymentExcel::create([
            'Date' => Carbon::now()->format('y-m-d'),
            'Ref' => $payment->ref_number,
            'Acc' => '368AGEUA01',
            'Names' => $payment->student->names . '#' . $payment->student->studentId,
            'Amount' => $payment->amount,
            'Deb_Cr' => 'C',
        ]);

        $claim = $payment->student->claim;
        if ($claim) {
            $claim->addressed = true;
            $claim->update();
        }
        // SEND CONFIRMATION EMAIL
        $details = [
            'title' => 'Mail from Auca student account control and follow-up system',
            'body' => 'Your payment of ' . $payment->amount . ' rwf has been successfully accepted.Thank you for using our app!'];

        \Mail::to($payment->student->email)->send(new PaymentConfirmation($details));

        return back()->with('message','successfully accepted payment');
    }

    public function declinePayment(Payment $payment)
    {
        $payment->declined = true;
        $payment->update();

        $claim = $payment->student->claim;
        if ($claim) {
            $claim->addressed = true;
            $claim->update();
        }

        
        // SEND CONFIRMATION EMAIL
        $details = [
            'title' => 'Mail from Auca student account control and follow-up system',
            'body' => 'Your payment bank slip has been declined.PLEASE CHECK IF YOU HAVE NOT PREVIOUSLY SUBMITTED THE SAME BANK SLIP AND MAKE SURE YOU SUBMIT A CLEAR PHOTO OF YOUR BANK SLIP.Thank you for using our app!'];

        \Mail::to($payment->student->email)->send(new PaymentConfirmation($details));

        return back()->with('message','successfully declined payment');
    }

    public function showStudents()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        $charges = Charge::all();
        return view('financeStudents', compact('time', 'charges'));
    }

    public function showPayments()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        $payments = Payment::all();
        return view('financePayments', compact('time', 'payments'));
    }

    public function showStudentInfo(Student $student)
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        return view('financeStudentInfo', compact('time', 'student'));
    }

    public function showPaymentsReport()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        $payments = PaymentExcel::all();
        return view('reports.payments.index', compact('time', 'payments'));
    }

    public function payments_report_pdf()
    {
        $payments = PaymentExcel::all();

        $pdf = PDF::loadView('reports.payments.paymentsList', compact('payments'))->setPaper('A4', 'portrait');

        return $pdf->download('paymentsReport.pdf');
    }

    public function payments_report_excel()
    {
        return \Excel::download(new PaymentExport, 'payments.xlsx');
    }

    public function showPermitRelease()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        return view('finance-permit-release',compact('time'));
    }

    public function releasePermit()
    {
        request()->validate(
            ['release-date' => 'required']
        );
        $release_date = PermitRelease::where('key','key')->first();
        $release_date->release_date = request('release-date');
        $release_date->update();

        return back()->with('message', 'successfully updated permit release date');
    }

    public function showClaims()
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        $claims = Claim::where('addressed',false)->get();
        return view('financeClaims',compact('time','claims'));
    }

    public function showStudentClaims(Student $student)
    {
        $time = Carbon::now()->format('d-m-y H:i:m');
        $payments = Payment::where('student_id',$student->id)
                            ->where('accepted',false)
                            ->where('declined',false)
                            ->first();

        return view('financeStudentClaims',compact('time','payments'));
    }
}
