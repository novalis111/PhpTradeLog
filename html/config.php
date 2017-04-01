<?php

define('PTL_URL', '/');
define('PTL_TPL', 'default');
define('DB_HOST', 'ptl_db');
define('DB_USER', 'ptl');
define('DB_PASS', 'ptl');
define('DB_NAME', 'ptl');

/*
 * DO NOT EDIT BELOW THIS LINE
 */
define('PTL_TPL_ROOT', PTL_ROOT . 'templates' . DS . PTL_TPL);

/**
 * Include used classes
 */
foreach (['classes', 'classes' . DS . 'Importer'] as $incPath) {
    if ($handle = opendir(PTL_ROOT . $incPath)) {
        while (false !== ($entry = readdir($handle))) {
            if (strpos($entry, '.php') !== false) {
                /** @noinspection PhpIncludeInspection */
                require(PTL_ROOT . $incPath . DS . $entry);
            }
        }
        closedir($handle);
    }
}