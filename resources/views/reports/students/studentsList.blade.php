<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Students report pdf</title>
  <style>
    .container {
      width: 1000px;
      margin: auto;
    }

    .content {
      width: 800px;
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
      /* text-align: center; */
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
      <h3 class="title"><u>Students who have paid {{ session('percentage') }} % of school fees Report</u></h3>
      <table>
        <thead>
          <tr>
            <th>StudentId</th>
            <th>Student Names</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($charges as $charge)
            <tr>
              <td>{{ $charge->student->studentId }}</td>
              <td>{{ $charge->student->names }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</body>

</html>
