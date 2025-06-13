<!DOCTYPE html>
<html>
<head>
  <title>Book a Tutor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <style>
    html, body {
      min-height: 100vh;
      height: 100%;
    }
    body {
      background: linear-gradient(135deg, #0f172a 0%, #10b981 100%);
      font-family: 'Inter', sans-serif;
      color: #f1f5f9;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .glass-card {
      background: rgba(17,23,39,0.96);
      color: #f1f5f9;
      box-shadow: 0 8px 32px rgba(16,185,129,0.22);
      border-radius: 1.3rem;
      padding: 2.7rem 2.2rem 2.2rem 2.2rem;
      backdrop-filter: blur(8px);
      position: relative;
      overflow: hidden;
      max-width: 430px;
      width: 100%;
      margin: 2rem auto;
    }
    .glass-card:before {
      content: "";
      position: absolute; inset: 0;
      background: radial-gradient(circle at 45% 20%, rgba(59,130,246,0.11) 0, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }
    .booking-title {
      font-size: 2.1rem;
      font-weight: 800;
      margin-bottom: 2.3rem;
      background: linear-gradient(90deg, #60a5fa, #10b981 65%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      display: flex;
      align-items: center;
      gap: 0.65rem;
      z-index: 2;
      letter-spacing: -0.5px;
    }
    .back-link {
      position: absolute;
      left: 2.1rem; top: 1.1rem;
      color: #3b82f6;
      font-weight: 600;
      display: flex; align-items: center; gap: 0.35rem;
      opacity: 0.91;
      font-size: 1.09rem;
      z-index: 2;
      text-decoration: none;
      transition: color 0.13s;
    }
    .back-link:hover { color: #10b981; text-decoration: underline; }

    /* Unified input/select/textarea */
    .glass-card input,
    .glass-card select,
    .glass-card textarea {
      background: rgba(31,41,55,0.88);
      color: #f1f5f9;
      border: 1.6px solid #374151;
      font-weight: 500;
      border-radius: 0.6rem;
      outline: none;
      transition: border 0.2s, box-shadow 0.2s, background 0.2s;
      font-size: 1.04rem;
      margin-bottom: 0.95rem;
      margin-top: 0.05rem;
      /* Consistent spacing for stacked inputs */
    }
    .glass-card input:focus,
    .glass-card select:focus,
    .glass-card textarea:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 2px #3b82f6;
      background: rgba(16,24,39,0.97);
    }
    .glass-card select,
    .glass-card select option {
      background: rgba(31,41,55,0.94);
      color: #f1f5f9;
    }
    .glass-card option[disabled] {
      color: #a7a7b7 !important;
      background: rgba(17,23,39,0.92) !important;
    }
    .glass-card button {
      background: linear-gradient(90deg,#3b82f6 0,#10b981 100%);
      color: #fff;
      font-weight: 700;
      border-radius: 0.7rem;
      box-shadow: 0 2px 10px rgba(16,185,129,0.13);
      transition: background 0.22s, box-shadow 0.18s, transform 0.13s;
      letter-spacing: 0.02em;
      font-size: 1.06rem;
    }
    .glass-card button:hover {
      background: linear-gradient(90deg,#10b981 0,#3b82f6 100%);
      box-shadow: 0 4px 20px rgba(59,130,246,0.16);
      transform: translateY(-2px) scale(1.03);
    }
    label { font-weight: 600; }
    .booking-title .material-icons { color: #10b981; font-size: 2.2rem; }

    /* Responsive fixes */
    @media (max-width: 600px) {
      html, body { padding: 0; }
      .glass-card {
        padding: 1.1rem 0.19rem 1.2rem 0.19rem;
        border-radius: 0.9rem;
        max-width: 98vw;
        width: 99vw;
        min-width: 0;
      }

      @media (max-width: 600px) {
  .booking-title {
    margin-top: 2rem;
  }
}

@media (max-width: 600px) {
  input[type="date"] {
    font-size: 0.99rem;
    padding: 0.62rem 0.9rem;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
     width: 100%;
  border-radius: 0.6rem;
  }


      .booking-title { font-size: 1.22rem; margin-bottom: 1.08rem; gap: 0.4rem;}
      .back-link { left: 0.44rem; top: 0.59rem; font-size: 0.97rem;}
      .glass-card input, .glass-card select, .glass-card textarea {
        font-size: 0.99rem;
        padding: 0.69rem 0.9rem;
        margin-bottom: 0.75rem;
      }
      .glass-card button { font-size: 0.99rem; padding: 0.65rem 0; }
      .glass-card form { margin-top: 0.9rem;}
    }
    @media (max-width: 400px) {
      .glass-card {
        padding: 0.29rem 0.06rem 0.7rem 0.06rem;
        border-radius: 0.7rem;
      }
      .booking-title { font-size: 1.03rem;}
      .back-link { font-size: 0.81rem;}
    }


  </style>
</head>
<body>
  <div class="glass-card mx-auto">
    <!-- Back to dashboard link -->
    <a href="{{ route('dashboard') }}" class="back-link">
      <span class="material-icons" style="font-size:1.22em;vertical-align:middle;">arrow_back</span> Dashboard
    </a>
    <div class="booking-title">
      <span class="material-icons">event_available</span>
      Book a Tutor
    </div>
    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 mb-4 rounded shadow">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <ul class="mb-4 text-red-400 font-bold">
        @foreach($errors->all() as $error)
          <li>- {{ $error }}</li>
        @endforeach
      </ul>
    @endif
    <form action="{{ route('booking.store') }}" method="POST" class="space-y-6 relative z-2">
      @csrf
      <input type="email" name="email" placeholder="Your Email" required class="w-full px-4 py-3" value="{{ old('email') }}">
      <input type="text" name="phone" placeholder="Your Phone Number" required class="w-full px-4 py-3" value="{{ old('phone') }}">

      <select name="topic" required class="w-full px-4 py-3">
        <option value="" disabled @if(!old('topic')) selected @endif>Choose Topic/Category</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" @if(old('topic') == $cat) selected @endif>{{ $cat }}</option>
        @endforeach
      </select>

      <textarea name="details" placeholder="What do you need help with? (Describe specifics or questions)" rows="3" required class="w-full px-4 py-3">{{ old('details') }}</textarea>

      <div>
        <label class="block mb-1 text-sm font-bold text-blue-200">Pick a date:</label>
        <input type="date" name="date" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-3" value="{{ old('date') }}">
      </div>
      <div>
        <label class="block mb-1 text-sm font-bold text-blue-200">Select time:</label>
        <select name="time" required class="w-full px-4 py-3">
          <option value="" disabled @if(!old('time')) selected @endif>Choose time</option>
          <option value="09:00" @if(old('time') == '09:00') selected @endif>9:00am</option>
          <option value="09:30" @if(old('time') == '09:30') selected @endif>9:30am</option>
          <option value="10:00" @if(old('time') == '10:00') selected @endif>10:00am</option>
          <option value="10:30" @if(old('time') == '10:30') selected @endif>10:30am</option>
          <option value="11:00" @if(old('time') == '11:00') selected @endif>11:00am</option>
          <option value="11:30" @if(old('time') == '11:30') selected @endif>11:30am</option>
          <option value="12:00" @if(old('time') == '12:00') selected @endif>12:00pm</option>
          <!-- No 13:00 -->
          <option value="14:00" @if(old('time') == '14:00') selected @endif>2:00pm</option>
          <option value="14:30" @if(old('time') == '14:30') selected @endif>2:30pm</option>
          <option value="15:00" @if(old('time') == '15:00') selected @endif>3:00pm</option>
          <option value="15:30" @if(old('time') == '15:30') selected @endif>3:30pm</option>
          <option value="16:00" @if(old('time') == '16:00') selected @endif>4:00pm</option>
          <option value="16:30" @if(old('time') == '16:30') selected @endif>4:30pm</option>
          <option value="17:00" @if(old('time') == '17:00') selected @endif>5:00pm</option>
        </select>
      </div>
      <button type="submit" class="w-full py-3 mt-2">Book Tutor</button>
    </form>
  </div>
</body>
</html>
