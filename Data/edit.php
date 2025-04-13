<?php 
    session_start();
    if ($_SESSION['role'] == 0) {
        //echo $_SESSION['role'];
        header('Location: ../index.php');
        }
    $css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
        //echo $_SESSION['role'];
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/func.php' );
    $start = $_POST['start'];
    $file = $_POST['path'];
    $dateTime = new DateTime($start);
    $info = pathinfo($file, PATHINFO_BASENAME);
    $photo = realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt');   
    $index = findLine($start,$info,$photo);
    $_POST['index'] = $index; 
    $array = $_POST['index'];
    $index = $array[0];
    $mid = $array[1];
    $sDate = new DateTime($mid[2]);
    $eDate = new DateTime($mid[3]);
    $old = $_POST['path'];
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Shared/base_small.php' );
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/edit_small.php' );
?>
</main>
    </body></html>


   
   
