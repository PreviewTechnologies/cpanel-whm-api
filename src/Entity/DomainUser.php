<?php

namespace PreviewTechs\cPanelWHM\Entity;

class DomainUser
{
    /**
     * @var bool
     */
    public $hasCGI;

    /**
     * @var string
     */
    public $serverName;

    /**
     * @var string
     */
    public $owner;

    /**
     * @var array
     */
    public $scriptAlias;

    /**
     * @var string
     */
    public $homeDirectory;

    /**
     * @var array
     */
    public $customLog;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $group;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var int
     */
    public $port;

    /**
     * @var bool
     */
    public $phpOpenBaseDirectoryProtect;

    /**
     * @var bool
     */
    public $useCanonicalName;

    /**
     * @var string
     */
    public $serverAdmin;

    /**
     * @var string
     */
    public $serverAlias;

    /**
     * @var string
     */
    public $documentRoot;

    /**
     * @return bool
     */
    public function isHasCGI()
    {
        return $this->hasCGI;
    }

    /**
     * @param bool $hasCGI
     * @return DomainUser
     */
    public function setHasCGI($hasCGI)
    {
        $this->hasCGI = $hasCGI;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     * @return DomainUser
     */
    public function setServerName($serverName)
    {
        $this->serverName = $serverName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     * @return DomainUser
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return array
     */
    public function getScriptAlias()
    {
        return $this->scriptAlias;
    }

    /**
     * @param array $scriptAlias
     * @return DomainUser
     */
    public function setScriptAlias($scriptAlias)
    {
        $this->scriptAlias = $scriptAlias;
        return $this;
    }

    /**
     * @return string
     */
    public function getHomeDirectory()
    {
        return $this->homeDirectory;
    }

    /**
     * @param string $homeDirectory
     * @return DomainUser
     */
    public function setHomeDirectory($homeDirectory)
    {
        $this->homeDirectory = $homeDirectory;
        return $this;
    }

    /**
     * @return array
     */
    public function getCustomLog()
    {
        return $this->customLog;
    }

    /**
     * @param array $customLog
     * @return DomainUser
     */
    public function setCustomLog($customLog)
    {
        $this->customLog = $customLog;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return DomainUser
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return DomainUser
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return DomainUser
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return DomainUser
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPhpOpenBaseDirectoryProtect()
    {
        return $this->phpOpenBaseDirectoryProtect;
    }

    /**
     * @param bool $phpOpenBaseDirectoryProtect
     * @return DomainUser
     */
    public function setPhpOpenBaseDirectoryProtect($phpOpenBaseDirectoryProtect)
    {
        $this->phpOpenBaseDirectoryProtect = $phpOpenBaseDirectoryProtect;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseCanonicalName()
    {
        return $this->useCanonicalName;
    }

    /**
     * @param bool $useCanonicalName
     * @return DomainUser
     */
    public function setUseCanonicalName($useCanonicalName)
    {
        $this->useCanonicalName = $useCanonicalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerAdmin()
    {
        return $this->serverAdmin;
    }

    /**
     * @param string $serverAdmin
     * @return DomainUser
     */
    public function setServerAdmin($serverAdmin)
    {
        $this->serverAdmin = $serverAdmin;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerAlias()
    {
        return $this->serverAlias;
    }

    /**
     * @param string $serverAlias
     * @return DomainUser
     */
    public function setServerAlias($serverAlias)
    {
        $this->serverAlias = $serverAlias;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }

    /**
     * @param string $documentRoot
     * @return DomainUser
     */
    public function setDocumentRoot($documentRoot)
    {
        $this->documentRoot = $documentRoot;
        return $this;
    }
}
