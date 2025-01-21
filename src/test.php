<?php
require __DIR__ . '/../vendor/autoload.php';
use Eaglewatch\Web3Search\Chain;
use Eaglewatch\Web3Search\Etherscan;


$scan = new Etherscan();
$hash = "0xea9641bf0ec642fad2c81efb7e2fd9b865146267cbd59fefef9d6cbe935d4a02";
$address = "0x9dd134d14d1e65f84b706d6f205cd5b1cd03a46b";
$contract = "0x57d90b64a1a57749b0f932f1a3395792e12e7055";
$addresses = ["0xddbd2b932c763ba5b1b7ae3b362eac3e8d40121a","0x63a9975ba31b0b9626b34300f7f627147df1f526","0x198ef1ec325a96cc354c7266a038be8b5c558f67"];
$search = $scan->getHistoricalBalance($address, Chain::ETHEREUM_MAINNET);

print_r($search);
