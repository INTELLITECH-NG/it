<?php

require('PHPMailerAutoload.php');

class MailUtility {

    public $mail;

    function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPSecure = "ssl";
        $this->mail->Port = 465;
        $this->mail->Username = "internship@intellitech.ng";
        $this->mail->Password = "########";
        $this->mail->Host = "intellitech.ng";
        $this->mail->Mailer = "smtp";
        $this->mail->SetFrom("internship@intellitech.ng", "INTELLITECH");
        //$this->mail->AddReplyTo("configureall@gmail.com", "INTELLITECH");
    }

    function sendMail($toList, $subject, $message) {
       
            $this->mail->AddAddress($toList);
            $this->mail->Subject = $subject;
            $this->mail->WordWrap = 80;
            $this->mail->MsgHTML($message);
            $this->mail->IsHTML(true);
            if (!$this->mail->Send()){
              return FALSE;
            }else{
              return TRUE;
            }
            $this->mail->SmtpClose();
    }

}

?>