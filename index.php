<?php
    $title = "Домашняя";
    session_start();    

    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = 'None';
        $_SESSION['role'] = 0;
    }
    //echo $_SESSION['user'];    
    
    require_once './Data/weeks.php';

    if (!isset($_SESSION['server'])){
        $_SESSION['server'] = $_SERVER['REQUEST_URI'];
    }
    //echo $_SESSION['server'];

    global $pack;
    date_default_timezone_set('Asia/Yekaterinburg');
    
    $DayOfWeekNumber = date("w"); // 0 - воскресенье, 1-6 - понедельник-суббота
    $today = date('d.m.Y');
    $currentYear = date('Y');
   
    if ($DayOfWeekNumber == 0){
        $nextDay = new DateTime('tomorrow');
        $today = $nextDay->format('d.m.Y');
    }

    $currentpath = '';
    $currentYearObject = $pack->collection[$currentYear];
    
    foreach ($currentYearObject->months as $monthNumber => $month) {
        foreach ($month->weeks as $week) {
            $dateStart = DateTime::createFromFormat('d.m.Y', $week->start);
            $dateEnd = DateTime::createFromFormat('d.m.Y', $week->finish);
            $dateCurrent = DateTime::createFromFormat('d.m.Y', $today);
            
            if ($dateCurrent >= $dateStart && $dateCurrent <= $dateEnd) {
                $currentpath = $week->path;
                break 2;
            }
        }
    }
    
    require_once './Shared/base_small.php';
     //echo $currentpath;
    echo '<a href="'.$currentpath.'" target="_blank"><img src="'.$currentpath.'" alt="none" class="main__img"></a></main></body></html>';







?>
