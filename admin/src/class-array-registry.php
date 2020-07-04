<?php
namespace WP_Speak;

class Array_Registry extends Abstract_Registry
{
    private $data = array();

    public function set($arg_key, $arg_value)
    {
        $this->_data[$arg_key] = $arg_value;
        return $this;
    }

    public function get($arg_key)
    {
        return isset($this->_data[$arg_key]) ? $this->_data[$arg_key] : null;
    }

    public function dump()
    {
        error_log(print_r($this->_data, true));
        return true;
    }
}
