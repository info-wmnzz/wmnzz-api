<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wmnzz</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;600&display=swap" rel="stylesheet">
  

</head>
<body>
  <div class="logo">
    <img src="{{ asset('landing-page-image/WoomenSquareFlat.png') }}" alt="Logo" />
    
  </div>
  <div class="container">
      <p class="tagline">Wmnzz</p>
      <h1 class="main-heading">COMING SOON</h1>
     
    <div class="social-icons">
      <a href="https://www.linkedin.com/company/wmnzz/" target="_blank" rel="noopener noreferrer"><img src="{{ asset('landing-page-image/linkedin_3536505.png') }}" alt="LinkedIn"></a>
      <a href="https://www.instagram.com/wmnzz.in?igsh=eXRpNXdkd2s1dW15" target="_blank" rel="noopener noreferrer"><img src="{{ asset('landing-page-image/instagram_733558.png') }}" alt="Instagram"></a>
      <a href="https://www.facebook.com/share/1AXyVgs3An/"target="_blank" rel="noopener noreferrer"><img src="{{ asset('landing-page-image/facebook_5968764.png') }}" alt="Facebook"></a>
      <a href="https://youtube.com/@wmnzz?si=uuGuhmM-tQwVaUJD"target="_blank" rel="noopener noreferrer"><img src="{{ asset('landing-page-image/1701508739youtube-png.png') }}" alt="youtube"></a>
      <a href="https://linktr.ee/info.wmnzz"target="_blank" rel="noopener noreferrer"><img src="{{ asset('landing-page-image/spotify-logo-png-7057.png') }}" alt="Spotify"></a>
    </div>
    <div id="custom-cursor"></div>
  
    <div id="stroke-container"></div> 
    <script>
      const cursor = document.getElementById('custom-cursor');
      const hoverTargets = document.querySelectorAll('.tagline, .main-heading, .social-icons a, .logo img');
    
      document.addEventListener('mousemove', (e) => {
        const x = e.clientX;
        const y = e.clientY;
    
        cursor.style.left = `${x}px`;
        cursor.style.top = `${y}px`;
    
        let hovering = false;
        hoverTargets.forEach((el) => {
          const rect = el.getBoundingClientRect();
          if (
            x >= rect.left &&
            x <= rect.right &&
            y >= rect.top &&
            y <= rect.bottom
          ) {
            hovering = true;
          }
        });
    
        document.body.classList.toggle('hovering-text', hovering);
      });
    
      document.addEventListener('mouseleave', () => {
        cursor.style.left = `-150px`;
        cursor.style.top = `-150px`;
        document.body.classList.remove('hovering-text');
      });
    </script>
    
    
  </div>
</body>
</html>
