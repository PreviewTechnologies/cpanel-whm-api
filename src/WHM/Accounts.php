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
        $page  = 1;

        $params = [
            'api.version'      => 1,
            'api.chunk.enable' => 1,
            'api.chunk.size'   => $limit,
            'api.chunk.start'  => $page * $limit
        ];

        if ( ! empty($options['limit'])) {
            $params['api.chunk.size'] = intval($options['limit']);
        }

        if ( ! empty($options['page'])) {
            $params['api.chunk.start'] = intval($options['page']) * $params['api.chunk.size'];
        }

        if ( ! empty($searchType) && ! in_array($searchType, ["domain", "owner", "user", "ip", "package"])) {
            throw new \InvalidArgumentException("`searchType` must be one of these - domain, owner, user, ip, package");
        }

        if ( ! empty($options['searchmethod']) && ! in_array($options['searchmethod'], ["exact", "regex"])) {
            throw new \InvalidArgumentException("options[searchmethod] must be either `regex` or `exact`");
        }

        if ( ! empty($options['want'])) {
            $params['want'] = $options['want'];
        }

        if ( ! empty($searchType)) {
            $params['searchtype'] = $searchType;
        }

        if ( ! empty($keyword)) {
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
            'count'    => $params['api.chunk.size'],
            'page'     => $page
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

        if ( ! empty($user) && ! empty($domain)) {
            throw ClientExceptions::invalidArgument(
                "You must provide only one argument either user OR domain (not both)"
            );
        }

        $params = [];

        if ( ! empty($user)) {
            $params['user'] = $user;
        }

        if ( ! empty($domain)) {
            $params['domain'] = $domain;
        }

        $result = $this->client->sendRequest("/json-api/accountsummary", "GET", $params);
        if (empty($result)) {
            return null;
        }

        if ($result['status'] === 0) {
            throw ClientExceptions::recordNotFound(
                ! empty($result['statusmsg']) ? $result['statusmsg'] : "Record not found"
            );
        }

        if ( ! empty($result['acct']) && is_array($result['acct'])) {
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

        if ( ! empty($result['app']) && sizeof($result['app']) > 0) {
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
     *
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

        $params             = [];
        $params['username'] = $account->getUser();
        $params['domain']   = $account->getDomain();
        ! empty($account->getPlanName()) ? $params['plan'] = $account->getPlanName() : null;
        ! empty($options['pkgname']) ? $params['pkgname'] = $options['pkgname'] : null;
        if ( ! empty($options['savepkg'])) {
            if ( ! in_array(intval($options['savepkg']), [0, 1])) {
                throw new ClientExceptions("`savepkg` must be either 0 or 1");
            }

            $params['savepkg'] = $options['savepkg'];
        }

        ! empty($options['featurelist']) ? $params['featurelist'] = $options['featurelist'] : null;
        if ( ! empty($account->getDiskLimit())) {
            if ($account->getDiskLimit() === -1) {
                $params['quota'] = 0;
            } else {
                $params['quota'] = intval($account->getDiskLimit());
            }
        }

        ! empty($account->getPassword()) ? $params['password'] = $account->getPassword() : null;
        ! empty($account->getIpAddress()) ? $params['ip'] = $account->getIpAddress() : null;
        ! empty($account->isCgiEnable()) ? $params['cgi'] = (int)$account->isCgiEnable() : null;
        ! empty($account->isSpamAssassinEnable()) ?
            $params['spamassassin'] = (int)$account->isSpamAssassinEnable()
            : null;
        ! empty($account->isFrontPageEnable()) ? $params['frontpage'] = (int)$account->isFrontPageEnable() : null;
        ! empty($account->getShell()) ? $params['hasshell'] = 1 : null;
        ! empty($account->getEmail()) ? $params['contactemail'] = 1 : null;
        ! empty($account->getEmail()) ? $params['contactemail'] = 1 : null;
        ! empty($account->getTheme()) ? $params['cpmod'] = 1 : null;

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

        ! empty($options['customip']) ? $params['customip'] = $options['customip'] : null;

        ! empty($account->getLanguagePreference()) ? $params['language'] = $account->getLanguagePreference() : null;

        ! empty($options['useregns']) ? $params['useregns'] = $options['useregns'] : null;
        ! empty($options['reseller']) ? $params['reseller'] = (int)$options['reseller'] : null;
        ! empty($options['forcedns']) ? $params['forcedns'] = (int)$options['forcedns'] : null;

        ! empty($account->getMailboxFormat()) ? $params['mailbox_format'] = $account->getMailboxFormat() : null;

        if ( ! empty($options['mxcheck'])) {
            if ( ! in_array($options['mxcheck'], ['local', 'secondary', 'remote', 'auto'])) {
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

        ! empty($account->getUid()) ? $params['uid'] = $account->getUid() : null;
        ! empty($account->getPartition()) ? $params['homedir'] = $account->getPartition() : null;
        ! empty($options['dkim']) ? $params['dkim'] = intval($options['dkim']) : null;
        ! empty($options['spf']) ? $params['spf'] = intval($options['spf']) : null;
        ! empty($account->getOwner()) ? $params['owner'] = $account->getOwner() : null;

        $result = $this->client->sendRequest("/json-api/createacct", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if ( ! empty($result) && ! empty($result['result'][0]) && $result['result'][0]['status'] === 0) {
            throw new ClientExceptions($result['result'][0]['statusmsg']);
        }

        if ( ! empty($result) && ! empty($result['result'][0]) && $result['result'][0]['status'] === 1) {
            return ['result' => $result['result'][0]['options'], 'raw_output' => $result['result'][0]['rawout']];
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return ['result' => $result['data'], 'raw_output' => $result['metadata']['output']['raw']];
        }

        return [];
    }

    /**
     * This function retrieves domain data.
     *
     * WHM API function: Accounts -> domainuserdata
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+domainuserdata
     *
     * @param $domain
     *
     * @return null|DomainUser
     * @throws ClientExceptions
     * @throws Exception
     */
    public function domainDetails($domain)
    {
        $params = ['domain' => $domain];

        $result = $this->client->sendRequest("/json-api/domainuserdata", "GET", $params);
        if (empty($result)) {
            return null;
        }

        if ($result['result'][0]['status'] === 0) {
            throw new ClientExceptions($result['result'][0]['statusmsg']);
        }

        $userData   = $result['userdata'];
        $domainUser = new DomainUser();
        $domainUser->setHasCGI((bool)$userData['hascgi']);
        $domainUser->setServerName($userData['servername']);
        $domainUser->setOwner($userData['owner']);
        $domainUser->setScriptAlias($userData['scriptalias']);
        $domainUser->setHomeDirectory($userData['homedir']);
        $domainUser->setCustomLog($userData['customlog']);
        $domainUser->setUser($userData['user']);
        $domainUser->setGroup($userData['group']);
        $domainUser->setIpAddress($userData['ip']);
        $domainUser->setPort($userData['port']);
        $domainUser->setPhpOpenBaseDirectoryProtect((bool)$userData['phpopenbasedirprotect']);

        if ($userData['usecanonicalname'] === "Off") {
            $domainUser->setUseCanonicalName(false);
        } elseif ($userData['usecanonicalname'] === "On") {
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
     *
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

    /**
     * This function forces a user to change the account password after the next login attempt.
     *
     * WHM API function: Accounts -> forcepasswordchange
     *
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+forcepasswordchange
     *
     * @param array $usernames
     * @param int $stopOnFail
     *
     * @return null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function forcePasswordChange(array $usernames, $stopOnFail = 1)
    {
        $params = [
            "stop_on_failure" => $stopOnFail
        ];

        $usersJson = [];
        foreach ($usernames as $username) {
            $usersJson[$username] = 1;
        }

        $params['users_json'] = json_encode($usersJson);

        $result = $this->client->sendRequest("/json-api/forcepasswordchange", "GET", $params);
        if ($result['metadata']['result'] === 0) {
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if ( ! empty($result['data'])) {
            return $result['updated'];
        }

        return null;
    }

    /**
     * This function returns information about each domain on the server.
     *
     * WHM API function: Accounts -> get_domain_info
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+get_domain_info
     *
     * @return Domain[]|null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getDomains()
    {
        $params = [];
        $result = $this->client->sendRequest("/json-api/get_domain_info", "GET", $params);

        if (empty($result)) {
            return null;
        }

        if ( ! empty($result['metadata']) && $result['metadata']['result'] === 1) {
            $domains = $result['data']['domains'];

            $domainList = [];
            foreach ($domains as $domain) {
                $do = new Domain();
                $do->setPort(intval($domain['port']));
                $do->setUser($domain['user']);
                $do->setDomain($domain['domain']);
                $do->setIpv4SSL($domain['ipv4_ssl']);
                $do->setIpv6($domain['ipv6']);
                $do->setSslPort(intval($domain['port_ssl']));
                $do->setPhpVersion($domain['php_version']);
                $do->setUserOwner($domain['user_owner']);
                $do->setDomainType($domain['domain_type']);
                $do->setIpv6IsDedicated((bool)$domain['ipv6_is_dedicated']);
                $do->setIpv4($domain['ipv4']);
                $do->setModSecurityEnabled((bool)$domain['modsecurity_enabled']);
                $do->setDocRoot($domain['docroot']);
                $domainList[] = $do;
            }

            return $domainList;
        }

        return null;
    }

    /**
     * Digest Authentication is enabled or disabled for any specific user.
     * This function checks whether Digest Authentication is enabled for
     * a cPanel user.
     * Windows® Vista, Windows® 7, and Windows® 8 require Digest Authentication
     * support in order to access Web Disk over an unencrypted connection.
     *
     * WHM API function: Accounts -> has_digest_auth
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+has_digest_auth
     *
     * @param $user
     *
     * @return bool|null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function hasDigestAuth($user)
    {
        $params = ['user' => $user];
        $result = $this->client->sendRequest("/json-api/has_digest_auth", "GET", $params);
        if ( ! empty($result['data'])) {
            return $result['data']['digestauth'] === 1 ? true : false;
        }

        return null;
    }

    /**
     * This function enables or disables Digest Authentication for an account.
     * Windows Vista®, Windows® 7, and Windows® 8 requires that
     * you enable Digest Authentication support in order to access your Web Disk over a clear text,
     * unencrypted connection.
     *
     * WHM API function: Accounts -> set_digest_auth
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+set_digest_auth
     *
     * @param $user
     * @param $password
     * @param bool $enableDigestAuth
     *
     * @return bool
     * @throws ClientExceptions
     * @throws Exception
     */
    public function setDigestAuth($user, $password, $enableDigestAuth = true)
    {
        $params = ['user' => $user, 'password' => $password, 'digestauth' => (int) $enableDigestAuth];
        $result = $this->client->sendRequest("/json-api/set_digest_auth", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return true;
        }

        return false;
    }

    /**
     * This function checks whether a cPanel user's home directory contains a valid .my.cnf file.
     * WHM API function: Accounts -> has_mycnf_for_cpuser
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+has_mycnf_for_cpuser
     *
     * @param $user
     *
     * @return bool|null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function hasMyCnfInHomeDirectory($user)
    {
        $params = ['user' => $user];
        $result = $this->client->sendRequest("/json-api/has_mycnf_for_cpuser", "GET", $params);
        if ( ! empty($result['data'])) {
            return $result['data']['has_mycnf_for_cpuser'] === 1 ? true : false;
        }

        return null;
    }

    /**
     * Modify a cPanel account's bandwidth quota.
     * WHM API function: Accounts -> limitbw
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+limitbw
     *
     * @param $user
     * @param $bwlimit
     *
     * @return null
     * @throws ClientExceptions
     * @throws Exception
     */
    public function limitBandwidth($user, $bwlimit)
    {
        $params = ['user' => $user, 'bwlimit' => intval($bwlimit)];
        $result = $this->client->sendRequest("/json-api/limitbw", "GET", $params);
        if ( ! empty($result['metadata']) && $result['metadata']['result'] === 1) {
            return $result['data']['bwlimits'][0];
        }

        return null;
    }


    /**
     * Get lists of the cPanel user accounts and the root user on the server.
     * WHM API function: Accounts -> list_users
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+list_users
     *
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getUsers()
    {
        $result = $this->client->sendRequest("/json-api/list_users", "GET", []);
        if ( ! empty($result['metadata']) && $result['metadata']['result'] === 1) {
            return $result['data']['users'];
        }

        return [];
    }

    /**
     * Get a list of locked accounts.
     * This function lists locked accounts on the server. Only WHM users with root-level privileges can unsuspend locked accounts.
     *
     * WHM API function: Accounts -> listlockedaccounts
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+listlockedaccounts
     *
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getLockedAccounts()
    {
        $result = $this->client->sendRequest("/json-api/listlockedaccounts", "GET", []);
        if ( ! empty($result['metadata']) && $result['metadata']['result'] === 1) {
            return $result['data']['account'];
        }

        return [];
    }

    /**
     * Get a list of suspended accounts
     *
     * WHM API function: listsuspended
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+listsuspended
     *
     * @return SuspendedAccount[]
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getSuspendedAccounts()
    {
        $result = $this->client->sendRequest("/json-api/listsuspended", "GET", []);
        if ( ! empty($result['metadata']) && $result['metadata']['result'] === 1) {
            $suspendList = $result['data']['account'];

            $lists = [];
            foreach ($suspendList as $item) {
                $sa = new SuspendedAccount();
                $sa->setUser($item['user']);
                $sa->setOwner($item['owner']);
                $sa->setIsLocked((bool)$item['is_locked']);
                $sa->setReason($item['reason']);
                $sa->setTime(DateTime::createFromFormat("D M j H:i:s Y", $item['time']));
                $lists[] = $sa;
            }

            return $lists;
        }

        return [];
    }

    /**
     * This function modifies a cPanel account.
     * You must define the user parameter to identify which account to update.
     * All other input parameters are optional, and assign new values to the account.
     * If you specify the current value in one of these parameters, no change will occur.
     *
     * WHM API function: Accounts -> modifyacct
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+modifyacct
     *
     * @param Account $account
     *
     * @return bool
     * @throws ClientExceptions
     * @throws Exception
     */
    public function modifyAccount(Account $account)
    {
        if(empty($account->getUser())){
            throw ClientExceptions::invalidArgument("You must provide username to modify account");
        }

        $params = [
            'user' => $account->getUser()
        ];

        if($account->isBackupEnabled()){
            $params['BACKUP'] = 1;
        }

        if($account->getBandwidthLimit() === -1){
            $params['BWLIMIT'] = "unlimited";
        }

        if(!empty($account->getDomain())){
            $params['DNS'] = $account->getDomain();
        }

        if(!empty($account->isCgiEnable())){
            $params['HASCGI'] = (int) $account->isCgiEnable();
        }

        if(!empty($account->getMaxAddonDomains())){
            $params['MAXADDON'] = $account->getMaxAddonDomains() === -1 ? "unlimited" : intval($account->getMaxAddonDomains());
        }

        if(!empty($account->getMaxFTP())){
            $params['MAXFTP'] = $account->getMaxFTP() === -1 ? "unlimited" : intval($account->getMaxFTP());
        }

        if(!empty($account->getMaxMailingList())){
            $params['MAXLST'] = $account->getMaxMailingList() === -1 ? "unlimited" : intval($account->getMaxMailingList());
        }

        if(!empty($account->getMaxParkedDomains())){
            $params['MAXPARK'] = $account->getMaxParkedDomains() === -1 ? "unlimited" : intval($account->getMaxParkedDomains());
        }

        if(!empty($account->getMaxPOP())){
            $params['MAXPOP'] = $account->getMaxPOP() === -1 ? "unlimited" : null;
        }

        if(!empty($account->getMaxSQL())){
            $params['MAXSQL'] = $account->getMaxSQL() === -1 ? "unlimited" : intval($account->getMaxSQL());
        }

        if(!empty($account->getMaxSubDomain())){
            $params['MAXSUB'] = $account->getMaxSubDomain() === -1 ? "unlimited" : intval($account->getMaxSubDomain());
        }

        if(!empty($account->getMaxEmailPerHour())){
            $params['MAX_EMAIL_PER_HOUR'] = $account->getMaxEmailPerHour() === -1 ? "unlimited" : intval($account->getMaxEmailPerHour());
        }
        if(!empty($account->getMaxEmailAccountQuota())){
            $params['MAX_EMAILACCT_QUOTA'] = $account->getMaxEmailAccountQuota() === -1 ? "unlimited" : intval($account->getMaxDeferFailMailPercentage());
        }

        if(!empty($account->getMaxDeferFailMailPercentage())){
            $params['MAX_DEFER_FAIL_PERCENTAGE'] = $account->getMaxDeferFailMailPercentage() === -1 ? "unlimited" : intval($account->getMaxDeferFailMailPercentage());
        }

        if(!empty($account->getOwner())){
            $params['owner'] = $account->getOwner();
        }

        if(!empty($account->getDiskLimit())){
            $params['QUOTA'] = $account->getDiskLimit() === -1 ? "unlimited" : intval($account->getDiskLimit());
        }

        if($account->isSpamAssassinEnable()){
            $params['spamassassin'] = (int) $account->isSpamAssassinEnable();
        }

        if($account->isFrontPageEnable()){
            $params['frontpage'] = (int) $account->isFrontPageEnable();
        }

        if(!empty($account->getTheme())){
            $params['RS'] = $account->getTheme();
        }

        if(!empty($account->getIpAddress())){
            $params['IP'] = $account->getIpAddress();
        }

        if(!empty($account->getLanguagePreference())){
            $params['LANG'] = $account->getLanguagePreference();
        }

        if(!empty($account->getMailboxFormat())){
            $params['MAILBOX_FORMAT'] = $account->getMailboxFormat();
        }

        if(is_bool($account->isOutgoingMailSuspended())){
            $params['OUTGOING_EMAIL_SUSPENDED'] = (int) $account->isOutgoingMailSuspended();
        }

        $result = $this->client->sendRequest("/json-api/modifyacct", "GET", $params);
        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return true;
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        return false;
    }

    /**
     * WHM API function: Accounts -> passwd
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+passwd
     *
     * @param $user
     * @param $newPassword
     * @param null $digestAuth
     * @param bool $dbPassUpdate
     *
     * @return null|array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function changePassword($user, $newPassword, $digestAuth = null, $dbPassUpdate = false)
    {
        $params = [
            'user' => $user,
            'password' => $newPassword
        ];

        if(isset($digestAuth)){
            $params['digestauth'] = (int) $digestAuth;
        }

        if(isset($dbPassUpdate)){
            $params['db_pass_update'] = (int) $dbPassUpdate;
        }

        $result = $this->client->sendRequest("/json-api/passwd", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return $result['data']['app'];
        }

        return null;
    }

    /**
     * This function deletes a cPanel or WHM account.
     *
     * WHM API function: Accounts -> removeacct
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+removeacct
     * @param $username
     * @param bool $keepDNS
     *
     * @return bool
     * @throws ClientExceptions
     * @throws Exception
     */
    public function remove($username, $keepDNS = false)
    {
        $params = ['user' => $username, 'keepdns' => (int) $keepDNS];
        $result = $this->client->sendRequest("/json-api/removeacct", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return true;
        }

        return false;
    }

    /**
     * This function retrieves account bandwidth information.
     * WHM API function: Accounts -> showbw
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+showbw
     *
     * @param null $month
     * @param null $year
     * @param null $resellerUsername
     * @param null $searchKeyword
     * @param null $searchType
     *
     * @return array
     * @throws ClientExceptions
     * @throws Exception
     */
    public function getBandwidthInfo($month = null, $year = null, $resellerUsername = null, $searchKeyword = null, $searchType = null)
    {
        $params = [];
        if(!empty($searchKeyword)){
            $params['search'] = $searchKeyword;
        }

        if(!empty($searchType) && !in_array($searchType, ["domain", "user", "owner", "ip", "package"])){
            throw new ClientExceptions("searchType must be one of domain, user, owner, ip and package");
        }

        if(!empty($searchType)){
            $params['searchtype'] = $searchType;
        }

        if(!empty($month) && !is_int($month)){
            throw new ClientExceptions("month must be an integer");
        }
        if(!empty($month)){
            $params['month'] = intval($month);
        }

        if(!empty($year) && !is_int($year)){
            throw new ClientExceptions("year must be an integer");
        }

        if(!empty($year)){
            $params['year'] = intval($year);
        }

        if(!empty($resellerUsername)){
            $params['showres'] = $resellerUsername;
        }

        $result = $this->client->sendRequest("/json-api/showbw", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1) {
            return $result['data']['acct'];
        }

        return [];
    }

    /**
     * This function suspends an account. Suspension denies the user access to the account. Unlike account deletion, you can reverse account suspension.
     * WHM API function: Accounts->suspendacct
     * @link https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+suspendacct
     *
     * @param $user
     * @param $reason
     * @param bool $disallowUnsuspension
     *
     * @return bool
     * @throws ClientExceptions
     * @throws Exception
     */
    public function suspend($user, $reason, $disallowUnsuspension = true)
    {
        $params = ['user' => $user, 'reason' => $reason, 'disallowun' => (int) $disallowUnsuspension];
        $result = $this->client->sendRequest("/json-api/suspendacct", "GET", $params);

        if(!empty($result['metadata']) && $result['metadata']['result'] === 0){
            throw new ClientExceptions($result['metadata']['reason']);
        }

        if(!empty($result['metadata']) && $result['metadata']['result'] === 1){
            return true;
        }

        return false;
    }
}
