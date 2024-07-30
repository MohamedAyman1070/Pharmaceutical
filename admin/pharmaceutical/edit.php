<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/validate.php');
?>


<?php

if (isset($_GET['pharma_id'])) {
    $pharma_id = $_GET['pharma_id'];

    $sql = "SELECT  c.city_name  , c.id as city_id , ph.name ,ph.price ,ph.quantity FROM cities c join pharmaceutical ph  on c.id = ph.city_id where ph.id = $pharma_id";
    $pharma_city = DB_explicit_sql($sql);
    $pharma_city ? $pharma_city = $pharma_city[0] : '';
    $branch = getRow('id', $pharma_city['city_id'], 'cities');
    if (!can('update_delete', $branch['admin_id']) && !is_superAdmin()) {
        header('location:' . BaseURL . '403.php');
    }
    $row = getRow('id', $pharma_id, 'pharmaceutical');
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
            $action =  BaseURL_admin . 'pharmaceutical/update.php';
            $method = 'post';
            $btn = 'Edit';
            $formGroup = array(
                [
                    'label' => 'Pharmaceutical',
                    'type' => 'text',
                    'value' => $row['name'],
                    'name' => 'pharma_name',
                ],
                [
                    'label' => 'Price',
                    'type' => 'text',
                    'value' => $row['price'],
                    'name' => 'pharma_price',
                ],
                [
                    'label' => 'Quantity',
                    'type' => 'text',
                    'value' => $row['quantity'],
                    'name' => 'pharma_quantity',
                ],
                [
                    'label' => '',
                    'type' => 'hidden',
                    'value' => $row['id'],
                    'name' => 'pharma_id',
                ],
            );
            if (is_superAdmin()) {
                $selection = array(

                    'label' => 'Branches',
                    'name' => 'city_id',
                    'options' => array(),

                );
                $stored = [];
                if ($pharma_city) {
                    $selection['options'][] = ['value' => $pharma_city['city_id'], 'name' => $pharma_city['city_name']];
                    $stored = [$pharma_city['city_id']];
                }

                $selection['options'][] = ['value' => 'NULL', 'name' => 'NULL'];

                foreach ($cities as $city) {
                    if (array_search($city['id'], $stored) !== false) {
                        continue;
                    }
                    $stored[] = $city['id'];
                    $selection['options'][] = ['value' => $city['id'], 'name' => $city['city_name']];
                }
            }

            require_once(componentsDirectory . 'form.php') ?>


        </div>
    </div>

    <?php
    require_once(componentsDirectory . 'footer.php');
    ?>