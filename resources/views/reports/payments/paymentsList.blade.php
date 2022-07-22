<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    .container {
      width: 950px;
      margin: auto;
    }

    .content {
      width: 90%;
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

    .title {
       /*text-align: center; */
    }

  </style>
</head>

<body>
  <div class="container">
    <div>
      <img src="{{ public_path('images/aucaLogo.png') }}" alt="Auca logo">
    </div>
    <hr>
    <div class="content">
      <h3 class="title" style="padding-left: 10px;"><u>Payments Report</u></h3>
      <table>
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Ref</th>
                  <th>Acc</th>
                  <th>Names</th>
                  <th>Amount</th>
                  <th>Deb-Cr</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($payments as $payment)
                  <tr>
                    <td>{{ $payment->Date }}</td>
                    <td>{{ $payment->Ref }}</td>
                    <td>{{ $payment->Acc }}</td>
                    <td>{{ $payment->Names }}</td>
                    <td>{{ $payment->Amount }}</td>
                    <td>{{ $payment->Deb_Cr }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
    </div>
  </div>
</body>

</html>
