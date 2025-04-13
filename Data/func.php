<?php

function render(string $base , string $value, string $atEnd){
    require_once $base;   
    echo $value;
    require_once $atEnd;

}
function view(string $base , string $value, string $atEnd){
    require_once $base;
    $x1 = realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/'.$value);   
    require_once $x1;
    require_once $atEnd;

}
function getExtension1($filename) {
    return substr(strrchr($filename, '.'), 1);
  }

  function findLine(string $day, string $path, string $txtfile){  
    $result = array();
    $text = file_get_contents($txtfile)  ;
    $toparray = explode(PHP_EOL, $text);
    for ($i = 0; $i < count($toparray); $i++) {
        $array = explode(',', $toparray[$i]);                
        if ($array[2] == $day && $array[4] == $path) {
            $result[0] = $i;
            $result[1] = $array;
            return $result;
        }
    }
}

function my_sort(string $path){
    $text = file_get_contents($path)  ;
    $toparray = explode(PHP_EOL, $text);
    $bool = true;
    while ($bool){
        $bool = false;
        for ($i = 0; $i < count($toparray)-1; $i++){
            $array1 = explode(',', $toparray[$i]);
            $array2 = explode(',', $toparray[$i+1]);
            $date1 = DateTime::createFromFormat('d.m.Y', $array1[3]);
            $date2 = DateTime::createFromFormat('d.m.Y', $array2[3]); 
            if ($date1 > $date2) {
                $anchor = $toparray[$i+1];
                $toparray[$i+1] = $toparray[$i];
                $toparray[$i] = $anchor;
                $bool = true;
            }
        }
    } 
    $text = implode(PHP_EOL, $toparray)  ;
    try {
        file_put_contents($path, $text);
        return true;
    } catch (Exception $e) {
        echo $e-> getMessage();
        return false;
    }
}

function delta(int $index, string $path) {
    $text = file_get_contents($path)  ;
    $toparray = explode(PHP_EOL, $text);
    $array = array();
    $n = count($toparray);
    switch ($index) {
        case 0:
            for ($i = 1; $i < $n; $i++) {
                $k = $i - 1;
                $array[$k] = $toparray[$i]; 
            }
            break;
        case $n:
            for ($i = 0; $i < $n - 1; $i++) {                
                $array[$i] = $toparray[$i]; 
            } 
            break;
        default:
            for ($i = 0; $i < $n; $i++) {
                if ($i < $index) {
                    $array[$i] = $toparray[$i];
                } elseif ($i > $index) {
                    $k = $i - 1;
                    $array[$k] = $toparray[$i]; 
                }
            }            
    }
    $text = implode(PHP_EOL, $array) ;
    try {
        file_put_contents($path, $text);
        //return true;
    } catch (Exception $e) {
        echo $e-> getMessage();
        return false;
    }
    $boo = my_sort( $path);
    return $boo;
}

function exchange(){
    if (!isset($_SESSION['admin']) or $_SESSION['admin'] != 'root'){
        $content = '<div class="warning"><span>ошибка авторизации 401 Unauthorized Error</span></div>';
        $x = realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base.php');
        $y = realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/end.php');        
        render($x, $content, $y);
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
//var_dump($array);
    
    try{
        $delta = delta($index, realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        $new_string = implode(',', $array);
        $textfile = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        $textfile = $textfile.PHP_EOL.$new_string;
        file_put_contents(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'), $textfile);
        $bom = my_sort(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));
        
        return true;
    } catch (Exception $e) {
        
        return false;
    }

}


?>