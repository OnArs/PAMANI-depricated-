<?php
ini_set('display_errors', true);
error_reporting(7);
set_time_limit(0);

define('APP', dirname(__FILE__) .'/');
//unlink('/var/www/pamani/pamani.ru/log_runner.txt');

$db = mysql_connect('85.25.99.79','pamani_pam','inst');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");

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
");

$count = 0;
while ($r = mysql_fetch_array($q)){
    $count++;

    $id_user = $r[id_user];
    $username = $r[username];
    $instapass = $r[instapass];
    $id_line = $r[id_line];
    $id_media_short = $r[id_media_short];

    exec("/usr/local/bin/php -f /var/www/pamani/pamani.ru/cron/like/worker.php {$id_user} {$username} {$instapass} {$id_line} {$id_media_short} {$count} > /dev/null 2>/dev/null &");
}

mysql_close($db);