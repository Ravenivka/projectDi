<?php
    $css = '<link rel="stylesheet" href="'.'' .'../style.css" class="css">';
    $title = "Навигация";
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
    require_once '../Shared/base_small.php';
?>

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

</main>
        
        </div>
    
        
    </body>
    </html>
