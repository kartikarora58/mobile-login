<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Nexmo;
use Hash;

class OtpController extends Controller
{
    public $x=NULL;
    public $mobile=NULL;
    public $error=NULL;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        $x=NULL;
        $mobile=NULL;
        $error=NULL;
        return view('auth.mobile',compact('x','mobile','error'));
    }
    public function verify(Request $request)
    {
        //dd($request);
        $mobile=$request->mobile;
        //dd($mobile);
        if(is_null($request->otp)) {
            $this->validate($request, [
                'mobile' => 'required|size:10',
            ]);
            $x = rand(111111, 999999);
            Nexmo::message()->send([
                'to' => '91'.$mobile,//replace it with $mobile
                'from'=>'EVCS',
                'text'=>$x,
            ]);
            $x=bcrypt($x);
            //dd($x);
            $error=NULL;
            return view('auth.mobile',compact('mobile','x','error'));
        }
        if(Hash::check($request->otp,$request->original))
        {
            $existUser = User::where('mobile',$mobile)->first();

            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->mobile=$mobile;
                $user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            //Auth::guard('web');
            return view('home');
        }
        else{
            $error="Incorrect OTP";
            $x=NULL;
            return view('auth.mobile',compact('mobile','x','error'));
        }
    }

}
