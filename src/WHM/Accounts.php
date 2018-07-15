<?php

namespace PreviewTechs\cPanelWHM\WHM;

use Http\Client\Exception;
use PreviewTechs\cPanelWHM\Entity\Account;
use PreviewTechs\cPanelWHM\Entity\DomainUser;
use PreviewTechs\cPanelWHM\Exceptions\ClientExceptions;
use PreviewTechs\cPanelWHM\WHMClient;

/**
 * Class Accounts
 *
 * @package PreviewTechs\cPanelWHM\WHM
 */
class Accounts
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
     * Search accounts from your WHM server.
     *
     * WHM API function: Accounts -> listaccts
     *
     * $accounts = new Accounts($c);
     * $keyword = "search_keyword";
     * $searchType = "username";   //valid search types are "domain", "owner", "user", "ip", "package"
     * $options = [
     *       'searchmethod' => "exact",   //"exact" or "regex",
     *       "page" => 1,
     *       "limit" => 10,   //per page,
     *       "want" => "username"    //A comma-separated list of fields you want to fetch
     *   ];
     *
     * try {
     *       $accounts->searchAccounts($keyword, $searchType, $options);
     *   } catch (\Http\Client\Exception $e) {
     *       echo $e->getMessage();
     *   } catch (\PreviewTechs\cPanelWHM\Exceptions\ClientExceptions $e) {
     *       echo $e->getMessage();
     *   }
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+listaccts
     *
     * @param null $keyword
     * @param null $searchType
     * @param array $options
     *
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function searchAccounts($keyword = null, $searchType = null, array $options = [])
    {
        $limit = 10;
        $page = 1;

        $params = [
            'api.version' => 1,
            'api.chunk.enable' => 1,
            'api.chunk.size' => $limit,
            'api.chunk.start' => $page * $limit
        ];

        if (!empty($options['limit'])) {
            $params['api.chunk.size'] = intval($options['limit']);
        }

        if (!empty($options['page'])) {
            $params['api.chunk.start'] = intval($options['page']) * $params['api.chunk.size'];
        }

        if (!empty($searchType) && !in_array($searchType, ["domain", "owner", "user", "ip", "package"])) {
            throw new \InvalidArgumentException("`searchType` must be one of these - domain, owner, user, ip, package");
        }

        if (!empty($options['searchmethod']) && !in_array($options['searchmethod'], ["exact", "regex"])) {
            throw new \InvalidArgumentException("options[searchmethod] must be either `regex` or `exact`");
        }

        if (!empty($options['want'])) {
            $params['want'] = $options['want'];
        }

        if (!empty($searchType)) {
            $params['searchtype'] = $searchType;
        }

        if (!empty($keyword)) {
            $params['search'] = $keyword;
            empty($searchType) ? $params['searchtype'] = "user" : null;
        }

        $results = $this->client->sendRequest("/json-api/listaccts", "GET", $params);
        if (empty($results['data']['acct'])) {
            return [];
        }

        $accounts = [];
        foreach ($results['data']['acct'] as $account) {
            $accounts[] = Account::buildFromArray($account);
        }

        return [
            'accounts' => $accounts,
            'count' => $params['api.chunk.size'],
            'page' => $page
        ];
    }

    /**
     * Get an account details
     *
     * WHM API function: Accounts -> accountsummary
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+accountsummary
     *
     * @param null $user
     * @param null $domain
     *
     * @return null|Account
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getDetails($user = null, $domain = null)
    {
        if (empty($user) && empty($domain)) {
            throw ClientExceptions::invalidArgument("You must provide either a username or a domain or both");
        }

        if (!empty($user) && !empty($domain)) {
            throw ClientExceptions::invalidArgument(
                "You must provide only one argument either user OR domain (not both)"
            );
        }

        $params = [];

        if (!empty($user)) {
            $params['user'] = $user;
        }

        if (!empty($domain)) {
            $params['domain'] = $domain;
        }

        $result = $this->client->sendRequest("/json-api/accountsummary", "GET", $params);
        if (empty($result)) {
            return null;
        }

        if ($result['status'] === 0) {
            throw ClientExceptions::recordNotFound(
                !empty($result['statusmsg']) ? $result['statusmsg'] : "Record not found"
            );
        }

        if (!empty($result['acct']) && is_array($result['acct'])) {
            return Account::buildFromArray($result['acct'][0]);
        }

        return null;
    }

    /**
     * This function lists available WHM API 1 functions.
     *
     * This function only lists the functions that are available to the current user.
     * For example, if the authenticated user is a reseller without root -level privileges,
     * the function will not list WHM API 1 functions that require root privileges.
     *
     * WHM API function: Accounts -> applist
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+applist
     *
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function availableFunctions()
    {
        $result = $this->client->sendRequest("/json-api/applist", 'GET', []);

        if (!empty($result['app']) && sizeof($result['app']) > 0) {
            return $result['app'];
        }

        return [];
    }

    /**
     * Create a new account. This function creates a cPanel account.
     * The function also sets up the new account's domain information.
     *
     * WHM API function: Accounts -> createacct
     *
     * @link    https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+createacct
     *
     * @param Account $account
     * @param array $options
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function create(Account $account, array $options = [])
    {
        if (empty($account->getUser())) {
            throw ClientExceptions::invalidArgument("You must provide an username to create new account");
        }

        if (empty($account->getDomain())) {
            throw ClientExceptions::invalidArgument("You must provide a domain to create new account");
        }

        $params = [];
        $params['username'] = $account->getUser();
        $params['domain'] = $account->getDomain();
        !empty($account->getPlanName()) ? $params['plan'] = $account->getPlanName() : null;
        !empty($options['pkgname']) ? $params['pkgname'] = $options['pkgname'] : null;
        if (!empty($options['savepkg'])) {
            if (!in_array(intval($options['savepkg']), [0, 1])) {
                throw new ClientExceptions("`savepkg` must be either 0 or 1");
            }

            $params['savepkg'] = $options['savepkg'];
        }

        !empty($options['featurelist']) ? $params['featurelist'] = $options['featurelist'] : null;
        if (!empty($account->getDiskLimit())) {
            if ($account->getDiskLimit() === -1) {
                $params['quota'] = 0;
            } else {
                $params['quota'] = intval($account->getDiskLimit());
            }
        }

        !empty($account->getPassword()) ? $params['password'] = $account->getPassword() : null;
        !empty($account->getIpAddress()) ? $params['ip'] = $account->getIpAddress() : null;
        !empty($account->isCgiEnable()) ? $params['cgi'] = (int)$account->isCgiEnable() : null;
        !empty($account->isSpamAssassinEnable()) ?
            $params['spamassassin'] = (int)$account->isSpamAssassinEnable()
            : null;
        !empty($account->isFrontPageEnable()) ? $params['frontpage'] = (int)$account->isFrontPageEnable() : null;
        !empty($account->getShell()) ? $params['hasshell'] = 1 : null;
        !empty($account->getEmail()) ? $params['contactemail'] = 1 : null;
        !empty($account->getEmail()) ? $params['contactemail'] = 1 : null;
        !empty($account->getTheme()) ? $params['cpmod'] = 1 : null;

        if ($account->getMaxFTP() === -1) {
            $params['maxftp'] = "unlimited";
        } elseif ($account->getMaxFTP() > 0) {
            $params['maxftp'] = intval($account->getMaxFTP());
        }

        if ($account->getMaxSQL() === -1) {
            $params['maxsql'] = "unlimited";
        } elseif ($account->getMaxSQL() > 0) {
            $params['maxsql'] = intval($account->getMaxSQL());
        }

        if ($account->getMaxPOP() === -1) {
            $params['maxpop'] = "unlimited";
        } elseif ($account->getMaxPOP() > 0) {
            $params['maxpop'] = intval($account->getMaxPOP());
        }

        if ($account->getMaxMailingList() === -1) {
            $params['maxlst'] = "unlimited";
        } elseif ($account->getMaxMailingList() > 0) {
            $params['maxlst'] = intval($account->getMaxMailingList());
        }

        if ($account->getMaxSubDomain() === -1) {
            $params['maxsub'] = "unlimited";
        } elseif ($account->getMaxSubDomain() > 0) {
            $params['maxsub'] = intval($account->getMaxSubDomain());
        }

        if ($account->getMaxParkedDomains() === -1) {
            $params['maxpark'] = "unlimited";
        } elseif ($account->getMaxParkedDomains() > 0) {
            $params['maxpark'] = intval($account->getMaxParkedDomains());
        }

        if ($account->getMaxAddonDomains() === -1) {
            $params['maxaddon'] = "unlimited";
        } elseif ($account->getMaxAddonDomains() > 0) {
            $params['maxaddon'] = intval($account->getMaxAddonDomains());
        }

        if ($account->getBandwidthLimit() === -1) {
            $params['bwlimit'] = "unlimited";
        } elseif ($account->getBandwidthLimit() > 0) {
            $params['bwlimit'] = intval($account->getBandwidthLimit());
        }

        !empty($options['customip']) ? $params['customip'] = $options['customip'] : null;

        !empty($account->getLanguagePreference()) ? $params['language'] = $account->getLanguagePreference() : null;

        !empty($options['useregns']) ? $params['useregns'] = $options['useregns'] : null;
        !empty($options['reseller']) ? $params['reseller'] = (int)$options['reseller'] : null;
        !empty($options['forcedns']) ? $params['forcedns'] = (int)$options['forcedns'] : null;

        !empty($account->getMailboxFormat()) ? $params['mailbox_format'] = $account->getMailboxFormat() : null;

        if (!empty($options['mxcheck'])) {
            if (!in_array($options['mxcheck'], ['local', 'secondary', 'remote', 'auto'])) {
                throw new ClientExceptions("options[mxcheck] parameters must be one of local, secondary, remote, auto");
            }

            $params['mxcheck'] = $options['mxcheck'];
        }

        if ($account->getMaxEmailPerHour() === -1) {
            $params['max_email_per_hour'] = "unlimited";
        } elseif ($account->getMaxEmailPerHour() > 0) {
            $params['max_email_per_hour'] = intval($account->getMaxEmailPerHour());
        }

        if ($account->getMaxEmailAccountQuota() === -1) {
            $params['max_emailacct_quota'] = "unlimited";
        } elseif ($account->getMaxEmailAccountQuota() > 0) {
            $params['max_email_per_hour'] = intval($account->getMaxEmailAccountQuota());
        }

        if ($account->getMaxDeferFailMailPercentage() === -1) {
            $params['max_defer_fail_percentage'] = "unlimited";
        } elseif ($account->getMaxDeferFailMailPercentage() > 0) {
            $params['max_defer_fail_percentage'] = intval($account->getMaxDeferFailMailPercentage());
        }

        !empty($account->getUid()) ? $params['uid'] = $account->getUid() : null;
        !empty($account->getPartition()) ? $params['homedir'] = $account->getPartition() : null;
        !empty($options['dkim']) ? $params['dkim'] = intval($options['dkim']) : null;
        !empty($options['spf']) ? $params['spf'] = intval($options['spf']) : null;
        !empty($account->getOwner()) ? $params['owner'] = $account->getOwner() : null;

        $result = $this->client->sendRequest("/json-api/createacct", "GET", $params);

        if (!empty($result) && !empty($result['result'][0]) && $result['result'][0]['status'] === 0) {
            throw new ClientExceptions($result['result'][0]['statusmsg']);
        }

        if (!empty($result) && !empty($result['result'][0]) && $result['result'][0]['status'] === 1) {
            return ['result' => $result['result'][0]['options'], 'raw_output' => $result['result'][0]['rawout']];
        }

        return [];
    }

    /**
     * This function retrieves domain data.
     *
     * WHM API function: Accounts -> domainuserdata
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+domainuserdata
     * @param $domain
     * @return null|DomainUser
     * @throws ClientExceptions
     * @throws Exception
     */
    public function domainDetails($domain)
    {
        $params = ['domain' => $domain];

        $result = $this->client->sendRequest("/json-api/domainuserdata", "GET", $params);
        if(empty($result)){
            return null;
        }

        if($result['result'][0]['status'] === 0){
            throw new ClientExceptions($result['result'][0]['statusmsg']);
        }

        $userData = $result['userdata'];
        $domainUser = new DomainUser();
        $domainUser->setHasCGI((bool) $userData['hascgi']);
        $domainUser->setServerName($userData['servername']);
        $domainUser->setOwner($userData['owner']);
        $domainUser->setScriptAlias($userData['scriptalias']);
        $domainUser->setHomeDirectory($userData['homedir']);
        $domainUser->setCustomLog($userData['customlog']);
        $domainUser->setUser($userData['user']);
        $domainUser->setGroup($userData['group']);
        $domainUser->setIpAddress($userData['ip']);
        $domainUser->setPort($userData['port']);
        $domainUser->setPhpOpenBaseDirectoryProtect((bool) $userData['phpopenbasedirprotect']);

        if($userData['usecanonicalname'] === "Off"){
            $domainUser->setUseCanonicalName(false);
        }elseif($userData['usecanonicalname'] === "On"){
            $domainUser->setUseCanonicalName(true);
        }

        $domainUser->setServerAdmin($userData['serveradmin']);
        $domainUser->setServerAlias($userData['serveralias']);
        $domainUser->setDocumentRoot($userData['documentroot']);

        return $domainUser;
    }

    /**
     * This function modifies a user's disk quota.
     * WHM API function: Accounts -> editquota
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+editquota
     *
     * @param $username
     * @param $newQuota
     * @return bool
     * @throws ClientExceptions
     * @throws Exception
     */
    public function changeDiskSpaceQuota($username, $newQuota)
    {
        $params = ['user' => $username, 'quota' => $newQuota];

        $this->client->sendRequest("/json-api/editquota", "GET", $params);
        return true;
    }
}
