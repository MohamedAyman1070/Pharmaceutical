<?php
require_once('../../config.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/authorization.php');


if(!is_superAdmin()){
    header('location:'.BaseURL);
}
if (isset($_POST['submit'])) {
    
    $admin_id = $_POST['admin_id'];
    $admin = getRow('id', $admin_id);
    if ($admin) {
        $sql = " DELETE FROM admins WHERE id = $admin_id";
        DB_delete($sql);
      
        header('location:' . BaseURL_admin.'admins');

    } else {
    header('location:'. BaseURL . '404.php', 404);
    }
}else{
    header('location:'. BaseURL . '404.php', 404);
}
