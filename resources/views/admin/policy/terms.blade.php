<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms & Conditions</title>
  <link rel="stylesheet" href="{{ asset('css/terms.css') }}">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
</head>
<body>
 <div class="header">
    <!-- <span class="back-btn">←</span> -->

    <h2>Hello 👋</h2>
    <p>Before you create an account, please read and accept our Terms & Conditions</p>

    <!-- Privacy Policy link -->
    <a href="{{route('privacy')}}" class="privacy-link" target="_blank">Privacy Policy</a>
 </div>

  <div class="content">
    <h3>📜 Terms and Conditions – WMNZZ</h3>
    <small> Effective Date : {{ $updatedAt ?? '' }}</small>
    <small> Last Updated on {{ $updatedAt ?? '' }}</small>
     {!! $termsContent ?? 'No Terms & Conditions available at the moment.' !!}
  </div>
</body>
</html>
