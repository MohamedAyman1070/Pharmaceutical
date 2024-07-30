<?php
// require_once('../config.php');

$admin = $_SESSION['admin'];
$branch = getRow('admin_id' , $admin['id'] , 'cities');
$rules = [
    'update_delete' => function ($id) use ($admin) {
        return $admin['id'] === $id;
    },
    'add' => function ($id) use ($admin){
        return $admin['id'] === $id;
    },
];



function is_superAdmin()
{
    global $admin ;
    return $admin['admin_type'] === 'super_admin';
}

function can(string $rule , $id): bool
{
    global $rules ;
    if(array_key_exists($rule,$rules)){
        return  $rules[$rule]($id);
    }
    return false;
}
