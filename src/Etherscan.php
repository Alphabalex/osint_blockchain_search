<?php

namespace Eaglewatch\Web3Search;

use Eaglewatch\Web3Search\Abstracts\HttpRequest;


class Etherscan extends HttpRequest
{

    public function __construct()
    {
        $this->setApiUrl(config('etherscan.api_url'));
        $this->setApiKey(config('etherscan.api_key'));
        //$this->additionalHeader = ['X-API-Key' => $this->apiKey];
    }

    public function getBalance(mixed $address, int $chain = Chain::BASE_MAINNET): array
    {
        if (is_array($address)) {
            $address = implode(",", $address);
            $url = "?chainid={$chain}&module=account&action=balancemulti&address={$address}&tag=latest&apikey={$this->apiKey}";
        } else {
            $url = "?chainid={$chain}&module=account&action=balance&address={$address}&tag=latest&apikey={$this->apiKey}";
        }
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getNormalTransactions(string $address, int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = http_build_query([
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'txlist',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ]);
        $url = "?{$data}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getInternalTransactions(string $address, int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = http_build_query([
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'txlistinternal',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ]);
        $url = "?{$data}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getInternalTransactionsByHash(string $hash, int $chain = Chain::BASE_MAINNET, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = http_build_query([
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'txlistinternal',
            'txhash' => $hash,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ]);
        $url = "?{$data}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getInternalTransactionsByBlock(int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = http_build_query([
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'txlistinternal',
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ]);
        $url = "?{$data}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getERC20TokenTransfers(string $address, string $contractaddress = '', int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'tokentx',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ];
    
        if (!empty($contractaddress)) {
            $data['contractaddress'] = $contractaddress;
        }
    
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getERC721TokenTransfers(string $address, string $contractaddress = '', int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'tokennfttx',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ];
    
        if (!empty($contractaddress)) {
            $data['contractaddress'] = $contractaddress;
        }
    
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getERC1155TokenTransfers(string $address, string $contractaddress = '', int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'token1155tx',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ];
    
        if (!empty($contractaddress)) {
            $data['contractaddress'] = $contractaddress;
        }
    
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getBlocks(string $address, int $chain = Chain::BASE_MAINNET, string $blocktype = "blocks", int $page = 1, int $offset = 100): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'getminedblocks',
            'address' => $address,
            'blocktype' => $blocktype,
            'page' => $page,
            'offset' => $offset,
            'apikey' => $this->apiKey
        ];
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getWithdrawals(string $address, int $chain = Chain::BASE_MAINNET, int $startblock = 0, int $endblock = 99999999, int $page = 1, int $offset = 100, string $sort = "asc"): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'txsBeaconWithdrawal',
            'address' => $address,
            'startblock' => $startblock,
            'endblock' => $endblock,
            'page' => $page,
            'offset' => $offset,
            'sort' => $sort,
            'apikey' => $this->apiKey
        ];
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }

    public function getHistoricalBalance(string $address, int $chain = Chain::BASE_MAINNET, int $blockno = 8000000): array
    {
        $data = [
            'chainid' => $chain,
            'module' => 'account',
            'action' => 'balancehistory',
            'address' => $address,
            'blockno' => $blockno,
            'apikey' => $this->apiKey
        ];
        $queryString = http_build_query($data);
        $url = "?{$queryString}";
        $this->setRequestOptions();
        return $this->setHttpResponse($url, 'GET', [])->getResponse();
    }
}
