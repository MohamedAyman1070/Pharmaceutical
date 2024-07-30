<div class="p-2  bg-blue-500 w-full flex gap-4 text-white ">
    <div class="text-3xl">
        Logo
    </div>

    <div class="text-xl flex items-center gap-2">
        <div >
            <a href="<?php echo BaseURL . 'admin/' ?>">Home</a>
        </div>

        <?php if(is_superAdmin()):?>
        <div  x-data="{show:false} "  @mouseleave="show = false">
            <button @mouseover="show = true">Admins</button>
            <div x-show="show"  x-transition.duration.300ms class="w-60 p-2 text-white  bg-blue-500 rounded absolute top-10  text-base">
                <ul class="">
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin . '/admins/add.php' ?>">Add</a>
                    </li>
                    <li  class="hover:bg-blue-600 rounded p-2 w-full  ">
                        <a  href="<?php echo BaseURL_admin . 'admins/index.php'?>">View All</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif;?>


  




        <?php if(is_superAdmin()):?>
        <div  x-data="{show:false}" @mouseleave="show=false">
            <button @mouseover="show = true">Branches</button>
            <div x-show="show" x-transition.duration.300ms class="w-60 p-2 text-white  bg-blue-500 rounded absolute top-10 text-base">
                <ul>
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin . 'cities/add.php' ?>">Add</a>
                    </li>
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin . 'cities/index.php' ?>">View All</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif;?>

        <div  x-data="{show:false}" @mouseleave="show=false">
            <button @mouseover="show = true">Pharmaceutical</button>
            <div x-show="show" x-transition.duration.300ms class="w-60 p-2 text-white  bg-blue-500 rounded absolute top-10 text-base">
                <ul>
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin.'pharmaceutical/add.php' ?>">Add</a>
                    </li>
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin.'pharmaceutical/index.php' ?>">view All</a>
                    </li>
                </ul>
            </div>
        </div>


        <div  x-data="{show:false}" @mouseleave="show=false">
            <button @mouseover="show = true">Orders</button>
            <div x-show="show" x-transition.duration.300ms class="w-60 p-2 text-white  bg-blue-500 rounded absolute top-10 text-base">
                <ul>
                    
                    <li class="hover:bg-blue-600 rounded p-2">
                        <a href="<?php echo BaseURL_admin.'orders/index.php'?>">View All</a>
                    </li>
                </ul>
            </div>
        </div>

        <?php
        if ($_SESSION['admin']) :

        ?>
            <div>
                <form action="<?php echo BaseURL_admin . 'logout.php' ?>">
                    <button>Logout</button>
                </form>
            </div>
        <?php
        endif;
        ?>

    </div>
</div>