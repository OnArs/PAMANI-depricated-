<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 01/12/13
 * Time: 18:29
 */

include('instagram.class.php');
include('config.php');
session_start();

/* Проверка наличия сессии start */
if (!$_SESSION[email]){
    header("Location: /");
}
/* Проверка наличия сессии end */

/* Сохранение настроек start */
if ($_POST){
    if (preg_match_all("/([а-яА-Яa-zA-Z0-9]+)/u",$_POST[tags],$tags)){
        //print_r($tags);

        for ($i=0;$i<count($tags[0]);$i++){
            $tags_in .= trim($tags[0][$i]).'\r\n';
        }
		
		$tags_in = trim($tags_in);
    }

    $_POST[access_token] = trim($_POST[access_token]);

    $q = mysql_query("UPDATE users SET p_first='0', access_token='{$_POST[access_token]}', tags='{$tags_in}', block='0' WHERE id_user_in='{$_SESSION[id]}' LIMIT 1");
    unset($_SESSION[username]);
    unset($_SESSION[profile_picture]);
    header("Location: /profile.php");
    die();
}
/* Сохранение настроек end */

$instagram = new Instagram(array(
    'apiKey'      => 'c42d78c753c8486783f2c4a02c5921ab',
    'apiSecret'   => '782f86c6c9eb40c2a5fa79a024a753da',
    'apiCallback' => 'http://pamani.ru/login.php'
));


$q = mysql_query("SELECT * FROM users WHERE id_user_in='" . $_SESSION[id] ."' LIMIT 1");
$r = mysql_fetch_array($q);

$email = $r[email];
/* не может быть такой ситуации что нет email'a
if (trim($email)==''){
    header("Location: /profile-email.php");
}
*/

$id_user_instagram = $r[id_user];
$first_time = $r[p_first];
$counter = number_format($r[counter],0,'.',' ');
$access_days = $r['access'];
$access_token = $r['access_token'];
$tags = $r[tags];

if ($access_token){
    $instagram->setAccessToken($access_token);

    if (!$_SESSION[username]){
        $data = $instagram->getUser();

        $_SESSION[username] = $data->data->username;
        $_SESSION[profile_picture] = $data->data->profile_picture;
        $_SESSION[id_instagram] = $data->data->id;

        $q = mysql_query("UPDATE users
                        SET id_user='{$_SESSION[id_instagram]}', username='{$_SESSION[username]}',
                        photo='{$_SESSION[profile_picture]}'
                        WHERE id_user_in='{$_SESSION[id]}' LIMIT 1");
    }
}

if ($id_user_instagram) {
    $q = mysql_query("SELECT SUM(counter) as sum FROM history WHERE id_user='" . $id_user_instagram ."'");
    $r = mysql_fetch_array($q);

    $total_likes = number_format($r[sum]+$counter,0,'.',' ');
}

/* Получаем данные обо всех профилях на аккаунте start */
$q = mysql_query("SELECT * FROM users WHERE email='" . $_SESSION['email'] ."'");
while ($r = mysql_fetch_array($q)){
    $accs[] =   array(
                    "id_user_in" => $r[id_user_in],
                    "username" => $r[username],
                    "access" => $r[access],
                    "block" => $r[block]
                );
}
/* Получаем данные обо всех профилях на аккаунте end */

//print_R($_SESSION);
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>PAMANI | <?=$_SESSION[username]?></title>
	<link rel="stylesheet" type="text/css" href="/style/profile.css?4"/>
    <script src="/js/jquery.min.js"></script>
    <script>
        $(function(){
            $("#boxBack").click(function(){
                $("#boxBack").fadeOut();
                $("#boxSettings").fadeOut();
                $("#boxPay").fadeOut();
                $("#boxAddNewAccount").fadeOut();
                $("#noAddNewAccount").fadeOut();
            });
            $(".getBoxSettings").click(function(){
                $("#boxBack").fadeIn();
                $("#boxSettings").fadeIn();
            });
            $(".getBoxPay").click(function(){
                $("#boxBack").fadeIn();
                $("#boxPay").fadeIn();
            });
            $(".getBoxAddNewAccount").click(function(){
                $("#boxBack").fadeIn();
                $("#boxAddNewAccount").fadeIn();
            });
            $("#boxAccountChange").on("change", function(){
                location.href="/profile-change.php?id_user_in="+$(this).val();
            })
            $("#yesAddNewAccount").on("click", function(){
                location.href="/profile-add-new.php";
            })
            $("#noAddNewAccount").click(function(){
                $("#boxBack").fadeOut();
                $("#boxAddNewAccount").fadeOut();
            });
        });
    </script>
</head>
<body>
<? if (count($accs)>1) { ?>
    <select id="boxAccountChange">
        <option>Перейти к другому аккаунту</option>
        <?
            foreach ($accs as $acc) {
                $disabled = ($acc[username]==$_SESSION[username]?'disabled="true"':'');
        ?>

            <option value="<?=$acc[id_user_in]?>" <?=$disabled?>><?=$acc[username]?> | баланс: <?=$acc[access]?> дн.<?//=$acc[block]?></option>
        <? } ?>
    </select>
<? } ?>
<div id="boxBack"></div>
<div id="boxSettings">
    <form method="post">
		<div class="title">Настройки</div>
		
        <div style="margin: 0 0 0;">Код доступа (access_token):</div>
        <input name="access_token" type="text" value="<?=$access_token?>" autofocus />
        <div style="text-align: center"><a href="/pages/faq.php" target="_blank">Как получить код доступа?</a></div>

        <div style="margin: 20px 0 0;">Хештеги:</div>
        <textarea name="tags" spellcheck="false"><?=$tags?></textarea>
		
        <input type="submit" value="Сохранить" />
		<div style="margin-top:10px; text-align:center"><a href="/profile-email.php">Сменить email</a></div>
		<div style="margin-top:10px; text-align:center"><a href="/profile-pass.php">Сменить пароль</a></div>
    </form>
</div>
<div id="header">
    <div id="boxProfile">
        <img class="profile_picture" src="<?=($_SESSION[profile_picture]?$_SESSION[profile_picture]:"/images/nophoto.png")?>" />

        <div>
            <div>
                <b><?=$_SESSION[username]?></b> <a href="/?exit=1" class="psevdoLink" style="font-size: 14px">выход</a>
            </div>

            <div style="margin-top: 10px">
                Баланс: <?=$access_days?> дней<br />
                <span class="getBoxPay psevdoLink">Пополнить баланс</span>
				<span class="getBoxSettings psevdoLink" style="display:<?=($first_time==1?"none":"block")?>;margin-top:15px;">Настройки</span><br />
            </div>
        </div>
    </div>
</div>
<div id="boxAddNewAccountButton">
    <span class="getBoxAddNewAccount psevdoLink">Добавить ещё один аккаунт для продвижения</span>
</div>
<div id="boxAddNewAccount">
    <div style="margin-bottom: 20px">Вы уверены что хотите добавить новый аккаунт?</div>

    <input type="button" id="yesAddNewAccount" value="Да, добавить" />
    <input type="button" id="noAddNewAccount" value="Нет, передумал(а)" />
</div>
<div id="boxPay">
	<form method="POST" class="payVar" action="/pay/form.php">
		<span class="payOld">Старая цена: 4500 руб</span>
		<span class="payPrice">3600 руб</span>
		<span class="payLong">за 360 дней</span>
		<span class="paySurp">+ 72 дня бесплатно</span>
		<input type="hidden" name="summ" value="3600" />
		<input type="submit" value="Оплатить" />
	</form>
	<form method="POST" class="payVar" action="/pay/form.php">
		<span class="payHit"><img src="/images/hit-ico.png" /></span>
		<span class="payOld">Старая цена: 2700 руб</span>
		<span class="payPrice">1800 руб</span>
		<span class="payLong">за 180 дней</span>
		<span class="paySurp">+ 36 дней бесплатно</span>
		<input type="hidden" name="summ" value="1800" />
		<input type="submit" value="Оплатить" />
	</form>
	<form method="POST" class="payVar" action="/pay/form.php">
		<span class="payOld">Старая цена: 1500 руб</span>
		<span class="payPrice">900 руб</span>
		<span class="payLong">за 90 дней</span>
		<span class="paySurp">+18 дней бесплатно </span>
		<input type="hidden" name="summ" value="900" />
		<input type="submit" value="Оплатить" />
	</form>
	<form method="POST" class="payVar" action="/pay/form.php">
		<span class="payOld">Старая цена: 1100 руб</span>
		<span class="payPrice">600 руб</span>
		<span class="payLong">за 60 дней</span>
		<span class="paySurp">+ 12 дней бесплатно</span>
		<input type="hidden" name="summ" value="600" />
		<input type="submit" value="Оплатить" />
	</form>
	<form method="POST" class="payVar" action="/pay/form.php">
		<span class="payOld">Старая цена: 550 руб</span>
		<span class="payPrice">300 руб</span>
		<span class="payLong">за 30 дней</span>
		<span class="paySurp"></span>
		<input type="hidden" name="summ" value="300" />
		<input type="submit" value="Оплатить" />
	</form>
	
	<div style="text-align: center; font-size: 12px; margin-top: 20px;">
		Мгновенная оплата! Принимаются все популярные виды платежей:
		<img style="color: red; width: 420px; margin-top: 5px;" src="/images/systems-w.png">
	</div>
</div>
<div id="boxFirst" <?if ($first_time==1) echo 'style="display:block;"'?>>
	<div class="title">Что дальше?</div>
	<?
		if ($access_days==0 && trim($access_token)=='' && trim($tags)!='') { // юзер здесь впервые
			echo '<b>Шаг 1 из 2</b> | <span class="getBoxPay psevdoLink">Пополните баланс</span> чтобы продолжить и перейти к простой настройке бота в один шаг';
		} elseif ($access_days!=0 && trim($access_token)=='' && trim($tags)!='') { // юзер после первой оплаты
			echo '<b>Шаг 2 из 2</b> | Укажите код доступа <span class="getBoxSettings psevdoLink">в настройках</span>. Что это и как его получтиь Вы узнаете там же.';
		}
	?>
</div>
<div id="boxError" <?if ($first_time==0 AND (trim($access_token)=='' || trim($tags)=='' || $access_days==0 || !$_SESSION[username])) echo 'style="display:block;"'?>>
	<div class="title">Есть проблема!</div>
	<?
		if (trim($access_token)=='') {
			echo 'Укажите код доступа <span class="getBoxSettings psevdoLink">в настройках</span>. Что это и как его получить Вы узнаете там же.';
		} elseif (trim($tags)=='') {
			echo 'Укажите хештеги <span class="getBoxSettings psevdoLink">в настройках</span>. По указанным хештегам робот будет искать фотографии и лайкать их.';
		} elseif ($access_days==0) {
			echo '<span class="getBoxPay psevdoLink">Пополните баланс</span> и бот продолжить ставить лайки. Подписчики уже ждут Вас!';
		} elseif (!$_SESSION[username]) {
            echo "Указан не верный код доступа в настройках!";
        }
		
	?>
</div>
<div id="boxStat">
    Лайков за сегодня: <?=$counter?> шт.<br />
    <? if ($total_likes!=0) { ?>Лайков за всё время: <?=$total_likes?> шт. <? } ?>
</div>
<div id="boxLiked">
    <div style="text-align: center; margin-top: 20px; font-weight: bold; color: rgb(44, 62, 80);">Последние 5 лайков</div>
<?
if (!$access_token){ echo "<br />Обычно здесь отображаются 5 последних лайков"; }
$likes = $instagram->getUserLikes(5);
//print_r($likes);
//if ($likes->meta->code==400) { echo '<meta http-equiv="refresh" content="0;url=/">'; }
foreach ($likes->data as $entry) {
?>
    <a href="<?=$entry->link?>" target="_blank">
        <img src="<?=$entry->images->low_resolution->url?>" />
    </a>

    <!--
    <a href="http://instagram.com/<?=$entry->user->username?>">
        <img src="<?=$entry->user->profile_picture?>" /> <?=$entry->user->username?>
    </a>
    -->
<?
}
?>
</div>
<a href="/pages/help.php" class="psevdoLink" target="_blank" style="color: rgb(0, 0, 0); display: block; width: 50px; margin: 0px auto 50px;">Помощь</a>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>