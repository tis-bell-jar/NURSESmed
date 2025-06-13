<!DOCTYPE html>
<html>
<head>
  <title>All Bookings</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #0f172a 0%, #0e7490 80%, #10b981 100%);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      color: #e0f2fe;
      margin: 0;
    }
    .glass-panel {
      background: rgba(18, 24, 38, 0.95);
      border-radius: 2.5rem;
      box-shadow: 0 16px 48px 0 rgba(16,185,129,0.22), 0 1.5px 9px 0 #0891b2;
      padding: 2.7rem 2rem 2rem 2rem;
      margin-top: 3.2rem;
      margin-bottom: 2.8rem;
      width: 95vw;
      max-width: 1700px;
      position: relative;
      overflow: visible;
      border: 2px solid rgba(59,130,246,0.15);
    }
    .glass-panel:before {
      content: "";
      position: absolute; inset: 0;
      background: radial-gradient(circle at 75% 23%, rgba(59,130,246,0.16) 0, transparent 60%);
      pointer-events: none;
      z-index: 0;
    }
    .admin-title {
      font-size: 2.4rem;
      font-weight: 900;
      letter-spacing: -1.1px;
      background: linear-gradient(90deg, #60a5fa, #10b981 80%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      margin-bottom: 2.5rem;
      z-index: 2;
    }
    .back-link {
      position: absolute;
      left: 2.2rem; top: 1.6rem;
      color: #38bdf8;
      font-weight: 700;
      font-size: 1.06rem;
      opacity: 0.93;
      z-index: 2;
      display: flex; align-items: center; gap: 0.3rem;
      text-decoration: none;
      transition: color 0.16s;
      background: rgba(34,197,94,0.09);
      padding: 0.45rem 1.12rem;
      border-radius: 1.2rem;
      box-shadow: 0 1px 7px #0891b288;
    }
    .back-link:hover { color: #10b981; text-decoration: underline; }

    /* Table wrapper for horizontal scroll */
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
    }
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      color: #f3f4f6;
      font-size: 1.12rem;
      min-width: 820px;
      background: transparent;
    }
    th {
      color: #38bdf8;
      font-weight: 800;
      font-size: 1.16rem;
      background: rgba(59,130,246,0.09);
      border-bottom: 3px solid #38bdf866;
      text-shadow: 0 2px 7px #10b98125;
      padding: 1.16rem 0.65rem 1.16rem 0.65rem;
      border-radius: 0.7rem 0.7rem 0 0;
      letter-spacing: 0.01em;
      white-space: nowrap;
    }
    td {
      background: rgba(31,41,55,0.87);
      color: #e0f2fe;
      border-radius: 1.2rem;
      box-shadow: 0 4px 18px #10b9811c;
      padding: 1.15rem 0.85rem;
      font-size: 1.11rem;
      vertical-align: top;
      transition: background 0.15s, color 0.14s, box-shadow 0.15s;
      max-width: 380px;
      word-break: break-word;
    }
    tr {
      transition: box-shadow 0.15s, background 0.12s;
    }
    tr:hover td {
      background: rgba(16,185,129,0.18);
      box-shadow: 0 8px 22px #10b9812e;
      color: #bef264;
    }
    .no-data-row td {
      background: none !important;
      box-shadow: none !important;
      color: #94a3b8 !important;
    }
    /* Responsive adjustments */
    @media (max-width:1500px){
      .glass-panel { max-width: 100vw; }
      td, th { font-size:1.04rem; }
    }
    @media (max-width: 900px){
      .glass-panel {padding: 1.25rem 0.5rem;}
      .admin-title {font-size:1.45rem;}
      .back-link {left:0.6rem;top:0.7rem;font-size:0.99rem;}
      th, td {padding-left: 0.7rem; padding-right: 0.7rem;}
    }
  @media (max-width: 640px) {
  .glass-panel { padding: 0.5rem 0.05rem;}
  table, th, td { font-size: 0.91rem;}
  .admin-title {
    font-size: 1.13rem;
    margin-top: 2.3rem; /* <--- Add this line for spacing on mobile */
  }
}

    .action-btn {
      background: linear-gradient(90deg,#ef4444 40%,#f59e42 120%);
      color: #fff;
      border: none;
      border-radius: 1rem;
      font-weight: 700;
      padding: 0.57rem 1.35rem;
      box-shadow: 0 2px 8px #ef4444ab;
      cursor: pointer;
      transition: background 0.15s, transform 0.12s;
      margin: 0.2rem 0;
      outline: none;
    }
    .action-btn:hover, .action-btn:focus {
      background: linear-gradient(90deg,#f59e42 10%, #ef4444 90%);
      color: #fff8dc;
      transform: scale(1.045);
    }
    .meeting-link {
      color: #4ade80;
      font-weight: 600;
      text-decoration: underline wavy #60a5fa;
      letter-spacing: 0.03em;
      transition: color 0.13s, text-shadow 0.16s;
      text-shadow: 0 1px 7px #60a5fa33;
      word-break: break-all;
    }
    .meeting-link:hover {
      color: #38bdf8;
      text-shadow: 0 2px 11px #10b98155;
    }
    ::selection {
      background: #bef26477;
      color: #1e293b;
    }


  </style>
</head>
<body>
  <div class="glass-panel mx-auto relative">
    <a href="{{ route('dashboard') }}" class="back-link">
      <span class="material-icons" style="font-size:1.17em;vertical-align:middle;">arrow_back</span>
      Dashboard
    </a>
    <div class="admin-title">
      <span class="material-icons" style="color:#10b981;font-size:2.2rem;">manage_accounts</span>
      All Bookings
    </div>
    <div class="z-2 w-full table-responsive">
      <table>
        <thead>
          <tr>
            <th>Email</th>
            <th>Phone</th>
            <th>Topic</th>
            <th>Details</th>
            <th>Date</th>
            <th>Time</th>
            <th>Meeting Link</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
          <tr>
            <td>{{ $b->email }}</td>
            <td>{{ $b->phone }}</td>
            <td>{{ $b->topic }}</td>
            <td>{{ $b->details }}</td>
            <td class="text-blue-200 font-bold">{{ $b->date }}</td>
            <td class="text-blue-200 font-bold">{{ $b->time }}</td>
            <td>
              @if($b->meeting_link)
                <a href="{{ $b->meeting_link }}" class="meeting-link" target="_blank">Join</a>
              @else
                <span class="text-gray-400">No Link</span>
              @endif
            </td>
            <td>
              <form action="{{ route('booking.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Delete this booking?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn">
                  Delete
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr class="no-data-row">
            <td colspan="8" class="text-center py-16 text-2xl">No bookings yet.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
