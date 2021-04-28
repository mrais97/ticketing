<?php
session_start();
define('_CDN_HOST', 'http://localhost/ticketing/public/');
// define("_UPLOAD_FOLDER", "/home/hris-dev/ticket_sandbox/");
define("_BASE_DIR", "http://localhost/ticketing/public/");
define("_CONFIG", "localhost/ticketing/config.php");
define("_DBHOST", "localhost");
define("_DB", "ticket_staging");
define("_UNAME", "root");
define("_PASS", "cuy123");
 
$con = mysqli_connect(_DBHOST, _UNAME, _PASS, _DB);
?>
