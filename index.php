<?php
    $title = "Домашняя";
    session_start();    

    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = 'None';
        $_SESSION['role'] = 0;
    }
    //echo $_SESSION['user'];    
    
    require_once './Data/weeks.php';
    require_once './Data/func.php';

    if (!isset($_SESSION['server'])){
        $_SESSION['server'] = $_SERVER['REQUEST_URI'];
    }
    //echo $_SESSION['server'];

    global $pack;
    date_default_timezone_set('Asia/Yekaterinburg');
    
    $todaypath = alternate(time());
    $stringtoday = render($todaypath);
    
   
    require_once './Shared/base_small.php';
     echo $stringtoday;
    echo '</main></body></html>';


?>
