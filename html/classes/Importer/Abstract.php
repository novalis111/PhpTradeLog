<?php

abstract class Importer_Abstract extends AbstractPtl
{
    public function __construct()
    {
        $this->_init();
    }

    abstract public function processFile($path);
}