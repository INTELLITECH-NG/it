<?php

namespace App\Http\Controllers;

use Alert;
use Excel;
use App\SMTP;
use App\Group;
use App\Email;
use App\SendMail;
use Swift_Mailer;
use Swift_Message;
use Carbon\Carbon;
use Swift_SmtpTransport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendMailController extends Controller
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
   public function index(){
      $sendMails = SendMail::latest()->get();
        return view('sendMail.index',['sendMails' => $sendMails]);
   }
   public function details($sendMail){
      $sendMails = SendMail::find($sendMail);
      $sendMail_emails = DB::table('mail_recipients')->where('send_mail_id','=',$sendMail)->get();
      return view('sendMail.details',['sendMails' => $sendMails, 'sendMail_emails' => $sendMail_emails]);
   }
   public function form(){
      $smtp = SMTP::where('status',1)->latest()->get();
      $groups = Group::latest()->get();
      $emails = Email::latest()->get();
      return view('sendMail.form',['groups' => $groups, 'emails' => $emails, 'mailers'=> $smtp]);
   }
   public function send(Request $request)
   {

      $mail = SMTP::where('username',$request->mailer)->first();

      // Create the Transport
      $transport = new Swift_SmtpTransport($mail->host, $mail->port, $mail->encryption);
      $transport->setUsername($mail->username);
      $transport->setPassword($mail->password);

      // Create the Mailer using your created Transport
      $mailer = new Swift_Mailer($transport);

      $i = 0;
      $rec_mailers1[] = "";
      $rec_mailers2[] = "";
      $rec_mailers3[] = "";
      $rec_mailers4[] = "";


      if (!empty($_FILES['file']['tmp_name'])){
        $extension = $request->file('file')->extension();
        if($extension == 'txt'){
            $rec_mailers1 = explode(",", file_get_contents($_FILES['file']['tmp_name']));
        }else{
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path)->get();
            if($data->count()){
                foreach ($data[0] as $key => $value) {
                    if( $value->email != "" )
                        $rec_mailers1[] = $value->email;
                }
            }
        }
      }

      if (!empty($request->emails)){
        $rec_mailers2 = $request->emails;
      }

      if (!empty($request->group)){

        $groupMail =  Email::where('group_id','=', $request->group)->get();
        
        foreach ($groupMail as $Mail) {
          $rec_mailers3[] = $Mail['email'];
        }
      }

      if (!empty($request->rec_email)){
        $rec_mailers4 = $request->rec_email;
      }

      $rec_mailers = array_unique(array_filter(array_merge($rec_mailers1, $rec_mailers2, $rec_mailers3, $rec_mailers4)));

      SendMail::create([
        'smtp_mail' => $request->mailer,
        'name' => $request->name,
        'subject' => $request->subject,
        'message' => $request->message,
        'recipients' => count($rec_mailers)
      ]);

      $last_send_mail = SendMail::latest()->first();

      foreach ($rec_mailers as $receive_mailer) {
        if (!empty($receive_mailer)){
          $message = (new Swift_Message($request->subject))
                ->setFrom($request->mailer, $request->name)
                ->setTo($receive_mailer)
                ->setBody($request->message, 'text/html');
          // Send the message
          $result = $mailer->send($message);

          DB::table('mail_recipients')->insert(
              ['send_mail_id' => $last_send_mail->id, 'recipient_mail' => $receive_mailer]
          );
          $i++;
        }
      }

      Alert::success('Your mail have been sent to '. $i .' Persons', 'Congratulations!')->persistent('Close');
    
      return redirect()->route('sendMail.index');
   }
   /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        SendMail::find($request->id)->delete();
        return redirect()->route('sendMail.index');
    }
}