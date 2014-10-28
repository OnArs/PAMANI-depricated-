<?
    session_start();
    include('config.php');

    /* Проверка наличия сессии start */
    if (!$_SESSION[id_user]){
        header("Location: /");
    }
    /* Проверка наличия сессии end */

    $email = $_SESSION[email];

    $q = mysql_query("SELECT * FROM users WHERE email='{$email}' AND access_token='' AND access=0 AND p_first=1");
    $r = mysql_fetch_array($q);
    //print_R($r);
    if ($r) $error_msg = "У Вас уже есть 1 ненастроенный аккаунт. Пожалуйста воспользуйтесь им!";

    if (!$error_msg){
        $q = mysql_query("SELECT COUNT(*) count, email, pass, tags FROM users WHERE email='{$email}' LIMIT 1");
        $r = mysql_fetch_array($q);

        if ($r[count]<=10) {
            $q = mysql_query("INSERT INTO users (id_user,email,pass,tags,registered,actived)
                            VALUE (NUll,'{$r[email]}','{$r[pass]}','{$r[tags]}',NOW(),NOW())");
            $_SESSION[email] = $email;
            $_SESSION[id_user] = mysql_insert_id();

            include('session.destroy.php');

            header("Location: /profile");
        }
    }
?>
<html>
<head>
    <title>Ошибка | PAMANI</title>
    <meta charset="utf-8">
    <link href="/style/profile-beta.css" rel="stylesheet" />
</head>
<body>
<div style="margin: 30px auto; width: 600px; text-align: center;">
    <div class="errors" style="display: block">
        <? if ($error_msg) { ?>
            <?=$error_msg?>
        <? } else { ?>
            Вы пытаетесь добавить больше 10 профилей на один аккаунт. Это превышает текущий лимит.<br />
            Свяжитесь с тех. поддержкой для увеличения лимита.
        <? } ?>

        <br /><br />
        <a href="/profile"><= Вернуться назад</a>
    </div>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>