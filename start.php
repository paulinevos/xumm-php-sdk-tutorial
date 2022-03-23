<?php

require_once './vendor/autoload.php';

use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Payload\Options;
use Xrpl\XummSdkPhp\Payload\Payload;
use Xrpl\XummSdkPhp\Subscription\CallbackParams;
use Xrpl\XummSdkPhp\XummSdk;

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

$callback = function(CallbackParams $event): ?array
{
    if (!isset($event->data['signed'])) {
        return null;
    }

    if ($event->data['signed'] === true) {
        echo "🎉 Payment request accepted!\n";
        return $event->data;  // Returning a value ends the subscription.
    }

    echo "Payment request rejected :(\n";
    return [];
};

$subscription = $sdk->subscribe($createdPayment, $callback);

$subscription->resolved()
    ->done(function (array $data) use ($sdk) {
        $payloadId = $data['payload_uuidv4'] ?? false;

        if (!$payloadId) {
            return null;
        }

        $signedRequest = $sdk->getPayload($data['payload_uuidv4']);

        $newRequest = $sdk->createPayload(new Payload(
            [
                'TransactionType' => 'Payment',
                'Destination' => 'rGBiHBoEs238W7H1b4gMey55He97kWcoUb', // Use your own address here
                'Amount' => '1000',
            ],
            $signedRequest->application->issuedUserToken,
        ));

        echo sprintf("The new request was %s\n", $newRequest->pushed ? 'pushed' : 'not pushed...');
    });
