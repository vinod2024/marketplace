<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    // Social redirect.
    public function socialiteRedirect($socialType='google'){
        return Socialite::driver($socialType)->redirect();
    }


    // Social Login.
    public function socialiteLogin($socialType='google'){
        try {
            $user = Socialite::driver($socialType)->user();
            // check user exist or not.
            $getUser = User::where('email', $user->email)->first();
            if(!$getUser){
                // Auth::login($user);
                $getUser = new User();
                $getUser->name = $user->name;
                $getUser->email = $user->email;
                // $getUser->picture = $user->avatar;
                $getUser->password = '12345678';
                $getUser->save();
            }

            session()->put('id', $getUser->id);
            session()->put('type', $getUser->type);
            return redirect('/');

        }
        catch(Exception $e) {
            dd($e->getMessage());
        }
        
    }

}
