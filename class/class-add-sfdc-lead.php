<?php
 
  class Add_SFDC_Lead {
  
  
  /**
  * URL
  *
  * @access public
  * @param str $consumer_key SFDC ORG Consumer Key
  * @param str $consumer_secret SFDC ORG Consumer Secret
  * @param str $username SFDC ORG Username 
  * @param str $userpass SFDC ORG Password
  * @param str $security_tocken SFDC ORG Security Tocken     
  * @return array $response Response from SFDC web service conatinging Access Tocken and status info
  * @author Anil
  **/
      public function get_access_tocken( $consumer_key, $consumer_secret, $username, $userpass, $security_tocken ) {  
      $ch = curl_init();  
      // set URL options
      curl_setopt( $ch, CURLOPT_POST, 1 );
      curl_setopt( $ch, CURLOPT_URL, 'https://login.salesforce.com/services/oauth2/token?grant_type=password&client_id=' . $consumer_key . '&client_secret=' . $consumer_secret . '&username=' . $username . '&password=' . $userpass . $security_tocken );
      curl_setopt( $ch, CURLOPT_HEADER, 0 );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      
      // grab HTML
      $data = curl_exec( $ch );
      $response = json_decode( $data, true );   
      curl_error( $ch );
      $access_token = $response['access_token'];
      $instance_url = $response['instance_url'];
      
      if ( !isset( $access_token ) || $access_token == '' ) {
        die('Error - access token missing from response!');
      }
      
      if ( ! isset( $instance_url) || $instance_url == "" ) {
        die("Error - instance URL missing from response!");
      }
      
      return $response;
    }
   
  /**
  * URL
  *
  * @access public
  * @param array $field_arr  field mapping with Lead In SFDC ORG
  * @return str $id SFDC ORG Lead Id
  * @author Anil
  **/ 
   public function create_lead( $field_arr, $instance_url, $access_token ) {  
      $url = "$instance_url/services/data/v20.0/sobjects/Lead/";
      $content = json_encode( $field_arr );
      
      $curl = curl_init( $url );
      curl_setopt( $curl, CURLOPT_HEADER, false );
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $curl, CURLOPT_HTTPHEADER, 
                  array( 
                    "Authorization: OAuth $access_token",
                    "Content-type: application/json" 
                  )
      );
      curl_setopt( $curl, CURLOPT_POST, true );
      curl_setopt( $curl, CURLOPT_POSTFIELDS, $content );  
      $json_response = curl_exec( $curl );  
      $status = curl_getinfo( $curl, CURLINFO_HTTP_CODE );  
      if ($status != 201) {
        die( "Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno( $curl ) );
      }  
      echo "HTTP status $status creating Lead<br/>";
      curl_close( $curl );
      $response = json_decode( $json_response, true );
      $id = $response['id'];
      return $id;
    }
  }
?>