<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 02/12/13
 * Time: 00:00
 */

include('/var/www/pamani/pamani.ru/instagram.class.php');

$db = mysql_connect('85.25.99.79','pamani_pam','inst');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");

$link = new mysqli( 
    '85.25.99.79',
    'pamani_pam',
    'inst',
    'pamani_pam'
);
$link->set_charset("utf8");

$instagram = new Instagram(array(
    'apiKey'      => '3b0286915f864165bc251c80309e9f39',
    'apiSecret'   => '5887a30b71db4e95b43485ea58640170',
    'apiCallback' => 'http://nextpls.me/login.php'
));

$q = mysql_query("SELECT * FROM users WHERE access>0 AND tags!='' AND instapass!='' ");
//$q = mysql_query("SELECT * FROM users WHERE access>0 AND tags!='' AND id_user=110");
while ($result = mysql_fetch_array($q)){
    $tags = explode("\r\n",$result[tags]);
    $tags = array_diff($tags, array('',' ','   ',0,null));
    //print_r($tags);

    //$tags = array('россия','москва','спб','мск','питер','фото','я','любовь','еда','город','дом','красота','красиво','девушка','кот');
    $tag = trim($tags[rand(0,count($tags)-1)]);
    $medias = $instagram->getRecentMediaByTag($tag);

    //echo $result[id_user].'<br />';
    foreach ($medias->data as $media){
        //$media_ids[] = $media->id;
        //print_r($media); //die();

        $explode = explode("_",$media->id);
        $id_media_short = $explode[0];

        $link->query("INSERT INTO line (id_media, id_media_short, link, img, tag, id_user)
                                    VALUE ('{$media->id}','{$id_media_short}','{$media->link}','{$media->images->low_resolution->url}','{$tag}','{$result[id_user]}')",
            MYSQLI_ASYNC);
        $link->reap_async_query();

        //$query = mysql_query("INSERT INTO line (id_media, img, tag, id_user)
        //                            VALUE ('{$media->id}','{$media->images->low_resolution->url}','{$tag}','{$result[id_user]}')");
    }
}

//print_r($medias);
//print_r($media_ids);
