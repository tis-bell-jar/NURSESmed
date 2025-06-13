<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .confirmation-box {
        max-width: 500px;
        margin: 2rem auto;
        background: #f8fafc;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.09);
        padding: 2rem;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .confirmation-box h3 {
        color: #166534;
        font-size: 1.7rem;
        margin-bottom: .5rem;
    }
    .confirmation-box p {
        font-size: 1.09rem;
        color: #23272b;
    }
    .confirmation-box .meeting-label {
        font-weight: bold;
        margin-top: 1.2rem;
        color: #2563eb;
    }
    .confirmation-box .meeting-link {
        display: inline-block;
        margin: .5rem 0 1.5rem 0;
        padding: .5rem 1rem;
        background: #2563eb;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.18s;
    }
    .confirmation-box .meeting-link:hover {
        background: #1e40af;
        text-decoration: underline;
    }
</style>

</head>
<body>
    <div class="confirmation-box">
    <h3>Booking Confirmed!</h3>
    <p>Your meeting is scheduled.</p>

    <div class="meeting-label">Meeting Link:</div>
    @if ($booking->meeting_link)
        <a class="meeting-link" href="{{ $booking->meeting_link }}" target="_blank" rel="noopener">
            Join Meeting
        </a>
        <div style="font-size: 0.93rem; color: #6b7280;">
            Or copy: <span style="user-select: all;">{{ $booking->meeting_link }}</span>
        </div>
    @else
        <span>No meeting link generated.</span>
    @endif

    <p style="margin-top: 2rem;">Click the link at your scheduled time. No login or install needed.</p>
</div>

</body>
</html>
