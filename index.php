<?php
    $title = "Домашняя";
    session_start();    

    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = 'None';
        $_SESSION['role'] = 0;
    }
    //echo $_SESSION['user'];    
    require_once './Data/weeks.php';

    if (!isset($_SESSION['server'] )){
        $_SESSION['server'] = $_SERVER['REQUEST_URI'];
    }
    //echo $_SESSION['server'];
    global $pack;
    date_default_timezone_set('Asia/Yekaterinburg');
    $DayOfWeekNumber = date("w");
    $today = date('d.m.Y');
    $currentYear = date('Y');
    $currentYearObject = $pack->collection[$currentYear];
    $currentMonth = date('m');
    $currentMonthObject = $currentYearObject->months[(int) $currentMonth]  ;
    $currentpath = '';
    if ($DayOfWeekNumber == 0){
        $d =(int) date('d') + 1;
        $today = $d.'.'.date('m').'.'.date('Y');
    }
    $array = $currentMonthObject->weeks ;
    foreach ($array as $key ) {
        $date1 = DateTime::createFromFormat('d.m.Y', $key->start);
        $date2 = DateTime::createFromFormat('d.m.Y', $key->finish);
        $date3 = DateTime::createFromFormat('d.m.Y', $today);
        if (($date1 <= $date3) and ($date2 >= $date3)){
            $currentpath = $key->path ;
        }
    }   
    
    require_once './Shared/base_small.php';

    //echo $currentpath;
    echo '<img src="'.$currentpath.'" alt="none" class="main__img"> </main></body></html>';






?>
