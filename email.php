<?php

    include($_SERVER[DOCUMENT_ROOT].'/classes/mandrill/Mandrill.php');
    include($_SERVER[DOCUMENT_ROOT].'/config.php');

    if ($_POST[spam]==1) die('SPAM!!!');
    //print_r($_POST);
    $mandrill = new Mandrill('z-7UFUKQdLpbJxSVW3khJA');
    $message = array(
        'html' => $_POST[msg],
        'subject' => "Вопрос о сервисе PAMANI #".date("dmy/his"),
        'from_email' => $_POST[email],
        'from_name' => $_POST[fname],
        'to' => array(
            array(
                'email' => "support@pamani.ru",
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => $_POST[email]),
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
?>
<html>
<header>
    <meta charset="utf8" />
    <style>
        body {
            background: url("//d36xtkk24g8jdx.cloudfront.net/bluebar/4fdd6ab/images/shared/noise-2.png") repeat scroll 0 0 #EDEEEF;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        div {
            background: none repeat scroll 0 0 #2ECC71;
            border: 1px solid #27AE60;
            color: #FFFFFF;
            margin: 100px auto;
            padding: 20px;
            text-align: center;
            text-shadow: 1px 1px 0 #27AE60;
            width: 380px;
        }
    </style>
</header>
<body>
<div>
    <b>Ваше сообщение отправлено!</b><br />
    Среднее время ожидания составляет 27 часов.
    <br /><br />
    В течении 3 секунд Вы будете перенаправлены обратно
</div>
<script>
    setTimeout(function() {
        location.href='/';
    }, 5000);
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>