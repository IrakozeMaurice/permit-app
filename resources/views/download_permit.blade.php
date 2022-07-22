<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
  <style>
    .container {
      width: 400px;
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
    <div style="width:40%;margin: auto;">
          <h5 class="text-center">Adventist University of Central Africa</h5>
          <h5 class="text-center"><b><u>Exam Permit</u></b></h5>
          <p style="text-align: left;"><b>Student Id N<sup>o</sup>: {{$student->studentId}}</b></p>
          <p style="text-align: left;"><b>Student Name: {{$student->names}}</b></p>
          <table>
            <tr>
              <th>#</th>
              <th>Course Title(code)</th>
              <th>Answer Booklet No</th>
            </tr>
            <tr>
              <td>1</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>2</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>3</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>4</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>5</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>6</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>7</td>
              <td></td>
              <td></td>
            </tr>
          </table>
      </div>
  </div>
</body>

</html>
