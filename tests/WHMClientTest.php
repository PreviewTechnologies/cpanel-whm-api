<?php

namespace PreviewTechs\cPanelWHM\Tests;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use PreviewTechs\cPanelWHM\Exceptions\ClientExceptions;
use PreviewTechs\cPanelWHM\WHMClient;

class WHMClientTest extends TestCase
{
    public function testConstructor()
    {
        $whmClient = new WHMClient("FAKE_USER", "FAKE_TOKEN", "FAKE_HOST", "FAKE_PORT");
        $this->assertTrue($whmClient instanceof WHMClient);
    }

    public function testSetHttpClient()
    {
        $this->httpClientResponseTest(['test' => 1], ['Content-Type' => "text/plain"]);
        $this->httpClientResponseTest(['test' => 1], ['Content-Type' => "application/json"]);
    }

    /**
     * @throws \Http\Client\Exception
     * @throws \PreviewTechs\cPanelWHM\Exceptions\ClientExceptions
     *
     * @expectedException \PreviewTechs\cPanelWHM\Exceptions\ClientExceptions
     */
    public function testSendRequestWithBadCredsAndThrowException()
    {
        $fakeResponseArray = array (
            'cpanelresult' =>
                array (
                    'apiversion' => '2',
                    'error' => 'Access denied',
                    'data' =>
                        array (
                            'reason' => 'Access denied',
                            'result' => '0',
                        ),
                    'type' => 'text',
                ),
        );
        $whmClient         = new WHMClient("FAKE_USER", "FAKE_TOKEN", "FAKE_HOST", 2087);

        $client   = new Client();
        $response = new Response(403, ['Content-Type' => "text/plain"], json_encode($fakeResponseArray));
        $response = $response->withStatus(403);
        $client->addResponse($response);
        $whmClient->setHttpClient($client);

        $whmClient->sendRequest("/fake_endpoint", "GET", []);
    }

    protected function httpClientResponseTest(array $responseArray = [], array $headers = [])
    {
        $whmClient         = new WHMClient("FAKE_USER", "FAKE_TOKEN", "FAKE_HOST", 2087);

        $client   = new Client();
        $response = new Response(200, $headers, json_encode($responseArray));
        $client->addResponse($response);
        $whmClient->setHttpClient($client);

        $result = $whmClient->sendRequest("/fake_endpoint", "GET", []);
        $this->assertTrue(is_array($result));
        $this->assertEquals($responseArray, $result);
    }
}