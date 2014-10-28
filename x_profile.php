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
if (!$_SESSION[id_user]){
    header("Location: /");
}
/* Проверка наличия сессии end */

/* Сохранение настроек start */
if ($_POST[tags]){
    if (preg_match_all("/([а-яА-Яa-zA-Z0-9]+)/u",$_POST[tags],$tags)){
        //print_r($tags);

        for ($i=0;$i<count($tags[0]);$i++){
            $tags_in .= trim($tags[0][$i]).'\r\n';
        }

        $tags_in = trim($tags_in);
    }

    $q = mysql_query("UPDATE users SET p_first='0', tags='{$tags_in}',
                        block=0,p_block=0 WHERE id_user='{$_SESSION[id_user]}' LIMIT 1");
    unset($_SESSION[username]);
    unset($_SESSION[profile_picture]);
    header("Location: /profile");
    die();
}
if ($_POST[access_token]){
    $_POST[access_token] = trim($_POST[access_token]);

    $q = mysql_query("UPDATE users SET p_first='0', access_token='{$_POST[access_token]}',
                        block='0',p_block=0 WHERE id_user='{$_SESSION[id_user]}' LIMIT 1");
    unset($_SESSION[username]);
    unset($_SESSION[profile_picture]);
    header("Location: /profile");
    die();
}
/* Сохранение настроек end */

$instagram = new Instagram(array(
    'apiKey'      => 'c42d78c753c8486783f2c4a02c5921ab',
    'apiSecret'   => '782f86c6c9eb40c2a5fa79a024a753da',
    'apiCallback' => 'http://pamani.ru/login'
));


$q = mysql_query("SELECT * FROM users WHERE id_user='" . $_SESSION[id_user] ."' LIMIT 1");
$r = mysql_fetch_array($q);

$email = $r[email];
/* не может быть такой ситуации что нет email'a
if (trim($email)==''){
    header("Location: /profile-email.php");
}
*/

$id_user = $r[id_user];
$first_time = $r[p_first];
$counter = number_format($r[counter_success],0,'.',' ');
$access_days = $r['access'];
$access_token = $r['access_token'];
$tags = $r[tags];
$block = $r[block];

if ($access_token){
    $instagram->setAccessToken($access_token);

    if (!$_SESSION[username]){
        $data = $instagram->getUser();
        //if ($id_user==110) print_r($data);
        $_SESSION[username] = $data->data->username;
        $_SESSION[profile_picture] = $data->data->profile_picture;
        $_SESSION[id_instagram] = $data->data->id;

        $q = mysql_query("UPDATE users
                        SET id_instagram='{$_SESSION[id_instagram]}', username='{$_SESSION[username]}',
                        photo='{$_SESSION[profile_picture]}'
                        WHERE id_user='{$_SESSION[id_user]}' LIMIT 1");
    }
}

$total_likes = 0;
if ($id_user) {
    $q = mysql_query("SELECT SUM(counter) as sum FROM history WHERE id_user='" . $id_user ."'");
    $r = mysql_fetch_array($q);

    $total_likes = number_format($r[sum]+$counter,0,'.',' ');
}


$q = mysql_query("SELECT COUNT(*) as count FROM users WHERE email='" . $_SESSION['email'] ."'");
$r = mysql_fetch_array($q);

$acc_count = $r[count];

//print_R($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>PAMANI | Личный кабинет</title>
    <meta charset="utf-8">
    <link media="screen" href="/style/profile-beta.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/profile.js"></script>
</head>
<body>
<!-- Шапка -->

<div id="content">

<div id="head">
    <div class="wrap">
        <div id="logo"></div>

        <ul>
            <li id="options<?if ($access_days==0) echo '-disable'?>">
                <a href="#" title="Настройки"><p></p>Настройки</a>
            </li>
            <li id="support"><a href="/help" title="Справка и поддержка"><p></p> Справка и поддержка</a></li>
            <li id="logout"><a href="http://pamani.ru/?exit=1" title="Выход"><p></p></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<!-- End Шапка -->

<div class="wrap" style="margin:0 auto 80px">

<!-- Профиль -->
<div id="profile">
    <div id="avatar"><img src="<?=($_SESSION[profile_picture]?$_SESSION[profile_picture]:"images/noavatar.png")?>" width="110" height="110" /></div>
    <div id="pay">Пополнить баланс</div>

    <div id="all-likes"><p><?=$total_likes?></p> лайков<br /> поставлено</div>
    <div id="day-likes"><p><?=$counter?></p> лайков<br /> сегодня</div>
    <div id="balance"><p><?=$access_days?> дней</p> ваш<br /> баланс</div>
</div>

<div id="info">
    <div id="login-on"><?=$_SESSION[username]?> #<?=$_SESSION[id_user]?></div>
    <? if ($acc_count==1) { ?>
        <a href="/profile-add-new.php" id="add-account">Добавить ещё один аккаунт для продвижения</a>
    <? } else { ?>
        <a href="/profile-manager.php" id="account-manager">Менеджер аккаунтов</a>
    <? } ?>
</div>
<!-- End Профиль -->







<!-- Совет -->
<div class="tips" <?if ($first_time==1) echo 'style="display:block;"'?>>
    <p>Что дальше?</p>
    <?
        if ($access_days==0 && trim($access_token)=='' && trim($tags)!='') { // юзер здесь впервые
            echo '<div class="step">Шаг 1 из 2</div> | <span class="getBoxPay psevdoLink">Пополните баланс</span> этого аккаунта чтобы продолжить и перейти к простой настройке бота в один шаг. Новые подписчики уже жду Вас прямо сейчас!';
        } elseif ($access_days!=0 && trim($access_token)=='' && trim($tags)!='') { // юзер после первой оплаты
            echo '<div class="step">Шаг 2 из 2</div> | Укажите код доступа <span class="getBoxSettings psevdoLink">в настройках</span>. Что такое код доступа и инструкцию по его получению Вы найдёте там же.';
        }
    ?>
</div>
<!-- End Совет -->

<!-- Ошибка -->
<div class="errors" <?if ($first_time==0 AND (trim($access_token)=='' || trim($tags)=='' || $access_days==0 || !$_SESSION[username] || $block==1 )) echo 'style="display:block;"'?>>
    <p>Есть проблема!</p>
    <?
        if (trim($access_token)=='') {
            echo 'Укажите код доступа <span class="getBoxSettings psevdoLink">в настройках</span>. Что такое код доступа и инструкцию по его получению Вы найдёте там же.';
        } elseif (trim($tags)=='') {
            echo 'Укажите #хештеги <span class="getBoxSettings psevdoLink">в настройках</span>. По указанным хештегам PAMANI будет искать фотографии в инстаграме и лайкать их.';
        } elseif ($access_days==0) {
            echo '<span class="getBoxPay psevdoLink">Пополните баланс</span> и PAMANI продолжить ставить лайки. Подписчики уже ждут Вас!';
        } elseif (!$_SESSION[username]) {
            echo "Указан не верный или заблокированный код доступа в настройках!";
        } elseif ($block==1) {
            echo "Ваш код доступа заблокирован администрацией инстаграма. Для возобновления работы аккаунта пожалуйста получите его снова и укажите в настройках.";
        }
    ?>
</div>
<!-- End Ошибка -->








<!-- Последние лайки -->
<div id="last-like">
<div id="last-title"><img src="images/like.png" />&nbsp; Последние лайки</div>

<!--   <div id="like-null">Здесь будут отображены последние лайки</div>   -->

<div class="last-photo">

<?
    //echo "SELECT * FROM line WHERE id_user='{$_SESSION[id_instagram]}' AND done=1 AND img!='' ORDER BY dt DESC LIMIT 6";
    $q = mysql_query("SELECT * FROM line WHERE
    id_user='{$_SESSION[id_user]}'
     AND
    UNIX_TIMESTAMP(dt)!=0
        AND success=1
    ORDER
    BY dt
    DESC LIMIT 6");

    if ($access_days==0 AND mysql_num_rows($q)==0) {
        echo "<div style='text-align: center;margin-left: 25px;'>Если оплатить доступ и настроить аккаунт, то здесь отобразятся последние 6 лайков</div>";
    }
    if ( $access_days!=0 AND mysql_num_rows($q)==0) {
        echo "<div style='text-align: center;margin-left: 25px;'>Идёт процесс формирования очереди фотографий для простановки лайков. Этот роцесс занимает от минуты до часа. Пожалуйста возвращайтесь позже.</div>";
    }

    while ($r=mysql_fetch_array($q)) {
?>
<!-- ! -->
<a href="<?=$r[link]?>" class="photo" target="_blank">
<div class="overlay"></div>
<div class="pinfo">найдено по: <span>#<?=$r[tag]?></span><br />
                    поставлен: <?=date_format(date_create($r[dt]), 'd.m.Y H:i:s')?>
</div>
<img src="<?=$r[img]?>" width="190" height="190" />
</a>
<!-- End ! -->
<?
    }
?>
<div class="clear"></div>
</div>

</div>
<!-- End Последние лайки -->
</div>

</div>

<!-- Подвал -->
<div id="foot">
    <div class="wrap">
        <div id="foot-link">
            <a href="/dogovor">Договор публичной оферты</a>
            <a href="/help">Помощь</a>
        </div>

        <div id="copyright">Успешно работает с 2013 года © PAMANI</div>
    </div>
</div>
<!-- End Подвал -->


<!-- Оплата -->
<? include('profile-block-pay.php'); ?>
<!-- End Оплата -->


<!-- Настройки -->
<div id="options-win">
<div id="options-block">
<div class="close"></div>

<!-- Табы -->
<div id="tabs">
<div id="tab-navi">
    <div class="h-tab"><a href="#content1"><p class="hash"></p></a></div>
    <div class="h-tab"><a href="#content2"><p class="code"></p></a></div>
    <div class="h-tab"><a href="#content3"><p class="user"></p></a></div>
</div>

<div class="tabs_content">

<!-- Хештеги -->
<div id="content1" class="tb">
    <div class="tab-title">Хештеги (указывайте без решетки #)</div>
    <form method="post">
        <textarea name="tags" style="height:200px"><?=$tags?></textarea>

        <input type="submit" value="Сохранить хештеги" />
    </form>
</div>
<!-- End Хештеги -->

<!-- Код -->
<div id="content2" class="tb">
    <div class="tab-title">Код доступа (access_token)</div>
    <form method="post">
        <input name="access_token" type="text" value="<?=$access_token?>" style="text-align: center" autofocus />
        <div class="tab-link"><a href="/faq">Как получить код доступа?</a></div>

        <input type="submit" value="Сохранить код доступа" />
    </form>
</div>
<!-- End Код -->

<!-- Юзер -->
<div id="content3" class="tb">
    <div class="tab-title">Личные настройки</div>
        <b>Email аккаунта:</b> <?=$_SESSION[email]?> <a href="/profile-email.php">изменить</a><br /><br />
        <b>Пароль аккаунта:</b> ********* <a href="/profile-pass.php">изменить</a>
        <!--<label>Изменить E-mail:</label>
        <input name="email" type="text" value="tester@test.ru" />

        <label>Изменить пароль:</label>
        <input name="password" type="password" value="*************" />

        <input type="submit" value="Сохранить изменения" />-->
</div>
<!-- End Юзер -->
</div>
</div>
<!-- End Табы -->

</div>
</div>
<!-- End Настройки -->
</body>
</html>