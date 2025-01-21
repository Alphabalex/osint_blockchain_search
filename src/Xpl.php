<?php

namespace Eaglewatch\Web3Search;

use Eaglewatch\Web3Search\Abstracts\HttpRequest;


class Xpl extends HttpRequest
{

    public function __construct()
    {
        $this->setApiUrl(config('xpl.sandbox_url'));
        $this->setApiKey(config('xpl.api_key'));
        //$this->additionalHeader = ['X-API-Key' => $this->apiKey];
    }

    public function getLastSeenData(string $blockchain, array $addresses, array $data, string $from = 'all', string $mixins = '', string $library = ''): array
    {
        if (count($addresses) > 100) {
            throw new \InvalidArgumentException("Maximum of 100 addresses allowed.");
        }

        $addressList = implode(",", $addresses);
        $queryParams = [
            'data' => implode(",", $data),
            'from' => $from,
        ];

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/{$blockchain}/addresses/{$addressList}?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function searchAllBlockchains(string $query, string $from = 'all', string $in = 'all', string $mixins = '', string $library = ''): array
    {
        $queryParams = [
            'q' => $query,
            'from' => $from,
            'in' => $in,
        ];

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/search?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getStats(string $from = 'all', string $mode = 'non-greedy', string $library = ''): array
    {
        $queryParams = [
            'from' => $from,
            'mode' => $mode,
        ];

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getPaginatedBlocks(string $blockchain, string $data, string $from = 'all', int $limit = 10, int $page = 0, string $mixins = '', string $library = ''): array
    {
        $queryParams = [
            'data' => $data,
            'from' => $from,
            'limit' => $limit,
            'page' => $page,
        ];

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/{$blockchain}/blocks?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getBlockData(string $blockchain, int $block, string $data, string $from = 'all', int $limit = 10, int $page = 0, string $mixins = '', string $library = ''): array
    {
        $queryParams = [
            'data' => $data,
            'from' => $from,
            'limit' => $limit,
            'page' => $page,
        ];

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/{$blockchain}/block/{$block}?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getTransactionData(string $blockchain, string $transaction, string $data, string $from = 'all', int $limit = 10, int $page = 0, string $mixins = '', string $library = ''): array
    {
        $queryParams = [
            'data' => $data,
            'from' => $from,
            'limit' => $limit,
            'page' => $page,
        ];

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/{$blockchain}/transaction/{$transaction}?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getAddressData(string $blockchain, string $address, string $data, string $from = 'all', int $limit = 10, int $page = 0, string $segment = '', string $mixins = '', string $library = ''): array
    {
        $queryParams = [
            'data' => $data,
            'from' => $from,
            'limit' => $limit,
            'page' => $page,
        ];

        if (!empty($segment)) {
            $queryParams['segment'] = $segment;
        }

        if (!empty($mixins)) {
            $queryParams['mixins'] = $mixins;
        }

        if (!empty($library)) {
            $queryParams['library'] = $library;
        }

        $queryString = http_build_query($queryParams);
        $url = "/{$blockchain}/address/{$address}?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }
}
