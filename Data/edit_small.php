<div class="addist__half">
    <?php
        $picPath = '../schedule/'.$mid[0].'/'.$mid[4]; 
    ?>
        <div class="half">
            <form method="post" action="../Data/text.php" id = "form1">
            <input type = 'hidden' name="rule" value="1">;
            <input type='hidden' value="<?php echo $index;?>" name="index">
                <ol class="addist__ol"><h2 class="edit_h2">Изменить</h2>
                    
                    <li class="addist__li">
                        <h3>Выбор даты начала</h3><br>
                        <input type="date" class="addist__date" name="start-date" value="<?php echo $sDate->format('Y-m-d') ;?>"/>
                    </li>
                    <li class="addist__li">
                        <h3>Выбор даты окончания</h3><br>
                        <input type="date" class="addist__date" name="end-date" value="<?php echo $eDate->format('Y-m-d') ;?>"/>
                    </li>
                </ol>
                <input type="hidden" value="<?php echo $mid[4]; ?>" name="mid4">
                <input type="hidden" value="<?php echo $picPath; ?>" name="old">    
                <input type="hidden" class="addist__input" name="god" value="<?php echo $sDate->format('Y') ;?>"/>
                <input type="hidden" class="addist__input" name="phone" value="<?php echo $sDate->format('m') ;?>"/>
                <button type="submit" class="month__button"  >OK</button> 
            </form>
        </div>
        <div class="half">
        <ol class="addist__ol"><h2>Cменить фото</h2>
            <li class="addist__li"><h3>Текущее фото:</h3></li> 
            <img src="<?php echo $picPath; ?>" alt="none" class="imgExc"><br>
            <span id="span"><?php echo $mid[4]; ?></span><br>
            <form method = "post" action = "../Data/text.php" enctype="multipart/form-data"> 
            <input type = 'hidden' name="rule" value="2">;
            <li class="addist__li"><h3>Смена фото</h3></li>
                <input type="file" class="addist__file" name="file" accept="image/*"  />
                <input type="hidden" name="small_index" value="<?php echo $index;  ?>"></li>
                <input type="hidden" name="mid0" value="<?php echo $mid[0];  ?>">
                <input type="hidden" name="mid1" value="<?php echo $mid[1];  ?>">
                <input type="hidden" name="mid2" value="<?php echo $mid[2];  ?>">
                <input type="hidden" name="mid3" value="<?php echo $mid[3];  ?>">
                <input type="hidden" name="mid4" value = "<?php echo $mid[4];?>"/>
            </ol>
                <button  type="submit" class="month__button" >OK</button>
                            
            </form>

        </div>            
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
