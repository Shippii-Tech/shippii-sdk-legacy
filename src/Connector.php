<?php
namespace Shippii;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiEndpointNotFoundException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Tightenco\Collect\Support\Arr as TightencoArr;
use Tightenco\Collect\Support\Collection as TightencoCollection;

/**
 * Class Connector
 * @package Shippii
 */
class Connector
{
    const SHIPPII_PRODUCTION_URL = 'https://api.shippii.com/';
    const SHIPPII_SANDBOX_URL = 'https://test-api.shippii.com/';
    const SHIPPII_SDK_VERSION = "1.8.4";
    const SHIPPII_TIMEOUT_SECONDS = 40;

    /**
     * Running in test mode
     *
     * @var bool
     */
    protected $testMode = true;

    /**
     * The client ID for authorization
     *
     * @var string
     */
    protected $clientId = "1";

    /**
     * Guzzle Http Client
     *
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * Connector constructor.
     * @param string $token
     * @param bool $testMode
     * @param string|null $baseUrl
     * @param string $clientId
     */
    public function __construct(string $token, bool $testMode = true, string $baseUrl = null, string $clientId = "1")
    {
        $this->baseUrl = $baseUrl;
        $this->clientId = $clientId;
        $this->testMode = $testMode;
        $this->token = $token;
        $this->boot();
    }

    /**
     * Configure the client
     *
     */
    protected function boot()
    {
        $url = $this->getBaseUrl();
        $headers = $this->prepareHeaders();
        $httpClient = new Client([
            'base_uri' => $url,
            'headers'  => $headers,
        ]);

        $this->client = $httpClient;
    }

    /**
     * Prepare The Headers
     * @return array
     */
    protected function prepareHeaders(): array
    {
        return  [
            'Authorization' => 'Bearer ' . $this->token,
            'User-Agent' => 'Shippii-PHPSdk/' . self::SHIPPII_SDK_VERSION,
            'Accept' => 'application/json',
            'X-Client-ID' => $this->clientId,
            'X-SDK-Version' => self::SHIPPII_SDK_VERSION,
        ];
    }

    /**
     * Get the base url
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        if (!(is_null($this->baseUrl))) {
            return $this->baseUrl;
        }
        return $this->testMode ? self::SHIPPII_SANDBOX_URL : self::SHIPPII_PRODUCTION_URL;
    }

    /**
     * Prepare Request Configuration
     *
     * @param TightencoCollection|null $requestData
     * @return array
     */
    protected function prepareRequestConfiguration(TightencoCollection $requestData = null): array
    {
        $result = [];

        TightencoArr::set($result, 'timeout', self::SHIPPII_TIMEOUT_SECONDS);

        if ($requestData->has('query')) {
            TightencoArr::set($result, 'query', $requestData->get('query'));
        }
        if ($requestData->has('json')) {
            TightencoArr::set($result, 'json', $requestData->get('json'));
        }

        return $result;
    }

    /**
     * Parse the Response
     *
     * @param $response
     * @return TightencoCollection
     */
    protected function parseResponse(Response $response): TightencoCollection
    {
        $responseResult = new TightencoCollection();
        $body = json_decode($response->getBody()->getContents(), true);
        $responseResult->put('headers', $response->getHeaders());
        $responseResult->put('request', null);
        $responseResult->put('success', data_get($body, 'success'));
        $responseResult->put('http_code', $response->getStatusCode());
        $responseResult->put('message', data_get($body, 'message'));
        $responseResult->put('data', data_get($body, 'data'));

        return $responseResult;
    }


    /**
     * @param Exception $exception
     * @return TightencoCollection
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    protected function parseException(Exception $exception)
    {
        if ($exception instanceof ClientException) {
            return $this->parseClientErrors($exception);
        } elseif ($exception instanceof GuzzleException) {
            return $this->parseGuzzleErrors($exception);
        }
    }

    /**
     * Parse Guzzle Itself Errors
     *
     * @param GuzzleException $guzzleException
     * @return TightencoCollection
     * @throws ShippiiServerErrorException
     */
    protected function parseGuzzleErrors(GuzzleException $guzzleException): TightencoCollection
    {
        $message = $guzzleException->getMessage();
        if ($guzzleException->hasResponse()) {
            $message = $guzzleException->getResponse()->getBody()->getContents();
        }
        throw new ShippiiServerErrorException($message);
    }

    /**
     * Parse Client Errors
     *
     * @param ClientException $clientException
     * @return TightencoCollection
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    protected function parseClientErrors(ClientException $clientException): TightencoCollection
    {
        $parsedResponseResult = new TightencoCollection();
        $responseBody = null;
        $request = $clientException->getRequest();
        $hasResponse = $clientException->hasResponse();
        $parsedResponseResult->put('success', false);
        $parsedResponseResult->put('http_code', $clientException->getCode());
        $parsedResponseResult->put('message', $clientException->getMessage());
        $parsedResponseResult->put('request', new TightencoCollection([
            'headers' => $request->getHeaders(),
            'uri' => $request->getUri(),
            'method' => $request->getMethod(),
            'body' => $request->getBody()->getContents(),
        ]));
        if ($hasResponse) {
            $responseBody = json_decode($clientException->getResponse()->getBody()->getContents());
            $parsedResponseResult->put('message', data_get($responseBody, 'message'));
            $parsedResponseResult->put('data', new TightencoCollection(data_get($responseBody, 'data')));
            switch ($clientException->getCode()) {
                case 401:
                    throw new ShippiiAuthenticationException($parsedResponseResult->get('message'));
                    break;
                case 403:
                    throw new ShippiiAuthorizationException($parsedResponseResult->get('message'));
                    break;
                case 404:
                    throw new ShippiiEndpointNotFoundException($parsedResponseResult->get('message'));
                    break;
                case 422:
                    throw new ShippiiValidationException($parsedResponseResult->get('message'), (array)data_get($responseBody, 'errors'));
                    break;
                case 500:
                    throw new ShippiiServerErrorException($parsedResponseResult->get('message'), data_get($responseBody, 'event_id'));
                    break;
            }
        }

        return $parsedResponseResult;

    }

    /**
     * Make Request
     *
     * @param string $method
     * @param string $endPoint
     * @param string $version
     * @param TightencoCollection $requestData
     * @return TightencoCollection
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiEndpointNotFoundException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function request(string $method, string $endPoint, string $version = "v1", TightencoCollection $requestData = null): TightencoCollection
    {
        $requestData = (is_null($requestData)) ? new TightencoCollection() : $requestData;

        $requestConfig = $this->prepareRequestConfiguration($requestData);
        $endPoint = $version . '/' . $endPoint;

        try {
            return $this->parseResponse($this->client->request($method, $endPoint, $requestConfig));
        } catch (ClientException $clientException) {
            return $this->parseException($clientException);
        } catch (GuzzleException $guzzleException) {
            return $this->parseException($guzzleException);
        }
    }
}