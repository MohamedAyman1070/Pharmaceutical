<?php
require_once('../../config.php');
require_once(componentsDirectory . '/header.php');
require_once(CurrentDirectory . '/functions/validate.php');
require_once(CurrentDirectory . '/functions/db.php' );
?>


<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $city_id = $_POST['city_id'];
    $error = [];

    if (isEmpty($name)  and isEmpty($price) and isEmpty($quantity)) {
        $error[] = 'Name is required';
        $error[] = 'Price is required';
        $error[] = 'Number of Items is required';
    } else {
                $attrs_val =[
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity ,
                    'city_id' => $city_id,
                ];
                DB_insert($attrs_val , 'pharmaceutical') ? $success = "New Pharmaceutical is Added successfully"  : $error[] = "something went wrong";
            }
                require_once(CurrentDirectory . '/functions/messages.php');
}

?>

<div class=" p-2 m-auto w-4/5 flex flex-col items-center justify-center  text-white">
    <div class="mt-40 w-4/5">
        <h1 class="text-4xl text-center bg-blue-500">Add Pharmaceuticals</h1>
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
                            'label' => 'Price',
                            'type' => 'text',
                            'value' =>'',
                            'name' => 'price',
                        ],
                        [
                            'label' => 'Quantity',
                            'type' => 'text',
                            'value' =>'',
                            'name' => 'quantity',
                        ],
                    );
                    if(is_superAdmin()):
                        $selection = [
                            'label' => 'Branches',
                            'name' => 'city_id',
                            'options' => array(),
                        ];
                        $cities = getData('id , city_name' , 'cities');
                        foreach($cities as $city){
                            $selection['options'][] = array('value'=>$city['id'] , 'name'=>$city['city_name']);
                        }
                    else:
                        $branch = getRow('admin_id' , $admin['id'] , 'cities');
                        $formGroup[] = [
                            'label' => '',
                            'type' => 'hidden',
                            'value' =>$branch['id'],
                            'name' => 'city_id',
                        ];
                    endif;
                    
                require_once(componentsDirectory.'form.php')?>

    </div>
</div>



<?php
require_once(componentsDirectory . '/footer.php');
?>