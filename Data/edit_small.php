<div class="addist__half">
        <div class="half">
            <form method="post" action="text" id = "form1">
            <input type='hidden' value="<?php echo $index;?>" name="index">
                <ol class="addist__ol"><h2>Изменить</h2>
                    <li class="addist__li">
                        <h3>ГОД</h3><br>
                        <input type="text" class="addist__input" name="god" value="<?php echo $mid[0] ;?>"/>
                    </li>
                    <li class="addist__li">
                        <h3>Месяц</h3><br>
                        <select class="addist__phone" name="phone"  >
                        <?php for ($i = 1; $i < 13; $i++) { ?>
                            <option value=<?php echo '"'.$i.'"';
                                if ($i == (int) $mid[1]) {
                                    echo 'selected';
                                }
                        ?>
                            ><?php echo $i;?></option>
                        <?php } ?>
                        </select>                
                    </li>
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
                <p style="text-align:center"> <button type="submit" class="month__button" >Сохранить</button> </p>
            </form>
        </div>
        <div class="half">
            <h3>Cменить фото</h3>
            <p>Текущее фото:</p>
            <?php 
                $picPath = './schedule/'.$mid[0].'/'.$mid[4];                 
            ?> 

            <img src="<?php echo $picPath; ?>" alt="none" class="imgExc"><br>
            <span id="span"><?php echo $mid[4]; ?></span><br>
            <form method = "post" action = "change_photo" enctype="multipart/form-data">
                <h3>Смена фото</h3><br>
                <input type="file" class="addist__file" name="file" accept="image/*"  />
                <input type="hidden" name="small_index" value="<?php echo $index;  ?>">
                <input type="hidden" name="mid0" value="<?php echo $mid[0];  ?>">
                <input type="hidden" name="mid1" value="<?php echo $mid[1];  ?>">
                <input type="hidden" name="mid2" value="<?php echo $mid[2];  ?>">
                <input type="hidden" name="mid3" value="<?php echo $mid[3];  ?>">
                <input type="hidden" name="mid4" value = "<?php echo $mid[4];?>"/>
                <p style="text-align:center"> <button type="submit" class="month__button" >Заменить</button> </p>                
            </form>

        </div>            
    </div>
        

</div>
