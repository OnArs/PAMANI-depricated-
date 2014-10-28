<?php
/**
 * Created by PhpStorm.
 * User: ibragimovme
 * Date: 01/12/13
 * Time: 18:21
 */

session_start();

if ($_GET[id_aff]){
	$_SESSION[id_aff]=$_GET[id_aff];
	header('Location: /');
}

if ($_GET['exit']) { session_destroy(); header('Location: /'); }
 
$db = mysql_connect('85.25.99.79','pamani_pam','inst');
mysql_select_db('pamani_pam',$db);
mysql_query("SET NAMES 'utf8'");


$q = mysql_query("SELECT COUNT(*) count FROM users WHERE DATE(registered)=DATE(NOW())");
$r = mysql_fetch_array($q);

$users_today = $r[count];


$q = mysql_query("SELECT COUNT(*) count, SUM(counter) counter FROM users");
$r = mysql_fetch_array($q);

$like_today = $r[counter];
$users_all = $r[count];


$q = mysql_query("SELECT SUM(counter) counter FROM history");
$r = mysql_fetch_array($q);

$like_all = $r[counter]+$like_today;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>PAMANI | Инстаграм бот онлайн</title>
	<meta charset="utf-8">
	<link media="screen" href="/style/style.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/landing.js"></script>
    <meta name='yandex-verification' content='72bc63943ced6337' />
</head>
<body>
<div style="display: none; background: none repeat scroll 0% 0% rgb(192, 57, 43); color: rgb(255, 255, 255); text-align: center; font-size: 15px; padding: 10px 0px;"> ВНИМАНИЕ! Наблюдается техническая проблема с входом и регистрацией. Сервис продолжает ставить лайки. Проблема будет решена до 22:00 23.04.2014 МСК.</div>
<!-- Меню -->
<div id="menu_body">
<div id="menu">
	<a href="" id="logo"></a>
	<p id="utp">эффективное инстаграм продвижение</p>

	<ul id="menu-list">
		<li><a href="#advantages">Преимущества</a></li>
		<li><a href="#how">Как это работает</a></li>
		<li><a href="#business">Для бизнеса и людей</a></li>
	</ul>
</div>
</div>
<!-- End Меню -->

<!-- Шапка -->
<div id="head_body">
	<div id="head">
		<a href="/login" id="registr">Войти в аккаунт</a>
		<a href="/reg" id="login">Регистрация</a>
		<div class="clear"></div>

		<div id="pamani">
			<a name="that"></a>
			<div id="that">Что такое pamani.ru?</div>
			<p>Это онлайн сервис, который автоматизирует раскрутку 
			(продвижение) аккаунта в социальной сети instagram.com. </p>
			<p>Такие программы ещё называют ботами и роботами.<br />
			Так что что можно смело сказать, что pamani.ru - это “бот” 
			для продвижения в инстаграме.</p>
		</div>
	</div>
</div>
<!-- End Шапка -->

<!-- Доверие -->
<div class="wrap">
	<div id="trust">
	<div id="trust-title">Доверие и уверенность</div>
	<div id="tr1"><p><?=number_format($users_all,0,'',' ')?></p><span>пользователя<br /> сервиса</span></div>
	<div id="tr2"><p><?=number_format($like_all,0,'',' ')?></p><span>лайков за<br /> все время</span></div>
	<div id="tr3"><p><?=number_format($users_today,0,'',' ')?></p><span>зарегистрировались<br /> сегодня</span></div>
	<div id="tr4"><p><?=number_format($like_today,0,'',' ')?></p><span>лайков<br /> за сегодня</span></div>
	</div>
</div>
<!-- End Доверие -->

<!-- Интерфейс -->
<div id="slider_body">
<div id="slider">

<!-- 1 -->
<div class="slide">
<div class="slide-txt">
<div class="slide-title">Интерфейс личного кабинета</div>
<p>При первом входе в личный кабинет Вы можете настроить 
тематику и местоположение использую #хэштеги.</p>
<p>Так же Вы можете отслеживать полную статистику расхода 
средств и количества проставленных лайков.</p>
</div>
<img src="images/slider/slide-1.jpg" width="404" height="253" />
</div>

<!-- 2 -->
<div class="slide">
<div class="slide-txt">
<div class="slide-title">Интерфейс оплаты сервиса</div>
<p>При оплате сервиса Pamani.ru на 2 месяца и более, Вы получаете совершенно бесплатно дополнительные дни использования.</p>

</div>
<img src="images/slider/slide-2.jpg" width="404" height="253" />
</div>


</div>
</div>
<!-- End Интерфейс -->

<!-- Преимущества -->
<a name="advantages"></a>
<div class="wrap">
<div id="advant">
<div class="title"><span>В чем преимущество?</span></div>

<!-- ! -->
<div class="adv" style="width:960px">
<div class="image"><img src="images/adv-1.png" /></div>
<p style="width:860px"><span>Передовые технологии</span>
Pamani.ru - это новшество в сфере инстаграм раскрутки, так как до появления этого сервиса для продвижения аккаунта необходимо было пользоваться настольными программами для компьютеров. Это было не удобно, так как программу нужно было постоянно держать включенной. Ну и расходы на электричество конечно тоже не мало важны.
</p>
</div>
<div class="clear"></div>

<!-- ! -->
<div class="adv">
<div class="image"><img src="images/adv-2.png" /></div>
<p><span>Великолепная настраиваемость</span>
С помощью #хештегов можно задавать тематику (#мода, #спорт, #дом) и местоположение (#россия, #москва, #питер) интересующих Вас пользователей.
</p>
</div>

<!-- ! -->
<div class="adv" style="float:right">
<div class="image"><img src="images/adv-3.png" /></div>
<p><span>Простота использования</span>
Pamani.ru прост в использовании: у программы всего одна обязательная настройка с которой справляются даже маленькие школьники за пару минут.
</p>
</div>

<!-- ! -->
<div class="adv">
<div class="image"><img src="images/adv-4.png" /></div>
<p><span>Безопасность</span>
Алгоритм работы сервиса не превышает допустимые лимиты и ограничения установленные правилами социальной сети instagram.com.
</p>
</div>

<!-- ! -->
<div class="adv" style="float:right">
<div class="image"><img src="images/adv-5.png" /></div>
<p><span>Простота использования</span>
Всегда под рукой, так как работает на всех устройствах и операционных системах: iPhone, iPad, Andoroid, Mac, Windows, Linux. Пользуйтесь дома, в офисе, в отпуске, в пути или в кафе.
</p>
</div>
<div class="clear"></div>

</div>
</div>
<!-- End Преимущества -->

<!-- Как работает -->
<a name="how"></a>
<div id="how_body">
<div id="round"></div>
<div id="how-head"><div>

<div id="how">
<div class="title"><span>Как это работает?</span></div>
<div id="how-arr1"></div>
<div id="how-arr2"></div>
<div id="how-1">С помощью <span>#хештегов</span> Вы задаёте тематику<br /> (#мода...) и местоположение (#россия...)<br /> интересующих Вас пользователей.</div>
<div id="how-2">Специальная <span>программа "бот"</span><br /> лайкает фотографии по заданным<br /> Вами #хештегам.</div>
<div id="how-3">Людям это нравится, они на Вас<br /> <span>подписываются</span> и лайкают Ваши<br /> фотографии.</div>
</div>
</div>
<!-- End Как работает -->

<!-- Кому -->
<a name="business"></a><a name="people"></a>
<div class="wrap">
<div id="whom">
<div class="title"><span>Кому нужен?</span></div>
<div id="who-1"><p>Для бизнеса</p> Воспользуйтесь преимуществами социальной сети для продвижения вашего бренда и увеличения продаж. Гибкая настройка целевой аудитории с помощью хештегов даёт возможность работать именно с Вашей аудиторией.</div>
<div id="who-2"><p>Для обычных людей</p> О тебе узнают много пользователей. Ты получишь кучу подписчиков и много лайков к своим фотографиям. Друзья уже начинают тебе завидовать!</div>
</div>
</div>
<!-- End Кому -->

<!-- Отзывы -->
<div id="reviews_body">
<div id="reviews">
<div class="title"><span>Отзывы наших пользователей</span></div>
<div class="slider2">
<ul>

<!-- 1 page -->
<li>
<div class="comment-l">
<div class="com-text-l">Используем PAMANI для продвижение товаров интернет магазина в инстаграме. Работает вот уже больше полугода и полёт нормальный.<br /><br /> Хочу подчеркнуть удобство использования: настроил и забыл. Результат не заставляет себя ждать - лайков под фотографиями всё больше и больше. Значит и охват целевой аудитории тоже растёт.</div>
<div class="com-ava-l">
<img src="images/otziv-mineralmarket.jpg" width="70" height="70" />
<a href="http://instagram.com/mineralmarket" class="com-name" target="_blank">MineralMarket.ru</a>
</div>
</div>

<div class="comment-r">
<div class="com-ava-r">
<img src="images/otziv-ogorodnik.jpg" width="70" height="70" />
<a href="http://instagram.com/ogorodnikqq" class="com-name" target="_blank">ogorodnikqq</a>
</div>
<div class="com-text-r">На сегодняшний день у меня больше 12 000 подписчиков. В среднем к каждой фотографии около 250 лайков. Такое внимание безумно подстёгивает к публикации новых и новых фотографий<br /><br />Мне нравится PAMANI за его простоту и эффективность. Настроил, оплатил и готово.<br /><br />Дмитрий Огородник</div>
</div>
</li>
<!-- End 1 page -->

<!-- 2 page -->
<li>
<div class="comment-l">
<div class="com-text-l">Девочки! Всем очень рекомендую использовать эту систему для продвижения себя красивую в инстаграме. Вы может быть и так красивая, но если ты не звезда, то как то же тебя должны заметить! Стоит копейки, а эффект посмотрите какой!<br /><br />Ольга Обрамович</div>
<div class="com-ava-l">
<img src="images/otziv-olga.jpg" width="70" height="70" />
<a href="http://instagram.com/oabramovich" class="com-name" target="_blank">redrocksy</a>
</div>
</div>

<div class="comment-r">
<div class="com-ava-r">
<img src="images/otziv-anna.jpg" width="70" height="70" />
<a href="http://instagram.com/anyuta_rai" class="com-name" target="_blank">anyuta_rai</a>
</div>
<div class="com-text-r">Эту "штука" помогла мне сделать из обычного профиля в социальной сети самый настоящий инструмент для зарабтывания денег. Рекламодатели охотно сотрудничают с раскрученными и популярными аккаунтами. Так что рекомендую!<br/><br/>Анна Вячкславовна</div>
</div>
</li>
<!-- End 2 page -->

</ul>
</div>

</div>
</div>
<!-- End Отзывы -->

<!-- Бонус -->
<div id="bonus_body">
	<div id="bonus">
		<div class="title3">Внимание, бонус!</div>
		<div id="bonus-icon">
			<div id="bon-1">Оплатите<br /> сервис</div>
			<div id="bon-2">на 2 месяца<br /> и более</div>
			<div id="bon-3">и получите<br /> до 72 дней <p>бесплатно</p></div>
		</div>

		<!-- Таймер -->
		<div id="timer_wrap">
			<div id="timer-title">До конца акции осталось:</div>

			<div id="day">
				<p>0</p><p>0</p>
				<span>дней</span>
			</div>

			<div id="hour">
				<p id="hour0"></p><p id="hour1"></p>
				<span>часов</span>
			</div>

			<div id="min">
				<p id="min0"></p><p id="min1"></p>
				<span>минут</span>
			</div>

			<div id="sec">
				<p id="sec0"></p><p id="sec1"></p>
				<span>секунд</span>
			</div>
			<div class="clear"></div>
		</div>
		<!-- End Таймер -->
	</div>
</div>
<!-- End Бонус -->

<!-- Форма -->
<div id="feedback_body">
	<div id="feedback">
		<div class="title4">Остались вопросы? <p>Напишите нам</p></div>
		<form class="form" method="post" action="/email.php">
			<input type="text" name="fname" class="fname" placeholder="Ваше имя" value="" />
			<input type="text" name="email" class="fmail" placeholder="Адрес электронной почты" value="" />
			<textarea name="msg" class="fmessage" placeholder="Сообщение"> </textarea>
			<div id="support">Время работы тех. поддержки: <p>с 9.00 до 19.00</p></div>
			<script>
                $(function(){
                    function spam() { $("#spam").val("0"); }
                    setInterval(spam, 2000) // использовать функцию
                });
			</script>
            <input type="hidden" name="spam" id="spam" value="1" />

			<input type="submit" id="form_send" value="Отправить" />
		</form>
	</div>
</div>
<div class="clear"></div>
<!-- End Форма -->

<!-- Соц. кнопки -->
<div id="share_body">
	<div id="share">
		<p>Расскажите о нас своим друзьям и коллегам:</p>
		<div id="share-button">
			<div id="vk"></div>
			<div class="tip">19</div>

			<div id="fb"></div>
			<div class="tip">28</div>

			<div id="tw"></div>
			<div class="tip">138</div>

			<div id="gp"></div>
			<div class="tip">226</div>
		</div>
	</div>
</div>
<!-- End Соц. кнопки -->

<!-- Подвал -->
<div id="foot_body">
<div id="foot">

<div id="foot-top">
	<div id="work">Работает с 2013 года &#169; “pamani.ru” </div>
	<div id="info">
		ООО “Памани.ру”<br />
		ИНН 780414379982<br />
		КПП 7812010019193
	</div>

	<div id="adres">
		190000, Россия, Санкт-Петербург,<br /> 
		пл. Александра Невского,<br /> 
		БЦ “Москва”, офис 8372
	</div>

	<div id="email">
		E-mail технической поддержки:<br />
		<a href="mailto:support@pamani.ru">support@pamani.ru</a>
	</div>
	<div class="clear"></div>
</div>

<div id="foot-down">
	<div id="foot-menu">
		<a href="/dogovor" target="_blank">Договор публичной оферты</a>
		<a href="/help" target="_blank">Помощь</a>
        <a href="/login">Вход</a>
        <a href="/reg">Регистрация</a>
	</div>

	<div id="work-it">
		<p>Разработчик: <a href="http://ibragimov.me" target="_blank">Арсен Ибрагимов</a></p>
		<p>Дизайн сайта: <a href="http://burgarts.ru" target="_blank">Burg!art</a></p>
	</div>
</div>

</div>
</div>
<!-- End Подвал -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter24173104 = new Ya.Metrika({id:24173104, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true, ut:"noindex"}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/24173104?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>