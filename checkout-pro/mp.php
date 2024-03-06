<?php
// Debug options
error_reporting(E_ALL);
ini_set("display_errors", 1);

// require MP CheckoutPro SDK
require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference\Payer;
use MercadoPago\Resources\Preference\Item;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

require_once 'checkout-pro/class-default-config.php';


$conf = new Default_Config();

//---------------------------------------------------------------------
// MP Checkout Pro preference

MercadoPagoConfig::setAccessToken ( $conf->access_token );
MercadoPagoConfig::setIntegratorId( $conf->integrator_id );
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);


// POST information
$url_img  = $conf->site_url . trim(filter_input(INPUT_POST, 'img'), '.');
$title    = filter_input(INPUT_POST, 'title');
$price    = floatval( filter_input(INPUT_POST, 'price') );
$quantity = intval( filter_input(INPUT_POST, 'unit') );


//---------------------------------------------------------------------
// MP Payer

$payer          = new Payer();
$payer->name    = $conf->payer_name;
$payer->surname = $conf->payer_surname;
$payer->email   = $conf->payer_email;
$payer->phone   = $conf->payer_phone;
$payer->address = $conf->payer_address;


//---------------------------------------------------------------------
// Optional

$payer->identification = array(
  'type'    => $conf->identification_type,
  'number'  => $conf->identification_number
);

$payer->date_created  = $conf->date_created;
$payer->last_purchase = $conf->last_purchases;

//---------------------------------------------------------------------
// MP Item

$item               = new Item();
$item->id           = $conf->product_id;
$item->title        = $title;
$item->description  = $conf->product_description;
$item->quantity     = $quantity;
$item->currency_id  = $conf->currency_id;
$item->unit_price   = $price;
$item->picture_url  = $url_img;

$items              = array( $item );

//---------------------------------------------------------------------
// Create Preference

$paymentMethods = array(
  "excluded_payment_methods"  => array ( $conf->excluded_payments_methods ),
  "installments"              => $conf->max_payments,
  "default_installments"      => $conf->default_payments
);

$request = array(
  "items"                 => $items,
  "payer"                 => $payer,
  "payment_methods"       => $paymentMethods,
  "back_urls"             => $conf->back_urls,
  "notification_url"      => $conf->notification_url,
  "statement_descriptor"  => $conf->user_billing_name,
  "external_reference"    => $conf->extenernal_reference,
  "expires"               => $conf->expires,
  "auto_return"           => $conf->auto_return,
);

//--- MP Checkout Pro client object
$client = new PreferenceClient();

try
{ // Create MP Checkout Pro preference.
  $preference = $client->create($request);

  // save init_point to use in button.
  $_POST['init_point']    = $preference->init_point;

} catch (MPApiException $error)
{ // Cath errors and log.
  error_log( $error->getMessage() );
  error_log( print_r( $error->getApiResponse(), true ) );
}

return;