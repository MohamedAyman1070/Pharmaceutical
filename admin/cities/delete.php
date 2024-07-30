<?php
require_once('../../config.php');
require_once(CurrentDirectory . 'functions/db.php');
require_once(CurrentDirectory . 'functions/authorization.php');
if(!is_superAdmin()){
    header('location:'.BaseURL);
}
if (isset($_POST['submit'])) {

    $city_id = $_POST['city_id'];
    $city = getRow('id', $city_id, 'cities');

    if ($city) {
        $sql = " DELETE FROM cities WHERE id = $city_id";
        DB_delete($sql);
        header('location:' . BaseURL_admin.'cities');

    } else {
        header('location:'. BaseURL . '404.php', 404);

    }
}else{
    header('location:'. BaseURL . '404.php', 404);

}
