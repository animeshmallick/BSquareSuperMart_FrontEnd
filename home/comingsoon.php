<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coming Soon - BSquare Super Mart</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #fffbe6, #fff2cc, #ffe066);
      font-family: 'Inter', sans-serif;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      overflow: hidden;
    }

    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.2);
      z-index: 0;
    }

    .coming-soon-container {
      position: relative;
      z-index: 2;
      max-width: 700px;
      padding: 50px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      backdrop-filter: blur(12px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
      animation: fadeInMain 1.5s ease-in-out;
    }

    .brand-title {
      font-family: 'Poppins', sans-serif;
      font-size: 2.8rem;
      font-weight: 700;
      color: #e69500;
      margin-bottom: 10px;
      letter-spacing: 0.5px;
      opacity: 0;
      animation: slideDown 1s ease-out forwards;
    }

    h1 {
      font-size: 2.2rem;
      font-weight: 700;
      margin: 10px 0 20px;
      color: #222;
      opacity: 0;
      animation: fadeIn 1s 0.6s ease-in-out forwards;
    }

    .typing {
      font-size: 1.3rem;
      font-weight: 500;
      border-right: 2px solid #333;
      white-space: nowrap;
      overflow: hidden;
      width: 0;
      color: #444;
      animation: typing 3.5s steps(40, end) forwards, blink 0.8s infinite;
    }

    .rhyme-line {
      margin-top: 30px;
      font-size: 1.15rem;
      font-style: italic;
      color: #555;
      opacity: 0;
      animation: fadeUp 1.2s 3.8s ease-in-out forwards;
    }

    .countdown {
      display: flex;
      justify-content: center;
      gap: 25px;
      margin-top: 35px;
      font-family: 'Poppins', sans-serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: #444;
      opacity: 0;
      animation: fadeUp 1.2s 4.5s ease-in-out forwards;
    }

    .countdown div {
      background: #fff3c4;
      padding: 10px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      min-width: 70px;
    }

    .countdown span {
      display: block;
      font-size: 0.75rem;
      font-weight: 500;
      margin-top: 5px;
      color: #777;
    }

    /* Animations */
    @keyframes fadeInMain {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes typing {
      to {
        width: 100%;
      }
    }

    @keyframes blink {
      50% {
        border-color: transparent;
      }
    }

    @media (max-width: 768px) {
      .coming-soon-container {
        padding: 30px 20px;
      }

      .brand-title {
        font-size: 2rem;
      }

      h1 {
        font-size: 1.8rem;
      }

      .typing {
        font-size: 1rem;
      }

      .rhyme-line {
        font-size: 1rem;
      }

      .countdown {
        flex-wrap: wrap;
        gap: 15px;
      }
    }
  </style>
</head>
<body>

  <div class="overlay"></div>

  <div class="coming-soon-container">
    <div class="brand-title">BSquare Super Mart</div>
    <h1>Coming Soon</h1>
    <div class="typing">Your new shopping destination is on the way...</div>
    <div class="rhyme-line">🛒 Big deals, bright carts — shopping with heart.</div>

    <div class="countdown" id="countdown">
      <div><span id="days">--</span>Days</div>
      <div><span id="hours">--</span>Hours</div>
      <div><span id="minutes">--</span>Minutes</div>
      <div><span id="seconds">--</span>Seconds</div>
    </div>
  </div>

  <script>
    const countdown = () => {
      const launchDate = new Date("August 15, 2025 00:00:00").getTime();
      const now = new Date().getTime();
      const diff = launchDate - now;

      if (diff < 0) return;

      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);

      document.getElementById("days").innerText = days;
      document.getElementById("hours").innerText = hours;
      document.getElementById("minutes").innerText = minutes;
      document.getElementById("seconds").innerText = seconds;
    };

    countdown(); // Run once on page load
    setInterval(countdown, 1000); // Update every second
  </script>

</body>
</html>
