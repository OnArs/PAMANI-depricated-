<?
	include("config.php");
	
	if ($_POST){
		$email = trim($_POST[email]);
		$pass = md5(trim($_POST[pass]));
		
		$q = mysql_query("SELECT * FROM aff WHERE email='{$email}' AND pass='{$pass}' LIMIT 1");
		$r = mysql_fetch_array($q);
		
		if ($r) {
			session_start();
			$_SESSION[id_aff] = $r[id_aff];
		
			header("Location: /aff/cp.php");
		}
	}

    $q = mysql_query("SELECT COUNT(*) count FROM aff");
    $r = mysql_fetch_array($q);

    $aff_count = $r[count];


    $q = mysql_query("SELECT SUM(summ) summ FROM aff_pay");
    $r = mysql_fetch_array($q);

    $pay_summ = $r[summ];


    $q = mysql_query("SELECT COUNT(*) count FROM users WHERE id_aff!=0");
    $r = mysql_fetch_array($q);

    $users_all = $r[count];


    $q = mysql_query("SELECT * FROM  aff_pay ORDER BY reg_date DESC LIMIT 1");
    $r = mysql_fetch_array($q);

    $pay_last = date_format(date_create($r[reg_date]), 'd.m.Y');

?>
<html>
<head>
	<meta charset="utf8" />
	<title>Вход в партнёрский интерфейс</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="wrap">
		<div id="login">
			<form method="POST">
				<input type="text" placeholder="email" name="email" value="<?=$_POST[email]?>" />
				<input type="password" placeholder="пароль" name="pass" autocomplete="off" />
				<input type="submit" value="войти" />
			</form>
		</div>

        <div id="muchSeo">
            <div>Средняя конверсия по системе: 8.3%</div>
            <div>С нами зарабатывает: <?=$aff_count?> партнёра</div>
            <div>Они заработали: <?=$pay_summ?> руб.</div>
            <div>Последняя выплата: <?=$pay_last?></div>
            <div>Привлекли: <?=$users_all?> пользователей</div>

            <div style="margin-top: 20px">
                Преимущества партнерской программы:
                <ul>
                    <li>Щедрые отчисления от 20 до 50%;</li>
                    <li>Отсутствие рекламных материалов для привлечения клиентов;</li>
                    <li>Выплата вознаграждения один раз в неделю;</li>
                    <li>Минимальная сумма для вывода денежных средств составляет всего 750 рублей;</li>
                    <li>Статистика по рефералам в личном кабинете;</li>
                    <li>Поддержка 24/7;</li>
                    <li>Лучшие условия в тематике "instagram";</li>
                </ul>
                <br />
                Начните зарабатывать с PAMANI уже сейчас!
            </div>
        </div>
	</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>