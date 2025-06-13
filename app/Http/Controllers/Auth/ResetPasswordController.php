<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token=null)
    {
        return view('auth.passwords.reset', ['token'=>$token,'email'=>$request->email]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'token'=>'required', 'email'=>'required|email',
            'password'=>'required|confirmed|min:8',
        ]);

        $status = Password::reset($data, function($user,$pass){
            $user->forceFill([
                'password'=>bcrypt($pass),
                'remember_token'=>Str::random(60),
            ])->save();
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email'=>[__($status)]]);
    }
}
