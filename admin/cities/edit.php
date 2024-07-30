<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/validate.php');
?>


<?php
if(!is_superAdmin()){
    header('location:'.BaseURL);
}
if (isset($_GET['city_id'])) {
    $city_id = $_GET['city_id'];
    // $row = getRow('id', $city_id, 'Cities');
    $sql = "SELECT c.city_name , c.created_at , c.id ,c.admin_id , a.admin_name FROM cities c join admins a on c.admin_id = a.id where c.id = $city_id";
    $row = DB_explicit_sql($sql);
    $row = $row[0];

    $admins  = getData('admin_name , id');
   
   
    !$row ?  header('location:'. BaseURL . '404.php', 404) : '';
   
} else {
    header('location:'. BaseURL . '404.php', 404);
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $error = explode(',', $error);
}
if(isset($_GET['success'])){
    $success = $_GET['success'];
}
require_once(CurrentDirectory . 'functions/messages.php');
?>


<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-screen flex justify-center items-center  m-auto">
        <div class="w-full">
            <h1 class="text-white text-2xl bg-blue-500 text-center rounded">Edit Branch</h1>

            <?php 
                    $action =  BaseURL_admin . 'cities/update.php' ;
                    $method = 'post';
                    $btn = 'Edit';
                    $formGroup = array(
                        [
                            'label' => 'Branch',
                            'type' => 'text',
                            'value' =>$row['city_name'],
                            'name' => 'city_name',
                        ],
                        [
                            'label' => '',
                            'type' => 'hidden',
                            'value' =>$row['id'],
                            'name' => 'city_id',
                        ],
                    );
                    $selection = array(
                        
                            'label' => 'Admin',
                            'name' => 'admin_id',
                            'options' => array(),
                        
                    );
                    $selection['options'][] = ['value' =>$row['admin_name'] , 'name' => $row['admin_name']];
                    $stored = [$row['admin_id']];
                    foreach($admins as $admin){
                        if($admin['admin_name'] == 'superAdmin' or  array_search($admin['id'] , $stored )  !== false){
                            continue;
                        }
                        $stored[] = $admin['id'];
                        $selection['options'][] = ['value' =>$admin['id'] , 'name' => $admin['admin_name']];
                    }

                require_once(componentsDirectory.'form.php')?>


        </div>
    </div>

    <?php
    require_once(componentsDirectory . 'footer.php');
    ?>