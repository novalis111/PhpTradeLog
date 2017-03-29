<?php

class Importer extends AbstractPtl
{
    public static function factory($format)
    {
        switch ($format) {
            case 'dastrader_report':
                $importer = new Importer_DasReport();
                break;
            default:
                throw new Exception("Unknown format: $format");
                break;
        }
        return $importer;
    }
}