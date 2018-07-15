<?php

namespace PreviewTechs\cPanelWHM\Entity;

class Domain
{
    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $ipv4SSL;

    /**
     * @var string
     */
    public $ipv6;

    /**
     * @var int
     */
    public $sslPort;

    /**
     * @var string|null
     */
    public $phpVersion;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $userOwner;

    /**
     * @var string
     */
    public $domainType;

    /**
     * @var bool
     */
    public $ipv6IsDedicated;

    /**
     * @var string|null
     */
    public $parentDomain;

    /**
     * @var string
     */
    public $ipv4;

    /**
     * @var bool
     */
    public $modSecurityEnabled;

    /**
     * @var int
     */
    public $port;

    /**
     * @var string
     */
    public $docRoot;

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return Domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpv4SSL()
    {
        return $this->ipv4SSL;
    }

    /**
     * @param string $ipv4SSL
     * @return Domain
     */
    public function setIpv4SSL($ipv4SSL)
    {
        $this->ipv4SSL = $ipv4SSL;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpv6()
    {
        return $this->ipv6;
    }

    /**
     * @param string $ipv6
     * @return Domain
     */
    public function setIpv6($ipv6)
    {
        $this->ipv6 = $ipv6;
        return $this;
    }

    /**
     * @return int
     */
    public function getSslPort()
    {
        return $this->sslPort;
    }

    /**
     * @param int $sslPort
     * @return Domain
     */
    public function setSslPort($sslPort)
    {
        $this->sslPort = $sslPort;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    /**
     * @param null|string $phpVersion
     * @return Domain
     */
    public function setPhpVersion($phpVersion)
    {
        $this->phpVersion = $phpVersion;
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
     * @return Domain
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserOwner()
    {
        return $this->userOwner;
    }

    /**
     * @param string $userOwner
     * @return Domain
     */
    public function setUserOwner($userOwner)
    {
        $this->userOwner = $userOwner;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomainType()
    {
        return $this->domainType;
    }

    /**
     * @param string $domainType
     * @return Domain
     */
    public function setDomainType($domainType)
    {
        $this->domainType = $domainType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIpv6IsDedicated()
    {
        return $this->ipv6IsDedicated;
    }

    /**
     * @param bool $ipv6IsDedicated
     * @return Domain
     */
    public function setIpv6IsDedicated($ipv6IsDedicated)
    {
        $this->ipv6IsDedicated = $ipv6IsDedicated;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getParentDomain()
    {
        return $this->parentDomain;
    }

    /**
     * @param null|string $parentDomain
     * @return Domain
     */
    public function setParentDomain($parentDomain)
    {
        $this->parentDomain = $parentDomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpv4()
    {
        return $this->ipv4;
    }

    /**
     * @param string $ipv4
     * @return Domain
     */
    public function setIpv4($ipv4)
    {
        $this->ipv4 = $ipv4;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModSecurityEnabled()
    {
        return $this->modSecurityEnabled;
    }

    /**
     * @param bool $modSecurityEnabled
     * @return Domain
     */
    public function setModSecurityEnabled($modSecurityEnabled)
    {
        $this->modSecurityEnabled = $modSecurityEnabled;
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
     * @return Domain
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocRoot()
    {
        return $this->docRoot;
    }

    /**
     * @param string $docRoot
     * @return Domain
     */
    public function setDocRoot($docRoot)
    {
        $this->docRoot = $docRoot;
        return $this;
    }
}
