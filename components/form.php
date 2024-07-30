<?php

if (!isset($formGroup, $method, $action, $btn)) {
    die('form attributes is not set');
}

?>


<form class="p-2 w-full flex flex-col gap-2" action="<?php echo $action ?>" method="<?php echo $method ?>">

    <?php
    if ($formGroup) {

        foreach ($formGroup as $group) {
    ?>
            <div class="flex flex-col  ">
                <label class="text-blue-400 text-xl " for=""><?php echo $group['label'] ?></label>
                <input class=" outline-none rounded bg-blue-200 p-2 text-slate-500" type="<?php echo $group['type'] ?>" name="<?php echo $group['name'] ?>" value="<?php echo $group['value'] ?>">
            </div>
    <?php }
    } ?>

    <?php

    if (isset($selection)) {
        
    ?>
        <label class="text-blue-400 text-xl" for="x"><?php echo $selection['label'] ?></label>
        <select class=" outline-none rounded bg-blue-200 p-2 text-slate-500" name="<?php echo $selection['name'] ?>" id="x">

            <?php

            foreach ($selection['options'] as $option) :
                
                
            ?>

                    <option  value="<?php echo $option['value']?>"><?php echo $option['name'] ?></option>
            <?php
            endforeach;
            ?>

        </select>

    <?php
    }

    ?>



    <div class="flex justify-center ">
        <button class="bg-blue-500 p-2 w-32  rounded hover:bg-blue-400" type="submit" name="submit"><?php echo $btn ?></button>
    </div>


</form>