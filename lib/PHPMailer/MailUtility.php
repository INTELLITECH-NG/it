<?php

require('PHPMailerAutoload.php');

class MailUtility {

    public $mail;

    function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = 3;
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPSecure = "ssl";
        $this->mail->Port = 465;
        $this->mail->Username = "internship@intellitech.ng";
        $this->mail->Password = "Kingofpop@50";
        $this->mail->Host = "mail.intellitech.ng";
        $this->mail->Mailer = "smtp";
        $this->mail->SetFrom("internship@intellitech.ng", "INTERNSHIP");
        $this->mail->AddReplyTo("internship@intellitech.ng", "INTELLITECH");
    }

    function sendMail($toList = [], $subject = '', $message = '') {
        foreach ($toList as $to) {
            $this->mail->AddAddress($to);
        }
        $this->mail->Subject = $subject;
        $this->mail->WordWrap = 80;
        $this->mail->MsgHTML($message);
        $this->mail->IsHTML(true);
        if (!$this->mail->Send())
            return FALSE;
        else
            return TRUE;;
    }

}

?>