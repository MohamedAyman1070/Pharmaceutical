<?php
require_once('../config.php');
require_once(componentsDirectory . 'header.php');


$data = [
    'Number OF Admins' => getData('count(id)')[0]['count(id)'],
    'Number OF Orders' => getData('count(id)', 'orders')[0]['count(id)'],
    'Number OF Branches' => getData('count(id)', 'cities')[0]['count(id)'],

];


?>

<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-full flex justify-center items-center  m-auto">
        <div class="flex   h-full items-center justify-center w-4/5  gap-2 ">

            <?php
            foreach ($data as $title => $value) :
            ?>

                <div class=" hover:bg-blue-500 hover:text-white transition  rounded border-2 w-60 h-80 p-2  border-black ">
                    <h1 class="text-2xl font-bold"><?php echo $title?></h1>
                    <div class="   w-full h-4/5 flex justify-center items-center ">
                        <h2 class="text-xl ">
                            <?php echo $value?>
                        </h2>
                    </div>
                </div>
            <?php
            endforeach;
            ?>

        </div>

    </div>
</div>

<?php
require_once(componentsDirectory . 'footer.php');
?>