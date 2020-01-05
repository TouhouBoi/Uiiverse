<?php
// Main Index File

require_once("AltoRouter.php");

$router = new AltoRouter();

$router->addRoutes(
  array(
    // Endpoint URLs
    array('GET', '/v1/endpoint', 'endpoint.php', 'Endpoint-index'),
    array('GET', '/v1/endpoint[*:type]', 'endpoint.php', 'Endpoint-handler')
  )
);

// Match the current request
$match = $router->match(urldecode($_SERVER['REQUEST_URI']));

if ($match)
{
    foreach ($match['params'] as &$param)
    {
        ${key($match['params'])} = $param;
    }

    require_once($match['target']);
}
else
{
    http_response_code(404);

    exit("<link rel='stylesheet' type='text/css' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'><link rel='icon' type='image/png' href='/assets/img/404_icon.png'><center><br><br><br><br><br><b><h1>4... Oh, 4...</h1></b><p>This page seems to not exist. Sorry!</p><a href='https://uiiverse.xyz/'><b>« Return to Uiiverse</b></a></center>");
}
