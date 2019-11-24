<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Email;
use App\SMTP;
use App\User;
USE Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $sendMail = DB::table('mail_recipients')->count();
        $emails = Email::count();
        $smtp = SMTP::count();
        $users = User::count();

        return view('dashboard',['sendMail' => $sendMail,'emails' => $emails,'smtp' => $smtp, 'users' => $users]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function general()
    {
        $data = DB::table('settings')->get();
        for ($i=0; $i < 10 ; $i++) { 
            $settings[$i] = json_decode(json_encode($data[$i]),TRUE);
        }
        return view('general-settings', ['settings',$settings]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateGeneral(Request $request)
    {
        if(!empty($request->name)){
            DB::table('settings')
            ->where('id', 1)
            ->update(['value' => $request->name]);
        }
        if(!empty($request->logo)){
            $request->logo->storeAs('images', "logo.png");

            DB::table('settings')
            ->where('id', 2)
            ->update(['value' => "storage/app/images/logo.png"]);
        }
        if(!empty($request->favicon)){
            $img = $request->favicon->getClientOriginalName();
            $request->favicon->storeAs('images', "favicon.png");

            DB::table('settings')
            ->where('id', 3)
            ->update(['value' => "storage/app/images/favicon.png"]);
        }
        if(!empty($request->welcome)){
            DB::table('settings')
            ->where('id', 4)
            ->update(['value' => $request->welcome]);
        }
        if(!empty($request->footer)){
            DB::table('settings')
            ->where('id', 5)
            ->update(['value' => $request->footer]);
        }
        if(!empty($request->footer)){
            DB::table('settings')
            ->where('id', 6)
            ->update(['value' => $request->theme]);
        }
        if(!empty($request->powered_by)){
            DB::table('settings')
            ->where('id', 7)
            ->update(['value' => $request->powered_by]);
        }
        else{
            DB::table('settings')
            ->where('id', 7)
            ->update(['value' => 0]);
        }
        if(!empty($request->version)){
            DB::table('settings')
            ->where('id', 8)
            ->update(['value' => $request->version]);
        }
        else{
            DB::table('settings')
            ->where('id', 8)
            ->update(['value' => 0]);
        }
        if(!empty($request->meta_title)){
            DB::table('settings')
            ->where('id', 9)
            ->update(['value' => $request->meta_title]);
        }
        if(!empty($request->meta_desc)){
            DB::table('settings')
            ->where('id', 10)
            ->update(['value' => $request->meta_desc]);
        }

        Alert::success('You Have Successfully Updated the Settings.', 'Successfully Updated!')->autoclose(3000);
        return back();
    }
}
