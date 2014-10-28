<?php
    ignore_user_abort(true);
    set_time_limit(0);

	include('/var/www/pamani/pamani.ru/classes/mandrill/Mandrill.php');
	include('/var/www/pamani/pamani.ru/cron/config.php');


    $q = mysql_query("SELECT *
                        FROM users u
                        LEFT JOIN bill b ON u.id_user = b.id_user
                        WHERE b.id_user IS NULL AND u.email_onlyreg<3 AND u.email!=''
                        ");
    //$q = mysql_query("SELECT * FROM users WHERE id_user=110");
    while ($r = mysql_fetch_array($q)) {
        //print_r($r);
        $email = trim($r[email]);
        $id_user = $r[0];

        $html = "
            Привет!
            <br /><br /><br />
            Меня зовут Алексей. Ты получил это письмо потому что какое то время назад<br /> зарегистрировался в <a href='http://pamani.ru/auth-login-fast.php?email={$email}'>сервисе PAMANI</a>, но так и не начал его использовать.<br /><br />
            Мне ужасно жаль что ты упускаешь возможность сделать свой инстаграм более популярным,<br /> как это делают 1742 наших пользователя прямо сейчас.
            <br /><br />
            Именно по этому Я предлагаю тебе начать пользоваться сервисом прямо сейчас.<br />
            <br /><br />
            Вот о чём Я говорю. Переходи <a href='http://pamani.ru/auth-login-fast.php?email={$email}'>по этой ссылке http://pamani.ru/profile</a>,<br /> олпачивай доступ, получай лайки и подписчиков.<br />
            <br /><br />
            На всякий случай ещё раз указываю ссылку на твой личный кабинет: <a href='http://pamani.ru/auth-login-fast.php?email={$email}'>http://pamani.ru/profile</a>.
            <br /><br /><br />
            --<br />
            С уважением,<br />
            Команда PAMANI<br />
            http://pamani.ru - эффективное инстаграм продвижение</a>
        ";

        $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
        $message = array(
            'html' => $html,
            'subject' => 'Почему в инстагарме только каждый стотысячный аккаунт популярен?',
            'from_email' => 'support@pamani.ru',
            'from_name' => 'Алексей из PAMANI',
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

        $qq = mysql_query("UPDATE users SET email_onlyreg=email_onlyreg+1 WHERE id_user='{$id_user}' LIMIT 1");
    }
?>