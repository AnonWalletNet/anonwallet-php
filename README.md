# anonwallet-php

Official PHP SDK of AnonWallet.Net Anonymous Cryptocurrency Payment Gateway

## Install guide
You can install anonwallet plugin using composer in your project using:

```
composer require anonwallet/anonwallet-php
```

## Usage
Include namespace of package wherever you want to use this library

```
include_once './vendor/autoload.php';
use AnonWallet\AnonWallet;

$api_key = 'Your merchant API Key';

$obj = new AnonWallet($api_key);
```

## Get Balance of specific coin

```

$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC

$balance = $obj->balance($currency);
```

## Get balances of all coins

```
$balances = $obj->balances();
```

## Generate Callback Address

```
$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC
$forward_address = '1Btcdemoforwardaddress'; // If forward address is specified, the funds are automatically send to this address after the transaction is confirmed
$ipn_url = 'Yourdomain.com/handle_payment'; // If IPN url is specified, notifications of payment status changes is sent to this domain
$label = 'John Doe'; //Specify label for your internal system tracking

$address = $obj->callback_address($currency, $forward_address, $ipn_url, $label);
```

## Create new Invoice

```
$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC
$amount = '0.01'; //Numeric double amount required to be received on the invoice
$forward_address = '1Btcdemoforwardaddress'; // If forward address is specified, the funds are automatically send to this address after the transaction is confirmed
$ipn_url = 'Yourdomain.com/handle_payment'; //If IPN url is specified, notifications of payment status changes is sent to this domain
$invoice_id = '112'; // Your internal system tracking invoice id
$hosted_invoice = true; // true or false, if boolean true is specified, the invoice will have a hosted payment page on AnonWallet gateway
$product_title = 'My product title';
$product_description = 'My product description';
$success_url = 'Yourdomain.com/success'; //URL where the buyer will redirect when it cancel the hosted invoice
$cancel_url = 'Yourdomain.com/cancel'; //URL where the buyer will redirect when it cancel the hosted invoice
$buyer_email = 'buyer@email.com' //Specify the buyer email

$invoice = $obj->create_invoice($currency, $amount, $forward_address, $ipn_url, $invoice_id, $hosted_invoice, $product_title, $product_description, $success_url, $cancel_url, $buyer_email);

```

## Create new Withdrawal request

```
$currency = 'BTC'; //If currency parameter is not specified, default currency is BTC
$amount = '0.01'; // Numeric double amount to be send from your account
$address = '1Btcdemowithdrawaladdress'; //The receiver address
$ipn_url = 'Yourdomain.com/handle_withdraw'; // URL where 

$withdraw = $obj->create_withdrawal($currency, $amount, $address, $ipn_url);
```

**You can find more references on our API Documentation (https://anonwallet.readme.io)**
