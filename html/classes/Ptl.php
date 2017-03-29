<?php

class Ptl extends AbstractPtl
{
    private static $_instance;
    protected $_routes;

    /**
     * Ptl constructor. Singleton
     */
    private function __construct()
    {
        $this->_init();
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof Ptl) {
            self::$_instance = new Ptl();
        }
        return self::$_instance;
    }

    public static function route()
    {
        try {
            $page = isset($_GET['p']) ? (string)$_GET['p'] : false;
            switch ($page) {
                case 'import':
                    $ct = new ImportController();
                    break;
                default:
                    $ct = new IndexController();
                    break;
            }
            $ct->handleRequest();
        } catch (Exception $e) {
            $ct = new IndexController();
            $ct->error($e);
        }
    }

    public static function redirect($page = false, $data = [])
    {
        header('Location: ' . self::url($page, $data));
        exit;
    }

    public static function url($page = false, Array $data = [])
    {
        $href = PTL_URL . 'index.php';
        $parts = [];
        if ($page) {
            $parts[] = 'p=' . $page;
        }
        if (isset($data['action'])) {
            $parts[] = 'a=' . $data['action'];
        }
        if (count($parts)) {
            $href = $href . '?' . array_shift($parts) . implode('&', $parts);
        }
        return $href;
    }

    public function setRoutes($routes)
    {
        $this->_routes = $routes;
        return $this;
    }

    public function getRoutes()
    {
        return $this->_routes;
    }

    public static function translate($label)
    {
        return $label;
    }

    public function bootstrap()
    {
        session_start(['cookie_lifetime' => 86400]);
        $version = $this->_db->query("SELECT `value` AS version FROM `config` WHERE `key` = 'version'");
        if (!$version instanceof mysqli_result) {
            // No version on DB set, init it
            self::_initDb();
        } else {
            // Check if DB needs migration
            $version = (int)$version->fetch_assoc()['version'];
        }
    }

    private function _initDb()
    {
        $initFile = PTL_ROOT . 'assets' . DS . 'db' . DS . 'db_init.sql';
        $handle = fopen($initFile, "r");
        $sql = explode(';', fread($handle, filesize($initFile)));
        foreach ($sql as $query) {
            if (trim($query) == '') {
                continue;
            }
            $this->_db->query($query);
        }
        fclose($handle);
    }
}