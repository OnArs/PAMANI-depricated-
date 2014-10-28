<?
	include('config.php');
	session_start();
	
	if (!$_SESSION[id_user]){
		header("Location: /");
	}
	
	if ($_POST) {

        $pass = $_POST[pass];
        $pass_md5 = md5($_POST[pass]);
        $q = mysql_query("UPDATE users SET pass='{$pass_md5}' WHERE email='{$_SESSION[email]}'");

        $headers = 'From: PAMANI <support@pamani.ru>' . "\r\n" .
            'Reply-To: PAMANI <support@pamani.ru>' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($_SESSION[email],"Новый пароль от PAMANI","Новый пароль: ".$pass, $headers);
        $error_msg = 'Ура! Новый пароль установлен и отправлен на Ваш email адрес!';
	}
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
		<div class="title">Укажите новый пароль<br />для <?=$_SESSION[email]?></div>
		<form method="POST">
			<input type="text" name="pass" value="<?=$_POST[pass]?>" autofocus />
			<input type="submit" value="Сменить пароль" />
		</form>
        <a href="/profile.php" style="color: #000000"><< Вернуться на страницу профиля</a>
	</div>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>
</html>