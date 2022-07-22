<!DOCTYPE html>
<html>

<head>
</head>

<body>
  <h1>{{ $details['title'] }}</h1>
  <p>{{ $details['body'] }}</p>
  <p>Thank you</p>
  <button
    style="background: lightseagreen;font-size:20px;border:1px solid grey;height: 30px; width: fit-content;text-align: center;">
    <a href="{{ route('homepage') }}" style="text-decoration: none;color:white;">Go back to app</a>
  </button>
  <br><br><br>
</body>

</html>
