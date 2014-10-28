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

    $q = mysql_query("SELECT * FROM users WHERE access>0 AND access_token!='' AND block=0"); //ANDid_user='879930883'

    while ($result = mysql_fetch_array($q)){
        //if (rand(1,3)>2) continue;
        $id_user = $result[id_user];
        $counter = $result[counter];
        $access_token = $result[access_token];
        //echo $id_user.'<br />';
        //$instagram->setAccessToken('401152790.5831bd8.c73e2aa8e73640128cffc94299b0890b');
        $instagram->setAccessToken($access_token);


        $instagram->setIp($result[ip]);

        $qq = mysql_query("SELECT * FROM line WHERE id_user='$id_user' AND success=0 AND fail=0 AND UNIX_TIMESTAMP(dt)
        =0 LIMIT 1");

        $result_in = mysql_fetch_array($qq);
        //while ($result_in = mysql_fetch_array($qq)) {
		if ($result_in) {
            $id_media = $result_in['id_media'];
            $id_line = $result_in['id_line'];
            $result = $instagram->likeMedia($id_media);
            echo '<br /><br />'.$id_user;
            //echo $id_media.'<br />';
            //echo $id_line.'<br />';
            print_r($result);
            if ($result->meta->code === 200) {
                //echo 'Success! The image was added to your likes.<br />';
                //file_put_contents("like_log.txt", '+'.$id_user.'\r\n', FILE_APPEND | LOCK_EX);

                $link->query("UPDATE users SET counter_success=counter_success+1 WHERE id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();

                $link->query("UPDATE line SET success=1, dt=NOW() WHERE id_line='$id_line' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();

                //$qq = mysql_query("UPDATE users SET counter_success=counter_success+1 WHERE id_user='$id_user' LIMIT 1");
				//$qq = mysql_query("UPDATE line SET done=1,date=NOW() WHERE id_media='$id_media' LIMIT 1");
            } else {
                //echo 'Something went wrong :(<br />';
                //file_put_contents("like_log.txt", '-'.$id_user.'\r\n', FILE_APPEND | LOCK_EX);

                $link->query("UPDATE users SET counter_fail=counter_fail+1 WHERE id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();

                $link->query("UPDATE line SET fail=1, dt=NOW() WHERE id_line='$id_line' LIMIT 1", MYSQLI_ASYNC);
                $link->reap_async_query();

                $error_type = $result->meta->error_type;
                if ($error_type=='OAuthParameterException' OR $error_type=='OAuthClientException') {
                    $link->query("UPDATE users SET block='1' WHERE id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
                    $link->reap_async_query();
                    //echo 'block<br />';
                }
				//$qq = mysql_query("UPDATE users SET counter_fail=counter_fail+1 WHERE id_user='$id_user' LIMIT 1");
                //echo $result->meta->error_type.'<br />';
                //echo $result->meta->code.'<br />';
                //echo $result->meta->error_message.'<br /><br />';
            }
        }

        $link->query("UPDATE users SET counter=counter+1 WHERE id_user='$id_user' LIMIT 1", MYSQLI_ASYNC);
        $link->reap_async_query();
        //$qq = mysql_query("UPDATE users SET counter=counter+1 WHERE id_user='$id_user' LIMIT 1");
    }
