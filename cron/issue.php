<?php

	include('/var/www/pamani/pamani.ru/classes/mandrill/Mandrill.php');
	include('/var/www/pamani/pamani.ru/cron/config.php');

    $q = mysql_query("SELECT * FROM users WHERE email!='' AND block>0 AND p_block=0 AND access>0");

    while ($r = mysql_fetch_array($q)) {

        $id_user = $r[id_user];
        $username = $r[username];
        $email = $r[email];


        $html = "
            Здравствуйте!
            <br /><br />
            Вы зарегистрированы под аккаунтом #{$id_user}: {$username} {$email}
            <br /><br />
            Автоматическая проверка Вашего аккаунта показала что с ним есть проблемы.
            <br /><br />
            Для получения дополнительной информации о проблеме пожалуйста войдите в аккаунт <a href='http://pamani.ru/profile'>http://pamani.ru/profile</a>.<br />
            Так же рекомендуем обратиться к справочной информации по адресу <a href='http://pamani.ru/help'>http://pamani.ru/help</a>
            <br /><br />
            Если у Вас возникли вопросы, обращайтесь в службу технической поддержки<br />
            по адресу support@pamani.ru или напишите ответ на это письмо.
            <br /><br />
            Спасибо за использование сервиса PAMANI.
            <br /><br />
            --<br />
            С уважением,<br />
            Команда PAMANI<br />
            http://pamani.ru - увеличение охвата аудитории Вашего инстаграм аккаунта
            ";

        $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
        $message = array(
            'html' => $html,
            'subject' => "Ваш аккаунт {$username} в беде!",
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
        //print_r($result);

        $qq = mysql_query("UPDATE users SET p_block=p_block+1 WHERE id_user='{$id_user}' LIMIT 1");

    }
?>