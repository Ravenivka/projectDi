<?php
    $css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
    $yearname = $_POST['year'];    
    require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Data/weeks.php' );
    //$pack = $_POST['pack'];
    $year = $pack->collection[$yearname];
    $months = $year->months;
    session_start();
    $code = false;
    if ( isset($_SESSION['user']) and $_SESSION['role'] > 0){
        $code = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $yearname ;?></title>
    <?php
        //global $pack;
        echo $css;        
    ?>    
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
                <form method="post" action="../Data/add.php">
                    <button type="submit" class="month__button month__button_nomargin" ><p style="text-align:center;">Добавить фото</p> </button>
                </form>
            </div> <?php } ?>
        </nav>     
        <main class="main">
<div class="main_double">
<?php foreach($months as $month) { ?>
<div class="month">
    <h2 class = "month__h3"> <?php echo $month->name ?></h2>
    <ul class="month__ul">
        <?php foreach ($month->weeks as $week) { ?>            
            <li class="month__li">
                <form action="../Shared/link.php" method="post">
                    <input value="<?php echo $week->path; ?>" name="week" type ="hidden"/>
                    <button class="month__btn" type="submit"><?php echo $week->start; ?></button>                      
                </form> <?php if ($code) { ?>
                <form method="post">
                    <input value = "<?php echo $week->path; ?>" name = "path" type ="hidden"/>
                    <input value = "<?php echo $week->start; ?>" name = "start" type ="hidden"/>
                    <input type = 'hidden' name="rule" value="3">;
                    <button class="month__btn month__btn-short " type="submit" formaction="../Data/edit.php" >&#128221;</button>
                    <button class="month__btn month__btn-short" type="submit" formaction="../Data/text.php" >&#128683;</button>
                </form>    
                <?php } ?>
            </li>
        <?php } ?>
    </ul>    
</div>
<?php } ?>
</div>
<script>
        const Di = document.querySelector('.main_double');
        const H = window.innerHeight;
        let Zu = H-120;
        if (Di.style.height < Zu){
            let M = Zu + 'px';
            Di.style.height = M;
        }
</script>
</main>
        
        </div>
    
        
    </body>
    </html>
