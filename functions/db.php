<?php

$hostName = "localhost";
$username = "root";
$password = "01006059030app";
$dbName = "medical_DB";


$conn = mysqli_connect($hostName, $username, $password, $dbName);

if (!$conn) {
    die("connnection failed" . mysqli_connect_error());
}

function DB_insert(array $attrs_value, $table = "Admins")
{
    $sql = "INSERT INTO " . $table . "(";
    $attrs = array_keys($attrs_value);
    $values = array_values($attrs_value);
    foreach ($attrs as $attr) {
        $sql .= $attr . ",";
    }
    $sql[-1] = ")";
    $sql .= " values(";
    foreach ($values as $val) {
        $sql .= "'" . $val . "',";
    }
    $sql[-1] = ")";

    global $conn;
    $res = mysqli_query($conn, $sql);
    return $res ? true : false;
}
function DB_update(array $attrs_value, $condition, $table = "Admins")
{

    $sql = "UPDATE " . $table . " SET ";

    foreach ($attrs_value as $attr => $val) {
        $sql .= " $attr = '$val' ,";
    }

    $sql[-1] = " ";
    $sql .= $condition;
    global $conn;
    $res = mysqli_query($conn, $sql);
    return $res ? true : false;
}


function getData($field, $table = 'Admins')
{
    global $conn;
    $sql = "SELECT $field FROM `$table` order by created_at desc";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    return false;
}


function getRow($field, $value, $table = 'Admins')
{
    global $conn;
    $sql = "SELECT * FROM `$table` WHERE `$field` = '$value' ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $rows = [];
        if (mysqli_num_rows($result) > 0) {
            $rows[] = mysqli_fetch_assoc($result);
            return $rows[0];
        }
    }
    return false;
}


function DB_isUnique($field, $value, $table = 'Admins')
{
    $row = getRow($field, $value, $table);
    return $row ? false : true;
}


function DB_explicit_sql(string $sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $rows = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[]  = $row;
            }
            return $rows;
        }
    }
    return false;
}

function DB_delete($sql){
    global $conn ;
    return mysqli_query($conn ,$sql) ? true :false;
}
