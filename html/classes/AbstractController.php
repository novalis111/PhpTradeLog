<?php

abstract class AbstractController extends AbstractPtl
{
    protected $_tpl;

    public function __construct()
    {
        $this->_init();
        $this->_tpl = new Template();
    }

    abstract public function handleRequest();

    protected function _sanitizeRequest()
    {
        if (isset($_GET['p']) && !in_array($_GET['p'], Ptl::app()->getRoutes())) {
            throw new Exception("Invalid route: " . $_GET['p']);
        }
    }
}