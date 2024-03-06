<?php

if ( class_exists( 'Default_Config' ) ) {
  return;
}

class Default_Config {

  public string $site_url;
  
  // Personal data
  public string $integrator_id;
  public string $extenernal_reference;

  // Payments data
  public int    $default_payments;
  public int    $max_payments;
  public array  $excluded_payments_methods;
  public string $currency_id;
  
  // Payer data
  public string $payer_name;
  public string $payer_surname;
  public string $payer_email;
  public array  $payer_phone;
  public array  $payer_address;
  
  public string $date_created;
  public string $last_purchases;
  public string $identification_type;
  public int    $identification_number;

  public string $user_billing_name;
  
  // Product data
  public string $product_id;
  public string $product_description;
  public string $category_id;
  public bool   $expires;

  // Data for preference
  public string $access_token;
  public string $public_key;

  public string $auto_return;
  public array  $back_urls;
  public string $notification_url;


  public function __construct()
  { // Set defautl values

    // Site
    $this->site_url = ( ( filter_input( INPUT_SERVER, 'HTTPS' ) == 'on' || filter_input( INPUT_SERVER, 'HTTPS' ) ) ?
      'https://' : 'http://' ) . filter_input( INPUT_SERVER, 'HTTP_HOST' );

    //---------------------------------------------------------------------
    // Integrator ID
    $this->integrator_id          = 'dev_24c65fb163bf11ea96500242ac130004';
    $this->extenernal_reference   = 'nicolas@tectel.com.uy';

    //---------------------------------------------------------------------
    // Medios de Pago

    $this->default_payments           = 1;
    $this->max_payments               = 6;
    $this->excluded_payments_methods  = [ 'id' => 'visa' ];
    $this->currency_id                = 'UYU';

    //---------------------------------------------------------------------
    // Informacion del pagador

    $this->payer_name             = 'Lalo';
    $this->payer_surname          = 'Landa';
    $this->payer_email            = 'test_user_17805074@testuser.com';
    $this->payer_phone            = array( 'area_code' => '598', 'number' => '98989898' );
    $this->payer_address          = array( 'street_name' => 'calle falsa', 'street_number' => '123', 'zip_code' => '27000' );

    $this->user_billing_name      = 'Mr Lalo Landa';
    
    //---------------------------------------------------------------------
    // External reference

    $this->extenernal_reference   = 'nicolas@tectel.com.uy';

    //---------------------------------------------------------------------
    // Producto

    $this->product_id             = '1234';
    $this->product_description    = 'Dispositivo móvil de Tienda e-commerce';
    $this->category_id            = 'Cell Phones';
    $this->expires                = false;
    
    //---------------------------------------------------------------------
    // Paginas de retorno (back_url)

    $this->auto_return            = 'approved';

    //---------------------------------------------------------------------
    // Store credentials

    $this->access_token           = 'APP_USR-2815099995655791-092911-c238fdac299eadc66456257445c5457d-1160950667';
    $this->public_key             = 'APP_USR-3fa91575-503e-476a-b21d-4f49cae39fa6';

    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    // Other parameters

    // Payer
    $this->identification_type    = 'CI';
    $this->identification_number  = '12345672';

    $this->date_created           = '2024-03-01T12:00:00Z';
    $this->last_purchases         = '2024-03-01T13:30:00Z';

    // Back URLs
    $this->back_urls  = array(
      'success' => $this->site_url . '/detail.php?status=success',
      'failure' => $this->site_url . '/detail.php?status=failure',
      'pending' => $this->site_url . '/detail.php?status=pending'
    );

    // Notification URL
    $this->notification_url = $this->site_url . '/notify.php';
  }
}