<?php




function export($data)
{
    $path = CurrentDirectory . 'storage/'.uniqid(rand(0,100)).'.csv' ;
    $f = fopen($path, 'w');
    if ($f) {
        foreach ($data as $row) {
            fputcsv($f, $row);
        }
    }
    fclose($f);
    return $path;
}
function import($data){
    
}
