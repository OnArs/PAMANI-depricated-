<?
include('config.php');
session_start();

/* Проверка наличия сессии start */
if (!$_SESSION[id_user]){
    header("Location: /");
}
/* Проверка наличия сессии end */

if ($_GET) {
    $id_user = $_GET[id_user];

    $q = mysql_query("SELECT * FROM users WHERE id_user='{$id_user}' AND email='{$_SESSION[email]}' LIMIT 1");
    $r = mysql_fetch_array($q);

    if ($r) {
        if ($r[email]==$_SESSION[email]) {
            $_SESSION[id_user] = $r[id_user];
            include('session.destroy.php');
        }

        header("Location: /profile");
    } else {
        header("Location: /profile");
    }
}
?>