<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\SignupRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request){
        
    $validator = Validator::make($request->all(), [
        'firstname' => 'required|string|min:3|max:50',
        'lastname' => 'required|string|min:3|max:50',
        'email' => 'required|string|email|unique:users|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $email_verification = Str::random(30);
    $expiryTimestamp = Carbon::now()->addHour();
 
    // Create User
    $user = User::create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'verification_code' => $email_verification,
        'expiry_timestamp' => $expiryTimestamp,
    ]);

    $email_verification_code = ['verification_string'=>$email_verification, 'email'=>$request->input('email') ];
    
    Mail::to($request->input('email'))->send(new SignupRegistration($email_verification_code));
 
     return response()->json(['status' => 200,
     'message'=>'Registration was successful']);

}


    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('VTU')->accessToken;

            return response()->json(['token' => $token], 200);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
{
    $user = Socialite::driver($provider)->user();

    // Use $user data to authenticate or register the user in your application
}

}