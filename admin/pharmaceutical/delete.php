<?php

require_once('../../config.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/authorization.php');

if (isset($_POST['submit'])) {
    
    $pharma_id = $_POST['pharma_id'];
    $pharma = getRow('id', $pharma_id , 'pharmaceutical');
    $branch = getRow('id' ,$pharma['city_id'] ,'cities' );
    if(!can('update_delete' , $branch['admin_id'])){
        header('location:'.BaseURL.'403.php');
    }
    
    if ($pharma) {
        $sql = " DELETE FROM pharmaceutical WHERE id = $pharma_id";
        DB_delete($sql);
      
        header('location:' . BaseURL_admin.'pharmaceutical');

    } else {
    header('location:'. BaseURL . '404.php', 404);
    }
}else{
    header('location:'. BaseURL . '404.php', 404);
}
