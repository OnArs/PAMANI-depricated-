<?php
ini_set('display_errors', true);
error_reporting(7);
set_time_limit(0);

define('APP', dirname(__FILE__) .'/');

include('/var/www/pamani/pamani.ru/test/rollingcurl.php');
include('/var/www/pamani/pamani.ru/test/instagram.php');
//include APP .'rollingcurl.php';
//include APP .'instagram.php';


$db = mysql_connect('localhost','ibragimov_clike3','clike3');
mysql_select_db('ibragimov_inst',$db);
mysql_query("SET NAMES 'utf8'");

$link = new mysqli(
    'localhost',
    'ibragimov_clike2',
    'clike2',
    'ibragimov_inst'
);


$in = new Instagram();


$q = mysql_query("SELECT * FROM users WHERE id_user=110 LIMIT 1");

while ($r = mysql_fetch_array($q)){

    $id_user = $r[id_user];
    $username = $r[username];
    $instapass = $r[instapass];

    $qq = mysql_query("SELECT * FROM line
                        WHERE id_user='{$id_user}' AND success=0 AND fail=0 AND UNIX_TIMESTAMP(dt)=0 LIMIT 1");
    $rr = mysql_fetch_array($qq);
    print_r($rr);
    if ($rr){
        $id_line = $rr[id_line];
        $id_media_short = $rr[id_media_short];

        $result = $in->lister(array($id_user,$username,$instapass), 'http://instagram.com/web/likes/'.$id_media_short.'/like/',' ');
        //echo 1;
        echo $result;
        if (substr_count($result,'{"status":"ok"}')>0){

            //@file_put_contents('/var/www/pamani/pamani.ru/test/local/error_log_success.txt', '['. date("d-m-y H:i:s") .'] '. $result . PHP_EOL, FILE_APPEND);

            $link->query("UPDATE users SET counter=counter+1, counter_success=counter_success+1 WHERE
            id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

            $link->query("UPDATE line SET success=1, dt=NOW() WHERE id_line='$id_line' LIMIT 1", MYSQLI_ASYNC);
            $link->reap_async_query();

            //die();

        } else {

            //@file_put_contents('/var/www/pamani/pamani.ru/test/local/error_log_fail.txt',
            //    '['. date("d-m-y H:i:s") .'] id:' . $id_user.' '. $result . PHP_EOL, FILE_APPEND);

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