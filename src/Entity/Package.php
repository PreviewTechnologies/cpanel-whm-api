<?php

namespace PreviewTechs\cPanelWHM\Entity;

class Package
{
    public $language;
    public $quota;
    public $maxSQL;
    public $lvePeakMemory;
    public $CGI;
    public $featureList;
    public $hasShell;
    public $lveIO;
    public $maxMailingList;
    public $maxAddonDomain;
    public $lveCPU;
    public $dedicatedIP;
    public $maxParkedDomain;
    public $maxBandwidth;
    public $maxDeferFailPercentage;
    public $maxEmailAddress;
    public $lveEP;
    public $maxSubdomain;
    public $frontpageEnabled;
    public $maxEmailPerHour;
    public $maxEmailAccountQuota;
    public $lveMemory;
    public $lveIOPS;
    public $maxFTP;
    public $nproc;
    public $digestAuth;
    public $theme;
    public $lveNumberOfCPU;

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     * @return Package
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * @param mixed $quota
     * @return Package
     */
    public function setQuota($quota)
    {
        $this->quota = $quota;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxSQL()
    {
        return $this->maxSQL;
    }

    /**
     * @param mixed $maxSQL
     * @return Package
     */
    public function setMaxSQL($maxSQL)
    {
        $this->maxSQL = $maxSQL;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLvePeakMemory()
    {
        return $this->lvePeakMemory;
    }

    /**
     * @param mixed $lvePeakMemory
     * @return Package
     */
    public function setLvePeakMemory($lvePeakMemory)
    {
        $this->lvePeakMemory = $lvePeakMemory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCGI()
    {
        return $this->CGI;
    }

    /**
     * @param mixed $CGI
     * @return Package
     */
    public function setCGI($CGI)
    {
        $this->CGI = $CGI;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeatureList()
    {
        return $this->featureList;
    }

    /**
     * @param mixed $featureList
     * @return Package
     */
    public function setFeatureList($featureList)
    {
        $this->featureList = $featureList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHasShell()
    {
        return $this->hasShell;
    }

    /**
     * @param mixed $hasShell
     * @return Package
     */
    public function setHasShell($hasShell)
    {
        $this->hasShell = $hasShell;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveIO()
    {
        return $this->lveIO;
    }

    /**
     * @param mixed $lveIO
     * @return Package
     */
    public function setLveIO($lveIO)
    {
        $this->lveIO = $lveIO;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxMailingList()
    {
        return $this->maxMailingList;
    }

    /**
     * @param mixed $maxMailingList
     * @return Package
     */
    public function setMaxMailingList($maxMailingList)
    {
        $this->maxMailingList = $maxMailingList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxAddonDomain()
    {
        return $this->maxAddonDomain;
    }

    /**
     * @param mixed $maxAddonDomain
     * @return Package
     */
    public function setMaxAddonDomain($maxAddonDomain)
    {
        $this->maxAddonDomain = $maxAddonDomain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveCPU()
    {
        return $this->lveCPU;
    }

    /**
     * @param mixed $lveCPU
     * @return Package
     */
    public function setLveCPU($lveCPU)
    {
        $this->lveCPU = $lveCPU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDedicatedIP()
    {
        return $this->dedicatedIP;
    }

    /**
     * @param mixed $dedicatedIP
     * @return Package
     */
    public function setDedicatedIP($dedicatedIP)
    {
        $this->dedicatedIP = $dedicatedIP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxParkedDomain()
    {
        return $this->maxParkedDomain;
    }

    /**
     * @param mixed $maxParkedDomain
     * @return Package
     */
    public function setMaxParkedDomain($maxParkedDomain)
    {
        $this->maxParkedDomain = $maxParkedDomain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxBandwidth()
    {
        return $this->maxBandwidth;
    }

    /**
     * @param mixed $maxBandwidth
     * @return Package
     */
    public function setMaxBandwidth($maxBandwidth)
    {
        $this->maxBandwidth = $maxBandwidth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxDeferFailPercentage()
    {
        return $this->maxDeferFailPercentage;
    }

    /**
     * @param mixed $maxDeferFailPercentage
     * @return Package
     */
    public function setMaxDeferFailPercentage($maxDeferFailPercentage)
    {
        $this->maxDeferFailPercentage = $maxDeferFailPercentage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxEmailAddress()
    {
        return $this->maxEmailAddress;
    }

    /**
     * @param mixed $maxEmailAddress
     * @return Package
     */
    public function setMaxEmailAddress($maxEmailAddress)
    {
        $this->maxEmailAddress = $maxEmailAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveEP()
    {
        return $this->lveEP;
    }

    /**
     * @param mixed $lveEP
     * @return Package
     */
    public function setLveEP($lveEP)
    {
        $this->lveEP = $lveEP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxSubdomain()
    {
        return $this->maxSubdomain;
    }

    /**
     * @param mixed $maxSubdomain
     * @return Package
     */
    public function setMaxSubdomain($maxSubdomain)
    {
        $this->maxSubdomain = $maxSubdomain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrontpageEnabled()
    {
        return $this->frontpageEnabled;
    }

    /**
     * @param mixed $frontpageEnabled
     * @return Package
     */
    public function setFrontpageEnabled($frontpageEnabled)
    {
        $this->frontpageEnabled = $frontpageEnabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxEmailPerHour()
    {
        return $this->maxEmailPerHour;
    }

    /**
     * @param mixed $maxEmailPerHour
     * @return Package
     */
    public function setMaxEmailPerHour($maxEmailPerHour)
    {
        $this->maxEmailPerHour = $maxEmailPerHour;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxEmailAccountQuota()
    {
        return $this->maxEmailAccountQuota;
    }

    /**
     * @param mixed $maxEmailAccountQuota
     * @return Package
     */
    public function setMaxEmailAccountQuota($maxEmailAccountQuota)
    {
        $this->maxEmailAccountQuota = $maxEmailAccountQuota;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveMemory()
    {
        return $this->lveMemory;
    }

    /**
     * @param mixed $lveMemory
     * @return Package
     */
    public function setLveMemory($lveMemory)
    {
        $this->lveMemory = $lveMemory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveIOPS()
    {
        return $this->lveIOPS;
    }

    /**
     * @param mixed $lveIOPS
     * @return Package
     */
    public function setLveIOPS($lveIOPS)
    {
        $this->lveIOPS = $lveIOPS;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxFTP()
    {
        return $this->maxFTP;
    }

    /**
     * @param mixed $maxFTP
     * @return Package
     */
    public function setMaxFTP($maxFTP)
    {
        $this->maxFTP = $maxFTP;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNproc()
    {
        return $this->nproc;
    }

    /**
     * @param mixed $nproc
     * @return Package
     */
    public function setNproc($nproc)
    {
        $this->nproc = $nproc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDigestAuth()
    {
        return $this->digestAuth;
    }

    /**
     * @param mixed $digestAuth
     * @return Package
     */
    public function setDigestAuth($digestAuth)
    {
        $this->digestAuth = $digestAuth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     * @return Package
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLveNumberOfCPU()
    {
        return $this->lveNumberOfCPU;
    }

    /**
     * @param mixed $lveNumberOfCPU
     * @return Package
     */
    public function setLveNumberOfCPU($lveNumberOfCPU)
    {
        $this->lveNumberOfCPU = $lveNumberOfCPU;
        return $this;
    }

    public static function build(array $data)
    {
        $package = new static();
        !empty($data["BWLIMIT"]) ? $package->setLanguage($data['BWLIMIT']) : null;

        if($data['IP'] === 0){
            $package->setDedicatedIP(false);
        }elseif($data['IP'] === 1){
            $package->setDedicatedIP(true);
        }
        !empty($data['lve_io']) ? $package->setLveIO($data['lve_io']) : null;
        !empty($data['lve_iops']) ? $package->setLveIOPS($data['lve_iops']) : null;
        !empty($data['lve_cpu']) ? $package->setLveCPU($data['lve_cpu']) : null;
        !empty($data['CPMOD']) ? $package->setTheme($data['CPMOD']) : null;

        if($data['DIGESTAUTH'] === "n"){
            $package->setDigestAuth(false);
        }else{
            $package->setDigestAuth(true);
        }

        if($data['HASSHELL'] === 0){
            $package->setHasShell(false);
        }else{
            $package->setHasShell(true);
        }

        !empty($data['lve_ncpu']) ? $package->setLveCPU($data['lve_ncpu']) : null;
        !empty($data['MAXLST']) ? $package->setMaxMailingList(intval($data['MAXLST'])) : null;
        !empty($data['MAXSQL']) ? $package->setMaxSQL(intval($data['MAXSQL'])) : null;
        !empty($data['MAX_DEFER_FAIL_PERCENTAGE']) ? $package->setMaxDeferFailPercentage(intval($data['MAX_DEFER_FAIL_PERCENTAGE'])) : null;
        !empty($data['FEATURELIST']) ? $package->setFeatureList($data['FEATURELIST']) : null;
        !empty($data['QUOTA']) ? $package->setQuota($data['QUOTA']) : null;
    }
}
