<?php
//ini_set('display_errors', true);
//error_reporting(7);
//set_time_limit(0);

define('APP', dirname(__FILE__) .'/'); // используется в подключаемых файлах
include APP . 'rollingcurl.php';
include APP . 'instagram.php';

$id_worker = 4;
$limit = ($id_worker*150)-150;

$db = mysql_connect('localhost','pamani_likew'.$id_worker.'-1','likew'.$id_worker.'-1');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");

$link = new mysqli(
    'localhost',
    'pamani_likew'.$id_worker.'-2',
    'likew'.$id_worker.'-2',
    'pamani_pam'
);


$in = new Instagram();

$q = mysql_query("SELECT COUNT(*) as count FROM users WHERE access>0 AND block=0 AND username!='' AND instapass!=''");
$r = mysql_fetch_array($q);
$users_count = $r[count];


$q = mysql_query("INSERT INTO log VALUE (NUll,'{$id_worker}','0','{$users_count}',NOW())");
$id_log = mysql_insert_id();


$q = mysql_query("SELECT * FROM users WHERE access>0 AND block=0 AND username!='' AND instapass!='' LIMIT ".$limit.", 150");

while ($r = mysql_fetch_array($q)){

    $log_update = mysql_query("UPDATE log SET users_done=users_done+1 WHERE id_log='{$id_log}' LIMIT 1");

    $id_user = $r[id_user];
    $username = $r[username];
    $instapass = $r[instapass];

    $qq = mysql_query("SELECT * FROM line
                        WHERE id_user='{$id_user}' AND success=0 AND fail=0 AND UNIX_TIMESTAMP(dt)=0 LIMIT 1");
    $rr = mysql_fetch_array($qq);

    if ($rr){
        $id_line = $rr[id_line];
        $id_media_short = $rr[id_media_short];

        $result = $in->lister(array($id_user,$username,$instapass), 'http://instagram.com/web/likes/'.$id_media_short.'/like/',' ');
        if (substr_count($result,'{"status":"ok"}')>0){

            $link->query("UPDATE users SET counter=counter+1, counter_success=counter_success+1 WHERE
            id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

            $link->query("UPDATE line SET success=1, dt=NOW() WHERE id_line='$id_line' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

        } else {

            $link->query("UPDATE users SET counter=counter+1, counter_fail=counter_fail+1 WHERE id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

            $link->query("UPDATE line SET fail=1, dt=NOW() WHERE id_line='$id_line' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

            if (substr_count($result,'checkpoint_url')>0){
                $link->query("UPDATE users SET block='2' WHERE id_user='{$id_user}' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();
            }

        }
    }

}