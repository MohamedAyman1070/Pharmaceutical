<?php
require_once('../../config.php');
require_once(componentsDirectory . '/header.php');
require_once(CurrentDirectory . '/functions/validate.php');
require_once(CurrentDirectory . '/functions/db.php' );
?>


<?php

if(!is_superAdmin()){
    header('location:'.BaseURL);
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $admin_password = $_POST['password'];
    $error = [];

    if (isEmpty($name)  and isEmpty($email) and isEmpty($admin_password)) {
        $error[] = 'Name is required';
        $error[] = 'Email is required';
        $error[] = 'Passsword is required';
    } else {
        if (isEmail($email)) {
            if(DB_isUnique('admin_email' , $email)){
                $attrs_val =[
                    'admin_name' => $name,
                    'admin_email' => $email,
                    'admin_password' => password_hash($admin_password ,PASSWORD_DEFAULT),
                ];
                DB_insert($attrs_val) ? $success = "Admin is Added successfully"  : $error[] = "something went wrong";
            }
            else{
                $error[]= "Email is already in use";
            }
        } else {
            $error[] = 'please enter a valid Email';
        }
    }
    require_once(CurrentDirectory . '/functions/messages.php');
}

?>


<div class=" p-2 m-auto w-4/5 flex flex-col items-center justify-center  text-white">
    <div class="mt-40 w-4/5">
        <h1 class="text-4xl text-center bg-blue-500">Add New Admin</h1>
        <?php 
                    $action = $_SERVER['PHP_SELF']  ;
                    $method = 'post';
                    $btn = 'Save';
                    $formGroup = array(
                        [
                            'label' => 'Name',
                            'type' => 'text',
                            'value' =>'',
                            'name' => 'name',
                        ],
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
                        ],
                    );
                    
                require_once(componentsDirectory.'form.php')?>

    </div>
</div>



<?php
require_once(componentsDirectory . '/footer.php');
?>