<?
	session_start();
	if (!$_SESSION[id_user]) header("Location: /");
	if ($_POST){
		include('../config.php');
		
		$id_user = $_SESSION[id_user];
		$summ = $_POST[summ];
		
		// Email пользователя
		$q = mysql_query("SELECT * FROM users WHERE id_user='{$id_user}' LIMIT 1");
		$r = mysql_fetch_array($q);
		
		$email = $r[email];
		
		// Создаём счёт
		$q = mysql_query("UPDATE users SET email_onlyreg='99', email_createbill='3' WHERE id_user='{$id_user}' LIMIT 1");
		$q = mysql_query("INSERT INTO bill VALUE (NULL, '{$id_user}','{$summ}', NOW())");

		$id_bill = mysql_insert_id();

		$signature = md5("pamani:{$summ}:{$id_bill}:abc12345");
		$desc = 'Продление аккаунта на pamani.ru';
		
		header("Location: https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=pamani&OutSum={$summ}&InvId={$id_bill}&Desc={$desc}&SignatureValue={$signature}&IncCurrLabel=&Email={$email}"); 
		
		die();
	}

	header("Location: /");
?>