# 3. Your first payload 

Now that we've established a connection to the XUMM platform using the SDK, it's time to send something we can sign. 
We'll send a "transaction template" to the XUMM platform, called a Payload. The lifecycle of a Payload is explained in 
more detail in [the XUMM API documentation.](https://xumm.readme.io/docs/payload-workflow)

First, create a payload by instantiating an instance of `Xrpl\XummSdkPhp\Payload\Payload`. It **must** contain a 
transaction body array formatted as per [XRP ledger specifications](https://xrpl.org/transaction-types.html). It **can**
contain a user token, options, and some custom metadata.

### 3.1 Create a payload
Our first payload will be a Payment transaction type. This is a very minimal example of a payload you can send to XUMM:
```php
$payment = new Xrpl\XummSdkPhp\Payload\Payload(
    [
        'TransactionType' => 'Payment',
        'Destination' => 'rwietsevLFg8XSmG3bEZzFein1g8RBqWDZ', // Use your own address here
    ],
);
```

If, like in the minimal example above, no amount is entered, the end user will be able to select the currency and amount
to send in XUMM after opening the sign request. You could also add more details to your payload, as per the following 
example:

```php
$payment = new Payload(
    transactionBody: [
        'TransactionType' => 'Payment',
        'Destination' => 'rwietsevLFg8XSmG3bEZzFein1g8RBqWDZ', // Use your own address here
        'Amount' => '10000',
    ],
    options: new Options(
        immutable: true
    )
    customMeta: new CustomMeta(
        uniqid(),
        'Hi! Can you pay me please? Thanks! ❤️',
    )
);
```

### 3.2 Send the payload
Now you can pass your `Payload` object to `XummSdk::createPayload` and show the result:
```php
$createdPayment = $sdk->createPayload($payment);
$url = $createdPayment->next->always;
echo "Sign request: ${url}\n";
```

Re-run your script to see it work! You can now follow the URL in the result and scan the QR code to sign the request,
or reject it.

The first time you send a user a sign request, they'll always have to scan the QR code. Once they've signed it, you can
obtain a user token for that user and send them push notifications on future sign requests! Let's see how that's done
in the next chapter:

Next: [4. Subscribe to live status updates](4-live-status-updates.md)