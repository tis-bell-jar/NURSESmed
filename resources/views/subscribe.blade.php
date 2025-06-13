<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscribe – NCK Helper</title>
  <!-- Inter font & Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <style>
    html, body {
      min-height: 100vh;
      background: linear-gradient(135deg, #e0f2f1, #60a5fa 65%, #10b981 100%);
    }
    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.3rem 0.4rem;
      color: #132136;
    }
    .subscribe-card {
      background: rgba(255,255,255,0.98);
      border-radius: 2rem;
      box-shadow: 0 10px 40px 0 #10b98133, 0 2px 10px 0 #0ea5e955;
      max-width: 420px;
      width: 100%;
      padding: 2.8rem 2.2rem 2.4rem 2.2rem;
      position: relative;
      overflow: visible;
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 1;
    }
    .subscribe-card::before {
      content: "";
      position: absolute;
      top: -40px; left: -50px;
      width: 120px; height: 120px;
      background: radial-gradient(circle at 40% 70%, #38bdf8aa 0%, #fff0 85%);
      z-index: 0;
      border-radius: 50%;
      pointer-events: none;
      opacity: 0.33;
      filter: blur(0.5px);
    }
    .mpesa-badge {
      background: linear-gradient(90deg,#10b981 60%,#60a5fa 120%);
      color: #fff;
      font-weight: 800;
      font-size: 1.45rem;
      border-radius: 50%;
      box-shadow: 0 2px 14px #10b98155, 0 1px 4px #0ea5e955;
      width: 64px; height: 64px;
      display: flex;
      align-items: center; justify-content: center;
      margin: 0 auto 1.1rem auto;
      border: 2.5px solid #60a5fa33;
      letter-spacing: 0.03em;
      animation: badgePop 1.1s cubic-bezier(.5,1.9,.3,1.2) 1;
    }
    @keyframes badgePop {
      0% { transform: scale(0.65); opacity: 0.2;}
      75% { transform: scale(1.11);}
      90% { transform: scale(0.96);}
      100% { transform: scale(1);}
    }
    h2 {
      font-size: 1.75rem;
      font-weight: 800;
      text-align: center;
      color: #0f172a;
      margin-bottom: 1.23rem;
      position: relative;
      z-index: 2;
      background: linear-gradient(90deg, #60a5fa, #10b981 90%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: -1px;
    }
    .plan-group {
      background: #f8fafc;
      border-radius: 0.75rem;
      margin-bottom: 0.7rem;
      padding: 0.7rem 0.85rem;
      box-shadow: 0 1px 5px #60a5fa13;
      display: flex; flex-direction: column;
      gap: 0.45rem;
      width: 100%;
    }
    label {
      font-weight: 700;
      font-size: 0.97rem;
      color: #0891b2;
      margin-bottom: 0.2rem;
      margin-top: 0.4rem;
    }
    select, input[type="text"] {
      padding: 0.7rem 1rem;
      border-radius: 9px;
      border: 1.3px solid #bae6fd;
      font-size: 1.09rem;
      background: #e0f2fe;
      color: #155e75;
      transition: border-color 0.19s, box-shadow 0.19s;
      font-weight: 600;
      margin-top: 0.1rem;
    }
    select:focus, input[type="text"]:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 2px #60a5fa66;
      outline: none;
    }
    .input-with-icon {
      position: relative;
      width: 100%;
      display: flex; align-items: center;
    }
    .input-with-icon .material-icons {
      position: absolute;
      left: 13px; top: 53%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 1.4rem;
      pointer-events: none;
    }
    .input-with-icon input {
      padding-left: 2.6rem;
      width: 100%;
    }
    button {
      margin-top: 1.1rem;
      width: 100%;
      padding: 0.82rem 1.2rem;
      background: linear-gradient(90deg,#0ea5e9 40%,#10b981 120%);
      color: #fff;
      border: none;
      border-radius: 1rem;
      font-size: 1.09rem;
      font-weight: 700;
      box-shadow: 0 4px 18px #0ea5e988;
      cursor: pointer;
      transition: background 0.17s, box-shadow 0.16s, transform 0.14s;
      letter-spacing: 0.02em;
    }
    button:hover, button:focus {
      background: linear-gradient(90deg,#10b981 10%,#0ea5e9 100%);
      box-shadow: 0 8px 32px #10b98122;
      transform: translateY(-2px) scale(1.015);
    }
    button:active {
      transform: scale(0.98);
      box-shadow: 0 2px 7px #0ea5e966;
    }
    .note {
      font-size: 0.88rem;
      color: #0891b2;
      text-align: center;
      margin-top: 0.88rem;
      position: relative;
      z-index: 1;
      letter-spacing: 0.02em;
    }
    /* Responsive! */
    @media (max-width: 600px) {
      .subscribe-card {
        padding: 1.45rem 0.23rem 1.2rem 0.23rem;
        max-width: 98vw;
        border-radius: 1.1rem;
      }
      h2 { font-size: 1.24rem;}
      .mpesa-badge { width: 45px; height: 45px; font-size: 1.03rem;}
      select, input[type="text"], button { font-size: 0.95rem;}
    }
    @media (max-width: 375px) {
      .subscribe-card { padding: 0.79rem 0.01rem 0.9rem 0.01rem;}
      h2 { font-size: 0.99rem;}
    }
  </style>
</head>
<body>
  <div class="subscribe-card">
    <div class="mpesa-badge">M‑Pesa</div>
    <h2>Choose Your Subscription</h2>
    <form method="POST" action="/subscribe" autocomplete="off">
      @csrf
      <div class="plan-group">
        <label for="plan">Select a Plan</label>
        <select name="plan" id="plan" required>
          <option value="" disabled selected>— Choose Plan —</option>
          <option value="trial">Free Trial (7 Days)</option>
          <option value="month_1">1 Month – KES 100</option>
          <option value="month_2">2 Months – KES 180</option>
        </select>
      </div>
      <label for="phone">M‑Pesa Phone Number</label>
      <div class="input-with-icon">
        <span class="material-icons">phone_android</span>
        <input type="text" name="phone" id="phone" placeholder="e.g. 0700 123 456" required autocomplete="off">
      </div>
      <button type="submit">Activate Subscription</button>
      <p class="note">You’ll receive a prompt to confirm payment on your phone.</p>
    </form>
  </div>
</body>
</html>
