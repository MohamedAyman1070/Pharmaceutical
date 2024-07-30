<?php



function isEmpty (string $val ):bool{
    
  
    return empty($val);
}


function isLessThan( string $val, int $min){
    return strlen(trim($val)) < $min;
}

function isNumber($val){
    return preg_match("/\d/" , $val);
}


function isEmail(string $email):bool{
    
    return filter_var($email , FILTER_VALIDATE_EMAIL );
}
