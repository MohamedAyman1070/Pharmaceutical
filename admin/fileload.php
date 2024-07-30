<?php

use function PHPSTORM_META\type;

require_once('../config.php');
require_once(CurrentDirectory . 'functions/csvHandler.php');
if (isset($_POST['submit_export'])) {
    $data = $_POST['data'];
    $data = explode("==", $data);
    $csv_data = array();
    foreach ($data as $row) {
        $csv_data[] = explode(",", $row);
    }

    $path = export($csv_data);
    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename = ' . basename($path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        unlink($path);
    }
}
if (isset($_POST['submit_import'])) {
    $error = [];
    $filename = $_FILES['csv_file']['name'];
    $destination = CurrentDirectory . 'storage/' . uniqid() . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['csv_file']['tmp_name'];
    $size = $_FILES['csv_file']['size'];
    $data_csv = [];
    if ($extension !== 'csv') {
        $error[] = 'Please import a csv file.';
    } elseif ($size > 1000000) { //1MB 
        $error[] = 'File is too large';
    } else {
        if (move_uploaded_file($file, $destination)) {
            $f = fopen($destination ,'r');
            while (($row = fgetcsv($f)) !== false) {
                $data_csv[] = $row;
            }
            unlink($destination);
        }
    }

    $error ? $error = implode('*', $error) : '';
    $url = $_SERVER['HTTP_REFERER'];
    $url_arr = str_split($url);

    if (in_array('?', $url_arr)) {
        array_splice($url_arr, array_search('?', $url_arr));
        $url = implode($url_arr);
    }

    if (count($error) > 0) :
        header('location:' . $url . "?error=$error");
    else :
        if (count($data_csv) < 1) :
            $error[] = 'The File You Uploaded Is Empty';
            header('location:' . $url . "?error=$error");
        else :
            $data = '';
            foreach($data_csv as $row):
                $data .= implode('*' , $row) .'==';
            endforeach;
            header('location:' . $url . "?data_csv=$data");
        endif;
    endif;
}
