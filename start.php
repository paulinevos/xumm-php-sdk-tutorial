<?php

require_once './vendor/autoload.php';

echo "Hello World\n";

$sdk = new \Xrpl\XummSdkPhp\XummSdk();
$pong = $sdk->ping();

echo "Application name: " . $pong->application->name;