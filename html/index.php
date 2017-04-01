<?php

define('PTL_ROOT', realpath(__DIR__) . DIRECTORY_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);
require(PTL_ROOT . 'config.php');

try {
    Ptl::app()->bootstrap();
    Ptl::route();
} catch (Exception $e) {
    $ct = new IndexController();
    $ct->error($e);
}