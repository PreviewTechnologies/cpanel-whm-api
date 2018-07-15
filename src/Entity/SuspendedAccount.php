<?php

namespace PreviewTechs\cPanelWHM\Entity;


class SuspendedAccount
{
    /**
     * @var string
     */
    public $owner;

    /**
     * @var \DateTime
     */
    public $time;

    /**
     * @var string
     */
    public $reason;

    /**
     * @var bool
     */
    public $isLocked;

    /**
     * @var string
     */
    public $user;

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     *
     * @return SuspendedAccount
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     *
     * @return SuspendedAccount
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     *
     * @return SuspendedAccount
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return $this->isLocked;
    }

    /**
     * @param bool $isLocked
     *
     * @return SuspendedAccount
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;

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
     *
     * @return SuspendedAccount
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}