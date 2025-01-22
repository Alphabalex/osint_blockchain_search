<?php

namespace Eaglewatch\Web3Search;

use Eaglewatch\Web3Search\Abstracts\HttpRequest;


class Blockchair extends HttpRequest
{

    public function __construct()
    {
        $this->setApiUrl(config('blockchair.api_url'));
        $this->setApiKey(config('blockchair.api_key'));
        //$this->additionalHeader = ['X-API-Key' => $this->apiKey];
    }

    public function setBlockchain(string $blockchain)
    {
        $blockchainUrls = [
            'bitcoin' => "{$this->baseUrl}/bitcoin",
            'bitcoin-cash' => "{$this->baseUrl}/bitcoin-cash",
            'bitcoin-testnet' => "{$this->baseUrl}/bitcoin/testnet",
            'omni' => "{$this->baseUrl}/bitcoin/omni",
            'ethereum' => "{$this->baseUrl}/ethereum",
            'erc-20' => "{$this->baseUrl}/ethereum/erc-20",
            'ethereum-testnet' => "{$this->baseUrl}/ethereum/testnet",
            'litecoin' => "{$this->baseUrl}/litecoin",
            'bitcoin-sv' => "{$this->baseUrl}/bitcoin-sv",
            'dogecoin' => "{$this->baseUrl}/dogecoin",
            'dash' => "{$this->baseUrl}/dash",
            'ripple' => "{$this->baseUrl}/ripple",
            'groestlcoin' => "{$this->baseUrl}/groestlcoin",
            'stellar' => "{$this->baseUrl}/stellar",
            'monero' => "{$this->baseUrl}/monero",
            'cardano' => "{$this->baseUrl}/cardano",
            'zcash' => "{$this->baseUrl}/zcash",
            'mixin' => "{$this->baseUrl}/mixin",
            'ecash' => "{$this->baseUrl}/ecash",
        ];

        if (!array_key_exists($blockchain, $blockchainUrls)) {
            throw new \InvalidArgumentException("Unsupported blockchain: {$blockchain}");
        }

        $this->setApiUrl($blockchainUrls[$blockchain]);

        return $this;
    }

    public function getStats(): array
    {
        $url = "/stats";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getRawBlockData(string $identifier): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $identifier) && !is_numeric($identifier)) {
            throw new \InvalidArgumentException("Invalid block identifier: {$identifier}");
        }

        $url = "/raw/block/{$identifier}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getRawTransactionData(string $hash): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $hash)) {
            throw new \InvalidArgumentException("Invalid transaction hash: {$hash}");
        }

        $url = "/raw/transaction/{$hash}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getDashboardBlockData(mixed $identifier): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $identifier) && !is_numeric($identifier)) {
            throw new \InvalidArgumentException("Invalid block identifier: {$identifier}");
        }

        if (is_array($identifier)) {
            $identifier = implode(",", $identifier);
            $url = "/dashboards/blocks/{$identifier}";
        } else {
            $url = "/dashboards/block/{$identifier}";
        }

        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getDashboardTransactionData(mixed $identifier): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $identifier) && !is_numeric($identifier)) {
            throw new \InvalidArgumentException("Invalid block identifier: {$identifier}");
        }

        if (is_array($identifier)) {
            $identifier = implode(",", $identifier);
            $url = "/dashboards/transactions/{$identifier}";
        } else {
            $url = "/dashboards/transaction/{$identifier}";
        }

        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getAddressData(mixed $address): array
    {
        if (is_array($address)) {
            $address = implode(",", $address);
            $url = "/dashboards/addresses/{$address}";
        } else {
            $url = "/dashboards/address/{$address}";
        }

        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }
}
