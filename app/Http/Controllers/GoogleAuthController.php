<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\WebUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginEmail;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(Request $request){
        try{
            $google_user = Socialite::driver('google')->user();

            $user = WebUsers::where('googleid', $google_user->getId())->first();

            if (!$user) {
                $new_user = WebUsers::create([
                    'name'=> $google_user->getName(),
                    'email'=> $google_user->getEmail(),
                    'googleid'=> $google_user->getId(),
                ]);
                $recipient = $google_user->getEmail();
                Mail::to($recipient)->send(new LoginEmail());
                Auth::guard('webuser')->login($new_user);
            } else {
                Auth::guard('webuser')->login($user);
            }
            return redirect()->intended('/');
        }
        catch(\Throwable $th){
            return redirect()->route('frontend.login');
        }
    }
}
