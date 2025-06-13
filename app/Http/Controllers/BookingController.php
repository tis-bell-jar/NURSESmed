<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Import this for unique meeting links
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;



class BookingController extends Controller
{
    public function create()
    {
        $categories = [
            "Adult Nursing",
            "Communication & Counselling",
            "Contraception & Gynecology",
            "Critical Care & Theatre Nursing",
            "Intro to Reproductive Health",
            "Paediatric Nursing",
            "Pregnancy, Labour & Puerperal Care",
            "Professionalism & Trends in Nursing",
            "STIs & HIV",
            "Community Health & Disease Control",
            "Environmental & Communicable Diseases",
            "Home-Based Care",
            "Leadership, Management & Education Methodologies",
            "Mental Health",
            "Primary Healthcare",
            "Research in Nursing",
            "Sociology & Anthropology",
            "Special Health Issues",
            "Past Paper 1",
            "Past Paper 2",
            "Predictive Template A",
            "Predictive Template B"
        ];
        return view('booking.create', compact('categories'));
    }public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'phone' => 'required',
        'topic' => 'required|max:100',
        'details' => 'nullable|max:500',
        'date' => 'required|date|after:yesterday',
        'time' => 'required'
    ]);

    // Block 1:00pm–2:00pm
    if ($request->time === '13:00') {
        return back()->withErrors(['time' => 'Booking not allowed between 1pm and 2pm']);
    }

    // Generate a unique Jitsi Meet link
    $uniqueRoom = 'tutormeeting-' . Str::random(16);
    $meetingLink = "https://meet.jit.si/{$uniqueRoom}";

    // Save booking with meeting link
    $booking = Booking::create(array_merge(
        $request->all(),
        ['meeting_link' => $meetingLink]
    ));

    // ===== Send Email to User =====
    Mail::to($booking->email)->send(new BookingConfirmed($booking));

    // Redirect with a success message and show the meeting link
    return redirect()->route('booking.confirmation', $booking->id)
        ->with('success', 'Booking successful! Meeting link is ready.');
}


    // Confirmation page
    public function confirmation($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.confirmation', compact('booking'));
    }

    public function admin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized.');
        }

        $bookings = Booking::orderBy('date', 'desc')->get();
        return view('booking.admin', compact('bookings'));
    }

    public function destroy(Booking $booking)
{
    $booking->delete();
    return back()->with('success', 'Booking deleted.');
}

}
