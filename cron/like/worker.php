<?php
ini_set('display_errors', true);
error_reporting(7);
set_time_limit(0);

define('APP', dirname(__FILE__) .'/'); // используется в подключаемых файлах
include APP .'rollingcurl.php';
include APP .'instagram.php';

$id_worker = rand(1,4);

$db = mysql_connect('85.25.99.79','pamani_pam','inst');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");

$in = new Instagram();

$id_user = $argv[1];
$username = $argv[2];
$instapass = $argv[3];
$id_line = $argv[4];
$id_media_short = $argv[5];
$count = $argv[6];

$result = $in->lister(array($id_user,$username,$instapass), 'http://instagram.com/web/likes/'.$id_media_short.'/like/',' ');
if (substr_count($result,'{"status":"ok"}')>0){

    $users_success .= $id_user.',';
    $lines_success .= $id_line.',';

} else {

    $users_fail .= $id_user.',';
    $lines_fail .= $id_line.',';

    if (substr_count($result,'checkpoint_url')>0){
        $users_block .= $id_user.',';
    }

}



$users_success = mb_substr($users_success, 0, -1);
$lines_success = mb_substr($lines_success, 0, -1);
$users_fail = mb_substr($users_fail, 0, -1);
$lines_fail = mb_substr($lines_fail, 0, -1);
$users_block = mb_substr($users_block, 0, -1);


mysql_query("UPDATE users SET block=2 WHERE id_user IN ({$users_block})");

mysql_query("UPDATE users SET counter=counter+1, counter_success=counter_success+1 WHERE id_user IN ({$users_success})");
mysql_query("UPDATE users SET counter=counter+1, counter_fail=counter_fail+1 WHERE id_user IN ({$users_fail})");

mysql_query("UPDATE line SET success=1, dt=NOW() WHERE id_line IN ({$lines_success})");
mysql_query("UPDATE line SET fail=1, dt=NOW() WHERE id_line IN ({$lines_fail})");

mysql_close($db);


//@file_put_contents('/var/www/pamani/pamani.ru/log_runner.txt', '['.date("d-m-y H:i:s").'] ['.$count.'] '.$argv[1]. PHP_EOL, FILE_APPEND);
