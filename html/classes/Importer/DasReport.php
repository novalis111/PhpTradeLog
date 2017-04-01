<?php

class Importer_DasReport extends Importer_Abstract
{
    public function processFile($path)
    {
        $fh = fopen($path, 'r');
        $firstRow = true;
        $map = [];
        $accountId = (int)$_POST['account_id'];
        while ($row = fgetcsv($fh)) {
            if ($firstRow) {
                $map = $row;
                $firstRow = false;
                continue;
            }
            $mapRow = [];
            foreach ($row as $k => $v) {
                $mapRow[$map[$k]] = $v;
            }
            // Insert/Update into Trading Table
            /*
             *
             *
TradeID = "9"
OrderID = "50"
Trader = "ST2403"
Account = "TR93818"
Branch = "SURE"
route = "SMAT"
bkrsym = ""
rrno = ""
B/S = "B"
SHORT = "N"
Market = "Lmt"
symb = "INNV"
qty = "5000"
price = "0.11"
time = "03/27/17 07:26:06"
            */
            $timezone = new DateTimeZone('EST');
            $dateTime = DateTime::createFromFormat("m/d/y H:i:s", $mapRow['time'], $timezone)->format("Y-m-d H:i:s");
            $this->_db->query("
                INSERT INTO trades (account_id, date, source, symbol, side, type, pos_size, price)
                VALUES(
                  '$accountId',
                  '$dateTime',
                  'file',
                  '{$mapRow['symb']}',
                  '{$this->_getOrderSide($mapRow)}',
                  '{$mapRow['Market']}',
                  '{$mapRow['qty']}',
                  '{$mapRow['price']}'
                )
            ");
        }
        fclose($fh);
        die;
    }

    protected function _getOrderSide($row)
    {
        if ($row['B/S'] == 'B') {
            $type = 'buy';
        } elseif ($row['B/S'] == 'S' && $row['SHORT'] == 'N') {
            $type = 'sell';
        } elseif ($row['B/S'] == 'S' && $row['SHORT'] == 'Y') {
            $type = 'short';
        } else {
            throw new Exception("Unknown Order type: " . print_r($row, true));
        }
        return $type;
    }
}