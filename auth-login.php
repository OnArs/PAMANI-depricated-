<?
include('config.php');
session_start();

if ($_SESSION[id_user]){
    header("Location: /profile");
}

if ($_POST) {
    $email = mb_strtolower($_POST[email]);
    $pass = md5($_POST[pass]);
    if (preg_match('/.+@.+\..+/i',$_POST[email]) || !isset($_POST[email])){

        $q = mysql_query("SELECT * FROM users WHERE email='{$email}' AND pass='{$pass}'");
        $r = mysql_fetch_array($q);
        if ($r) {
            $_SESSION[email] = $email;
            $_SESSION[id_user] = $r[id_user];

            // записываем последнюю активность пользователя
            $q = mysql_query("UPDATE users SET
                                p_gorod='{$_POST[p_gorod]}',
                                p_region='{$_POST[p_region]}',
                                p_strana='{$_POST[p_strana]}',
                                p_browser='{$_POST[p_browser]}',
                                p_os='{$_POST[p_os]}',
                                actived=NOW()
                              WHERE id_user='{$r[id_user]}' LIMIT 1");

            header("Location: /profile");
        } else {
            $error_msg = 'Ошибка! Пользователя с таким email не существует или введённый пароль не верный!';
        }
    } else {
        $error_msg = 'Ошибка! Укажите настоящий email';
    }

}

$browser = get_browser(null, true);
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Вход | PAMANI.ru</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css?4" />
    <link rel="stylesheet" type="text/css" href="/style/auth.css?4" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
</head>
<body>
<div class="wrap">
    <div class="error" style="display:<?=($error_msg?"block":"none")?>">
        <p><?=$error_msg?></p>
    </div>
    <a href="http://pamani.ru" class="logo"></a>

    <!-- Форма -->
    <div id="login-window">
        <div id="head-win">Вход в личный кабинет</div>

        <form method="POST">
            <label>Адрес электронной почты</label>
            <input class="loginInput" type="text" name="email" value="<?=($_POST[email]?$_POST[email]:$_GET[email])?>" placeholder="введите email" autofocus />
            <label>Пароль</label>
            <input class="loginInput" type="password" name="pass" value="<?=$_POST[pass]?>" placeholder="введите пароль" />
            <input type="submit" class="form-go" value="Войти" />

            <input type="hidden" name="p_gorod" id="p_gorod" value="n/a" />
            <input type="hidden" name="p_region" id="p_region" value="n/a" />
            <input type="hidden" name="p_strana" id="p_strana" value="n/a" />

            <input type="hidden" name="p_browser" value="<?=$browser[browser]?>" />
            <input type="hidden" name="p_os" value="<?=$browser[platform]?>" />
        </form>

        <div id="login-link">
            <a href="http://pamani.ru/reg?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-left">Зарегистрироваться</a>
            <a href="http://pamani.ru/reset?email=<?=($_POST[email]?$_POST[email]:$_GET[email])?>" class="link-right">Восстановить пароль</a>
            <div class="clear"></div>
        </div>

    </div>
    <!-- End Форма -->

</div>

<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU"></script>
<script>
    ymaps.ready(init);
    function init() {
        var geolocation = ymaps.geolocation;
        if (geolocation) {
            $("#p_gorod").val(geolocation.city);
            $("#p_region").val(geolocation.region);
            $("#p_strana").val(geolocation.country);
        }
    }
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>