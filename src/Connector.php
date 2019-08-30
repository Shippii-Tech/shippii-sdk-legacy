<?php
namespace Shippii;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Shippii\Exceptions\Auth\ShippiiAuthenticationException;
use Shippii\Exceptions\Auth\ShippiiAuthorizationException;
use Shippii\Exceptions\ShippiiServerErrorException;
use Shippii\Exceptions\ShippiiValidationException;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

class Connector
{
    const SHIPPII_PRODUCTION_URL = 'https://api.shippii.com/';
    const SHIPPII_SANDBOX_URL = 'https://test-api.shippii.com/';
    const SHIPPII_SDK_VERSION = "1.0.1";
    const SHIPPII_TIMEOUT_SECONDS = 4;

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
     * Connector constructor.
     * @param string $token
     * @param bool $testMode
     * @param string $clientId
     */
    public function __construct(string $token, bool $testMode = true, string $clientId = "1")
    {
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
        return $this->testMode ? self::SHIPPII_SANDBOX_URL : self::SHIPPII_PRODUCTION_URL;
    }

    protected function prepareRequestConfiguration(Collection $requestData): array
    {
        $result = [];

        Arr::set($result, 'timeout', self::SHIPPII_TIMEOUT_SECONDS);

        if ($requestData->has('query')) {
            Arr::set($result, 'query', $requestData->get('query'));
        }
        if ($requestData->has('json')) {
            Arr::set($result, 'json', $requestData->get('json'));
        }

        return $result;
    }

    /**
     * Parse the Response
     *
     * @param $response
     * @return Collection
     */
    protected function parseResponse(Response $response): Collection
    {
        $responseResult = collect();
        $body = json_decode($response->getBody()->getContents());
        $responseResult->put('headers', $response->getHeaders());
        $responseResult->put('request', null);
        $responseResult->put('success', data_get($body, 'success'));
        $responseResult->put('http_code', $response->getStatusCode());
        $responseResult->put('message', data_get($body, 'message'));
        $responseResult->put('data', collect(data_get($body, 'data')));

        return $responseResult;
    }

    /**
     * Parse Client Errors
     *
     * @param ClientException $clientException
     * @return \Illuminate\Support\Collection|Collection
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    protected function parseClientErrors(ClientException $clientException)
    {
        $parsedResponseResult = collect();
        $responseBody = null;
        $request = $clientException->getRequest();
        $hasResponse = $clientException->hasResponse();
        $parsedResponseResult->put('success', false);
        $parsedResponseResult->put('http_code', $clientException->getCode());
        $parsedResponseResult->put('message', $clientException->getMessage());
        $parsedResponseResult->put('request', collect([
            'headers' => $request->getHeaders(),
            'uri' => $request->getUri(),
            'method' => $request->getMethod(),
            'body' => $request->getBody()->getContents(),
        ]));
        if ($hasResponse) {
            $responseBody = json_decode($clientException->getResponse()->getBody()->getContents());
            $parsedResponseResult->put('message', data_get($responseBody, 'message'));
            $parsedResponseResult->put('data', collect(data_get($responseBody, 'data')));
            switch ($clientException->getCode()) {
                case 401:
                    throw new ShippiiAuthenticationException($parsedResponseResult->get('message'));
                    break;
                case 403:
                    throw new ShippiiAuthorizationException($parsedResponseResult->get('message'));
                    break;
                case 422:
                    throw new ShippiiValidationException($parsedResponseResult->get('message'), (array)data_get($responseBody, 'errors'));
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
     * @param Collection|null $requestData
     * @return Collection
     * @throws ShippiiAuthenticationException
     * @throws ShippiiAuthorizationException
     * @throws ShippiiServerErrorException
     * @throws ShippiiValidationException
     */
    public function request(string $method, string $endPoint, string $version = "v1", Collection $requestData = null): Collection
    {
        $requestConfig = $this->prepareRequestConfiguration($requestData);
        $endPoint = $version . '/' . $endPoint;

        try {
            $response = $this->parseResponse($this->client->request($method, $endPoint, $requestConfig));
            return $response;
        } catch (ClientException $clientException) {
            return  $this->parseClientErrors($clientException);
        } catch (GuzzleException $e) {
            dump($e->getMessage());
        }
    }
}