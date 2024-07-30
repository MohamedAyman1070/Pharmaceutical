<?php
require_once(CurrentDirectory . 'functions/authorization.php');

if (!isset($_SESSION['admin'])) {
    header('location:' . BaseURL_admin . "login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Pro</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="<?php echo BaseURL_assets . 'css/output.css' ?>">
    <!-- <link rel="stylesheet" href="/assets/css/output.css"> -->
    <?php include_once(componentsDirectory . 'navbar.php') ?>

</head>

<body class="h-screen ">