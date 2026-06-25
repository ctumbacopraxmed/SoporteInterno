<?php

class Config
{
    private $config_key;
    private $config_value;

    function __construct() {}

    public function getConfig_key()
    {
        return $this->config_key;
    }

    public function setConfig_key($config_key)
    {
        $this->config_key = $config_key;
        return $this;
    }

    public function getConfig_value()
    {
        return $this->config_value;
    }

    public function setConfig_value($config_value)
    {
        $this->config_value = $config_value;
        return $this;
    }
}
