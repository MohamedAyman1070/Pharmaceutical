<?php

require_once('../../config.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/authorization.php');


if (isset($_POST['submit'])) {
    
    $order_id = $_POST['order_id'];
    $order = getRow('id', $order_id , 'orders');
    $branch = getRow('id' ,$order['city_id'] ,'cities' );
    if(!can('update_delete' , $branch['admin_id'])){
        header('location:'.BaseURL.'403.php');
    }
    
    if ($order) {
        $sql = " DELETE FROM orders WHERE id = $order_id";
        DB_delete($sql);
      
        header('location:' . BaseURL_admin.'orders');

    } else {
    header('location:'. BaseURL . '404.php', 404);
    }
}else{
    header('location:'. BaseURL . '404.php', 404);
}
