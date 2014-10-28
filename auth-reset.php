<?
include('config.php');
session_start();

if ($_SESSION[id_user]){
    header("Location: /profile");
}

if ($_POST) {
    $email = $_POST[email];

    if (preg_match('/.+@.+\..+/i',$_POST[email]) || !isset($_POST[email])){

        $q = mysql_query("SELECT * FROM users WHERE email='{$email}'");
        $r = mysql_fetch_array($q);
        if ($r) {

            $pass = rand(10000000,99999999);
            $pass_md5 = md5($pass);

            $q = mysql_query("UPDATE users SET pass='{$pass_md5}' WHERE email='{$email}'");

            $headers = 'From: PAMANI <support@pamani.ru>' . "\r\n" .
                'Reply-To: PAMANI <support@pamani.ru>' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($_POST[email],"Новый пароль от PAMANI","Новый пароль: ".$pass, $headers);

            $error_msg = 'Ура! Новый пароль отправлен на указанный email адрес!';
        } else {
            $error_msg = 'Ошибка! Пользователя с таким email не существует!';
        }
    } else {
        $error_msg = 'Ошибка! Укажите настоящий email';
    }

}
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Сброс пароля | PAMANI.ru</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css?3" />
    <link rel="stylesheet" type="text/css" href="/style/auth.css?3" />
</head>
<body>
<div class="wrap">
    <div class="error" style="display:<?=($error_msg?"block":"none")?>">
        <p><?=$error_msg?></p>
    </div>
    <a href="/" class="logo"></a>

    <!-- Форма -->
    <div id="login-window">
        <div id="head-win">Восстановление пароля от PAMANI</div>

        <form method="POST">
            <label>Ваш настоящий адрес электронной почты <span>*</span></label>
            <input class="loginInput" type="text" name="email" value="<?=($_POST[email]?$_POST[email]:$_GET[email])?>" placeholder="введите email" autofocus />

            <input type="submit" class="form-go" value="Восстановить пароль" />
        </form>

        <div id="login-link">
            <a href="http://pamani.ru/login?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-left">Войти</a>
            <a href="http://pamani.ru/reg?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-right">Зарегистрироваться</a>
            <div class="clear"></div>
        </div>

    </div>
    <!-- End Форма -->

</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>