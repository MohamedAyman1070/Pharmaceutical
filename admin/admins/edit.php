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
if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
    $sql = "SELECT  c.city_name , c.id FROM cities c join admins a  on c.admin_id = a.id where a.id = $admin_id";
    $admin_city = DB_explicit_sql($sql);
    $admin_city ? $admin_city = $admin_city[0] : '';
    $row = getRow('id', $admin_id);
    if ($row) {
        $cities  = getData('city_name , id', 'cities');
    } else {
        header('location:' . BaseURL . '404.php', 404);
    }
} else {
    header('location:' . BaseURL . '404.php', 404);
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $error = explode(',', $error);
}
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}
require_once(CurrentDirectory . 'functions/messages.php');
?>


<div class="h-screen w-screen ">
    <div class="w-full sm:w-4/5 h-screen flex justify-center items-center  m-auto">
        <div class="w-full">
            <h1 class="text-white text-2xl bg-blue-500 text-center rounded">Edit Admin</h1>

            <?php
            $action =  BaseURL_admin . 'admins/update.php';
            $method = 'post';
            $btn = 'Edit';
            $formGroup = array(
                [
                    'label' => 'Admin Name',
                    'type' => 'text',
                    'value' => $row['admin_name'],
                    'name' => 'admin_name',
                ],
                [
                    'label' => 'Admin Emial',
                    'type' => 'email',
                    'value' => $row['admin_email'],
                    'name' => 'admin_email',
                ],
                [
                    'label' => 'Admin Salary',
                    'type' => 'text',
                    'value' => $row['salary'],
                    'name' => 'admin_salary',
                ],
                [
                    'label' => '',
                    'type' => 'hidden',
                    'value' => $row['id'],
                    'name' => 'admin_id',
                ],
            );
            $selection = array(

                'label' => 'Branches',
                'name' => 'city_id',
                'options' => array(),

            );
            $stored=[];
            if ($admin_city) {
                $selection['options'][] = ['value' => $admin_city['id'], 'name' => $admin_city['city_name']];
                $stored = [$admin_city['id']];
            }

                $selection['options'][] = ['value' => 'NULL', 'name' => 'NULL'];
            
            foreach ($cities as $city) {
                if (array_search($city['id'], $stored) !== false) {
                    continue;
                }
                $stored[] = $city['id'];
                $selection['options'][] = ['value' => $city['id'], 'name' => $city['city_name']];
            }

            require_once(componentsDirectory . 'form.php') ?>


        </div>
    </div>

    <?php
    require_once(componentsDirectory . 'footer.php');
    ?>