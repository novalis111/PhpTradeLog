<?php

abstract class AbstractController
{
    protected $_db;
    protected $_tpl;

    public function __construct()
    {
        $this->_db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->_tpl = new Template();
    }

    abstract public function handleRequest();

    protected function _sanitizeRequest()
    {
        if ($_GET['p'] && !in_array($_GET['p'], Ptl::getInstance()->getRoutes())) {
            throw new Exception("Invalid route: " . $_GET['p']);
        }
    }
}