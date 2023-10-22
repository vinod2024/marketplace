<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use DB;

class SocialiteController extends Controller
{
    // Social Login.
    public function socialiteLogin(Request $request){

        // $social_type = $request->social_type;
        /* $user = Socialite::driver('github')->userFromToken($request->token);
        dd($user); */
        try {
            $user = Socialite::driver('github')->userFromToken($request->token);
            // dd($user);
            // check user exist or not.
            $getUser = User::where('email', $user->email)->first();
            if(!$getUser){
                // Auth::login($user);
                /* $getUser = new User();
                $getUser->name = $user->name;
                $getUser->email = $user->email;
                // $getUser->picture = $user->avatar;
                $getUser->password = '12345678';
                $getUser->save(); */
                // return $user->id;
                $getUser = new User();
                $getUser->facebook_id = $user->id;
                $getUser->name = $user->name;
                $getUser->email = $user->email;
                $getUser->password = '12345678';
                $getUser->save();
                
            }else{
                $saveUser = User::where('email', $user->email)->update([
                    'facebook_id' => $user->id,
                ]);

                $getUser = User::where('email', $user->email)->first();
            }
            // print_r($getUser);exit;
            // dd($getUser);
            /* session()->put('id', $getUser->id);
            session()->put('type', $getUser->type);
            return redirect('/'); */

            $user = Auth::loginUsingId($getUser->id);
            // Auth::login($getUser);
            // return $token =  $user->createToken('Token')->accessToken;
            return $token =  auth()->user()->createToken('Token')->accessToken;

        }
        catch(Exception $e) {
            dd($e->getMessage());
        }
        
    }
}
