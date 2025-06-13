<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
</head>
<body>
    <h2>Your Booking is Confirmed!</h2>
    <p>Hello,</p>
    <p>Your meeting has been scheduled.</p>
    <p><strong>Date:</strong> {{ $booking->date }}<br>
       <strong>Time:</strong> {{ $booking->time }}<br>
       <strong>Topic:</strong> {{ $booking->topic }}</p>
    <p>
        <strong>Meeting Link:</strong><br>
        <a href="{{ $booking->meeting_link }}" target="_blank">{{ $booking->meeting_link }}</a>
    </p>
    <p>Click the link at your scheduled time. No login or install needed.</p>
</body>
</html>
