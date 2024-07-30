<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/validate.php');



if (isset($_POST['submit'])) {
    
    if (isset( $_POST['admin_id'] )) {
        $admin_name = $_POST['admin_name'];
        $id = $_POST['admin_id'];
        $admin_email = $_POST['admin_email'];
        $admin_salary = $_POST['admin_salary'];
        $error = [];

        if (isEmpty($admin_name)) {
            $error[] = 'Admin name is empty';
        }elseif(isEmpty($admin_email)){
            $error[] = 'Admin email is empty';
        } elseif(isEmpty($admin_salary)){
            var_dump('sdf');
            $error[]='Admin salary is empty';
        }
        else {
            if (isLessThan($admin_name, 3)) {
                $error[] = 'City name must be at least 3 characters';
            } elseif(!isEmail($admin_email)){
                $error[] = 'please enter a valid email address';
            }elseif(!DB_isUnique('admin_email' , $admin_email)){
                $error[] = 'Email is already registered';
            }elseif(!isNumber($admin_salary)){
                $error[] = 'salaray must be a number';
            }
            else {
                $attrs_value = [
                    'admin_name' => $admin_name,
                    'admin_email' => $admin_email,
                    'salary' => $admin_salary
                ];
                $condition = "where id = $id";
                DB_update($attrs_value, $condition);
                $attrs_value_city = [
                    'admin_id' => $id,
                ];
                $city_id = $_POST['city_id'];
                $condition_city = "where id = $city_id";
                DB_update($attrs_value_city, $condition_city , 'cities');
                $success = 'Admin was updated successfully';
                header('location:' . BaseURL_admin . "admins/edit.php?admin_id=$id&success=$success");
            }
        }
        if (count($error) > 0) {
            $error = implode(',', $error);
            header('location:' . BaseURL_admin . "admins/edit.php?admin_id=$id&error=$error");
        }
    }
}
