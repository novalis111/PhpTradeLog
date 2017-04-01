<?php

class Ptl extends AbstractPtl
{
    private static $_instance;
    protected $_routes;
    protected $_config = [];

    /**
     * Ptl constructor. Singleton
     */
    private function __construct()
    {
        $this->_init();
    }

    public static function app()
    {
        if (!self::$_instance instanceof Ptl) {
            self::$_instance = new Ptl();
        }
        return self::$_instance;
    }

    public static function route()
    {
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

    public function setConfig($key, $value)
    {
        $this->_config[$key] = $value;
        return $this;
    }

    public function getConfig($key)
    {
        if (isset($this->_config[$key])) {
            return $this->_config[$key];
        }
        return null;
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
        $this->_routes = ['index', 'import'];
        // Accounts + Brokers
        foreach ($this->_db->query("SELECT * FROM `accounts`") as $row) {
            $broker = new Broker();
            $this->_config['accounts'][$row['id']] = [
                'token'  => $row['token'],
                'broker' => $broker->load($row['broker_id']),
            ];
        }
    }

    private function _initDb()
    {
        $initFile = PTL_ROOT . 'assets' . DS . 'db' . DS . 'init.sql';
        if (!is_file($initFile)) {
            throw new Exception("DB Init File not found: $initFile");
        }
        try {
            $this->_db->begin_transaction();
            $this->_db->real_query(file_get_contents($initFile));
            $this->_db->commit();
        } catch (Exception $e) {
            $this->_db->rollback();
            throw $e;
        }
    }
}