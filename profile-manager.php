<?
    session_start();

    include('config.php');

    /* Проверка наличия сессии start */
    if (!$_SESSION[id_user]){
        header("Location: /");
    }
    /* Проверка наличия сессии end */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<title>PAMANI | Менеджер аккаунтов</title>
<meta charset="utf-8">
<link media="screen" href="/style/profile-beta.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/profile.js"></script>
</head>
<body>
<div class="wrap">
<div id="logo" style="float:none;margin:0 auto 55px"></div>

<?
    $q = mysql_query("SELECT * FROM users WHERE email='{$_SESSION['email']}'");
    while ($r = mysql_fetch_array($q)){
        if ($r[id_user]!=0)
        $qq = mysql_query("SELECT SUM(counter) as sum FROM history WHERE id_user='{$r[id_user]}' ");
        $rr = mysql_fetch_array($qq);

        $total_likes = number_format($rr[sum]+$r[counter_success],0,'.',' ');
?>
<!-- ! -->
<div class="account">
<div class="acc-avatar"><img src="<?=($r[photo]?$r[photo]:'/images/noavatar.png')?>" width="110" height="110" /></div>

<ul class="acc-info">
<li><span>Логин:</span> <?=$r[username]?></li>
<li><span>ID:</span> #<?=$r[id_user]?></li>
<li><span>Статус:</span> <span class="status-on"><?=($r[block]==0?"активен":"заблокирован")?></span></li>
<li><span>Баланс:</span> <?=$r[access]?> дней</li>
</ul>

<div class="acc-like">
<div class="acc-day-likes"><p><?=$r[counter_success]?></p> лайков сегодня</div>
<div class="acc-all-likes"><p><?=$total_likes?></p> лайков поставлено</div>
</div>

<a href="/profile-change.php?id_user=<?=$r[id_user]?>" class="go-to">перейти к акккаунту</a>
</div>
<!-- End ! -->
<?
}
?>


<a href="/profile-add-new.php" class="acc-add">Добавить еще один аккаунт <span>+</span></a>



</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>