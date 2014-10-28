<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 02/12/13
 * Time: 00:00
 */
//error_reporting(E_ALL);
include('/var/www/pamani/pamani.ru/instagram.class.php');

$db = mysql_connect('localhost','ibragimov_clike','clike');
mysql_select_db('ibragimov_inst',$db);
mysql_query("SET NAMES 'utf8'");

$link = new mysqli(
    'localhost',
    'ibragimov_clike',
    'clike',
    'ibragimov_inst'
);

$instagram = new Instagram(array(
    'apiKey'      => 'c42d78c753c8486783f2c4a02c5921ab',
    'apiSecret'   => '782f86c6c9eb40c2a5fa79a024a753da',
    'apiCallback' => 'http://pamani.ru/login.php'
));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>PAMANI | Инстаграм бот онлайн</title>
    <meta charset="utf-8">
    <link media="screen" href="/style/style.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/landing.js"></script>
    <meta name='yandex-verification' content='72bc63943ced6337' />
</head>
<body>
<form method="POST">
    <input type="text" name="access_token" value="<?=($_POST['access_token']?$_POST['access_token']:'1284396959.b59fbe4.4798bfc78bcf4cf18e3436ea8b14293a')?>" style="width:100%;" />
</form>

<?
if ($_POST){
    $instagram->setAccessToken($_POST['access_token']);

    $q = mysql_query("SELECT * FROM line WHERE UNIX_TIMESTAMP(dt)=0 AND id_user=110 ORDER BY RAND() LIMIT 1");
    $r = mysql_fetch_array($q);

    print_r($r);

    $id_media = $r['id_media'];
    $result = $instagram->likeMedia($id_media);

    print_r($result);
}
?>