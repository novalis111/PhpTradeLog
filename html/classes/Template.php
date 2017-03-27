<?php

class Template
{
    private $_data;

    public function __construct()
    {
        $this->_data = [];
    }

    protected function _render($section)
    {
        $path = implode(DS, explode('/', $section));
        $tplFile = $path . '.phtml';
        ob_start();
        if (file_exists(PTL_TPL_ROOT . DS . $tplFile)) {
            try {
                /** @noinspection PhpIncludeInspection */
                include(PTL_TPL_ROOT . DS . $tplFile);
            } catch (Exception $e) {
                ob_clean();
                throw $e;
            }
        } else {
            throw new Exception("Template not found: $tplFile");
        }
        return ob_get_clean();
    }

    protected function _getBody()
    {
        return $this->_render($this->_data['body']);
    }

    public function setData(Array $data)
    {
        $this->_data = $data;
        return $this;
    }

    public function getHtml($section)
    {
        $this->_data['body'] = $section;
        return $this->_render('layout/layout');
    }

    public function getSkin($file)
    {
        $path = PTL_TPL_ROOT . DS . 'skin' . DS . $file;
        if (!is_file($path)) {
            return '';
        }
        return '/templates/' . PTL_TPL . '/skin/' . $file;
    }

    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function __get($key)
    {
        if (!isset($this->_data[$key])) {
            throw new Exception("No value for '$key' defined");
        }
        return $this->_data[$key];
    }
}