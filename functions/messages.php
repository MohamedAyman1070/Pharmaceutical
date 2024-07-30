<div class=" flex flex-col fixed right-2 gap-2   w-96  text-white">

    <?php

    if (isset($error) and count($error) > 0) {

        foreach ($error as $e) {

    ?>

            <div x-data=" { open : true } ">
                <div x-show="open">
                    <div class="rounded bg-red-500">


                        <div class="flex border-b-2 p-1 justify-between border-white">
                            <div class="text-xl">
                                Error
                            </div>
                            <button class=" p-1 " x-on:click="open=false">X</button>
                        </div>
                        <div class="p-2">
                            <?php echo $e ?>
                        </div>


                    </div>
                </div>
            </div>
    <?php

        }
    }
    ?>

    <?php

    if (isset($success)) {
        
    ?>
        <div x-data=" { open : true } ">
            <div x-show="open">
                <div class="rounded bg-blue-400">


                    <div class="flex border-b-2 p-1 justify-between border-white">
                        <div class="text-xl">
                            Success
                        </div>
                        <button class=" p-1 " x-on:click="open=false">X</button>
                    </div>
                    <div class="p-2">
                        <?php echo $success ?>
                    </div>


                </div>
            </div>
        </div>
    <?php
    }


    ?>




</div>