<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$data = file_get_contents('php://input');
file_put_contents("php://stderr", $data . "\n");