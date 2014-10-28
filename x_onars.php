<?

	include("config.php");
	//print_R($_POST);
	if ($_POST[id_user]){
		$access = $_POST[pay]/10;
		
		$q = mysql_query("SELECT * FROM pay WHERE id_user='{$_POST[id_user]}' LIMIT 1");
		if (mysql_num_rows($q)>0) {
			$aff_summ = $_POST[pay]*0.2;
		} else {
			$aff_summ = $_POST[pay]*0.5;
		}
		
		$q = mysql_query("UPDATE users SET p_first=0, access=access+{$access} WHERE id_user={$_POST[id_user]} LIMIT 1");
		$q = mysql_query("INSERT INTO pay (id_user,summ,access,id_aff,aff_summ,payed_dt,payed_d) 
									VALUE ('{$_POST[id_user]}','{$_POST[pay]}','{$access}','{$_POST[id_aff]}','{$aff_summ}',NOW(),NOW())");
	}
?>
<html>
<head>
	<title>Панель управления</title>
	<meta charset="utf8" />
	<style>
		body {
			padding: 0;
			margin: 0;
			font-family: Tahoma;
			background: #ecf0f1;
		}
		#wrap {
			background: #FFF;
			margin: 50px auto;
			width: 500px;
		}
		form {
			padding: 0;
			margin: 0;
		}
		#search {
			padding: 20px;
		}
		#search input[type="text"] {
			border: 1px solid #BDC3C7;
			float: left;
			font-size: 20px;
			height: 31px;
			margin: 0;
			padding: 0;
			width: 80%;
		}
		#search input[type="submit"] {
			border: 1px solid #BDC3C7;
			border-left: none;
			height: 31px;
			margin: 0;
			padding: 0;
			width: 20%;
		}
		#result {
			padding: 20px;
		}
		#result form {
			height: 40px;
		}
		#result #user_name {
			display: block;
			float: left;
			font-size: 20px;
			width: 180px;
		}
		#result #rur {
			float: left;
			font-size: 20px;
			margin-left: 5px;
		}
		#result input[type="text"] {
			float: left;
			font-size: 20px;
			margin-left: 5px;
			width: 60px;
		}
		#result input[type="submit"] {
			border: 1px solid #BDC3C7;
			float: right;
			height: 31px;
		}
	</style>
</head>
<body>
	<div id="wrap">
		<div id="search">
			<form method="post">
				<input type="text" name="s" value="<?=$_POST[s]?>" />
				<input type="submit" value="поиск" />
			</form>
		</div>
		<? if ($_POST[s]){ ?>
		<div id="result">
			<?
				$q = mysql_query("SELECT * FROM users WHERE (user_name LIKE '%{$_POST[s]}%' OR email LIKE '%{$_POST[s]}%' OR access_token LIKE '%{$_POST[s]}%') AND user_name!=''");
				while ($r = mysql_fetch_array($q)){
			?>
				<form method="post">
					<label id="user_name"><?=$r[user_name]?></label>
					
					<input type="text" value="<?=$r[access]?>" />
					<input type="text" name="pay" /> <label id="rur">руб.</label>
					<input type="submit" value="Зачислить" />
					
					<input type="hidden" name="id_user" value="<?=$r[id_user]?>" />				
					<input type="hidden" name="id_aff" value="<?=$r[id_aff]?>" />				
					<input type="hidden" name="s" value="<?=$_POST[s]?>" />				
				</form>
			<?
				}
			?>
		</div>
		<? } ?>
	</div>
</body>
</html>