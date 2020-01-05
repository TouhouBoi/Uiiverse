<?php
require("config.php");

if (UII_DISCOVERY_MAINTENANCE_MODE == true)
{
  $dom = new DOMDocument();
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><result/>');

	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;

	$xml->addChild('has_error', 1);

	$xml->addChild('version', 1);

	$xml->addChild('code', 400);

	$xml->addChild('error_code', 3);

	$xml->addChild('message', 'SERVICE_MAINTENANCE');

	$dom->loadXML($xml->asXML());

	$xml = $dom->saveXML();

	header('Content-Type: application/xml');
	header('Content-Length: ' . strlen($xml));

	http_response_code(400);

	print($xml);

	exit;
}
else if (UII_DISCOVERY_SERVICE_CLOSED == true)
{
  $dom = new DOMDocument();
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><result/>');

	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;

	$xml->addChild('has_error', 1);

	$xml->addChild('version', 1);

	$xml->addChild('code', 400);

	$xml->addChild('error_code', 3);

	$xml->addChild('message', 'SERVICE_CLOSED');

	$dom->loadXML($xml->asXML());

	$xml = $dom->saveXML();

	header('Content-Type: application/xml');
	header('Content-Length: ' . strlen($xml));

	http_response_code(400);

	print($xml);

	exit;
}
else
{
  $server_host = $_SERVER["HTTP_HOST"];

  $dom = new DOMDocument();
  $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><result/>');

  $dom->preserveWhiteSpace = false;
  $dom->formatOutput = true;

  $xml->addChild('has_error', 0);
  $xml->addChild('version', 1);

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
}
?>
