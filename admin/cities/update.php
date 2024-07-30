<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/validate.php');



if (isset($_POST['submit'])) {
    if (isset($_POST['city_name'], $_POST['city_id'])) {
        $city_name = $_POST['city_name'];
        $id = $_POST['city_id'];
        $error = [];

        if (isEmpty($city_name)) {
            $error[] = 'City name is empty';
        } else {
        if (isLessThan($city_name, 3)) {
                $error[] = 'City name must be at least 3 characters';
            } else {
                $attrs_value = [
                    'city_name' => $city_name,
                    'admin_id' => $_POST['admin_id'],
                ];
                $condition = "where id = $id";
                DB_update($attrs_value, $condition, 'cities');
                $success = 'Branch  was updated successfully';
                header('location:'. BaseURL_admin . "/cities/edit.php?city_id=$id&success=$success");
            }
        }
        if (count($error) > 0) {
            $error = implode(',', $error);
            header('location:'. BaseURL_admin . "cities/edit.php?city_id=$id&error=$error");
        }
    }
}
