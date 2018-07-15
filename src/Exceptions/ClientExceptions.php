<?php

namespace PreviewTechs\cPanelWHM\Exceptions;

class ClientExceptions extends \Exception
{
    protected $reason;

    public function __construct($message = "", $code = 0, $reason = null)
    {
        $this->reason = $reason;

        parent::__construct($message, $code);
    }

    /**
     *
     * @param $message
     * @param $reason
     *
     * @return ClientExceptions
     */
    public static function accessDenied($message, $reason = null)
    {
        return new static($message, 0, $reason);
    }

    /**
     *
     * @param $message
     * @param $reason
     *
     * @return ClientExceptions
     */
    public static function recordNotFound($message, $reason = null)
    {
        return new static($message, 0, $reason);
    }

    /**
     *
     * @param $message
     * @param $reason
     *
     * @return ClientExceptions
     */
    public static function invalidArgument($message, $reason = null)
    {
        return new static($message, 0, $reason);
    }
}
