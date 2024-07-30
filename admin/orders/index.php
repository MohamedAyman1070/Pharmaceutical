<?php
require_once('../../config.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(componentsDirectory . 'header.php');


$data = [
    ['Name' , 'Mobile' , 'Email' , 'Pharmaceutical' ,'Branch' ,'Added At'],
];
?>


<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-screen flex justify-center items-center  m-auto">
        <div class="flex flex-col min-h-screen items-center justify-center w-full gap-2 ">
            <h1 class="text-center w-full text-4xl text-white bg-blue-500">All Pharmaceutical</h1>
            <div class="overflow-x-auto  w-full">
                <table class=" overflow-scroll  w-full text-white   shadow-md   ">
                    <thead>
                        <tr class="bg-blue-gray-100 bg-blue-500  text-white text-center  border-b-2 border-white">
                            <th class="py-3 p-2 px-4 ">Name</th>
                            <th class="py-3 p-2 px-4 ">Mobile</th>
                            <th class="py-3 p-2 px-4 ">Email</th>
                            <!-- <th class="py-3 p-2 px-4 ">Notes</th> -->
                            <th class="py-3 p-2 px-4 ">Pharmaceutical</th>
                            <th class="py-3 p-2 px-4 ">Branch</th>
                            <th class="py-3 p-2 px-4 ">Added At</th>
                            <th class="py-3 p-2 px-4 ">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-blue-gray-900 bg-blue-500  text-center">

                        <?php

                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $limit = 6;
                        $offset = ($page - 1) * $limit;

                        if (is_superAdmin()) :
                            $explicit_sql = "select * ,p.name as pharma_name  , c.city_name as branch from orders o join pharmaceutical p on o.pharmaceutical_id = p.id join cities c on c.id = o.city_id LIMIT $offset ,$limit;";
                            $explicit_sql_data_for_super = "select  o.order_name , o.order_mobile , o.order_email , p.name as pharma_name  , c.city_name  as branch , o.created_at from orders o join pharmaceutical p on o.pharmaceutical_id = p.id join cities c on c.id = o.city_id ;";
                            $clients = DB_explicit_sql($explicit_sql_data_for_super);
                            foreach ($clients as $row):
                                $data[]= $row;
                            endforeach;
                            else :
                            $branch_id = $branch['id'];
                            $explicit_sql = "select * ,p.name as pharma_name  , c.city_name as branch from orders o join pharmaceutical p on o.pharmaceutical_id = p.id join cities c on c.id = o.city_id where c.id = $branch_id  LIMIT $offset ,$limit;";
                            $explicit_sql_data_for_admin = "select  o.order_name , o.order_mobile ,o.order_email  ,p.name as pharma_name  , c.city_name  as branch,o.created_at from orders o join pharmaceutical p on o.pharmaceutical_id = p.id join cities c on c.id = o.city_id where c.id = $branch_id;";
                            $clients = DB_explicit_sql($explicit_sql_data_for_admin);
                            foreach ($clients as $row):
                                $data[]= $row;
                            endforeach;
                        endif;
                        $orders =  DB_explicit_sql($explicit_sql);
                        if ($orders) {
                            foreach ($orders as $order) {

                        ?>

                                <tr class="border-b-2   border-white ">
                                    <td class="py-3 p-2 px-4"><?php echo $order['order_name'] ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo '0' . $order['order_mobile'] ?></td>
                                    <td class="py-3 px-4"><?php echo $order['order_email'] ?></td>
                                    <!-- <td class="py-3 px-4"><?php //echo '...' ?></td> -->
                                    <td class="py-3 px-4"><?php echo $order['pharma_name'] ?></td>
                                    <td class="py-3 px-4"><?php echo $order['branch'] ?></td>

                                    <td class="py-3 px-4"><?php echo $order['created_at'] ?></td>

                                    <td class="py-3 p-2 px-4">
                                        <a class="font-medium" href="<?php echo BaseURL_admin . 'orders/show.php/$order[\'id\']' ?>"></a>
                                        <form action="<?php echo BaseURL_admin . 'orders/delete.php' ?>" method="post">
                                            <input type="hidden" value="<?php echo $order['id'] ?>" name="order_id">
                                            <button type="submit" class="font-medium" name="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>

                <div class="flex gap-2">
                    <?php
                    $total = getData('count(id)', 'orders');
                    $total = $total[0]['count(id)'];
                    $number_of_pages = ceil($total / $limit);
                    $pagLink = "";
                    for ($i = 1; $i <= $number_of_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<li class='p-2  list-none bg-blue-400 text-white'><a href='index.php?page="
                                . $i . "'> page " . $i . "</a></li>";
                        } else {
                            $pagLink .= "<li class='p-2 list-none bg-blue-500 text-white' ><a href='index.php?page=" . $i . "'> 
                                                                         page " . $i . "</a></li>";
                        }
                    };
                    echo $pagLink;
                    ?>
                </div>
            </div>
            <?php  require_once(componentsDirectory . 'fileHandler.php')?>
        </div>

    </div>
</div>

<?php
require_once(componentsDirectory . 'footer.php');
?>