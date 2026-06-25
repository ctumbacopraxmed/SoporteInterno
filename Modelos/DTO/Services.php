<?php

class Services
{
    private $id;
    private $server_id;
    private $name;
    private $description;
    private $file_log;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getFile_log()
    {
        return $this->file_log;
    }

    public function setFile_log($file_log)
    {
        $this->file_log = $file_log;
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
