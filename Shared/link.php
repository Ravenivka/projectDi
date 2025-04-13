<?php
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/weeks.php' );
    $a = '../'. $_POST['week'];
    $value='<img src="'.$a.'" alt="none" class="main__img">'           ;
    $title = "Расписание";
    $css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Shared/base.php' );
    


?>