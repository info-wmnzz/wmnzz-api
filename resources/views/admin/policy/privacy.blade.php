<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms & Conditions</title>
  <link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
</head>
<body>
 <div class="header">
    <h2>Hello 👋</h2>
    <p>Before you create an account, please read and accept our Privacy Policy</p>

    <!-- Privacy Policy link -->
    
 </div>

  <div class="content">
    <h3>📄 Privacy Policy –  WMNZZ</h3>
    <small> Effective Date : {{$updatedAt ?? ''}}</small>
    <small> Last Updated on {{$updatedAt ?? ''}}</small>
    {!! $privacyContent ?? 'No Policy available at the moment.' !!}
  </div>
</body>
</html>
