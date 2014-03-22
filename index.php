<?php

define('DOCROOT', dirname(__FILE__));

include_once DOCROOT.'/includes/config.inc';

function __autoload($class_name) {
    $filename = DOCROOT.'/classes/'.$class_name . '.php';
    require_once $filename;
 
}

use \Listener as Listener;

?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $listener = new Listener();
        $listener->returnFirstResponse($_POST);
        
        ?>
    </body>
</html>
