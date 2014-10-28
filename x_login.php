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

$instagram = new Instagram(array(
    'apiKey'      => 'c42d78c753c8486783f2c4a02c5921ab',
    'apiSecret'   => '782f86c6c9eb40c2a5fa79a024a753da',
    'apiCallback' => 'http://pamani.ru/login.php'
));

// Receive OAuth code parameter
$code = $_GET['code'];

// Check whether the user has granted access
if (true === isset($code)) {

    // Receive OAuth token object
    $data = $instagram->getOAuthToken($code);

	$tags_default = 'спб\r\nпитер\r\nмск\r\nмосква\r\nроссия\r\nмода\r\nстиль\r\nfollow\r\nfun\r\nlove';
    $_SESSION[access_token] = $data->access_token;
    $_SESSION[username] = $data->user->username;
    $_SESSION[id] = $data->user->id;
    $_SESSION[profile_picture] = $data->user->profile_picture;
    $_SESSION[id_aff] = (rand(1,2)==1?$_SESSION[id_aff]:0);

    $q = mysql_query("SELECT * FROM users WHERE id_user='{$data->user->id}' LIMIT 1");
    $result = mysql_fetch_array($q);

    if (!$result){
        $q = mysql_query("INSERT INTO users (id_user,user_name,access_token,tags,access,counter,id_aff,registered,actived)
                            VALUE ('{$data->user->id}','{$data->user->username}','{$data->access_token}','{$tags_default}','0','0','{$_SESSION[id_aff]}',NOW(),NOW())");
    } else {
        $q = mysql_query("UPDATE users 
							SET user_name='{$data->user->username}',access_token='{$data->access_token}',actived=NOW()
							WHERE id_user='{$data->user->id}'
							LIMIT 1");
    }

    header('Location: /profile.php');

} else {
    if (true === isset($_GET['error'])) {
        echo 'An error occurred: '.$_GET['error_description'];
    }
}

?>