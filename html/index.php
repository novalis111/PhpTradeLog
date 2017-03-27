<?php

define('PTL_ROOT', realpath(__DIR__) . DIRECTORY_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);
require(PTL_ROOT . 'config.php');

Ptl::getInstance()->bootstrap();
Ptl::route();