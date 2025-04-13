<!DOCTYPE html>
<?php
     require_once realpath($_SERVER['DOCUMENT_ROOT']. '/Data/weeks.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ;?></title>
    <?php
        //global $pack;
        
              
    ?> 
    <link rel="stylesheet" href="../style.css">   
    </head>
<body>
    
    <div class="basic">
        <div class="header">
            <div class="header_h">
                <h2 class="header_title">Ревдинский филиал ГАПОУ УГК им И.И.Ползунова</h2>
                <h3 class="header_subtitle">РАСПИСАНИЕ ЗАНЯТИЙ</h3>
            </div>            
                <div class="header_editor">
                    <?php 
                        if (isset($_SESSION['user']) and ($_SESSION['role'] > 0)){ ?>
                            <h2 class = "header_user"><?php echo $_SESSION['user']; ?></h2>   <br>                         
                            <a class="exit" href="../Data/autor.php?var=1">Выйти</a>                            
                    <?php } else { ?>
                        <form method="post" action="../Data/autor.php">
                         <input type = 'hidden' name = "var" value = "2">   
                        <button type="submit" class="month__button" >Вход</button>
                        </form>
                    <?php } ?>
                </div> 
        </div>
        <nav class="nav">
            <div class="nav__menu"><a href="../index.php" class="nav__a">Домой</a></div>
            <?php foreach ($pack->collection as $year) { ?>
            <div class="nav__menu">
                <form action="../Shared/year.php" method="post">
                    <input name = "year" value="<?php echo $year->year;?>" type="hidden" />               
                    <button class="nav__btn" type="submit"><?php echo $year->year;?></button> 
                </form>  
            </div>
            <?php 
                } 
                if (isset($_SESSION['user']) and ($_SESSION['role'] > 0)){
            ?>            
            <div class="nav__menu">
                <form method="post" action="../Shared/add.php">
                    <button type="submit" class="month__button month__button_nomargin" ><p style="text-align:center;">Добавить фото</p> </button>
                </form>
            </div> <?php } ?>
        </nav>     
        <main class="main">