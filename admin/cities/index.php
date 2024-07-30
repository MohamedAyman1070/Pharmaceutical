<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
if (!is_superAdmin()) {
    header('location:' . BaseURL);
}

$data = [
    ['Branch Name', 'Admin', 'Created at'],
];
?>


<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-screen flex justify-center items-center  m-auto">
        <div class="flex flex-col min-h-screen items-center justify-center w-full gap-2 ">
            <h1 class="text-center w-full text-4xl text-white bg-blue-500">All Cities</h1>
            <div class="overflow-x-auto  w-full">
                <table class=" overflow-scroll  w-full text-white   shadow-md   ">
                    <thead>
                        <tr class="bg-blue-gray-100 bg-blue-500  text-white text-center border-b-2 border-white ">
                            <th class="py-3 p-2 px-4 ">City Name</th>
                            <th class="py-3 p-2 px-4 ">Admin</th>
                            <th class="py-3 p-2 px-4 ">Created At</th>
                            <th class="py-3 p-2 px-4 ">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-blue-gray-900 bg-blue-500  text-center">

                        <?php


                        $explicit_sql = "select  c.city_name  , a.admin_name, c.created_at from cities c left join admins a on c.admin_id = a.id ;";
                        $all_branches = DB_explicit_sql($explicit_sql);
                        if($all_branches):
                            foreach($all_branches as $branch):
                                    $data[] = $branch;
                            endforeach;
                        endif;

                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $limit = 6;
                        $offset = ($page - 1) * $limit;
                        $explicit_sql = "select c.id , c.city_name , c.created_at , a.admin_name from cities c left join admins a on c.admin_id = a.id LIMIT $offset , $limit ;";
                        $cities =  DB_explicit_sql($explicit_sql);
                        if ($cities) {
                            foreach ($cities as $city) {
                        ?>

                                <tr class="border-b-2   border-white ">
                                    <td class="py-3 p-2 px-4"><?php echo $city['city_name'] ?></td>
                                    <td class="py-3 p-2 px-4"><?php echo $city['admin_name'] ?></td>
                                    <td class="py-3 px-4"><?php echo $city['created_at'] ?></td>

                                    <td class="py-3 p-2 px-4">
                                        <form action="<?php echo BaseURL_admin . 'cities/edit.php' ?>" method="get">
                                            <input type="hidden" value="<?php echo $city['id'] ?>" name="city_id">
                                            <button type="submit" class="font-medium">Edit</button>
                                        </form>
                                        <form action="<?php echo BaseURL_admin . 'cities/delete.php' ?>" method="post">
                                            <input type="hidden" value="<?php echo $city['id'] ?>" name="city_id">
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
                    $total = getData('count(id)', 'cities');
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
            <?php 
            require_once(componentsDirectory. 'fileHandler.php');?>
        </div>

    </div>
</div>

<?php
require_once(componentsDirectory . 'footer.php');
?>