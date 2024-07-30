<?php
require_once('../config.php');
require_once(CurrentDirectory . 'functions/validate.php');
require_once(CurrentDirectory . 'functions/db.php');
?>


<?php

    if(isset($_SESSION['admin'])){
        header('location:'.CurrentDirectory.'/index.php');
    }

    if(isset($_POST['submit'])){
        $error = [];
        $email = $_POST['email'];
        $admin_password = $_POST['password'];
        if( isEmpty($email) AND isEmpty($admin_password)){
            $error[] = "Email is required";
            $error[] = "Password is required";
        }else{
            if(isEmail($email)){
               $admin = getRow('admin_email' , $email);

               if($admin){
                    if(password_verify($admin_password,$admin['admin_password'])){
                        $success= 'welcome admin';
                        $admin_obj = [
                            'id' => $admin['id'],
                            'admin_name' => $admin['admin_name'],
                            'admin_email' => $admin['admin_email'],
                            'admin_type' => $admin['admin_type'],
                            //'admin_password' => $admin['admin_password'],
                        ];
                        $_SESSION['admin'] = $admin_obj;
                        header('Location:'.BaseURL_admin.'/index.php');
                    }
                    else{
                        $error[] = "password verification failed";
                    }

               }else{
                $error[]= "Email is not registered";
               }

               
            }
        }

    }

    require_once(CurrentDirectory.'/functions/messages.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmaceutical</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="<?php echo BaseURL_assets . 'css/output.css' ?>">
</head>

<body class="  h-screen w-screen">
    <div class=" flex justify-center items-center w-full sm:w-96 h-screen m-auto">
        <div class="w-full">
            <h1 class="text-white text-2xl bg-blue-500 text-center rounded">Login</h1>
            <div >
                <?php 
                    $action =  $_SERVER['PHP_SELF'] ;
                    $method = 'post';
                    $btn = 'Login';
                    $formGroup = array(
                        [
                            'label' => 'Email',
                            'type' => 'email',
                            'value' =>'',
                            'name' => 'email',
                        ],
                        [
                            'label' => 'Password',
                            'type' => 'password',
                            'value' =>'',
                            'name' => 'password',
                        ]
                    );
                require_once(componentsDirectory.'form.php')?>
          
            </div>
        </div>
    </div>
</body>

</html>