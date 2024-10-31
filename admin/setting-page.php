<?php
  global $wpdb;
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
  
  $result = $wpdb->get_results("SELECT * FROM `wp_sfdc_setting`");
  foreach ($result as $page) {
      $consumer_key    = $page->consumer_key;
      $consumer_secret = $page->consumer_secret;
      $security_token  = $page->security_token;
      $username        = $page->username;
      $userpass        = $page->userpass;
      $redirect_uri    = $page->redirect_uri;
      $login_uri       = $page->login_uri;
      $id              = $page->id;
  }
  
  if (isset($_POST['update'])) {
      $data = array(
        'consumer_key'     => sanitize_text_field($_POST["consumer_key"]),
        'consumer_secret'  => sanitize_text_field($_POST["consumer_secret"]),
        'security_token'   => sanitize_text_field($_POST["security_token"]),
        'username'         => sanitize_text_field($_POST["username"]),
        'userpass'         => sanitize_text_field($_POST["userpass"]),
        'redirect_uri'     => sanitize_url($_POST["redirect_uri"]),
        'login_uri'        => sanitize_url($_POST["login_uri"])
      );
        
      $consumer_key    = sanitize_text_field($_POST["consumer_key"]);
      $consumer_secret = sanitize_text_field($_POST["consumer_secret"]);
      $security_token  = sanitize_text_field($_POST["security_token"]);
      $username        = sanitize_text_field($_POST["username"]);
      $userpass        = sanitize_text_field($_POST["userpass"]);
      $redirect_uri    = sanitize_text_field($_POST["redirect_uri"]);
      $login_uri       = sanitize_text_field($_POST["login_uri"]);
      $table_name      = $wpdb->prefix . 'sfdc_setting';
      
      if ( $result ) {
          $rowid = $wpdb->update($table_name, $data, array('id' => $id));
      } else {
          $wpdb->insert($table_name, $data, '%s');
          $rowid = $wpdb->insert_id;
          $wpdb->query("CREATE TABLE IF NOT EXISTS `wp_sfdc_setting` (
                  `lead_id` int(11) NOT NULL AUTO_INCREMENT,
                  `first_name` varchar(30) NOT NULL,
                  `last_name` varchar(30) NOT NULL,
                  `email` varchar(50) NOT NULL,
                  `business_name` varchar(50) NOT NULL,
                  `password` varchar(50) NOT NULL,
                  `company_name` varchar(50) NOT NULL,
                  `street` varchar(30) NOT NULL,
                  `city` varchar(30) NOT NULL,
                  `state` varchar(30) NOT NULL,
                  `country` varchar(30) NOT NULL,
                  `postal_code` varchar(10) NOT NULL,
                  `sfdc_id` varchar(50) DEFAULT NULL,
                  PRIMARY KEY (`lead_id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;");
      }
      if ( $rowid > 0 ) {
          ?>
          <script>
              alert('Successfully Updated!');
          </script>
          <?php
      }
  }
?>
<div>
    <h1>Lead Generation Plug-in SFDC Credentials</h1>
    <form id="get_param" action=" <?php esc_url($_SERVER['REQUEST_URI']) ?> " method="post">
        CONSUMER KEY<br><input type="text" name="consumer_key" id="consumer_key"  placeholder="Enter Consumer Key" size="40" value="<?php echo $consumer_key; ?>" height="10"/><br>
        CONSUMER SECRET<br><input type="text" name="consumer_secret" id="consumer_secret" placeholder="Enter Consumer Secret" size="40" value="<?php echo $consumer_secret; ?>" height="10"/><br>
        SECURITY TOKEN<br><input type="text" name="security_token" id="security_token"  placeholder="Enter Security Token" size="40" value="<?php echo $security_token; ?>" height="10"/><br>
        USER NAME<br><input type="text" name="username" id="username"  placeholder="Enter Username" size="40" value="<?php echo $username; ?>" height="10"/><br>
        PASSWORD<br><input type="password" name="userpass" id="userpass"  placeholder="Enter Password" size="40" value="<?php echo $userpass; ?>" height="10"/><br>
        <input type="submit" name="update" id="update" class="button-large" value="Update" />
		<br><input type="hidden" name="redirect_uri" id="redirect_uri" placeholder="Enter Redirect Uri" size="40" value="<?php echo $redirect_uri; ?>" height="10"/><br>
        <br><input type="hidden" name="login_uri" id="login_uri" placeholder="Enter Login Uri" size="40" value="<?php echo $login_uri; ?>" height="10"/><br>
        
    </form>
</div>    