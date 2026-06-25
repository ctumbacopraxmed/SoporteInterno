<?php

class Servers
{
    private $id;
    private $name;
    private $ip_address;
    private $port;
    private $user;
    private $password_encrypted;
    private $operating_system;
    private $environment;
    private $online;
    private $latency_ms;
    private $last_revision;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getIp_address()
    {
        return $this->ip_address;
    }

    public function setIp_address($ip_address)
    {
        $this->ip_address = $ip_address;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getPassword_encrypted()
    {
        return $this->password_encrypted;
    }

    public function setPassword_encrypted($password_encrypted)
    {
        $this->password_encrypted = $password_encrypted;
        return $this;
    }

    public function getOperating_system()
    {
        return $this->operating_system;
    }

    public function setOperating_system($operating_system)
    {
        $this->operating_system = $operating_system;
        return $this;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    public function getOnline()
    {
        return $this->online;
    }

    public function setOnline($online)
    {
        $this->online = $online;
        return $this;
    }

    public function getLatency_ms()
    {
        return $this->latency_ms;
    }

    public function setLatency_ms($latency_ms)
    {
        $this->latency_ms = $latency_ms;
        return $this;
    }

    public function getLast_revision()
    {
        return $this->last_revision;
    }

    public function setLast_revision($last_revision)
    {
        $this->last_revision = $last_revision;
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
