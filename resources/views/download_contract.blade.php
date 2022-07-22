<!DOCTYPE html>
<html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title></title>
      <style>
        .container {
          width: 700px;
          margin: auto;
        }

        .content {
          width: 600px;
          margin: auto;
        }

        table,
        tr,
        th,
        td {
          border: 1px solid black;
          border-collapse: collapse;
          padding: 10px;
        }

        .text-center {
           text-align: center; 
        }

      </style>
    </head>

    <body>
      <div class="container">
        <h4 class="text-center">Contract of payment</h4>
                  <hr>
                  <div class="row">
                    <div class="col-md-6"><p>Student id: {{$student->studentId}}</p></div>
                    <div class="col-md-6">Student names: {{$student->names}}</div>
                  </div>
                  <table id="tableSearch" class="table table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th class="text-center">Amount Total to be paid</th>
                  <th class="text-center">Paymnet made</th>
                  <th class="text-center">Remain</th>
                  <th class="text-center">{{$date1}}</th>
                  <th class="text-center">{{$date2}}</th>
                  <th class="text-center">{{$date3}}</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td>{{ number_format($contract->total_to_be_paid, 0, null, ',') }}</td>
                    <td>{{ number_format($contract->payment_made, 0, null, ',') }}</td>
                    <td>{{ number_format($contract->remain, 0, null, ',') }}</td>
                    <td>{{ number_format($contract->installment_one, 0, null, ',') }}</td>
                    <td>{{ number_format($contract->installment_two, 0, null, ',') }}</td>
                    <td>{{ number_format($contract->installment_three, 0, null, ',') }}</td>
                  </tr>
              </tbody>
            </table>
            <div class="row">
            <p class="pl-3">That i <u>{{$student->names}}</u> hereby acknowledge that as of <u>{{$date}}</u> , I registered with the Adventist university of central africa</p>
            <p class="pl-3">with {{session('totalCredits')}} credits and i promise to pay the total amount of fees on installment payment at the date as specified above.</p>
            <p class="pl-3">That i accept and fully understand that tuition and fees paid upon registration is not refundable on whatever reason and that</p>
            <p class="pl-3"><b>5%</b> penalty per month on the amount due will be charged on delayed payment.</p>
            <br><br>
            </div>
      </div>
    </body>
</html>