<?php

session_start(); 

$css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
$title = "Авторизация";
require_once $_SERVER['DOCUMENT_ROOT'] .'/Data/weeks.php';
$action = $_REQUEST['var'];
require_once $_SERVER['DOCUMENT_ROOT'].'/Data/users.php' ;
switch ($action){
    case 1:
        session_abort();
        session_start();
        $_SESSION['user'] = 'Гость';
        $_SESSION['role'] = 0;
        //echo $_SERVER['SERVER_NAME'] ;
        header('Location: ../index.php' );
        break;
    case 2:
        $title = "Авторизация";
        $value = '
            <div class="autorize">
            <div class="auto2">
                <form action="http://'.$_SERVER['HTTP_HOST'] .'/Data/autor.php" class="hForm" method="post">
                <input type="hidden" name="var" value="3"><br>
                <input type="text" class="hInput" name="log" placeholder="Login"><br>
                <input type="password" class="hInput" name="pass" placeholder="Password"><br>
                <p style="text-align: center;"><button type="submit" class="month__button hBtn">OK</button></p>
                </form>
            </div>
            </div>
        ';
        require_once '../Shared/base.php';
        break;
    case 3: 
        $autorize = false;       
        $path = realpath($_SERVER['DOCUMENT_ROOT'].'/Data/user.txt');        
        $login = $_POST['log'];
        $pass = $_POST['pass'];
        $users = new MyUsers($path);
        if (!$users->inList($login)) {
            $value = '<div class="warning"><span>Пользователь не найден</span></div>';
            $title = "Внимание";
            require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base.php';
            break;
        } else {
            if ($users->autorize($login, $pass) == false) {
                $value = '<div class="warning"><span>Пароль ошибочен</span></div>';
                $title = "Внимание";
                require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base.php';
                break;
            } else {
                $value = '<div class="warning"><span>Авторизация пройдена</span></div>';
                $title = "Внимание";
                session_abort();
                session_start();
                $_SESSION['user'] = $login;
                $_SESSION['role'] =  $users->getRoleByName($login)     ;
                require_once $_SERVER['DOCUMENT_ROOT']. '/Shared/base.php';
                break;
            }
        }
        
        //break;
    default:
        session_abort();
        session_start();
        $_SESSION['user'] = 'Гость';
        $_SESSION['role'] = 0;
        header('Location ../index.php');
}
?>


