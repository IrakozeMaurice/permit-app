<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmation;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'bankName' => ['required'],
            'accountNumber' => ['required'],
            'amount' => ['required'],
            'comment' => ['required'],
        ]);
        $client = new \GuzzleHttp\Client();
        $req = $client->get('http://localhost:7000/api/onlineBankSystem/account/' . request('accountNumber'));
        $response = json_decode($req->getBody());
        if (isset($response) && !empty($response)) {
            $account = $response[0];
            if (request('amount') > $account->balance) {
                return back()->withErrors(["insufficientBalance" => "sorry you do not have enough balance to perform this transaction."]);
            } else {
                // PERFORM TRANSACTION
                $client = new \GuzzleHttp\Client();
                $req = $client->post('http://localhost:7000/api/onlineBankSystem/payment/transfer', [
                    'form_params' => [
                        'accountFrom' => request('accountNumber'),
                        'accountTo' => '040-0280275-75',
                        'amount' => request('amount'),
                        'comment' => request('comment'),
                    ]
                ]);
                $response = json_decode($req->getBody());
                $transaction = $response;
                // ADD TRANSACTION TO PAYMENTS TABLE
                Payment::create([
                    'student_id' => Student::where('studentId', auth()->user()->studentId)->value('id'),
                    'paymentDate' => Carbon::now()->format('Y-m-d'),
                    'amount' => request('amount')
                ]);

                // SEND CONFIRMATION EMAIL
                $details = [
                    'title' => 'Mail from auca online school fees payment',
                    'body' => 'Thank you for using our app! We have successfully processed
                                your payment of ' . $transaction->amount . 'Rwf to account number
                                ' . $transaction->account_to_number . ' of ' . $transaction->account_to_name
                ];

                \Mail::to(auth()->user()->email)->send(new PaymentConfirmation($details));

                return back()->with(["success" => "Transaction completed successfully.", "message" => "confirmation Email sent to " . auth()->user()->email . " check your email for more details on the transaction."]);
            }
        } else {
            return back()->withErrors(["invalidAccount" => "invalid account number.please verify your account number and try again."]);
        }
    }
}
