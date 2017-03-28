<?php

class IndexController extends AbstractController
{
    public function error(Exception $e)
    {
        echo $this->_tpl->setData(['error' => $e->getMessage()])->getHtml('index/error');
    }

    public function handleRequest()
    {
        $this->_sanitizeRequest();
        switch ($_GET['a']) {
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