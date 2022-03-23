<?php

use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Payload\Options;
use Xrpl\XummSdkPhp\Payload\Payload;
use Xrpl\XummSdkPhp\XummSdk;

require_once './vendor/autoload.php';

$sdk = new XummSdk();

$payment = new Payload(
    transactionBody: [
        'TransactionType' => 'Payment',
        'Destination' => 'rGBiHBoEs238W7H1b4gMey55He97kWcoUb' // Use your own address here
    ],
    options: new Options(
        immutable: true,
    ),
    customMeta: new CustomMeta(
        uniqid(),
        'Hi! Can you pay me please? Thanks! ❤️',
    )
);

$createdPayment = $sdk->createPayload($payment);
$url = $createdPayment->next->always;
echo "Sign request: ${url}\n";
