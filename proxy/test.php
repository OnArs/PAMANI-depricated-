<?php

    $document_root = '/var/www/pamani/pamani.ru';
    include($document_root.'/cron/config.php');

    // get random id_media
    $q = mysql_query("SELECT * FROM line WHERE UNIX_TIMESTAMP(dt)=0 AND id_user=110 ORDER BY RAND() LIMIT 1");
    $r = mysql_fetch_array($q);

    //echo $id_media = '745024597765196314_506178649';
    echo $id_media = $r['id_media'];

    // get next proxy
    $q = mysql_query("SELECT * FROM proxy ORDER BY sort");
    $r = mysql_fetch_array($q);

    //print_r($r);

    //$token = '1284396959.c52ae59.d2816c0d29b3442b95e1526af69e6374';
    //$token = '879930883.c52ae59.d314f4e7d1eb4ff08ed4d6436cb60262';
    $token = '879930883.3b02869.4a788bf697bf41969d01fe672a17d274';

    //echo $r[ip];
    //$r[ip] = '141.8.192.181';
    $client_secret = '57c5fb260f944b1fbdf4d1d1c0dc7ce2';
    $signature = (hash_hmac('sha256', $r[ip], $client_secret, false));
    $header = join('|', array($r[ip], $signature));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/media/'.$id_media.'/likes');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'access_token='.$token);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        "X-Insta-Forwarded-For: {$header}"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    //curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
    //curl_setopt($ch, CURLOPT_PROXY, "23.27.239.205:29842");
    //curl_setopt($ch, CURLOPT_PROXY, trim($proxy[0]));
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, "aibragim:VLgpcmMq");
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, trim($proxy[1]));
    //curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
    //curl_setopt($ch, CURLOPT_PROXY, $r[ip].":".$r[port]);
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $r[login].":".$r[pass]);

echo curl_exec($ch);
    $jsonData = json_decode(curl_exec($ch));

    if (false === $jsonData) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    print_r($jsonData);
    /*
    if ($jsonData->meta->code == 200) { $status=1; } else { $status=0; };

    mysql_query("UPDATE proxy SET status='{$status}', sort=sort+1
                    WHERE id_proxy='{$r[id_proxy]}' LIMIT 1");


    if ($r[status]==$status AND $status==0) {
        mysql_query("UPDATE proxy SET rept=rept+1 WHERE id_proxy='{$r[id_proxy]}' LIMIT 1");
    } else {
        mysql_query("UPDATE proxy SET rept=0 WHERE id_proxy='{$r[id_proxy]}' LIMIT 1");
    }

    if ($status==1){
        $r[port] = trim($r[port]);
        file_put_contents($document_root.'/proxy/proxy.txt',"{$r[ip]}:{$r[port]}\n{$r[login]}:{$r[pass]}");
    }
    echo $status;
    */
?>