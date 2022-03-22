# 4. Subscribe to live status updates

So far, you've created a payment request, clicked the "next" URL, and scanned the QR code with you XUMM app to approve
or reject the request. Great!

As an app developer, you can subscribe to your payload's live status updates and react to them. For instance, you can
show the user who created the request a message that says "Payment request accepted! 🎉" when the user on the other end
has signed your request or "Payment request rejected :(️" when it was rejected.

Let's try and do that.

### 4.1 Create a callback function
One of the things that makes subscribing to status updates so powerful, is that you can pass it a _callback function_ to
handle the data. The status update data will be passed to your callback as an instance of 
`Xrpl\XummSdkPhp\Subscription\CallbackParams`.

Let's define your callback at the bottom of your script:

```php
$callback = function(CallbackParams $event): ?array
{
    if (!isset($event->data['signed'])) {
        return null; // Don't do anything, wait for the next message.
    }

    if ($event->data['signed'] === true) {
        echo "🎉 Payment request accepted!\n";
        return $event->data;  // Returning a value ends the subscription.
    }

    echo "Payment request rejected :(\n";
    return [];
};
```

### 4.2 Start a subscription
Now let's start a subscription and pass our callback to handle any events that are coming in!
```php
$subscription = $sdk->subscribe($createdPayload, $callback);
```
Now, when the user signs or rejects the request (which you can do by following the URL 
[as per the last step](3-create-payload.md)), your function will be called and the subscription ended.

### 4.3 Obtain a user token and send a push notification
Let's say that next time we send this user a sign request, we want them to receive a push notification on their phone. 
We can do that by obtaining a user token for them and passing that into the next payload. The user token is issued when
they sign their first sign request. We just have to fetch the signed request using the event data we return in our 
callback function.

**Please note:** this part uses [Promises](http://wiki.commonjs.org/wiki/Promises/A), which is a fairly new concept in 
PHP. If you've written async code in JavaScript, you'll be familiar with it.

Let's wait until the subscription has ended, and then send ourselves another payment request. This time, we'll receive a 
push notification on our phone because we pass the user token we've obtained.

```php
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
```

Be aware that to test this on your actual phone, you should have push notifications turned on for XUMM. It might also
help to put in a short `sleep()` statement before you push the new request, so you have some time to lock your phone and
clearly see the notification coming in.