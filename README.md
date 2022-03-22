# Using the XUMM PHP SDK (tutorial)

In a nutshell, the [XUMM API](https://xumm.readme.io/docs/call-xumm-platform) allows developers to deliver sign requests
to their app's users, to create new transactions on the XRP ledger.

XUMM end users can then [scan a QR code](https://www.youtube.com/watch?v=P6hL1FDvF4c) or receive a push notification to 
open the sign request. When they approve it, XUMM signs it, and the transaction is placed on the ledger.

To make it easier to interact with the API, XUMM released an SDK in a number of languages, 
[most recently in PHP](https://github.com/XRPL-Labs/XUMM-SDK-PHP). This tutorial explains how to use it. Every chapter 
will have a branch with the code solution in the tutorial's Git repository. So if you get stuck, just `git 
checkout ch-2`, `git checkout ch-3`, etc.

### Prerequisites
For this tutorial, we assume you have:
- basic knowledge of PHP and the terminal
- [composer](https://getcomposer.org/doc/00-intro.md) installed on your machine
- PHP^8.1 (the SDK's required PHP version) installed on your machine
- the XUMM app on your phone, and an account

Chapters
1. [Create XUMM API credentials](https://dev.to/wietse/xumm-sdk-1-get-your-xumm-api-credentials-5c3i)
2. [Project setup](instructions/2-project-setup.md)
3. [Your first payload](instructions/3-create-payload.md)
4. [Subscribe to live status updates](instructions/4-live-status-updates.md)


