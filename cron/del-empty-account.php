<?php

include('/var/www/pamani/pamani.ru/cron/config.php');


$q = mysql_query("SELECT * FROM users WHERE p_first=0 AND email!='' ORDER BY email");

while ($r = mysql_fetch_array($q)) {

    //echo "{$r[email]} {$r[id_user]}<br />";

    /*
    $qq = mysql_query("SELECT * FROM users WHERE email='{$r[email]}' AND p_first=1");
    $rr = mysql_fetch_array($qq);

    if ($rr)
        echo "-- {$rr[email]} {$rr[id_user]}<br />";
    */

    $qqq = mysql_query("DELETE FROM users WHERE email='{$r[email]}' AND id_user!='{$r[id_user]}' AND p_first=1");

}


?>