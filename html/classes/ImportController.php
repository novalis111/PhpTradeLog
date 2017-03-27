<?php

class ImportController extends AbstractController
{
    public function handleRequest()
    {
        $this->_sanitizeRequest();
        switch ($_GET['a']) {
            default:
                echo $this->_tpl->render('import/index');
                break;
        }
    }
}