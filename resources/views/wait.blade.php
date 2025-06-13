<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirming Payment</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #0f172a 0%, #1e40af 85%, #10b981 100%);
      font-family: 'Inter', sans-serif;
      color: #f1f5f9;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      overflow-x: hidden;
    }
    .payment-container {
      background: rgba(15, 23, 42, 0.92);
      border-radius: 1.5rem;
      padding: 2.7rem 2.1rem 2.2rem 2.1rem;
      box-shadow: 0 8px 40px #10b98144, 0 2px 8px #0ea5e9bb;
      max-width: 350px;
      width: 96vw;
      text-align: center;
      position: relative;
    }
    .mpesa-icon {
      background: #10b981;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.3rem auto;
      box-shadow: 0 4px 28px #10b98144, 0 1px 5px #0ea5e9bb;
      font-size: 2.5rem;
      animation: bounceIn 1.3s cubic-bezier(.45,1.8,.35,1.1) 1;
    }
    @keyframes bounceIn {
      0% { transform: scale(0.5); opacity: 0; }
      65% { transform: scale(1.17); opacity: 1;}
      80% { transform: scale(0.95);}
      100% { transform: scale(1);}
    }
    .payment-title {
      font-size: 1.44rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
      letter-spacing: -1px;
      background: linear-gradient(90deg, #60a5fa, #10b981 80%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .payment-sub {
      color: #a5f3fc;
      font-size: 1.02rem;
      margin-bottom: 2.2rem;
      opacity: 0.94;
    }
    .spinner {
      margin: 1.4rem auto 0 auto;
      width: 48px;
      height: 48px;
      border: 6px solid #38bdf8;
      border-top-color: transparent;
      border-radius: 50%;
      animation: spin 1.1s linear infinite;
      box-shadow: 0 0 8px #0ea5e988;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .footer-msg {
      margin-top: 1.8rem;
      color: #7dd3fc;
      font-size: 0.98rem;
      opacity: 0.95;
    }
    /* Mobile adjustments */
    @media (max-width: 500px) {
      .payment-container {
        padding: 1.2rem 0.2rem 1.25rem 0.2rem;
        max-width: 99vw;
        border-radius: 1.1rem;
      }
      .payment-title { font-size: 1.04rem;}
      .mpesa-icon { width: 48px; height: 48px; font-size: 1.5rem; }
      .spinner { width: 34px; height: 34px; border-width: 5px;}
      .footer-msg { font-size: 0.90rem; }
    }
  </style>
</head>
<body>
  <div class="payment-container">
    <div class="mpesa-icon" aria-label="M-Pesa">
      <span style="font-weight:900; font-size:2.1rem; color:#fff;">Ksh</span>
    </div>
    <div class="payment-title">Confirming your M‑Pesa payment…</div>
    <div class="payment-sub">Please complete the payment on your phone. <br>
      You’ll be redirected once confirmed.</div>
    <div class="spinner" aria-label="Loading"></div>
    <div class="footer-msg">
      <span class="material-icons" style="font-size:1.1rem;vertical-align:middle;">lock</span>
      Secured by NURSESmed
    </div>
  </div>
  <script>
    setInterval(() => {
      fetch('/check-subscription')
        .then(res => res.json())
        .then(data => {
          if (data.subscribed) {
            window.location.href = "/dashboard";
          }
        });
    }, 5000); // check every 5 seconds
  </script>
</body>
</html>
