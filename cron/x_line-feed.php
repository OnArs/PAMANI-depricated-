<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 02/12/13
 * Time: 00:00
 */

include('/var/www/pamani/pamani.ru/instagram.class.php');
include('/var/www/pamani/pamani.ru/cron/config.php');

$link = new mysqli(
    'localhost',
    'ibragimov_instc',
    'instc',
    'ibragimov_inst'
);

$instagram = new Instagram(array(
    'apiKey'      => 'c42d78c753c8486783f2c4a02c5921ab',
    'apiSecret'   => '782f86c6c9eb40c2a5fa79a024a753da',
    'apiCallback' => 'http://pamani.ru/login.php'
));

$q = mysql_query("SELECT * FROM users WHERE access>0 AND access_token!='' AND opt_feed=1");
while ($result = mysql_fetch_array($q)){
	$instagram->setAccessToken($result[access_token]);
	
	$result_api = $instagram->getUserFeed();

	foreach($result_api->data as $media){
        //print_r($media);
        $link->query("INSERT INTO line (id_media, link, img, tag, id_user, feed)
                         VALUE ('{$media->id}', '{$media->link}', '{$media->images->low_resolution->url}', '0',
                         {$result[id_user]}', '1')",
                     MYSQLI_ASYNC);
        $link->reap_async_query();

		//$query = mysql_query("INSERT INTO line (id_media, id_user, feed) VALUE ('{$media->id}','{$result[id_user]}', '1')");
		//echo $media->id;
	}
}