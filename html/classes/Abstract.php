<?php

class AbstractPtl
{
    /**
     * @var mysqli
     */
    protected $_db;

    protected function _init()
    {
        $this->_db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
}