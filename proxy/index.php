<?php
    include('../config.php');

        $file = file($_FILES["filename"]["tmp_name"]);

        for ($i=0;$i<count($file);$i++){
            $pie = explode(":",$file[$i]);
            $pie = array_map('trim',$pie);
            //print_r($pie);

            if ($pie[1])
                mysql_query("INSERT INTO proxy VALUE (NULL, '{$pie[0]}', '{$pie[1]}', '{$pie[2]}', '{$pie[3]}', '0')");
        }


?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="filename"><br>
    <input type="submit" value="Загрузить"><br>
</form>
