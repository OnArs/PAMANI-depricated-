<?

include('/var/www/pamani/pamani.ru/classes/EmailSender.php');
include('/var/www/pamani/pamani.ru/classes/mailchimp/Mailchimp.php');
$mc = new Mailchimp('a30fb385f16f05012281e8ebc94d099c-us8');

include('config.php');
session_start();

if ($_SESSION[id_user]){
    header("Location: /profile");
}

if ($_POST) {

    if (preg_match('/.+@.+\..+/i',$_POST[email]) || !isset($_POST[email])){

        if (!trim($_POST[pass])=='') {

            $email = mb_strtolower(trim($_POST[email]));
            $pass = md5($_POST[pass]);

            $q = mysql_query("SELECT * FROM users WHERE email='{$email}'");
            $r = mysql_fetch_array($q);
            if (!$r) {
                $tags_default = 'спб\r\nпитер\r\nмск\r\nмосква\r\nроссия\r\nмода\r\nстиль\r\nfollow\r\nfun\r\nlove';

                $_SESSION[id_aff] = (rand(1,2)==1?$_SESSION[id_aff]:0);

                $q = mysql_query("INSERT INTO users (id_user,email,pass,tags,id_aff,registered,actived)
                            VALUE (NUll,'{$email}','{$pass}','{$tags_default}','{$_SESSION[id_aff]}',NOW(),NOW())");
                $_SESSION[email] = $email;
                $_SESSION[id_user] = mysql_insert_id();

                $mc->lists->subscribe('7abb318366',array('email'=>$email),NULL,'html',false,false,false,false);

                sendEmailReg($email, $_POST[pass]);

                header("Location: /profile");
            } else {
                $error_msg = 'Ошибка! Пользователь с таким email уже существует!';
            }
        } else {
            $error_msg = 'Ошибка! Укажите пароль!';
        }
    } else {
        $error_msg = 'Ошибка! Укажите настоящий email';
    }

}
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Регистрация | PAMANI.ru</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css?3" />
    <link rel="stylesheet" type="text/css" href="/style/auth.css?3" />
</head>
<body>
<div class="wrap">
    <div class="error" style="display:<?=($error_msg?"block":"none")?>">
        <p><?=$error_msg?></p>
    </div>
    <a href="http://pamani.ru" class="logo"></a>

    <!-- Форма -->
    <div id="login-window">
        <div id="head-win">Регистрация в сервисе PAMANI</div>

        <form method="POST">
            <label>Ваш настоящий адрес электронной почты <span>*</span></label>
            <input class="loginInput" type="text" name="email" value="<?=($_POST[email]?$_POST[email]:$_GET[email])?>" placeholder="введите Ваш настоящий email" autofocus />

            <label>Придумайте и запомните пароль</label>
            <input class="loginInput" type="text" name="pass" value="<?=$_POST[pass]?>" placeholder="придумайте пароль" />

            <input type="submit" class="form-go" value="Зарегистрироваться" />
        </form>

        <div id="login-link">
            <a href="http://pamani.ru/login?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-left">Войти</a>
            <a href="http://pamani.ru/reset?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-right">Восстановить пароль</a>
            <div class="clear"></div>
        </div>

        <div id="adinfo"><span>*</span> Внимание! Указывайте Ваш настоящий E-mail для того &nbsp;&nbsp;&nbsp;чтобы иметь возможность восстановить пароль, получать &nbsp;&nbsp;&nbsp;уведомления о необходимости продления аккаунта и о &nbsp;&nbsp;&nbsp;важных изменениях в работе сервиса pamani.ru</div>
    </div>
    <!-- End Форма -->

</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>