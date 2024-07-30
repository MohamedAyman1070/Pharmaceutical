<?php
require_once('../config.php');
require_once(CurrentDirectory . 'functions/db.php');


function Admin_Create(int $times)
{
    $admin = getRow('admin_email' , 'admin@super.com');
    if(!$admin){
        $admin_data = [
            'admin_name' => "super_admin" ,
            'admin_password' => password_hash('000', PASSWORD_DEFAULT),
            'admin_email' => "admin@super.com",
            'admin_type' => 'super_admin',
        ];
        $added = db_insert($admin_data);
    }
    for ($i = 0; $i < $times; $i++) {
        $admin_data = [
            'admin_name' => "admin" . "$i",
            'admin_password' => password_hash('password', PASSWORD_DEFAULT),
            'admin_email' => "admin" . "$i" . "@pharma.com",
            'admin_type' => 'admin',
            'salary' => rand(3000 ,10000),
        ];
        $added = db_insert($admin_data);
        if ($added) {
            echo "admin added successfully <br>";
        }
    }
}

function Branch_Create($times)
{
    $admins = getData('id');
    if (!$admins) {
        Admin_Create($times);
        $admins = getData('id');
    }
    for ($i = 0; $i < $times; $i++) {
        $city_data = [
            'city_name' => "Branch" . "$i",
            'admin_id' => $admins[$i%count($admins)]['id'],
        ];
        $added = db_insert($city_data, 'cities');
        if ($added) {
            echo "branch added successfully <br>";
        }
    }
}


function Pharma_Create($times){
    $branches = getData('id' ,'cities');
    if (!$branches) {
        Branch_Create($times);
        $branches = getData('id' , 'cities');
    }
    for ($i = 0; $i < $times; $i++) {
        $pharma_data = [
            'name' => 'pharma'. "$i",
            'price' => rand(50 , 1000),
            'quantity' => rand(10 , 1000 ),
            'city_id' => $branches[$i%count($branches)]['id'],
        ];
        $added = db_insert($pharma_data, 'pharmaceutical');
        if ($added) {
            echo "pharma added successfully <br>";
        }
    }
}

function Order_Create($times){
    $pharma = getData('id','pharmaceutical');
    if (!$pharma) {
        Pharma_Create($times);
        $pharma = getData('id' , 'pharmaceutical');
    }
    $branches = getData('id' ,'cities');
    for ($i = 0; $i < $times; $i++) {
        $rnum = range(0,8) ;
        array_walk($rnum , function(&$val){
            $val = rand(0,9);
        });
        $order_data = [
            'order_name' => 'client'. "$i",
            'order_email' => 'client'."$i".'@pharma.com',
            'order_mobile'=> '0'.(string)rand(10,12).implode('' ,$rnum),
            'order_notes' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum voluptas cum iure quaerat beatae, necessitatibus omnis veniam ut sunt, numquam nam ipsa maiores tempore nesciunt est cupiditate aliquid dignissimos repellendus.',
            'city_id' => $branches[$i%count($branches)]['id'],
            'pharmaceutical_id' => $pharma[$i%count($pharma)]['id'],
        ];
        $added = db_insert($order_data, 'orders');
        if ($added) {
            echo "order added successfully <br>";
        }
    }
}
Order_Create(50);
