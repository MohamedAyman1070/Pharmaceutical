<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');

$data = [
    ['Name', 'Branches', 'Price', 'Quantity', 'Added At'],
];
if(isset($_GET['error'])){
    $error = $_GET['error'];
    $error = explode('*' , $error);
}

if(isset($_GET['data_csv']) ){
    $received_data = explode('==',$_GET['data_csv']);
    $data_csv =[]; 
    foreach($received_data as $row):
        $data_csv[] = explode('*',$row);
    endforeach;
    if($received_data[0] !== $data[0]){
        $error[] = 'Invalid CSV data , Tip: columns must be ' .implode(' , ',$data[0]);
    }
}

require_once(CurrentDirectory.'functions/messages.php');

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
                            <th class="py-3 p-2 px-4 ">Branches</th>
                            <th class="py-3 p-2 px-4 ">Price</th>
                            <th class="py-3 p-2 px-4 ">Quantity</th>
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
                            $explicit_sql = "select p.id , p.name, p.price ,p.quantity , p.created_at , c.city_name from pharmaceutical p left join cities c on p.city_id = c.id  LIMIT $offset  ,$limit ;";
                            $explicit_sql_data_for_super = "select  p.name, c.city_name, p.price ,p.quantity , p.created_at  from pharmaceutical p left join cities c on p.city_id = c.id  ;";
                            $data_for_super = DB_explicit_sql($explicit_sql_data_for_super);
                            foreach ($data_for_super as $row) :
                                $data[] = $row;
                            endforeach;
                        else :
                            $admin_id  = $_SESSION['admin']['id'];
                            $explicit_sql = "select p.id , p.name, p.price ,p.quantity , p.created_at , c.city_name from pharmaceutical p left join cities c on p.city_id = c.id where c.admin_id =$admin_id  LIMIT $offset  ,$limit ;";
                            $explicit_sql_data_for_admin = "select  p.name, c.city_name, p.price ,p.quantity , p.created_at  from pharmaceutical p left join cities c on p.city_id = c.id where c.admin_id =$admin_id   ;";
                            $data_for_admin = DB_explicit_sql($explicit_sql_data_for_admin);
                            foreach ($data_for_admin as $row) :
                                $data[] = $row;
                            endforeach;
                        endif;

                        $pharmaceutical =  DB_explicit_sql($explicit_sql);
                        if ($pharmaceutical) {
                            foreach ($pharmaceutical as $pharma) {

                        ?>

                                <tr class="border-b-2   border-white ">
                                    <td class="py-3 p-2 px-4"><?php echo $pharma['name'] ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo $pharma['city_name'] ?? 'NULL' ?></td>
                                    <td class="py-3 px-4"><?php echo $pharma['price'] . '$' ?></td>
                                    <td class="py-3 px-4"><?php echo $pharma['quantity'] ?></td>

                                    <td class="py-3 px-4"><?php echo $pharma['created_at'] ?></td>

                                    <td class="py-3 p-2 px-4">
                                        <form action="<?php echo BaseURL_admin . 'pharmaceutical/edit.php' ?>" method="get">
                                            <input type="hidden" value="<?php echo $pharma['id'] ?>" name="pharma_id">
                                            <button type="submit" class="font-medium">Edit</button>
                                        </form>
                                        <form action="<?php echo BaseURL_admin . 'pharmaceutical/delete.php' ?>" method="post">
                                            <input type="hidden" value="<?php echo $pharma['id'] ?>" name="pharma_id">
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
                    $total = getData('count(id)', 'pharmaceutical');
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
            <?php require_once(componentsDirectory .'fileHandler.php');
                    
            ?>
        </div>

    </div>
</div>

<?php
require_once(componentsDirectory . 'footer.php');
?>