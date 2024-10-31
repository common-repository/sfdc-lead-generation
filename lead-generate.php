<?php
  /*
    Plugin Name: SFDC Lead Generation
    Plugin URI: http://ksolves.com/plugins.php
    Description: This plugin extends the wordpress registration form by adding up fields and registers the user as a lead on Salesforce platform (Salesforce CRM).
    Author: Ksolves
    Version: 1.0.0
    Author URI: http://ksolves.com
  */
  session_start();
  
  // Defing plugin folder path and url constants
  define( 'SFDC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
  define( 'SFDC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );  
   
  // including config file containg SFDC ORG Details 
  include_once ( SFDC_PLUGIN_DIR.'include/config.php' );
  
  // Make sure we don't expose any info if called directly
  if (!function_exists('add_action')) {                                  
      echo 'Plugin cannot access directly.';
      exit;
  }
  
  /**
   * 
   * Handle user redirection after login 
   *    
   * @param str $url url to set on which user will redircted after login
   * @param str $user this contain user type info 
   * @return str $url url on which user will redircted after login
   * @author Ksolves
   * */
  function my_login_redirect($url, $request, $user) {
  
      if ($user && is_object($user) && is_a($user, 'WP_User')) {
  
          if ($user->has_cap('administrator')) { //checking for Admin login
              //settign url to redirect admin to dashboard
              $url = admin_url();
          } else {    // Member login
              //settign url to redirect member to front end
              $url = home_url();
          }
      }
      return $url;
  }
  
  /**
   * 
   * Adding extra fields to registraton form 
   *    
   * @param none 
   * @return false
   * @author Ksolves
   * */
  function add_registration_fields() {
      ?>  
      <p>
          <label for="user_extra"><?php _e('FirstName', 'myplugin_textdomain') ?><br />
              <input type="text" name="first_name" id="first_name" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['first_name'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('LastName', 'myplugin_textdomain') ?><br />
              <input type="text" name="last_name" id="last_name" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['last_name'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('PhoneNo', 'myplugin_textdomain') ?><br />
              <input type="text" name="phone_no" id="phone_no" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['phone_no'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('BusinessName', 'myplugin_textdomain') ?><br />
              <input type="text" name="business_name" id="business_name" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['business_name'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('Street', 'myplugin_textdomain') ?><br />
              <input type="text" name="street" id="street" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['street'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('City', 'myplugin_textdomain') ?><br />
              <input type="text" name="city" id="city" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['city'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('State', 'myplugin_textdomain') ?><br />
              <input type="text" name="state" id="state" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['state'];
      } ?>" size="25" /></label>
      </p>
      <p>
          <label for="user_extra"><?php _e('Country', 'myplugin_textdomain') ?><br />
              <input type="text" name="country" id="country" class="input" value="<?php if (isset($_POST)) {
          echo $_POST['country'];
      } ?>" size="25" /></label>
      </p>
      <p>
         
          <script> 
            ( function( $ ) {            
                    $("#phone_no").mask("(999)999-9999");	
            } )( jQuery );
            
            function refreshCaptcha() {
                var img = document.images['captchaimg'];
                img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
            }
          </script>
          
      <?php if (isset($msg)) { ?>            
              <label colspan="2" align="center" valign="top"><?php echo $msg; ?></label>            
      <?php } ?>
          <img src="<?php echo SFDC_PLUGIN_URL ?>captcha/createcaptcha.php?rand=<?php echo rand(); ?>" id='captchaimg'><br>
          <label for='message'>Enter the code above here :</label>
          <br>
          <input id="captcha_code" name="captcha_code" type="text">
          <br>
          Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
      </p> 
      <?php
  }
  
  /**
   * 
   * Adding validation to added the extra fields
   *
   * @param @object $errors object of the class WP_Error
   * @param $sanitized_user_login Sanitized user login 
   * @param $user_email user email
   * @return $errors
   * @author Sudhanshu Kumar
   **/
  function myplugin_check_fields($errors, $sanitized_user_login, $user_email) {
  
      $business_name = $_POST['business_name'];
      $city = $_POST['city'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $phone_no = $_POST['phone_no'];
  
      // Validating firstname against blank value
      if (trim($first_name) == "") {
          // Adding error message for blank first name
          $errors->add('Blank Business Name', __('<strong>ERROR</strong>: Please enter first name.', 'mydomain'));
      }
      // Validating lastname against blank value
      if (trim($last_name) == "") {
          // Adding error message for blank last name
          $errors->add('Blank City', __('<strong>ERROR</strong>: Please enter last name.', 'mydomain'));
      }
      // Validating lastname against blank value
      if (trim($phone_no) == "") {
          // Adding error message for blank last name
          $errors->add('Blank City', __('<strong>ERROR</strong>: Please enter correct phone number.', 'mydomain'));
      }
      // Validating business name against blank value
      if (trim($business_name) == "") {
          // Adding error message for blank business name
          $errors->add('Blank Business Name', __('<strong>ERROR</strong>: Please enter business name.', 'mydomain'));
      }
      // Validating city against blank value
      if (trim($city) == "") {
          // Adding error message for blank city name
          $errors->add('Blank City', __('<strong>ERROR</strong>: Please enter city.', 'mydomain'));
      }
      if (empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0) {
          $errors->add('Blank City', __('<strong>ERROR</strong>: The Validation code does not match!.', 'mydomain'));
      }
      return $errors;
  }
  
  /**
   * 
   * Saving user extra fiels data in database and call function to create lead in SFDC ORG
   *   
   * @param $user_id user id created in wordpress db     
   * @return $id Lead Id from SFDC ORG
   * @author Ksolves
   * */
  function registration_save($user_id) {
  
      // Checking for first name set in $_POST array
      if (isset($_POST['first_name'])) {
  
          // Saving first name in user meta data 
          update_user_meta($user_id, 'first_name', $_POST['first_name']);
  
          // Getting  first name from $_POST array
          $first_name = $_POST['first_name'];
      }
  
      // Checking for last name set in $_POST array
      if (isset($_POST['last_name'])) {
  
          // Saving last name in user meta data
          update_user_meta($user_id, 'last_name', $_POST['last_name']);
  
          // Getting  last name from $_POST array
          $last_name = $_POST['last_name'];
      }
      if (isset($_POST['phone_no'])) {
          update_user_meta($user_id, 'phone_no', $_POST['phone_no']);
          $phone_no = $_POST['phone_no'];
      }
  
      // Checking for business name set in $_POST array
      if (isset($_POST['business_name'])) {
  
          // Saving business name in user meta data
          update_user_meta($user_id, 'business_name', $_POST['business_name']);
  
          // Getting  business name from $_POST array
          $business_name = $_POST['business_name'];
      }
  
      // Checking for user email set in $_POST array
      if (isset($_POST['user_email'])) {
  
          // Getting  user email from $_POST array
          $user_email = $_POST['user_email'];
      }
  
      // Checking for street set in $_POST array
      if (isset($_POST['street'])) {
  
          // Saving street name in user meta data
          update_user_meta($user_id, 'street', $_POST['street']);
  
          // Getting  street from $_POST array
          $street = $_POST['street'];
      }
  
      // Checking for city set in $_POST array
      if (isset($_POST['city'])) {
  
          // Saving city name in user meta data
          update_user_meta($user_id, 'city', $_POST['city']);
  
          // Getting  city from $_POST array
          $city = $_POST['city'];
      }
  
      // Checking for state set in $_POST array
      if (isset($_POST['state'])) {
  
          // Saving state name in user meta data
          update_user_meta($user_id, 'state', $_POST['state']);
  
          // Getting state from $_POST array
          $state = $_POST['state'];
      }
  
      // Checking for country set in $_POST array
      if (isset($_POST['country'])) {
  
          // Saving country name in user meta data
          update_user_meta($user_id, 'country', $_POST['country']);
  
          // Getting country from $_POST array
          $country = $_POST['country'];
      }
  
      // Call to function to add user details to the SFDC ORG as Lead
      $id = add_lead_to_sfdc($first_name, $last_name, $phone_no, $email, $business_name, $street, $city, $state, $country);
  }
  
  //Adding login_redirect filter to the my_login_redirect function
  add_filter('login_redirect', 'my_login_redirect', 10, 3);
  
  //Adding register_form hook to the add_registration_fields function
  add_action('register_form', 'add_registration_fields');
  
  //Adding registration_errors filter to the myplugin_check_fields function
  add_filter('registration_errors', 'myplugin_check_fields', 10, 3);
  
  //Adding user_register hook to the registration_save function
  add_action('user_register', 'registration_save');
  
  //Adding admin_menu hook to the set_param function
  add_action('admin_menu', 'set_param');
  
  /**
   * 
   * To add setting option page
   *    
   * @param none  
   * @return false
   * @author Ksolves
   * */
  function set_param() {
      //Add options page for setting of this plugin, this page will visible on admin section 
      add_options_page('SFDC Lead Generate', 'SFDC Lead Generate', 'manage_options', __FILE__, 'fun_get_param');
  }
  
  /**
   * 
   * Adding a form to get credentials from admin
   *    
   * @param none  
   * @return false
   * @author Ksolves
   * */
  function fun_get_param() {
      //include setting form
      include_once 'admin/setting-page.php';
  }
  
  //Create welcome page on activation
  /* Runs when plugin is activated */
  register_activation_hook(__FILE__, 'my_plugin_install');
  
  //Trash welcome page on deactivation
  /* Runs on plugin deactivation */
  register_uninstall_hook(__FILE__, 'my_plugin_uninstall');
  
  /**
   * 
   * To create a setting table when a plugin activated
   *
   * @param null     
   * @return false
   * @author Ksolves
   * */
  function my_plugin_install() {
      global $wpdb;
      //Create a setting table 
      $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_sfdc_setting` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `consumer_key` varchar(100) NOT NULL,
                        `consumer_secret` varchar(100) NOT NULL,
                        `security_token` varchar(100) NOT NULL,
                        `username` varchar(100) NOT NULL,
                        `userpass` varchar(100) NOT NULL,
                        `redirect_uri` varchar(100) NOT NULL,
                        `login_uri` varchar(100) NOT NULL,
                        PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
  }
  
  /**
   * 
   * Drop table when uninstall
   *   
   * @param null     
   * @return false
   * @author Ksolves
   * */
  function my_plugin_uninstall() {
      //Drop table for setting
      global $wpdb;
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}_sfdc_setting");
  }
  /**
   * 
   * Add settings link to plugins list
   *   
   * @param links url of setting page     
   * @return links
   * @author Ksolves
   * */
  function add_SFDC_settings_link( $links ) {
    	array_unshift( $links, '<a href="options-general.php?page=sfdc-lead-generation/lead-generate.php">Settings</a>' );
    	return $links;
  }
  $plugin = plugin_basename( __FILE__ );
  add_filter( 'plugin_action_links_'.$plugin, 'add_SFDC_settings_link' );
  
  
  
  
  /**
   * 
   * Create object of Add_SFDC_Lead class and call fucntions to get access tocken and create lead in SFDC ORG   
   *   
   * @param str $first_name user first name
   * @param str $last_name user last name
   * @param str $email user email
   * @param str $company user company
   * @param str $street user street
   * @param str $city user city
   * @param str $state user state
   * @param str $country  user country       
   * @return str $id SFDG ORG Lead Id
   * @author Ksolves
   * */
  function add_lead_to_sfdc($first_name, $last_name, $phone_no, $email, $company, $street, $city, $state, $country) { 
    
      // Including class Add_SFDC_Lead file  
      include_once( SFDC_PLUGIN_DIR.'class/class-add-sfdc-lead.php' );
  
      // Creating class Add_SFDC_Lead object
      $obj_add_lead = new Add_SFDC_Lead();
  
      // Checking for alraedy exit access tocken and instance url  
      if (isset($_SESSION['access_token']) || isset($_SESSION['instance_url'])) {
  
          // Setting access tocken and instance url in session to avoid multiple authentication request
          $access_token = $_SESSION['access_token'];
          $instance_url = $_SESSION['instance_url'];
      } else {
  
          try {
  
              // Calling function to get access tocken and instance url
              $response = $obj_add_lead->get_access_tocken(CONSUMER_KEY, CONSUMER_SECRET, USERNAME, USERPASS, SECURITY_TOKEN);
  
              // Getting  access token and instance url fron $response array
              $access_token = $response['access_token'];
              $instance_url = $response['instance_url'];
  
              // Setting access tocken and instance url in session to avoid multiple authentication request
              $_SESSION['access_token'] = $access_token;
              $_SESSION['instance_url'] = $instance_url;
          } catch (Exception $e) {
  
              echo "Exception : {$e->getMessage()}\n ";
          }
      }
  
      // Creating field array of user details 
      $field_arr = array(
        'FirstName' => $first_name,
        'LastName'  => $last_name,
        'Phone'     => $phone_no,
        'Email'     => $email,
        'Company'   => $company, 
        'Street'    => $street, 
        'City'      => $street, 
        'State'     => $state, 
        'Country'   => $country
      );
  
      try {
  
          // Calling function to create lead 
          $id = $obj_add_lead->create_lead($field_arr, $instance_url, $access_token);
      } catch (Exception $e) {
  
          echo "Exception : {$e->getMessage()}\n";
      }
      return $id;
  }
  
  /**
   * 
   * Enqueue js and css scripts
   *   
   * @param none     
   * @return false
   * @author Ksolves
   * */
    
  function add_scripts(){
    
    // enqueue jquery mask library
    wp_enqueue_script(
      'mask_jquery',
      SFDC_PLUGIN_URL . 'js/jquery.mask.min.js',
      array( 'jquery' ) ,
      '1.7.7'
    );
    
    // enqueue captcha style css file
    wp_enqueue_style( 'captcha-style', SFDC_PLUGIN_URL.'captcha/css/style.css' ); 
     
  }
  
  // Adding login_enqueue_scripts hook to add_script funtion
  add_action('login_enqueue_scripts','add_scripts');
?>