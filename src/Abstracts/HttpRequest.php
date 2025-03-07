<?php

namespace Eaglewatch\Web3Search\Abstracts;

use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Promise\PromiseInterface;


abstract class HttpRequest
{
    private string $api_url;
    private $client;
    private $response;
    private array $additionalHeader = [];

    protected function setHeaders(array $headers): void
    {
        $this->additionalHeader =  $headers;
    }

    protected function setApiUrl(string $url): void
    {
        $this->api_url =  $url;
    }

    protected function sendHttpRequest($relativeUrl, $method, $body = [], $response = 'json')
    {
        if (empty($this->api_url)) {
            throw new InvalidArgumentException("Api URL is required and cannot be empty");
        }
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            ...$this->additionalHeader
        ];
        $this->client = new Client(
            [
                'base_uri' => $this->api_url,
                'headers' => $headers
            ]
        );
        if (is_null($method)) {
            throw new Exception("Request method must be specified");
        }

        $this->response = $this->client->{strtolower($method)}(
            $this->api_url . $relativeUrl,
            ["body" => json_encode($body)]
        );

        if ($response == 'json') {
            $data = json_decode($this->response->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to decode JSON: " . json_last_error_msg());
            }
            return $data;
        }
        return $this->response->getBody()->getContents();
    }

    protected function getFileContent($url)
    {
        // Fetch the JSON data from the API endpoint
        $jsonData = @file_get_contents($url);
        if ($jsonData === FALSE) {
            throw new Exception("Unable to fetch data from $url");
        }

        // Decode the JSON response
        $data = json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode JSON: " . json_last_error_msg());
        }

        return $data;
    }
}
