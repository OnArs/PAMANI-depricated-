<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 08/12/13
 * Time: 18:50
 */

error_reporting(E_ALL);
include('/var/www/pamani/pamani.ru/instagram.class.php');
include('/var/www/pamani/pamani.ru/cron/config.php');

$instagram = new Instagram(array(
    'apiKey'      => '797152b131f84407a80a611317201127',
    'apiSecret'   => 'a7336c2900934c4388b03a13403da186',
    'apiCallback' => 'http://habr.ru/login.php'
));

$q = mysql_query("SELECT * FROM users WHERE access>0");
while ($r = mysql_fetch_array($q)) {
    //print_r($r);

    $instagram->setAccessToken($r[access_token]);
    $data = $instagram->getUser($r[id_instagram]);

    //print_r($data);


    $access = $r[access];
    $counter = $r[counter];
    $counter_success = $r[counter_success];
    $counter_fail = $r[counter_fail];
    $media = $data->data->counts->media;
    $follows = $data->data->counts->follows;
    $followed_by = $data->data->counts->followed_by;


    $qq = mysql_query("INSERT INTO history (id_history,id_user,media,follows,followed_by,access,counter,counter_success,counter_fail,date)
                        VALUE (NULL,'{$r[id_user]}','$media','$follows','$followed_by','$access','$counter','$counter_success','$counter_fail',NOW())");
}

$q = mysql_query("UPDATE users SET access=access-1 WHERE access>0");
$q = mysql_query("UPDATE users SET counter=0, counter_success=0, counter_fail=0");
$q = mysql_query("TRUNCATE TABLE line");
