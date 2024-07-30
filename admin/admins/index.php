<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/csvHandler.php');
?>

<?php
$data = [
    ['Name', 'Email', 'Wage', 'Branches', 'Created At'],
];

if(!is_superAdmin()){
    header('location:'.BaseURL);
}

?>


<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-screen flex justify-center items-center  m-auto">
        <div class="flex flex-col min-h-screen items-center justify-center w-full gap-2 ">
            <h1 class="text-center w-full text-4xl text-white bg-blue-500">All Admins</h1>
            <div class="overflow-x-auto  w-full">
                <table class=" overflow-scroll  w-full text-white   shadow-md   ">
                    <thead>
                        <tr class="bg-blue-gray-100 bg-blue-500  text-white text-center  border-b-2 border-white">
                            <?php
                            foreach ($data[0] as $val) :
                            ?>
                                <th class="py-3 p-2 px-4 "><?php echo $val ?></th>
                            <?php
                            endforeach;
                            ?>
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

                        
                        $explicit_sql = "select a.id , a.admin_email , a.salary  , a.admin_name , a.created_at , c.city_name from admins a left join cities c on c.admin_id = a.id   ;";
                        
                        $all_admins =  DB_explicit_sql($explicit_sql);
                        if ($all_admins) {
                            foreach ($all_admins as $admin) {
                                $data[] = [$admin['admin_name'], $admin['admin_email'], $admin['salary'], $admin['city_name'], $admin['created_at']];
                            }
                            
                        }
                        $explicit_sql = "select a.id , a.admin_email , a.salary  , a.admin_name , a.created_at , c.city_name from admins a left join cities c on c.admin_id = a.id  LIMIT $offset  ,$limit ;";
                        $admins =  DB_explicit_sql($explicit_sql);
                        if ($admins) {
                            foreach ($admins as $admin) :
                                if ($admin['admin_email'] == 'admin@super.com') {
                                    continue;
                                }
                        ?>

                                <tr class="border-b-2   border-white ">
                                    <td class="py-3 p-2 px-4"><?php echo $admin['admin_name'] ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo $admin['admin_email'] ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo $admin['salary'] . '$' ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo $admin['city_name'] ?? 'NULL' ?></td>
                                    <td class="py-3 px-4"><?php echo $admin['created_at'] ?></td>

                                    <td class="py-3 p-2 px-4">
                                        <form action="<?php echo BaseURL_admin . 'admins/edit.php' ?>" method="get">
                                            <input type="hidden" value="<?php echo $admin['id'] ?>" name="admin_id">
                                            <button type="submit" class="font-medium">Edit</button>
                                        </form>
                                        <form action="<?php echo BaseURL_admin . 'admins/delete.php' ?>" method="post">
                                            <input type="hidden" value="<?php echo $admin['id'] ?>" name="admin_id">
                                            <button type="submit" class="font-medium" name="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                        <?php
                            endforeach;
                        }
                        ?>

                    </tbody>
                </table>

                <div class="flex gap-2">
                    <?php
                    $total = getData('count(id)');
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
            <?php require_once(CurrentDirectory.'components/fileHandler.php');?>
        </div>

    </div>
</div>

<?php

require_once(componentsDirectory . 'footer.php');
?>