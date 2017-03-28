<?php

class ImportController extends AbstractController
{
    public function handleRequest()
    {
        $this->_sanitizeRequest();
        if (isset($_POST['trade_csv'])) {
            $_SESSION['flash'][] = 'Imported file';
            Ptl::redirect();
            die;
        }
        switch ($_GET['a']) {
            default:
                echo $this->_tpl
                    ->setData(['title' => 'Import Trading Data'])
                    ->getHtml('import/index');
                break;
        }
    }
}