<?php

class Importer_DasReport extends Importer_Abstract
{
    public function processFile($path)
    {
        $fh = fopen($path, 'r');
        $firstRow = true;
        $map = [];
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
            echo "<pre>";
            print_r($mapRow);
            echo "</pre>";
        }
        fclose($fh);
        die;
    }
}