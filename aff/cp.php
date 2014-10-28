<?
	include("config.php");
	session_start();
	//$_SESSION[id_aff]=0;
	
	//Общая информация
	$q = mysql_query("SELECT * FROM aff WHERE id_aff='{$_SESSION[id_aff]}' LIMIT 1");
	$r = mysql_fetch_array($q);
	
	$id_aff = $r[id_aff];
	$email = $r[email];
	$wallet_wm = $r[wallet_wm];
	$wallet_yd = $r[wallet_yd];

	// Сколько привлечено
	$q = mysql_query("SELECT COUNT(*) as count FROM users WHERE id_aff='{$id_aff}'");
	$r = mysql_fetch_array($q);
	
	$users_count = $r[count];
	
	// Текущий баланс
	$q = mysql_query("SELECT SUM(aff_summ) as sum FROM pay WHERE id_aff='{$id_aff}'");
	$r = mysql_fetch_array($q);
		
	$sum = $r[sum];
	
	$q = mysql_query("SELECT SUM(summ) as sum FROM aff_pay WHERE id_aff='{$id_aff}'");
	$r = mysql_fetch_array($q);
		
	$aff_sum = $r[sum];

	$balance = $sum - $aff_sum;
	
?>
<html>
<head>
	<title>Панель партнёра</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
</head>
<body>
	<div id="wrap">
		<div id="logo">
			<span>PAMANI.RU</span>
			<a href="/aff/">выход</a>
		</div>
		<div id="head">
			<label>Аккаунт</label>
			<span>Вы вошли как: <?=$email?></span>
			<span>Кошелёк WM: <?=$wallet_wm?></span>
			<span>Кошелёк ЯД: <?=$wallet_yd?></span>
			<span>Ваша ссылка: http://pamani.ru/?id_aff=<?=$id_aff?></span>
		</div>
		<div id="info">
			<label>Контроль баланса</label>
			<span>Баланс: <?=$balance?> руб.</span>
			<span>Всего выплачено: <?=$aff_sum?> руб.</span>
			<span>Привлечено клиентов: <?=$users_count?></span>
		</div>
		<div id="body">
			<label>История выплат</label>
			
			<?
				$q = mysql_query("SELECT * FROM aff_pay WHERE id_aff='{$id_aff}' ORDER BY reg_date DESC");
				while ($r = mysql_fetch_array($q)){
			?>
				<div class="payLine">
					<span class="left"><?=$r[wallet]?></span>
					<span class="center"><?=$r[summ]?> руб</span>
					<span class="right"><?=$r[reg_date]?></span>
				</div>
			<?
				}
			?>
		</div>
	</div>
</body>
</html>