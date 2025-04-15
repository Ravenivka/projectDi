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

function demiurg(array $array){
    
    if (!isset($_SESSION['role']) or $_SESSION['role'] == 0){        
        require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');        
        echo '<div class="warning"><span>ошибка авторизации 401 Unauthorized Error</span></div>';
        return false;          
    }      
    $stamp1 = new DateTime($array[2]);
    $stamp2 = new DateTime($array[3]);
    $array[2] = $stamp1->format('d.m.Y');
    $array[3] = $stamp2->format('d.m.Y');
    $array[4] = $array[4];
    $dir = checkYear($array[2], $array[4], $array[4]);
    if (!$dir) {
        return false;
    }
    $array[0] = $stamp1->format('Y');
    $array[1] = $stamp1->format('m');
//var_dump($array);
    
    try{
        //$delta = delta($index, realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
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