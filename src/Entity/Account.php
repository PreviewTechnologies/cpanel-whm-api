<?php

namespace PreviewTechs\cPanelWHM\Entity;

class Account
{
    /**
     * The account's username. A cPanel account or reseller username on the server.
     *
     * @var string
     */
    public $user;

    /**
     * The account's main domain. A valid domainnameon the account.
     *
     * @var string
     */
    public $domain;


    /**
     * The percentage of failed or deferred email messages that the account can send per hour
     * before outgoing mail is rate-limited.
     *
     * unlimited / An integer that represents a percentage of messages.
     *
     * @var integer
     */
    public $maxDeferFailMailPercentage;

    /**
     * The account's shell. The absolute path to a shell location on the server.
     *
     * @var string
     */
    public $shell;

    /**
     * The type of mailbox the account uses. mdbox/maildir
     *
     * @var string
     */
    public $mailboxFormat;

    /**
     * The account's cPanel interface theme. paper_lantern or another valid theme on the server.
     *
     * @var string
     */
    public $theme;

    /**
     * The account's maximum number of mailing lists. unlimited or an integer that represents a number of mailing lists.
     *
     * @var integer
     */
    public $maxMailingList;

    /**
     * The account's maximum number of addon domains.
     *
     * Possible values -
     *  unlimited
     *  unknown* — The account cannot use addon domains
     *  an integer that represents a number of addon domains.
     *
     * @var integer
     */
    public $maxAddonDomains;

    /**
     * The account's maximum number of parked domains.
     *
     * Possible values -
     *  unlimited
     *  unknown* — The account cannot use parked domains
     *  an integer that represents a number of parked domains.
     *
     * @var integer
     */
    public $maxParkedDomains;

    /**
     *
     * @var string
     */
    public $ipv6;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $partition;

    /**
     *
     * @var integer
     */
    public $maxSQL;

    /**
     *
     * @var \DateTime
     */
    public $createdAt;

    /**
     *
     * @var bool
     */
    public $isBackupEnabled;

    /**
     *
     * @var bool
     */
    public $outgoingMailSuspended;

    /**
     *
     * @var string
     */
    public $owner;

    /**
     *
     * @var string
     */
    public $suspensionReason;

    /**
     *
     * @var bool
     */
    public $isLocked;

    /**
     *
     * @var bool
     */
    public $outgoingMailCanHold;

    /**
     *
     * @var \DateTime
     */
    public $suspendedAt;

    /**
     *
     * @var int
     */
    public $maxFTP;

    /**
     *
     * @var int
     */
    public $maxEmailPerHour;

    /**
     *
     * @var bool
     */
    public $temporary;

    /**
     *
     * @var string
     */
    public $ipAddress;

    /**
     *
     * @var int
     */
    public $uid;

    /**
     *
     * @var bool
     */
    public $suspended;

    /**
     *
     * @var bool
     */
    public $backup;

    /**
     *
     * @var int
     */
    public $maxPOP;

    /**
     *
     * @var int
     */
    public $maxSubDomain;

    /**
     *
     * @var int
     */
    public $maxEmailAccountQuota;

    /**
     *
     * @var int
     */
    public $diskUsed;

    /**
     *
     * @var int
     */
    public $inodeUsed;

    /**
     *
     * @var
     */
    public $minDeferFailToTriggerProtection;

    /**
     *
     * @var string
     */
    public $planName;

    /**
     *
     * @var int
     */
    public $inodesLimit;

    /**
     *
     * @var int
     */
    public $diskLimit;

    /**
     *
     * @var bool
     */
    public $legacyBackup;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var bool|null
     */
    public $cgiEnable;

    /**
     * @var bool
     */
    public $spamAssassinEnable;

    /**
     * @var bool
     */
    public $frontPageEnable;

    /**
     * @var int
     */
    public $bandwidthLimit;

    /**
     * @var string|null
     */
    public $languagePreference;

    /**
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param string $user
     *
     * @return Account
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     *
     * @param string $domain
     *
     * @return Account
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxDeferFailMailPercentage()
    {
        return $this->maxDeferFailMailPercentage;
    }

    /**
     *
     * @param int $maxDeferFailMailPercentage
     *
     * @return Account
     */
    public function setMaxDeferFailMailPercentage($maxDeferFailMailPercentage)
    {
        $this->maxDeferFailMailPercentage = $maxDeferFailMailPercentage;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getShell()
    {
        return $this->shell;
    }

    /**
     *
     * @param string $shell
     *
     * @return Account
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getMailboxFormat()
    {
        return $this->mailboxFormat;
    }

    /**
     *
     * @param string $mailboxFormat
     *
     * @return Account
     */
    public function setMailboxFormat($mailboxFormat)
    {
        $this->mailboxFormat = $mailboxFormat;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     *
     * @param string $theme
     *
     * @return Account
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxMailingList()
    {
        return $this->maxMailingList;
    }

    /**
     *
     * @param int $maxMailingList
     *
     * @return Account
     */
    public function setMaxMailingList($maxMailingList)
    {
        $this->maxMailingList = $maxMailingList;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxAddonDomains()
    {
        return $this->maxAddonDomains;
    }

    /**
     *
     * @param int $maxAddonDomains
     *
     * @return Account
     */
    public function setMaxAddonDomains($maxAddonDomains)
    {
        $this->maxAddonDomains = $maxAddonDomains;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxParkedDomains()
    {
        return $this->maxParkedDomains;
    }

    /**
     *
     * @param int $maxParkedDomains
     *
     * @return Account
     */
    public function setMaxParkedDomains($maxParkedDomains)
    {
        $this->maxParkedDomains = $maxParkedDomains;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIpv6()
    {
        return $this->ipv6;
    }

    /**
     *
     * @param string $ipv6
     *
     * @return Account
     */
    public function setIpv6($ipv6)
    {
        $this->ipv6 = $ipv6;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPartition()
    {
        return $this->partition;
    }

    /**
     *
     * @param string $partition
     *
     * @return Account
     */
    public function setPartition($partition)
    {
        $this->partition = $partition;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxSQL()
    {
        return $this->maxSQL;
    }

    /**
     *
     * @param int $maxSQL
     *
     * @return Account
     */
    public function setMaxSQL($maxSQL)
    {
        $this->maxSQL = $maxSQL;

        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt
     *
     * @return Account
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isBackupEnabled()
    {
        return $this->isBackupEnabled;
    }

    /**
     *
     * @param bool $isBackupEnabled
     *
     * @return Account
     */
    public function setIsBackupEnabled($isBackupEnabled)
    {
        $this->isBackupEnabled = $isBackupEnabled;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isOutgoingMailSuspended()
    {
        return $this->outgoingMailSuspended;
    }

    /**
     *
     * @param bool $outgoingMailSuspended
     *
     * @return Account
     */
    public function setOutgoingMailSuspended($outgoingMailSuspended)
    {
        $this->outgoingMailSuspended = $outgoingMailSuspended;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     *
     * @param string $owner
     *
     * @return Account
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getSuspensionReason()
    {
        return $this->suspensionReason;
    }

    /**
     *
     * @param string $suspensionReason
     *
     * @return Account
     */
    public function setSuspensionReason($suspensionReason)
    {
        $this->suspensionReason = $suspensionReason;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->isLocked;
    }

    /**
     *
     * @param bool $isLocked
     *
     * @return Account
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isOutgoingMailCanHold()
    {
        return $this->outgoingMailCanHold;
    }

    /**
     *
     * @param bool $outgoingMailCanHold
     *
     * @return Account
     */
    public function setOutgoingMailCanHold($outgoingMailCanHold)
    {
        $this->outgoingMailCanHold = $outgoingMailCanHold;

        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getSuspendedAt()
    {
        return $this->suspendedAt;
    }

    /**
     *
     * @param \DateTime $suspendedAt
     *
     * @return Account
     */
    public function setSuspendedAt($suspendedAt)
    {
        $this->suspendedAt = $suspendedAt;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxFTP()
    {
        return $this->maxFTP;
    }

    /**
     *
     * @param int $maxFTP
     *
     * @return Account
     */
    public function setMaxFTP($maxFTP)
    {
        $this->maxFTP = $maxFTP;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxEmailPerHour()
    {
        return $this->maxEmailPerHour;
    }

    /**
     *
     * @param int $maxEmailPerHour
     *
     * @return Account
     */
    public function setMaxEmailPerHour($maxEmailPerHour)
    {
        $this->maxEmailPerHour = $maxEmailPerHour;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     *
     * @param bool $temporary
     *
     * @return Account
     */
    public function setTemporary($temporary)
    {
        $this->temporary = $temporary;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     *
     * @param string $ipAddress
     *
     * @return Account
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     *
     * @param int $uid
     *
     * @return Account
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isSuspended()
    {
        return $this->suspended;
    }

    /**
     *
     * @param bool $suspended
     *
     * @return Account
     */
    public function setSuspended($suspended)
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isBackup()
    {
        return $this->backup;
    }

    /**
     *
     * @param bool $backup
     *
     * @return Account
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxPOP()
    {
        return $this->maxPOP;
    }

    /**
     *
     * @param int $maxPOP
     *
     * @return Account
     */
    public function setMaxPOP($maxPOP)
    {
        $this->maxPOP = $maxPOP;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxSubDomain()
    {
        return $this->maxSubDomain;
    }

    /**
     *
     * @param int $maxSubDomain
     *
     * @return Account
     */
    public function setMaxSubDomain($maxSubDomain)
    {
        $this->maxSubDomain = $maxSubDomain;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getMaxEmailAccountQuota()
    {
        return $this->maxEmailAccountQuota;
    }

    /**
     *
     * @param int $maxEmailAccountQuota
     *
     * @return Account
     */
    public function setMaxEmailAccountQuota($maxEmailAccountQuota)
    {
        $this->maxEmailAccountQuota = $maxEmailAccountQuota;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getDiskUsed()
    {
        return $this->diskUsed;
    }

    /**
     *
     * @param int $diskUsed
     *
     * @return Account
     */
    public function setDiskUsed($diskUsed)
    {
        $this->diskUsed = $diskUsed;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getInodeUsed()
    {
        return $this->inodeUsed;
    }

    /**
     *
     * @param int $inodeUsed
     *
     * @return Account
     */
    public function setInodeUsed($inodeUsed)
    {
        $this->inodeUsed = $inodeUsed;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getMinDeferFailToTriggerProtection()
    {
        return $this->minDeferFailToTriggerProtection;
    }

    /**
     *
     * @param mixed $minDeferFailToTriggerProtection
     *
     * @return Account
     */
    public function setMinDeferFailToTriggerProtection($minDeferFailToTriggerProtection)
    {
        $this->minDeferFailToTriggerProtection = $minDeferFailToTriggerProtection;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     *
     * @param string $planName
     *
     * @return Account
     */
    public function setPlanName($planName)
    {
        $this->planName = $planName;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getInodesLimit()
    {
        return $this->inodesLimit;
    }

    /**
     *
     * @param int $inodesLimit
     *
     * @return Account
     */
    public function setInodesLimit($inodesLimit)
    {
        $this->inodesLimit = $inodesLimit;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getDiskLimit()
    {
        return $this->diskLimit;
    }

    /**
     *
     * @param int $diskLimit
     *
     * @return Account
     */
    public function setDiskLimit($diskLimit)
    {
        $this->diskLimit = $diskLimit;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isLegacyBackup()
    {
        return $this->legacyBackup;
    }

    /**
     *
     * @param bool $legacyBackup
     *
     * @return Account
     */
    public function setLegacyBackup($legacyBackup)
    {
        $this->legacyBackup = $legacyBackup;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCgiEnable()
    {
        return $this->cgiEnable;
    }

    /**
     * @param bool|null $cgiEnable
     * @return Account
     */
    public function setCgiEnable($cgiEnable)
    {
        $this->cgiEnable = $cgiEnable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSpamAssassinEnable()
    {
        return $this->spamAssassinEnable;
    }

    /**
     * @param bool $spamAssassinEnable
     * @return Account
     */
    public function setSpamAssassinEnable($spamAssassinEnable)
    {
        $this->spamAssassinEnable = $spamAssassinEnable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFrontPageEnable()
    {
        return $this->frontPageEnable;
    }

    /**
     * @param bool $frontPageEnable
     * @return Account
     */
    public function setFrontPageEnable($frontPageEnable)
    {
        $this->frontPageEnable = $frontPageEnable;
        return $this;
    }

    /**
     * @return int
     */
    public function getBandwidthLimit()
    {
        return $this->bandwidthLimit;
    }

    /**
     * @param int $bandwidthLimit
     * @return Account
     */
    public function setBandwidthLimit($bandwidthLimit)
    {
        $this->bandwidthLimit = $bandwidthLimit;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLanguagePreference()
    {
        return $this->languagePreference;
    }

    /**
     * @param null|string $languagePreference
     * @return Account
     */
    public function setLanguagePreference($languagePreference)
    {
        $this->languagePreference = $languagePreference;
        return $this;
    }

    /**
     *
     * @param array $account
     *
     * @return Account
     */
    public static function buildFromArray(array $account)
    {
        $ac = new static();

        if ($account['maxsub'] === "unlimited") {
            $ac->setMaxSubDomain(-1);
        } elseif ($account['maxsub'] === "unknown") {
            $ac->setMaxSubDomain(0);
        } else {
            $ac->setMaxSubDomain(intval($account['maxsub']));
        }

        $ac->setPartition($account['partition']);

        if ($account['disklimit'] === "unlimited") {
            $ac->setDiskLimit(-1);
        } else {
            $ac->setDiskLimit(intval(str_replace("M", "", $account['disklimit'])));
        }

        $ac->setInodeUsed(intval($account['inodesused']));

        if (! empty($account['has_backup'])) {
            $ac->setBackup((bool)$account['has_backup']);
        }

        if ($account['max_emailacct_quota'] === "unlimited") {
            $ac->setMaxEmailAccountQuota(-1);
        } else {
            $ac->setMaxEmailAccountQuota(intval(str_replace("M", "", $account['max_emailacct_quota'])));
        }

        $ac->setEmail($account['email']);
        $ac->setSuspensionReason($account['suspendreason']);
        $ac->setLegacyBackup((bool)$account['legacy_backup']);
        $ac->setMaxEmailPerHour(
            $account['max_email_per_hour'] === "unlimited" ? -1 : intval($account['max_email_per_hour'])
        );
        $ac->setIsBackupEnabled((bool)$account['backup']);
        $ac->setMaxPOP($account['maxpop'] === "unlimited" ? -1 : intval($account['maxpop']));
        $ac->setUid(intval($account['uid']));
        $ac->setUser($account['user']);
        $ac->setPlanName($account['plan']);
        $ac->setOutgoingMailSuspended((bool)$account['outgoing_mail_suspended']);
        $ac->setMaxFTP($account['maxftp'] === "unlimited" ? -1 : intval($account['maxftp']));
        $ac->setTemporary((bool)$account['temporary']);
        $ac->setDomain($account['domain']);
        $ac->setShell($account['shell']);
        $ac->setMailboxFormat($account['mailbox_format']);
        $ac->setIpAddress($account['ip']);

        if ($account['diskused'] === "unlimited") {
            $ac->setDiskUsed(-1);
        } else {
            $ac->setDiskUsed(intval(str_replace("M", "", $account['diskused'])));
        }

        $ac->setMaxSQL($account['maxsql'] === "unlimited" ? -1 : intval($account['maxsql']));

        if ($account['maxaddons'] === "*unknown*") {
            $ac->setMaxAddonDomains(0);
        } elseif ($account['maxaddons'] === "unlimited") {
            $ac->setMaxAddonDomains(-1);
        } else {
            $ac->setMaxAddonDomains(intval($account['maxaddons']));
        }

        if ($account['maxparked'] === "*unknown*") {
            $ac->setMaxParkedDomains(0);
        } elseif ($account['maxparked'] === "unlimited") {
            $ac->setMaxParkedDomains(-1);
        } else {
            $ac->setMaxParkedDomains(intval($account['maxparked']));
        }

        $ac->setIsLocked((bool)$account['is_locked']);
        $ac->setOwner($account['owner']);
        $ac->setInodesLimit($account['inodeslimit'] === "unlimited" ? -1 : intval($account['inodeslimit']));

        return $ac;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'legacy_backup'                        => $this->isLegacyBackup(),
            'inodesused'                           => $this->getInodeUsed(),
            'min_defer_fail_to_trigger_protection' => $this->getMinDeferFailToTriggerProtection(),
            'maxlst'                               => $this->getMaxMailingList(),
            'max_email_per_hour'                   => $this->getMaxEmailPerHour(),
            'suspendreason'                        => $this->getSuspensionReason(),
            'backup'                               => $this->isBackupEnabled(),
            'suspendtime'                          => $this->getSuspendedAt()->format(DATE_ATOM),
            'maxpop'                               => $this->getMaxPOP(),
            'suspended'                            => $this->isSuspended(),
            'uid'                                  => $this->getUid(),
            'user'                                 => $this->getUser(),
            'plan'                                 => $this->getPlanName(),
            'has_backup'                           => $this->isBackup(),
            'outgoing_mail_suspended'              => $this->isOutgoingMailSuspended(),
            'startdate'                            => $this->getCreatedAt()->format(DATE_ATOM),
            'maxftp'                               => $this->getMaxFTP(),
            'temporary'                            => $this->isTemporary(),
            'domain'                               => $this->getDomain(),
            'disklimit'                            => $this->getDiskLimit(),
            'max_emailacct_quota'                  => $this->getMaxEmailAccountQuota(),
            'shell'                                => $this->getShell(),
            'partition'                            => $this->getPartition(),
            'mailbox_format'                       => $this->getMailboxFormat(),
            'ip'                                   => $this->getIpAddress(),
            'maxsub'                               => $this->getMaxSubDomain(),
            'max_defer_fail_percentage'            => $this->getMaxDeferFailMailPercentage(),
            'diskused'                             => $this->getDiskUsed(),
            'maxsql'                               => $this->getMaxSQL(),
            'maxaddons'                            => $this->getMaxAddonDomains(),
            'theme'                                => $this->getTheme(),
            'maxparked'                            => $this->getMaxParkedDomains(),
            'is_locked'                            => $this->isLocked(),
            'ipv6'                                 => $this->getIpv6(),
            'email'                                => $this->getEmail(),
            'outgoing_mail_hold'                   => $this->isOutgoingMailCanHold(),
            'inodeslimit'                          => $this->getInodesLimit()
        ];
    }
}
