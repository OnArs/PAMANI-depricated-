<?php

include('/var/www/pamani/pamani.ru/instagram.class.php');

$db = mysql_connect('localhost','ibragimov_cline','cline');
mysql_select_db('ibragimov_inst',$db);
mysql_query("SET NAMES 'utf8'");

$link = new mysqli(
    'localhost',
    'ibragimov_cline',
    'cline',
    'ibragimov_inst'
);

$instagram = new Instagram(array(
    'apiKey'      => '797152b131f84407a80a611317201127',
    'apiSecret'   => 'a7336c2900934c4388b03a13403da186',
    'apiCallback' => 'http://habr.ru/login.php'
));

$q = mysql_query("SELECT * FROM users WHERE access>0 AND access_token!='' AND tags!='' ORDER BY RAND()
LIMIT 1");
while ($result = mysql_fetch_array($q)){
    $tags = explode("\r\n",$result[tags]);
	$tags = array_diff($tags, array('',' ','   ',0,null));
    print_r($tags);

    $tags   = array('россия','москва','спб','мск','питер','фото','я','любовь','еда','город','дом','красота','красиво','девушка','кот');
    $tag    = trim($tags[rand(0,count($tags)-1)]);
    $medias = $instagram->getRecentMediaByTag($tag);
    //print_r($medias);
    echo "INSERT INTO line (id_media, link, img, tag, id_user, feed)
                         VALUE ('{$media->id}', '{$media->link}', '{$media->images->low_resolution->url}', '0',
                         {$result[id_user]}', '1')";
	//echo trim($tags[rand(0,count($tags)-1)]);

    //echo $result[id_user].'<br />';
    echo 2;
}
echo 1;