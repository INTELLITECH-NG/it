<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use App\SMTP;
use Illuminate\Http\Request;

class SMTPController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mailer = SMTP::latest()->get();
        return view('smtp.index',['mailers' => $mailer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('smtp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $transport = new \Swift_SmtpTransport($request->host, $request->port, $request->encryption);
        $transport->setUsername($request->username);
        $transport->setPassword($request->password);
        $mailer = new \Swift_Mailer($transport);
        $mailer->getTransport()->start();

        // store
        $data = $request->all();
        $mailer = new SMTP;
        $mailer->create($data);
        Alert::success('You Have Successfully Stored Mailer.', 'Successfully Stored!')->autoclose(3000);
        return redirect()->route('mailer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\STMP  $sTMP
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return redirect()->route('smtp.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\STMP  $sTMP
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mailer = SMTP::find($id);
        return view('smtp.edit',['mailer' => $mailer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\STMP  $sTMP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mailer = SMTP::find($id);
        $data = $request->all();
        $mailer->update($data);
        Alert::success('You Have Successfully Updated the  Mailer Account.', 'Successfully Updated!')->autoclose(3000);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\STMP  $sTMP
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $mailer = SMTP::find($id);

        if($mailer->status != 1){
            SMTP::where('id', $id)->update(['status' => 1]);
        }
        else{
            SMTP::where('id', $id)->update(['status' => 0]);
        }

        Alert::success('You Have Successfully Updated Mailer Status', 'Successfully Updated')->autoclose(3000);
        return redirect()->route('mailer.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\STMP  $sTMP
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SMTP::find($id)->delete();
        Alert::success('You Have Successfully Deleted Mailer Account', 'Successfully Deleted')->autoclose(3000);
        return redirect()->route('mailer.index');
    }
}
