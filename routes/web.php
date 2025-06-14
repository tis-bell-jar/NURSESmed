<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FileController;

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Subscription
Route::get('/subscribe', [SubscriptionController::class, 'show']);
Route::post('/subscribe', [SubscriptionController::class, 'process']);
Route::get('/subscribe/success', [SubscriptionController::class, 'success']);
Route::post('/mpesa/callback', [SubscriptionController::class, 'handleCallback']);

// Admin Panel
// ... other routes above ...

// Admin upload form (GET) if you actually have a separate upload page:
Route::get('/admin/upload', [AdminController::class, 'showUploadForm'])
     ->name('admin.upload.form');

// Admin upload POST:
Route::post('/admin/upload', [AdminController::class, 'upload'])
     ->name('admin.upload');

// Admin delete POST:
Route::post('/admin/delete', [AdminController::class, 'delete'])
     ->name('admin.delete');

// Admin analytics (optional)
Route::get('/admin/analytics', [AdminController::class, 'dashboard'])
     ->name('admin.analytics');

Route::get('/admin/files', [AdminController::class, 'listFiles'])->name('admin.files');
//Test yourself
// routes/web.php

use App\Http\Controllers\QuizController;

// … any other routes …

Route::middleware(['auth'])->group(function() {
    // Show the quiz form
    Route::get('/quiz', [QuizController::class, 'index'])
         ->name('quiz');

    // Handle quiz submission
    Route::post('/quiz', [QuizController::class, 'submit'])
         ->name('quiz.submit');
});






// Dashboard for Subscribed Users
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) return redirect('/login');
    if (!$user->is_subscribed) return redirect('/subscribe');

    $gatherFiles = function ($folder) {
        $categories = Storage::disk('public')->directories("nck/{$folder}");
        $filesPerCategory = [];
        foreach ($categories as $path) {
            $cat = basename($path);
            $files = collect(Storage::disk('public')->files($path))->map(function ($file) use ($cat, $folder) {
                return [
                    'name' => basename($file),
                    'link' => route('file.render', [
                        'paper' => $folder,
                        'category' => $cat,
                        'filename' => basename($file),
                    ])
                ];
            });
            $filesPerCategory[$cat] = $files;
        }
        return $filesPerCategory;
    };

    return view('dashboard', [
        'user' => $user,
        'paper1' => $gatherFiles('paper_1'),
        'paper2' => $gatherFiles('paper_2'),
        'pastpapers' => $gatherFiles('pastpapers'),
        'predictions' => $gatherFiles('predictions'),
    ]);
})->name('dashboard');

// Smart unified preview route (PDF + DOCX)
Route::get('/view/{paper}/{category}/{filename}', function ($paper, $category, $filename) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $controller = app(FileController::class);

    if ($ext === 'pdf') {
        return $controller->viewPDF($paper, $category, $filename);
    }

    if (in_array($ext, ['doc', 'docx'])) {
        return $controller->previewDocAsHtml($paper, $category, $filename);
    }

    abort(415, 'Unsupported file format');
})->name('file.render');

// File list and preview routes
Route::get('/files/{paper}/{category}', [FileController::class, 'showFileList']);
Route::get('/preview/{paper}/{category}/{filename}', [FileController::class, 'previewOffice']);

use App\Http\Controllers\ChatController;

Route::get('/chat/{room}/messages', [ChatController::class,'fetchMessages'])
     ->name('chat.fetch');
Route::post('/chat/{room}/message',  [ChatController::class,'sendMessage'])
     ->name('chat.send');
use App\Models\ChatMessage;

Route::get('/chat/{room}/messages', function($room) {
    return ChatMessage::with('user')
        ->where('room', $room)
        ->orderBy('id')
        ->get();
});

Route::delete('/chat/{room}/clear', [ChatController::class, 'clear']);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('password/reset',  [ForgotPasswordController::class, 'showLinkRequestForm'])
     ->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
     ->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
     ->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
     ->name('password.update');



use App\Http\Controllers\BookingController;

Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/booking/admin', [BookingController::class, 'admin'])->name('booking.admin');

Route::get('/booking/confirmation/{id}', [BookingController::class, 'confirmation'])
    ->name('booking.confirmation');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

use Illuminate\Support\Facades\Artisan;

Route::get('/run-migration', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "<pre>" . Artisan::output() . "</pre>";
    } catch (\Exception $e) {
        return '❌ Migration failed: ' . $e->getMessage();
    }
});




