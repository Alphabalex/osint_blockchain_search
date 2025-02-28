<?php

namespace Eaglewatch\Web3Search;

use Eaglewatch\Web3Search\Abstracts\HttpRequest;


class Blockchair extends HttpRequest
{
    private $defaultConfig = array("api_url" => "https://api.blockchair.com");
    private $options = array();
    private $apiKey;

    public function __construct(string $api_key, array $options = [])
    {
        $this->options = array_merge($this->defaultConfig, $options);
        $this->setApiUrl($this->options['api_url']);
        $this->apiKey = $api_key;
    }

    public function setBlockchain(string $blockchain)
    {
        $blockchainUrls = [
            'bitcoin' => "{$this->options['api_url']}/bitcoin",
            'bitcoin-cash' => "{$this->options['api_url']}/bitcoin-cash",
            'bitcoin-testnet' => "{$this->options['api_url']}/bitcoin/testnet",
            'omni' => "{$this->options['api_url']}/bitcoin/omni",
            'ethereum' => "{$this->options['api_url']}/ethereum",
            'erc-20' => "{$this->options['api_url']}/ethereum/erc-20",
            'ethereum-testnet' => "{$this->options['api_url']}/ethereum/testnet",
            'litecoin' => "{$this->options['api_url']}/litecoin",
            'bitcoin-sv' => "{$this->options['api_url']}/bitcoin-sv",
            'dogecoin' => "{$this->options['api_url']}/dogecoin",
            'dash' => "{$this->options['api_url']}/dash",
            'ripple' => "{$this->options['api_url']}/ripple",
            'groestlcoin' => "{$this->options['api_url']}/groestlcoin",
            'stellar' => "{$this->options['api_url']}/stellar",
            'monero' => "{$this->options['api_url']}/monero",
            'cardano' => "{$this->options['api_url']}/cardano",
            'zcash' => "{$this->options['api_url']}/zcash",
            'mixin' => "{$this->options['api_url']}/mixin",
            'ecash' => "{$this->options['api_url']}/ecash",
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
        return $this->sendHttpRequest($url, 'GET', []);
    }

    public function getRawBlockData(string $identifier): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $identifier) && !is_numeric($identifier)) {
            throw new \InvalidArgumentException("Invalid block identifier: {$identifier}");
        }

        $url = "/raw/block/{$identifier}";
        return $this->sendHttpRequest($url, 'GET', []);
    }

    public function getRawTransactionData(string $hash): array
    {
        if (!preg_match('/^[0-9a-f]{64}$/i', $hash)) {
            throw new \InvalidArgumentException("Invalid transaction hash: {$hash}");
        }

        $url = "/raw/transaction/{$hash}";
        return $this->sendHttpRequest($url, 'GET', []);
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
        return $this->sendHttpRequest($url, 'GET', []);
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
        return $this->sendHttpRequest($url, 'GET', []);
    }

    public function getAddressData(mixed $address): array
    {
        if (is_array($address)) {
            $address = implode(",", $address);
            $url = "/dashboards/addresses/{$address}";
        } else {
            $url = "/dashboards/address/{$address}";
        }

        return $this->sendHttpRequest($url, 'GET', []);
    }
}
