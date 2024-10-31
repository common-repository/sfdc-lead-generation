<?php

    global $wpdb;
    // Getting SFDC congiguration setting from db
    $result = $wpdb->get_results("SELECT * FROM `wp_sfdc_setting`");
    $consumer_key     = "";
  	$consumer_secret  = "";
  	$security_token   = "";
  	$username         = "";
  	$userpass         = "";
  	$redirect_uri     = "";
  	$login_uri        = "";
  	$id               = "";
    foreach ($result as $page ) {
      $consumer_key     = $page->consumer_key;
      $consumer_secret  = $page->consumer_secret;
      $security_token   = $page->security_token;
      $username         = $page->username;
      $userpass         = $page->userpass;
      $redirect_uri     = $page->redirect_uri;
      $login_uri        = $page->login_uri;
      $id               = $page->id;
    }
    // Setting SFDC congiguration constants
    define( 'CONSUMER_KEY', $consumer_key );
    define( 'CONSUMER_SECRET', $consumer_secret );
    define( 'SECURITY_TOKEN', $security_token );
    define( 'USERNAME', $username );
    define( 'USERPASS', $userpass );
    define( 'REDIRECT_URI', $redirect_uri );
    define( 'LOGIN_URI', $login_uri );

    //Plugin version constant
    define( 'SFDC_PLUGIN_VERSION', '1.0.0' );
    define( 'SFDC_PLUGIN__MINIMUM_WP_VERSION', '3.1' );

    //Plugin directory path constant
    define( 'SFDC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    define( 'SFDC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

?>