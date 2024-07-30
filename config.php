<?php

session_start();



define('BaseURL' , 'http://localhost:8081/websites/medical_pro/');
define('BaseURL_admin' , BaseURL.'admin/');
define('BaseURL_assets' , BaseURL.'assets/');


define('CurrentDirectory' , __DIR__.'/');
define('CurrentDirectory_admin' ,__DIR__.'/admin/');

define('layoutDirectory', __DIR__.'/layouts/');
define('componentsDirectory', __DIR__.'/components/');

require_once(CurrentDirectory . 'functions/db.php');




