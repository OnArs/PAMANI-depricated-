<?php

	include('/var/www/pamani/pamani.ru/classes/mandrill/Mandrill.php');
	include('/var/www/pamani/pamani.ru/cron/config.php');


    $q = mysql_query("SELECT * FROM users
                        WHERE
                            (
                                access IN (15,7,5,3,2,1)
                                AND email!=''
                            )
                            OR email='barsnur@gmail.com'");

    while ($r = mysql_fetch_array($q)) {

        $id_user = $r[id_user];
        $username = $r[username];
        $email = $r[email];
        $exp_days = $r[access];
        $exp_date = date("d.m.Y", (time()+24*60*60*$exp_days));


        $html = "
            Здравствуйте!
            <br /><br />
            Баланс вашего аккаунта #{$id_user} <b>{$username}</b> в сервисе PAMANI истекает.<br />
            Предположительная дата отключения услуг: {$exp_date} (осталось {$exp_days} дн.)
            <br /><br />
            Пополнить счет можно любым удобным для вас способом, среди которых<br />
            оплата по банковской карте, QIWI, Яндекс.Деньги, Вебмани и другие.
            <br /><br />
            Пополнение баланса осуществляется из личного кабинета: <a href='http://pamani.ru/auth-login-fast.php?email={$email}'>http://pamani.ru/profile</a>
            <br /><br />
            ВНИМАНИЕ! В случае непополнения счета в течение 30 дней с момента отключения,<br />
            данные на аккаунте могут быть ПОЛНОСТЬЮ УДАЛЕНЫ БЕЗ ВОЗМОЖНОСТИ ВОССТАНОВЛЕНИЯ.
            <br /><br />
            По всем вопросам обращайтесь в службу технической поддержки<br />
            по адресу support@pamani.ru или напишите ответ на это письмо.
            <br /><br />
            Спасибо за использование сервиса PAMANI.
            <br /><br />
            --<br />
            С уважением,<br />
            Команда PAMANI<br />
            http://pamani.ru - эффективное инстаграм продвижение
        ";

        $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
        $message = array(
            'html' => $html,
            'subject' => 'Необходимо пополнить баланс Вашего аккаунта',
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

        $result = $mandrill->messages->send($message, $async);
        print_r($result);

    }
?>