<?php
require("../../lib/config.php");

$server_host = $_SERVER["HTTP_HOST"];

$dom = new DOMDocument();
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><result/>');

$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$xml->addChild('has_error', 0);
$xml->addChild('version', 1);

$prod = $config['prod'];

$endpoint = $xml->addChild('endpoint');

$endpoint->addChild('host', $server_host);
$endpoint->addChild('api_host', UII_DISCOVERY_API_HOST);
$endpoint->addChild('portal_host', UII_DISCOVERY_PORTAL_HOST);
$endpoint->addChild('n3ds_host', UII_DISCOVERY_N3DS_HOST);

$dom->loadXML($xml->asXML());

$xml = $dom->saveXML();

// X-Dispatch: Olive::Web::Discovery::V1::Endpoint-index
header("X-Dispatch: Uiiverse::Web::Discovery::V1::Endpoint-index");
header("Content-Type: application/xml");
header("Content-Length: " . strlen($xml));

print($xml);
?>
