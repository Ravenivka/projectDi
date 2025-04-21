<?php
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/weeks.php' );
    //$a = $_SERVER['SERVER_NAME'] .'/'. $_POST['week'];
    $a = '../'.$_POST['week'];
    session_start();
    $title = "Расписание";
    $css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Shared/base_small.php' );
    //echo $a;
    echo '<img src="'.$a.'?='.filemtime($a).'" alt="none" class="main__img"></main></body></html>'           ;


?>