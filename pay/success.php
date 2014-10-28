<html>
<head>
    <meta charset="utf8" />
    <style>
        body {
            background: url("//d36xtkk24g8jdx.cloudfront.net/bluebar/4fdd6ab/images/shared/noise-2.png") repeat scroll 0 0 #EDEEEF;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        div {
            background: none repeat scroll 0 0 #2ECC71;
            border: 1px solid #27AE60;
            color: #FFFFFF;
            margin: 100px auto;
            padding: 20px;
            text-align: center;
            text-shadow: 1px 1px 0 #27AE60;
            width: 300px;
        }
    </style>
</head>
<body>
<div>
    <b>Оплата успешно произведена</b><br /><br />
    В течении 3 секунд Вы будете перенаправлены в личный кабинет PAMANI<sup>&reg;</sup>
</div>
<? if (!$_GET[test]) { ?>
    <meta http-equiv="refresh" content="5;url=/profile.php">
<? } ?>
</body>