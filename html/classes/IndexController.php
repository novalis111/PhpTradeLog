<?php

class IndexController extends AbstractController
{
    public function error(Exception $e)
    {
        echo $this->_tpl->setData(['title' => 'Error', 'error' => $e->getMessage()])->getHtml('index/error');
    }

    public function handleRequest()
    {
        $this->_sanitizeRequest();
        $action = isset($_GET['a']) ? (string)$_GET['a'] : false;
        switch ($action) {
            default:
                echo $this->_tpl
                    ->setData([
                        'trades' => [],
                        'title'  => 'Tradelog',
                    ])
                    ->getHtml('index/index');
                break;
        }
    }
}