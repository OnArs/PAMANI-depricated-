<?php

	include('/var/www/pamani/pamani.ru/classes/mandrill/Mandrill.php');
	include('/var/www/pamani/pamani.ru/cron/config.php');

    /*
    $q = mysql_query("SELECT *
                        FROM users u, bill b
                        LEFT JOIN pay p ON p.id_user = b.id_user
                        WHERE u.id_user = b.id_user
                        AND p.id_user IS NULL
                        AND u.email_createbill>0
                        AND u.id_user=110
                        ");
    */
    $q = mysql_query("SELECT * FROM users
                        WHERE email_createbill>0");

    while ($r = mysql_fetch_array($q)) {

        $email = $r[email];
        $days = $r[email_createbill];
        $days_post = ' дня'; if ($days==1) $days_post = ' день';

        $html = "
            Здравствуйте!
            <br /><br /><br />
            Меня зовут Анастасия. Недавно вы начали оплату сервиса PAMANI.
            Решила напомнить Вам об этом. Вдруг Вы об этом забыли :) А в ближайшее время мы планируем поднять стоимость.
            <br /><br />
            Продолжите оплату сервиса прямо сейчас по ссылке: <a href='http://pamani.ru/auth-login-fast.php?email={$email}'>http://pamani.ru/profile</a>
            <br /><br /><br />
            --<br />
            С уважением,<br />
            Анастасия из команды PAMANI<br />
            http://pamani.ru - эффективное инстаграм продвижение
        ";

        $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
        $message = array(
            'html' => $html,
            'subject' => 'До аннулирования счёта осталось '.$days.$days_post,
            'from_email' => 'support@pamani.ru',
            'from_name' => 'Анастасия из PAMANI',
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

        $result = $mandrill->messages->send($message, $async);
        print_r($result);


        $q = mysql_query("UPDATE users SET email_createbill=email_createbill-1 WHERE id_user='{$id_user}' LIMIT 1");
    }
?>