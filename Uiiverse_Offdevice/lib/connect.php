<?php
require("config.php");

// die will output to console which is not what you want to do if you want a clean console
// exit will not
function mysql_machine_broke()
{
    http_response_code(503);
    exit('Failed to Connect to Database, Please try again later.');
}


$dbc = @mysqli_connect(UII_MYSQL_HOST, UII_MYSQL_USER, UII_MYSQL_PASS, UII_MYSQL_DB);

if (!$dbc) {
    mysql_machine_broke();
}

@$dbc->set_charset('utf8') || mysql_machine_broke();
//sets timezones
@$dbc->query('SET time_zone = "-5:00";') || mysql_machine_broke();
date_default_timezone_set('America/New_York');
if (session_status() == PHP_SESSION_NONE) {
    session_name('graham');
    session_set_cookie_params(30 * 6000000, "/");
    session_start();
}

// Error handler. If this returns nothing, there's something wrong.
if (empty($dbc->query('SELECT 1;')->num_rows)) {
    mysql_machine_broke();
}
