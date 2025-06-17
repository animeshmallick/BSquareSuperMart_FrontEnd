<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Coming Soon - BSquareSuperMart</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #fff9e6, #fff0b3, #ffe066); /* soft yellow-white gradient */
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
      background: rgba(255, 255, 255, 0.3);
      z-index: 0;
    }

    .coming-soon-container {
      position: relative;
      z-index: 2;
      max-width: 700px;
      padding: 50px;
      background: rgba(255, 255, 255, 0.6);
      border: 1px solid rgba(0, 0, 0, 0.05);
      border-radius: 20px;
      backdrop-filter: blur(10px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 1.5s ease-in-out;
    }

    .rocket {
      font-size: 3.5rem;
      animation: floatRocket 2s ease-in-out infinite;
    }

    h1 {
      font-size: 3rem;
      font-weight: 800;
      margin: 20px 0 10px;
      color: #333;
    }

    .typing {
      font-size: 1.3rem;
      font-weight: 500;
      border-right: 2px solid #333;
      white-space: nowrap;
      overflow: hidden;
      width: 0;
      animation: typing 4s steps(40, end) forwards, blink 0.8s infinite;
      color: #444;
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

    @keyframes floatRocket {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .btn-home {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 30px;
      font-size: 1rem;
      font-weight: 600;
      background: #ffcc00;
      color: #333;
      border: none;
      border-radius: 30px;
      text-decoration: none;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 4px 12px rgba(255, 204, 0, 0.4);
    }

    .btn-home:hover {
      background: #ffaa00;
      color: #fff;
      box-shadow: 0 6px 15px rgba(255, 170, 0, 0.6);
    }

    @media (max-width: 768px) {
      .coming-soon-container {
        padding: 30px 20px;
      }

      h1 {
        font-size: 2.2rem;
      }

      .typing {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="overlay"></div>

  <div class="coming-soon-container animate_animated animate_fadeInUp">
    <div class="rocket">🚀</div>
    <h1>Coming Soon</h1>
    <div class="typing">We're launching something amazing just for you...</div>
    <a href="../index.php" class="btn-home">← Back to Home</a>
  </div>

</body>
</html>
