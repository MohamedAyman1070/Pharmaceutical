<?php
require_once('../../config.php');
require_once(componentsDirectory . 'header.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/validate.php');



if (isset($_POST['submit'])) {
    
    if (isset($_POST['pharma_name'], $_POST['pharma_id'],$_POST['pharma_quantity'],$_POST['pharma_price'])) {
        $pharma_name = $_POST['pharma_name'];
        $pharma_price = $_POST['pharma_price'];
        $pharma_price = trim($pharma_price);
        $pharma_quantity = $_POST['pharma_quantity'];
        $pharma_quantity = trim($pharma_quantity);
        $id = $_POST['pharma_id'];
        $error = [];


        if (isEmpty($pharma_name)) {
            $error[] = 'Pharmaceutical name is empty';
        }
        elseif(isEmpty($pharma_price)){
            $error[] = "Price is Empty";
        }elseif(isEmpty($pharma_quantity)){
            $error[] = "Quantity is Empty";
        }
        else {
            if (isLessThan($pharma_name, 3)) {
                $error[] = 'Pharmaceutical must be at least 3 characters';
            }elseif(!isNumber($pharma_price) || !isNumber($pharma_quantity)){
                $error[] = "price and quantity must be a numerical value"; 
            } 
            else {
                $attrs_value = [
                    'name' => $pharma_name,
                    'price' => $pharma_price,
                    'quantity' => $pharma_quantity,
                ];
                $condition = "where id = $id";
                DB_update($attrs_value, $condition , 'pharmaceutical');
                $success = 'Pharmaceutical was updated successfully';
                header('location:' . BaseURL_admin . "pharmaceutical/edit.php?pharma_id=$id&success=$success");
            }
        }
        if (count($error) > 0) {
            $error = implode(',', $error);
            header('location:' . BaseURL_admin . "pharmaceutical/edit.php?pharma_id=$id&error=$error");
        }
    }
}
