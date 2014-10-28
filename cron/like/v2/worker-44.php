<?php
//ini_set('display_errors', true);
//error_reporting(7);
//set_time_limit(0);

define('APP', dirname(__FILE__) .'/'); // используется в подключаемых файлах
include APP .'rollingcurl.php';
include APP .'instagram.php';

$id_worker = 4;
$limit = ($id_worker*150)-150;

$db = mysql_connect('localhost','pamani_likew'.$id_worker.'-1','likew'.$id_worker.'-1');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");

$in = new Instagram();

$q = mysql_query("SELECT COUNT(*) as count FROM users WHERE access>0 AND block=0 AND username!='' AND instapass!=''");
$r = mysql_fetch_array($q);
$users_count = $r[count];

mysql_query("INSERT INTO log VALUE (NUll,'{$id_worker}','0','{$users_count}',NOW())");
$id_log = mysql_insert_id();

$q = mysql_query("
SELECT
    users.id_user as id_user,
    users.username as username,
    users.instapass as instapass,
    line.id_line as id_line,
    line.id_media_short as id_media_short
FROM users
LEFT JOIN line ON line.id_user=users.id_user
WHERE users.access>0 AND users.block=0 AND users.username!='' AND line.success=0 AND line.fail=0
GROUP BY line.id_user
LIMIT {$limit}, 150
");

while ($r = mysql_fetch_array($q)){

    $id_user = $r[id_user];
    $username = $r[username];
    $instapass = $r[instapass];
    $id_line = $r[id_line];
    $id_media_short = $r[id_media_short];

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

mysql_query("UPDATE log SET users_done=150 WHERE id_log='{$id_log}' LIMIT 1");

mysql_close($db);