<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>PAMANI | Личный кабинет</title>
    <meta charset="utf-8">
    <link media="screen" href="/style/profile-beta.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/landing.js"></script>
    <style>
        .answer img {
            max-width: 560px;
            border: 1px #d9e1e6 solid;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div id="logo" style="float:none;margin:0 auto"></div>
    <a href="/profile" class="link2">← Вернуться в аккаунт</a>

    <!-- ! -->
    <div class="question">Получаем access_token (код доступа)</div>
    <div class="answer">

        Внимание! Если ранее Вы уже проделывали эти действия с сервисом pictacular.co или statigr.am или webstagr.am или iconosquare.com - не переживайте. Просто инструкция обновилась и теперь все шаги инструкции необходимо делать с новым сервисом.
        <br /><br /><br />
        Технические требования: Для получения кода доступа необходимо использовать стационарный компьютер или ноутбук с браузером Google Chrome или Mozilla Firefox. Мобильные устройства не позволяют получить код доступа.
        <br /><br /><br />

    1. Перейдите по адресу <a href="https://apigee.com/console/instagram" target="_blank">https://apigee.com/console/instagram</a><br /><br />
    2. В верхней части страницы в блоке "Authentication" нажмите на кнопку “No Auth” или "instagram-AuthenicatedUser" и в выпадающем списке
        выберите
        пункт "OAuth 2":
        <div style="text-align: center"><img src="/images/faq/2-2.png" /></div>
        <div style="text-align: center"><img src="/images/faq/2-1.png" /></div>
        <br /><br /><br />
        если появляется следующее окно то, жмём на кнопку "Sign in with Instagram"
        <br />
        <div style="text-align: center"><img src="/images/faq/2-3.png" /></div>
        <br /><br /><br />
    3. Если Вы не видите следующее окно, то перейдите к следующему шагу. Если видите следующее окно то введите в нём Ваш логин и пароль от Вашего инстаграм аккаунта и нажмите на зелёную кнопку “Log in”
        <div style="text-align: center"><img src="/images/faq/3.png" /></div>
        <br /><br /><br />

    4. Если Вы не видите следующее окно, то перейдите к следующему шагу. Если Вы ввели данные от аккаунта верно, то должны уже видеть следующее окно здесь просто жмём на зелёную кнопку “Authorize”.
        <div style="text-align: center"><img src="/images/faq/4.png" /></div>
        <br /><br /><br />

    5. Закрываем сайт (вкладку) apigee.com
        <!--<div style="text-align: center"><img src="/images/faq/5.png" /></div>-->
        <br /><br /><br />

    6. Теперь переходим на официальный сайт социальной сети <a href="http://instagram.com"
                                                               target="_blank">http://instagram.com</a>. Если
        необходимо то войдите, нажав на кнопку "Log in" с использованием логина и пароля от своего инстаграма.
        <br /><br /><br />

    7. В правой верхней части интерфейса Вы должны видеть маленькое изображение со своей аватаркой и рядом написанный Ваш логин от инстаграма. У меня это выглядит как на следующем рисунке. Сначала кликаем на свою аватарку, затем кликаем на “Edit profile”.
        <div style="text-align: center"><img src="/images/faq/7.png" /></div>
        <br /><br />

    8. В появившемся окне в колонке слева жмём на “Manage Applications”
        <div style="text-align: center"> <img src="http://i.imgur.com/oUentrB.png" /></div>
        <br /><br />
        Сейчас Вы должны видеть примерно следующее. Важно чтобы на странице был блок с заголовком "Apigee API Console" как на картинке ниже. Если такого блока нет - Вы что то сделали не правильно на предыдущих пунктах. Начните сначала.<br />
        <div style="text-align: center"><img src="/images/faq/8-2.png" /></div>
        <br /><br /><br />

    9. В появившемся окне в любом пустом месте интерфейса жмём правой кнопкой мыши и в появившемся контекстном меню выбираем строчку вроде “Показать исходный код страницы”. Во всех браузерах эта строка может называться по разному, но сути дела это не меняет
        <div style="text-align: center"><img src="http://i.imgur.com/Xd8NcEX.png" /></div>
        <div style="text-align: center;margin-top: 15px;">или так</div>
        <div style="text-align: center"><img src="http://i.imgur.com/owKcgHg.png" /></div>
        <br /><br /><br />

    10. Если Вы видите что-то вроде этого, то всё сделали правильно:
        <div style="text-align: center"><img src="http://img811.imageshack.us/img811/3530/etov.png" /></div>
        <br /><br /><br />

    11. Теперь на этой странице нажимаем сочетание клавиш “Ctrl + F” для Windows или “CMD + F” для устройств Apple. Должна появится строчка поиска (либо в правом верхнем углу браузера, либо в левом нижнем). В неё вбиваем слово “apigee”
        <div style="text-align: center"><img src="/images/faq/11-1.png" /></div>
        <div style="text-align: center;margin-top: 15px;">или такая строка</div>
        <div style="text-align: center"><img src="/images/faq/11-2.png" /></div>
        <br /><br /><br />

    12. Поиск по странице должен найти следующий кусок кода. Рядом с подсвеченным словом “apigee” Вы увидите Ваш access_token (код доступа). Скопируйте (запишите или сохраните) его и можете закрывать все лишние окна,
        кроме окна сервиса PAMANI. Не копируйте ковычки, пробелы и другие элементы. Только сам код,
        как указано на примере ниже.
        <div style="text-align: center"><img src="/images/faq/12.png" /></div>
        <br /><br /><br />

    13. Скопированный код укажите (вставьте) в настройках Вашего личного кабинета сервиса PAMANI. Сохраните настройки. Сервис начнёт ставить лайки автоматически в течении 30 минут.
        <br /><br /><br />
    </div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>