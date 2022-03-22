# 2. Project setup 

_Previous: [1. Create XUMM API credentials](https://dev.to/wietse/xumm-sdk-1-get-your-xumm-api-credentials-5c3i)_

The tutorial project has a little script that will use the SDK as a dependency. Right now, it returns a 
`Hello World` response. Let's run it in our terminal:

```shell
php ./start.php   # Start server listening to port 8080 
```

You should now see `Hello World`. Great! Any time you make changes to your project during this tutorial, you'll run the
script to see the changes.

### 2.1 Include the SDK
Use composer to add the XUMM PHP SDK as a dependency to your project:
```shell
composer require xrpl/xumm-sdk-php
```

### 2.2 Add your credentials
_Note: this is the only part that won't be included in the code solution of this chapter, as everybody's credentials are
unique._

Assign the credentials you created in 
[Step 1](https://dev.to/wietse/xumm-sdk-1-get-your-xumm-api-credentials-5c3i)
to the `XUMM_API_KEY` and `XUMM_API_SECRET` environment variables (be aware you need to do this on every new terminal 
session):
```shell
export XUMM_API_KEY="{your API key}"
export XUMM_API_SECRET="{your API secret}"
```

### 2.3 Use the XUMM SDK
In `start.php`, include composer's `autoload` file at the top of the script, so that your script can find the `XummSdk` 
class:

```php
require_once './vendor/autoload.php';
```

Now instantiate the `XummSdk`. It will source your credentials from the environment variables you set in step 2.2.
To test the SDK, call `XummSdk::ping` and show the application name.
```php
$sdk = new \Xrpl\XummSdkPhp\XummSdk();
$pong = $sdk->ping();
echo "Application name: " . $pong->application->name
```

Now when you run your script your should see:
```shell
Application name: {your app name}
```
🎉 It works!

Next: [3. Your first payload](3-create-payload.md)