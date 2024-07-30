<?php 
    require_once('../config.php');
    if(isset($_SESSION['admin'])){
        session_destroy(); 
    }
    header('location:' . BaseURL_admin .'login.php');
?>