<?php

    include('/var/www/pamani/pamani.ru/classes/mandrill/Mandrill.php');

    function sendEmailReg($email, $pass){
        $html = file_get_contents('/var/www/pamani/pamani.ru/email/reg.php');

        $chto = array("{{email}}","{{pass}}");
        $chem = array($email, $pass);

        $html = str_replace($chto, $chem, $html);

        $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
        $message = array(
            'html' => $html,
            'subject' => "Поздравляем с успешной регистрацией на pamani.ru",
            'from_email' => 'support@pamani.ru',
            'from_name' => 'PAMANI',
            'to' => array(
                array(
                    'email' => $email,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'support@pamani.ru'),
            'important' => true,
            'track_opens' => true,
            'track_clicks' => true,
            'auto_text' => true,
            'auto_html' => true,
            'preserve_recipients' => false
        );

        $async = true;

        $mandrill->messages->send($message, $async);
    }
?>