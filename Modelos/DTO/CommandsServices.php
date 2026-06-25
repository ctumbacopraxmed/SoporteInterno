<?php

class CommandsServices
{
    private $id;
    private $server_id;
    private $service_id;
    private $name;
    private $command;
    private $status;

    function __construct() {}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getServer_id()
    {
        return $this->server_id;
    }

    public function setServer_id($server_id)
    {
        $this->server_id = $server_id;
        return $this;
    }

    public function getService_id()
    {
        return $this->service_id;
    }

    public function setService_id($service_id)
    {
        $this->service_id = $service_id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
