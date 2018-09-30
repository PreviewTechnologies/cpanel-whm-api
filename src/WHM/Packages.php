<?php

namespace PreviewTechs\cPanelWHM\WHM;

use DateTime;
use Http\Client\Exception;
use PreviewTechs\cPanelWHM\Entity\Account;
use PreviewTechs\cPanelWHM\Entity\Domain;
use PreviewTechs\cPanelWHM\Entity\DomainUser;
use PreviewTechs\cPanelWHM\Entity\SuspendedAccount;
use PreviewTechs\cPanelWHM\Exceptions\ClientExceptions;
use PreviewTechs\cPanelWHM\WHMClient;

/**
 * Class Accounts
 *
 * @package PreviewTechs\cPanelWHM\WHM
 */
class Packages
{
    /**
     *
     * @var WHMClient
     */
    protected $client;

    /**
     * Accounts constructor.
     *
     * @param WHMClient $client
     */
    public function __construct(WHMClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $packageName
     * @return null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getPackageDetails($packageName)
    {
        $result = $this->client->sendRequest("/json-api/getpkginfo", "GET", ['pkg' => $packageName]);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new \Exception($result['metadata']['reason']);
        }

        if(!empty($result['data']) && !empty($result['data']['pkg'])){
            return $result['data']['pkg'];
        }

        return null;
    }
}
