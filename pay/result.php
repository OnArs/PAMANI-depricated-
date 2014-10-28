<?
	if ($_POST){
	
		include('../config.php');
		
		$id_bill = $_POST[InvId];
		
		$q = mysql_query("SELECT * FROM bill WHERE id_bill='{$id_bill}' LIMIT 1");
		$r = mysql_fetch_array($q);
		
		$summ = $r[summ];
		
		$access = $summ/10;
		if ($access==60) $access += 12;
		if ($access==90) $access += 18;
		if ($access==180) $access += 36;
		if ($access==360) $access += 72;


		$id_user = $r[id_user];
			
			
		// Получаем id_aff
		$q = mysql_query("SELECT * FROM users WHERE id_user='{$id_user}' LIMIT 1");
		$r = mysql_fetch_array($q);
			
		$id_aff = $r[id_aff];
		
		// Выясняем сумму начисления аффу
		if ($id_aff!=0){
			$q = mysql_query("SELECT * FROM pay WHERE id_user='{$id_user}' LIMIT 1");
			if (mysql_num_rows($q)>0) {
				$aff_summ = $summ*0.2;
			} else {
				$aff_summ = $summ*0.5;
			}
		}
		
		// Проверяем поступалали оплата по данному счёту
		$q = mysql_query("SELECT * FROM pay WHERE id_bill='{$id_bill}' LIMIT 1");
		if (mysql_num_rows($q)==0) {
			$q = mysql_query("INSERT INTO pay VALUE (NULL,'$id_bill','$id_user','$summ','$access','$id_aff','$aff_summ',NOW(),NOW())");
			$q = mysql_query("UPDATE users SET p_first=0, email_createbill=0, access=access+{$access} WHERE id_user='{$id_user}' LIMIT 1");
		}
	}
?>