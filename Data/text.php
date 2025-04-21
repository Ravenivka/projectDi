<?php
session_start();
$rule = $_REQUEST['rule'];
$title = "РеДАКТОР";
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
        $file = $_FILES['file']['name'];
        $ext = getExtension1($file);
        $array = array();        
        $array[0] =$_POST['mid0'];
        $array[1] =$_POST['mid1'];
        $array[2] =$_POST['mid2'];
        $array[3] =$_POST['mid3'];
        $array[4] = $_POST['mid4'];
        //var_dump($array);
        $new_name = $array[2].'.'.$ext;
        //echo $new_name;
        $uploads_dir = realpath($_SERVER['DOCUMENT_ROOT'].'/schedule/'.$array[0] );
        $boo = move_uploaded_file($file = $_FILES['file']['tmp_name'], "$uploads_dir/$new_name");
        if (!$boo) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break; 
        }
        if ($array[4] == $new_name) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Записано</span></div></main></body></html>';
            break;
        }
        $array[4] = $new_name;
        $demo = demiurg($array);        
        if (!$demo) {            
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }
        $index =$_POST['small_index'];
        
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

    case 3:
        $path ='../'. $_POST['path'];
        $start = $_POST['start'];
        $path_array = explode('/', $path);
        $path_end = $path_array[count($path_array)-1];     
        $photo = realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt' );   
        $array = findLine($start, $path_end, $photo);
        $index = $array[0];
        if (file_exists($path)) {
            unlink($path);
        }
        $boo = delta($index, $photo);
        if (!$boo) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Операция выполнена</span></div></main></body></html>';  
    
        break;
    case 4:
        ini_set('upload_tmp_dir', 'Data/tama');
        $upload_tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        $realpath_cache_size = ini_get('realpath_cache_size');
        $post_max_size = ini_get('post_max_size');
        $file_uploads = ini_get('file_uploads');
        $upload_max_filesize = ini_get('upload_max_filesize');

        $sDate = new DateTime($_POST["start-date"]);
        $eDate = new DateTime($_POST["end-date"]);

        $file = $_FILES['file']['name'];
        $ext = getExtension1($file);
        $new_name = $sDate -> format('d.m.Y') . '.' . $ext;
        //echo $new_name;
        $uploads_dir = realpath($_SERVER['DOCUMENT_ROOT'].'/schedule/'.$sDate->format('Y') );
        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir);
        }
        
        //$boo = move_uploaded_file($_FILES['file']['tmp_name'], "$uploads_dir/$new_name");
        //$tamapath = realpath($_SERVER['DOCUMENT_ROOT'].'/Data/tama'.$_FILES['file']['tmp_name']);
        //$foo = alternate($_FILES['file']['tmp_name'], "$uploads_dir/$new_name");
        echo 'upload_tmp_dir: - '.$upload_tmp_dir.'<br>';
        echo 'realpath_cache_size: - '.$realpath_cache_size.'<br>';
        echo 'post_max_size: - '.$post_max_size.'<br>';
        echo 'file_uploads: - '.$file_uploads.'<br>';
        echo 'upload_max_filesize: - '.$upload_max_filesize.'<br>';

break;
        if (!$boo) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break;
        }
        $array = array();
        $array[0] = $sDate -> format('Y');
        $array[1] = $sDate -> format('m');
        $array[2] = $sDate -> format('d.m.Y');
        $array[3] = $eDate -> format('d.m.Y');
        $array[4] = $new_name;
        $text = implode(',', $array);
        $photo_text = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT']).'/Data/photo.txt');
        $photo_text = $photo_text.PHP_EOL.$text;
        $boo = file_put_contents(realpath($_SERVER['DOCUMENT_ROOT']).'/Data/photo.txt', $photo_text);
        if ($boo == false) {
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
            echo '<div class="warning"><span>Ошибка записи</span></div></main></body></html>';
            break; 
        }
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Операция выполнена</span></div></main></body></html>';  

        break;
    default:
        require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base_small.php';
        echo '<div class="warning"><span>Ошибка 500 (Файл не найден)</span></div></main></body></html>';
}



?>