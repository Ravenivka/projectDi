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
    $stamp1 = new DateTime($array[2]);
    $stamp2 = new DateTime($array[3]);
    $array[2] = $stamp1->format('d.m.Y');
    $array[3] = $stamp2->format('d.m.Y');     
    $array[0] = $stamp1->format('Y');
    $array[1] = $stamp1->format('m');
    $new_string = implode(',', $array);
    $textfile = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));           
    $textfile = $textfile.PHP_EOL.$new_string;
    return file_put_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'), $textfile); 
}


autorize($_SESSION['role']);
switch($rule) {
    case 1:
        if (!isset($_SESSION['role']) or $_SESSION['role'] == 0){        
            require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');        
            echo '<div class="warning"><span>ошибка авторизации 401 Unauthorized Error</span></div>';
            return false;          
        }
        $array = array();        
        $array[0] =$_POST['god'];
        $array[1] =$_POST['phone'];
        $array[2] =$_POST['start-date'];
        $array[3] =$_POST['end-date'];
        $array[4] = $_POST['mid4'];
        $stamp1 = new DateTime($array[2]);
        $newYear = $stamp1->format('Y');
        $dir = checkYear($array[2]);
        if (!$dir) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }

        $oldPath = '../schedule'.'/'.$array[0].'/'.$array[4];
        $newPath = '../schedule'.'/'.$newYear .'/'.$array[4];
        if ($oldPath != $newPath) {
            try {
                $do = rename($oldPath, $newPath);
                
            } catch (Exception $e) {
                require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
                echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
                break;
            }            
        }

        $demo = demiurg($array);        
        if (!$demo) {            
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }
        
        
        $index =$_POST['index'];
        
        $delta = delta($index, realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        
        if (!$delta) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }

        
        $my_sort = my_sort(realpath($_SERVER['DOCUMENT_ROOT']. '/Data/photo.txt'));
        //echo $my_sort;

        if (!$my_sort) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Записано</span></div></main></body></html>';
           
        break;
    case 2:
        echo 'photo';
        break;
    default:
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Ошибка 500 (Файл не найден)</span></div></main></body></html>';
}



?>