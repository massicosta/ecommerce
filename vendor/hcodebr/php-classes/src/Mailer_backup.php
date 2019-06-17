<?php

namespace Hcode;

use Rain\Tpl;

class Mailer{

    const USERNAME = "massiscosta2@gmail.com";
    const PASSWORD = "antunes2";
    const NAME_FROM = "Marco Hcode Store";

    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {
        echo "<br>o valor de data é:  ";
        var_dump($data);

        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        echo "<br>o valor de config é:  ";
        var_dump($config);

        Tpl::configure( $config );

        $tpl = new Tpl;
        echo "<br>o valor de tpl é:  ";
        var_dump($tpl);

        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
            echo "<br>.$key";
            echo "<br>o valor de tpl dentro do foreach é:  ";
            var_dump($tpl);

        }
//        var_dump($data);
        echo "<br>antes";
        echo "<br>o valor de tplName é:  ";
        var_dump($tplName);

        $html = $tpl->draw($tplName, true);
        echo "<br>depois";

        var_dump($html);

        //Create a new PHPMailer instance
        $this->mail = new \PHPMailer;

//Tell PHPMailer to use SMTP
        $this->mail->isSMTP();

        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $this->mail->SMTPDebug = 0;

//Set the hostname of the mail server
        $this->mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = Mailer::USERNAME;

//Password to use for SMTP authentication
        $this->mail->Password = Mailer::PASSWORD;

//Set who the message is to be sent from
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

//Set an alternative reply-to address
//        $this->mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
        $this->mail->addAddress($toAddress, $toName);

//Set the subject line
        $this->mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML($html);

//Replace the plain text body with one created manually
        $this->mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');


    }

    public function send()
{

    return $this->mail->send();

}




}