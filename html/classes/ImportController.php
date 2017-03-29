<?php

class ImportController extends AbstractController
{
    public function handleRequest()
    {
        $this->_sanitizeRequest();
        $postAction = isset($_POST['action']) ? (string)$_POST['action'] : false;
        if ($postAction) {
            try {
                switch ($postAction) {
                    case 'import_trades':
                        $this->_importFile($_FILES['trades_file']['tmp_name'], $_POST['trades_format']);
                        $_SESSION['flash'][] = 'Imported file';
                        break;
                    default:
                        throw new Exception("Invalid action: $postAction");
                        break;
                }
            } catch (Exception $e) {
                $_SESSION['flash'][] = "Error: " . $e->getMessage();
            }
            Ptl::redirect();
            die;
        }
        $action = isset($_GET['a']) ? (string)$_GET['a'] : false;
        switch ($action) {
            default:
                echo $this->_tpl
                    ->setData(['title' => 'Import Trading Data'])
                    ->getHtml('import/index');
                break;
        }
    }

    private function _importFile($path, $format)
    {
        if (!is_file($path)) {
            throw new Exception("Invalid file: $path");
        }
        $importer = Importer::factory($format);
        $importer->processFile($path);
    }
}