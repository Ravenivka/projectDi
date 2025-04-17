<?php 
$title = "Новое расписание";
session_start();
if ( !isset($_SESSION['role']) or ($_SESSION['role'] == 0) ) {
    require_once realpath ($_SERVER['DOCUMENT_ROOT'].'/shared/base_small.php');        
    echo '<div class="warning"><span>ошибка авторизации 401 Unauthorized Error</span></div>';

}
$Date = new DateTime();
$eDate = new DateTime('+5 days');
require_once realpath($_SERVER['DOCUMENT_ROOT'].'/Shared/base_small.php');

?>
<div class="addist__half">
    
        <div class="half__center">
            <form method="post" action="../Data/text.php" id = "form1" enctype="multipart/form-data">
                <input type = 'hidden' name="rule" value="4">
            
                <ol class="addist__ol"><h2 class="edit_h2">Новое расписание</h2>
                    
                    <li class="addist__li">
                        <h3>Выбор даты начала</h3>
                        <input type="date" class="addist__date" name="start-date" value="<?php echo $sDate->format('Y-m-d') ;?>"/>
                    </li>
                    <li class="addist__li">
                        <h3>Выбор даты окончания</h3><br>
                        <input type="date" class="addist__date" name="end-date" value="<?php echo $eDate->format('Y-m-d') ;?>"/>
                    </li>
                    <li class="addist__li">
                        <h3>Загрузить фото</h3>
                        <input type="file" class="addist__file" name="file" accept="image/*" />
                    </li>
                </ol>
                
                <button type="submit" class="month__button" style="margin-left:30px;" >Сохранить</button> 
            </form>
        </div>
           
   
</div>        


<script>
        const Di = document.querySelector('.addist__half');
        const H = window.innerHeight;
        let Zu = H-120;
        if (Di.style.height < Zu){
            let M = Zu + 'px';
            Di.style.height = M;
        }
</script>
