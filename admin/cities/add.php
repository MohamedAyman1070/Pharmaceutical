<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/validate.php');
require_once(CurrentDirectory . 'functions/db.php');
?>


<?php

if(!is_superAdmin()){
    header('location:'.BaseURL);
}
if (isset($_POST['submit'])) {
    $city_name = $_POST['city_name'];
    $error = [];
    if (isEmpty($city_name)) {
        $error[] = 'Please enter a city name';
    } else {
        if (isLessThan($city_name, 3)) {
            $error[] = 'City name must be at least 3 characters';
        } else {
            $attrs_val['city_name'] = $city_name;
            $attrs_val['admin_id'] = $_POST['admin'];
            DB_insert($attrs_val, $table = "Cities");
            $success = 'City Added Successfully';
        }
    }
}
require_once(CurrentDirectory . 'functions/messages.php');

?>

<div class="h-screen w-screen ">
    <div class="h-full w-full sm:w-4/5 m-auto  flex justify-center items-center">

        <div class=" w-full sm:w-4/5  text-white">
            <h1 class="p-2 text-2xl bg-blue-500 text-center">Add City</h1>
            <?php
            $action = $_SERVER['PHP_SELF'];
            $method = 'post';
            $btn = 'Save';
            $formGroup = array(
                [
                    'label' => 'City Name',
                    'type' => 'text',
                    'value' => '',
                    'name' => 'city_name',
                ],
            );
            $admins = getData('id , admin_name , admin_email');
            $selection = array(
                'label' => 'Choose Admin',
                'name' => 'admin',
                'options' => array(),

            );
            foreach ($admins as $admin) {
                if ($admin['admin_name'] === 'superAdmin') {
                    continue;
                }
                $selection['options'][] = [
                    'value' => $admin['id'],
                    'name' => $admin['admin_name'],
                ];
            }


            require_once(componentsDirectory . 'form.php') ?>


        </div>

    </div>
</div>

<?php
require_once(componentsDirectory . 'footer.php');
?>