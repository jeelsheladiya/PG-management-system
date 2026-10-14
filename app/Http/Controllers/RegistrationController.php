<?php
namespace App\Http\Controllers;

use App\Models\PGMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Mail 

class RegistrationController extends Controller
{
    public function registration()
    {
        return view('registration');
    }

    public function registration_process(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:25',
            'mail' => 'required|email|unique:pgmember,Email',
            'mobile' => 'required|digits:10|unique:pgmember,Phone',
            'password' => 'required|min:6|confirmed'
        ]);

        $otp = rand(100000, 999999);

        // 🔥 store in session
        $registrationData = [
            'Name' => $request->fname,
            'Email' => $request->mail,
            'Phone' => $request->mobile,
            'Password' => Hash::make($request->password),
            'OTP' => $otp,
            'OTP_Expires_At' => now()->addMinutes(10),
        ];

        session(['temp_reg_data' => $registrationData]);

        // send mail
        Mail::to($request->mail)->send(new \App\Mail\SendOtpMail($otp));

        return redirect()->route('otp.verify')->with('success', 'OTP sent to your email.');
    }

    public function verify_process(Request $request) {
        $request->validate(['otp' => 'required|digits:6']);
        
        $data = session('temp_reg_data');
    
        if ($data && $data['OTP'] == $request->otp) {
            
            try {
                // ✅ ડેટાબેઝમાં એન્ટ્રી
                PGMember::create([
                    'Name' => $data['Name'],
                    'Email' => $data['Email'],
                    'Phone' => $data['Phone'],
                    'Password' => $data['Password'],
                    'JoinDate' => now(), // અથવા date('Y-m-d')
                    'IsVerified' => 1
                ]);
                
                session()->forget('temp_reg_data');
                return redirect()->route('login')->with('success', 'Registration successful!');
    
            } catch (\Exception $e) {
                
                dd($e->getMessage()); 
            }
        }
    
        return back()->with('error', 'Invalid OTP.');
    }

    public function verify_page()
    {
        // session not have data then send to registration page
        if (!session('temp_reg_data')) {
            return redirect()->route('registration')->with('error', 'Please register first.');
        }
        return view('auth.verify_otp');
    }
}