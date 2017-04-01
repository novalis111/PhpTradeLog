<?php

class Broker extends AbstractPtl
{
    protected $_token;
    protected $_rates;

    public function __construct()
    {
        $this->_init();
    }

    public function load($id)
    {
        $row = $this->_db->query("
            SELECT  *
            FROM    brokers
            WHERE   id = '$id'
        ")->fetch_row();
        if (!$row) {
            throw new Exception("Broker with ID $id not found");
        }
        $this->_token = $row['token'];
        $this->_rates = $this->_parseRates($row['rates']);
        return $this;
    }

    private function _parseRates($rates)
    {
        return $rates;
    }
}