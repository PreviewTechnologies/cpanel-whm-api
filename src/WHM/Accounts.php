<?php

namespace PreviewTechs\cPanelWHM\WHM;


use Http\Client\Exception;
use PreviewTechs\cPanelWHM\Entity\Account;
use PreviewTechs\cPanelWHM\Exceptions\ClientExceptions;
use PreviewTechs\cPanelWHM\WHMClient;

/**
 * Class Accounts
 * @package PreviewTechs\cPanelWHM\WHM
 */
class Accounts
{
    /**
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
     * @link  https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+listaccts
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
            throw ClientExceptions::invalidArgument("You must provide only one argument either user OR domain (not both)");
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
            throw ClientExceptions::recordNotFound(! empty($result['statusmsg']) ? $result['statusmsg'] : "Record not found");
        }

        if ( ! empty($result['acct']) && is_array($result['acct'])) {
            return Account::buildFromArray($result['acct'][0]);
        }

        return null;
    }
}