<?
	include('config.php');
	session_start();

    /* Проверка наличия сессии start */
    if (!$_SESSION[id_user]){
        header("Location: /");
    }
    /* Проверка наличия сессии end */

	if ($_POST) {
	    $_POST[email] = mb_strtolower(trim($_POST[email]));
	    if (preg_match('/.+@.+\..+/i',$_POST[email]) || !isset($_POST[email])){

            print_r($_SESSION);
            print_r($_POST);
            if ($_POST[email]!=$_SESSION[email]) {
                $email = $_POST[email];
                $q = mysql_query("SELECT * FROM users WHERE email='{$email}'");
                $r = mysql_fetch_array($q);
                if (!$r) {
                    $q = mysql_query("UPDATE users
                                    SET email='".$_POST[email]."'
                                    WHERE email='" . $_SESSION[email]."' ");
                    $_SESSION[email] = $_POST[email];
                    header("Location: /profile.php");
                } else {
                    $error_msg = 'Ошибка! Пользователь с таким email уже существует!';
                }
            } else {
                $error_msg = 'Вы указали Ваш текущий email';
            }
        } else {
            $error_msg = 'Пожалуйста укажите настоящий email';
		}
	}
	
	$q = mysql_query("SELECT * FROM users WHERE id_user='" . $_SESSION[id_user] . "' LIMIT 1");
	$r = mysql_fetch_array($q);
	$email = $r[email];
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>PAMANI.ru | <?=$_SESSION[username]?></title>
	<link rel="stylesheet" type="text/css" href="/style/profile.css?3" />
</head>
<body>
    <div id="boxError" style="text-align:center;display:<?=($error_msg?"block":"none")?>">
        <?=$error_msg?>
    </div>
	<div id="boxEmail">
		<div class="title">Для продолжения введите Ваш email</div>
		<form method="POST">
			<input type="text" name="email" value="<?=$email?>" autofocus />
			<input type="submit" value="Сохранить" />
		</form>
		<div class="desc" style="text-align: justify">Внимание! Указывайте Ваш настоящий email для того чтобы иметь возможность восстановить пароль, получать уведомления о необходимости продления аккаунта и о важных изменениях в работе сервиса pamani.ru</div>
        <br /><a href="/profile" style="color: #000000"><< Вернуться на страницу профиля</a>
	</div>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>
</html>