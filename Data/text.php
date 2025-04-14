<?php
session_start();
$rule = $_REQUEST['rule'];
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/func.php');
function autorize($text) {
    if ((int) $text == 0) {
        $title = "Warning!";        
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Авторизация не пройдена</span></div></main></body></html>';
    } 
}

function exchange(){
    
    if (!isset($_SESSION['role']) or $_SESSION['role'] == 0){        
        require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');        
        echo '<div class="warning"><span>ошибка авторизации 401 Unauthorized Error</span></div>';
        return false;          
    }
    $array = array();
    $array[0] = $_POST['god'];
    $tem = $_POST['phone'];
    if (strlen($tem) == 1){
        $array[1] = '0'.$tem;
    } else {
        $array[1] = $tem;
    }
    $index = $_POST['index'];    
    $stamp1 = new DateTime($_POST['start-date']);
    $stamp2 = new DateTime($_POST['end-date']);
    $array[2] = $stamp1->format('d.m.Y');
    $array[3] = $stamp2->format('d.m.Y');
    $array[4] = $_POST['mid4'];
    $dir = checkYear($_POST['start-date'], $array[4], oldpath: $_POST['old']);
    if (!$dir) {
        return false;
    }
    $array[0] = $stamp1->format('Y');
    $array[1] = $stamp1->format('m');
//var_dump($array);
    
    try{
        $delta = delta($index, realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        $new_string = implode(',', $array);
        $textfile = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        $textfile = $textfile.PHP_EOL.$new_string;
        file_put_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'), $textfile);           
        $bom = my_sort(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        if ($bom) {
            return true;
        } else {
            return false;
        } 
        
    } catch (Exception $e) {
        
        return false;
    }

}

autorize($_SESSION['role']);
switch($rule) {
    case 1:
        if (exchange()) {
            require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/Data/func.php');
            require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');                    
            echo '<div class="warning"><span>Записано</span></div>'; 
        } else {
            require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');        
            echo '<div class="warning"><span>Ошибка записи</span></div>';
        }        
        break;
    case 2:
        echo 'photo';
        break;
    default:
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Ошибка 500 (Файл не найден)</span></div></main></body></html>';
}



?>