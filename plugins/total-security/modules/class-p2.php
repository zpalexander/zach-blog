<?php
class FDX_CLASS_P2 extends Total_Security {
static $security_tests = array(
'ver_check'                => array(),
'plugins_ver_check'        => array(),
'themes_ver_check'         => array(),
'install_file_check'       => array(),
'upgrade_file_check'       => array(),
'db_password_check'        => array(),
'salt_keys_check'          => array(),
'db_table_prefix_check'    => array(),
'debug_check'              => array(),
'blog_site_url_check'      => array(),
'uploads_browsable'        => array(),
'anyone_can_register'      => array(),
'file_editor'              => array(),
'user_exists'              => array(),
'id1_user_check'           => array(),
'bruteforce_login'         => array(),
'secure_hidden_login'      => array() ); //end

function __construct() {
add_action('wp_ajax_sn_run_tests', array($this, 'run_tests'));

$fail2 = get_site_option( 'fdx_p2_red2' );// p2
$fail3 = get_site_option( 'fdx_p2_red3' );// p2

$fail4 = get_site_option( 'fdx_p2_red4' );
$fail5 = get_site_option( 'fdx_p2_red5' );
$fail6 = get_site_option( 'fdx_p2_red6' );
$fail7 = get_site_option( 'fdx_p2_red7' );
$fail8 = get_site_option( 'fdx_p2_red8' );
$fail9 = get_site_option( 'fdx_p2_red9' );
$fail10 = get_site_option( 'fdx_p2_red10' );
$fail11 = get_site_option( 'fdx_p2_red11' );
$fail12 = get_site_option( 'fdx_p2_red12' );
$fail13 = get_site_option( 'fdx_p2_red13' );
$fail_p2_t = $fail2+$fail3+$fail4+$fail5+$fail6+$fail7+$fail8+$fail9+$fail10+$fail11+$fail12+$fail13;  //12
update_option('fdx_p2_red_total', $fail_p2_t );

$fail15 = get_site_option( 'fdx_p2_yel1' );
$fail16 = get_site_option( 'fdx_p2_yel2' );
$fail17 = get_site_option( 'fdx_p2_yel3' );
$fail18 = get_site_option( 'fdx_p2_yel4' ); // p2
$fail19 = get_site_option( 'fdx_p2_yel5' ); // p2
$fail20 = get_site_option( 'fdx_p2_yel6' ); // new
$fail21 = get_site_option( 'fdx_p2_yel7' ); // p2 new

$fail_p2_t2 = $fail15+$fail16+$fail17+$fail18+$fail19+$fail20+$fail21; //2.5
update_option('fdx_p2_yel_total', $fail_p2_t2 );

}

/*
 * run all tests; via AJAX
 */
function run_tests() {
    $settings = Total_Security::fdx_get_settings();
    @set_time_limit($settings['p2_op1']);  //seconds
    $test_count = 0;
    $test_description = array('last_run' => current_time('timestamp'));
    foreach(self::$security_tests as $test_name => $test){
      if ($test_name[0] == '_') {
        continue;
      }
      $response = self::$test_name();
      if (!isset($response['msg'])) {
        $response['msg'] = '';
      }
      $test_description['test'][$test_name]['status'] = $response['status'];
      $test_description['test'][$test_name]['msg'] = sprintf($response['msg']);
      $test_count++;
    } // foreach
    update_option($this->p2_options_key, $test_description);
    die('1');
  }


/* -------1
 * check WP version
 */
function ver_check() {
   global $wp_version;
   $msgTIT = __('Check if WordPress core is up to date.', $this->hook);
 if (!version_compare(get_bloginfo('version'), $this->min_wp_ver,  '>=')) {
     $return['status'] = '<span class="pb_label pb_label-important">X</span>';
     $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT . '</span></td><td><a href="'.admin_url('update-core.php').'" title="'.__('Fix', $this->hook ).'"><strong>'.__('outdated', $this->hook ).':</strong> <code>v'.$wp_version.'</code></a></td>';
     update_option('fdx_p2_red4', '1' );

     } else {
     $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
     $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
     update_option('fdx_p2_red4', '0' );

}
    return $return;
  }

/* -------2
 * check if plugins are up to date
 */
  function plugins_ver_check() {
   $msgTIT = __('Check if plugins are up to date.', $this->hook);
   $current = get_site_transient('update_plugins');
    if (!is_object($current)) {
      $current = new stdClass;
    }
    set_site_transient('update_plugins', $current);
     $current = get_site_transient('update_plugins');
    if (isset($current->response) && is_array($current->response) ) {
      $plugin_update_cnt = count($current->response);
    } else {
      $plugin_update_cnt = 0;
    }
    if($plugin_update_cnt > 0){
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.admin_url('plugins.php').'" title="'.__('Fix', $this->hook ).'"><strong>'.__('outdated', $this->hook ).':</strong> <code>'. sizeof($current->response) .'</code></a></td>';
      update_option('fdx_p2_red5', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
      update_option('fdx_p2_red5', '0' );
    }
    return $return;
  }

/* -------3
 * check themes versions
 */
  function themes_ver_check() {
   $msgTIT = __('Check if themes are up to date.', $this->hook);
   $current = get_site_transient('update_themes');
   if (!is_object($current)){
      $current = new stdClass;
    }
    set_site_transient('update_themes', $current);
    $current = get_site_transient('update_themes');
    if (isset($current->response) && is_array($current->response)) {
      $theme_update_cnt = count($current->response);
    } else {
      $theme_update_cnt = 0;
    }
    if($theme_update_cnt > 0){
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.admin_url('themes.php').'" title="'.__('Fix', $this->hook ).'"><strong>'.__('outdated', $this->hook ).':</strong> <code>'. sizeof($current->response) .'</code></a></td>';
      update_option('fdx_p2_red6', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
       update_option('fdx_p2_red6', '0' );
    }
    return $return;
  }

/* -------4
 * does WP install.php file exist?
 */
  function install_file_check() {
   $msgTIT = sprintf( __('Check if %s file is accessible via HTTP on the default location.' , $this->hook) , '<code>install.php</code>' );
   $url2 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'install_file_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $url = get_bloginfo('wpurl') . '/wp-admin/install.php?rnd=' . rand();
   $response = wp_remote_get($url);
    if(is_wp_error($response)) {
      $return['status'] = '<span class="pb_label pb_label-desat">&Oslash;</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><code>-----</code></td>';
    } elseif ($response['response']['code'] == 200) {
      $return['status'] = '<span class="pb_label pb_label-info">&#10003;</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url2.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a></td>';
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
    }
    return $return;
  }

/* -------5
 * does WP upgrade.php file exist?
 */
  function upgrade_file_check() {
   $msgTIT = sprintf( __('Check if %s file is accessible via HTTP on the default location.' , $this->hook) , '<code>upgrade.php</code>' );
   $url2 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'upgrade_file_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $url = get_bloginfo('wpurl') . '/wp-admin/upgrade.php?rnd=' . rand();
   $response = wp_remote_get($url);
    if(is_wp_error($response)) {
      $return['status'] = '<span class="pb_label pb_label-desat">&Oslash;</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><code>-----</code></td>';
    } elseif ($response['response']['code'] == 200) {
      $return['status'] = '<span class="pb_label pb_label-info">&#10003;</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url2.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a></td>';
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
    }
    return $return;
  }

/* -------6
 * check database password
 */
  function db_password_check() {
   $msgTIT = __('Test the strength of WordPress database password.', $this->hook);
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'db_password_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $password = DB_PASSWORD;
    if (empty($password)) {
      $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT  . '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Weak Password', $this->hook).'</strong></a>&nbsp;<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="' . __('password is empty', $this->hook) . '"></a></span></td>';
      update_option('fdx_p2_yel1', '1' );
    } elseif (strlen($password) < 8) {
      $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT  . '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Weak Password', $this->hook).'</strong></a>&nbsp;<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="' . __('password length is only', $this->hook).' \''. strlen($password) .'\' '. __('chars', $this->hook) . '"></a></span></td>';
     update_option('fdx_p2_yel1', '1' );
    } elseif (sizeof(count_chars($password, 1)) < 6) {
      $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT  . '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Weak Password', $this->hook).'</strong></a>&nbsp;<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="' . __('password is too simple', $this->hook) . '"></a></span></td>';
       update_option('fdx_p2_yel1', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
      update_option('fdx_p2_yel1', '0' );
    }
    return $return;
  }

/* -------7
 * unique config keys check
 */
  function salt_keys_check() {
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'salt_keys_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Check if security keys and salts have proper values.', $this->hook);
   $ok = true;
   $keys = array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
                  'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT');
    foreach ($keys as $key) {
      $constant = @constant($key);
      if (empty($constant) || trim($constant) == 'put your unique phrase here' || strlen($constant) < 50) {
        $bad_keys[] = $key;
        $ok = false;
      }
    } // foreach
    if ($ok == true) {
       $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
       $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
       update_option('fdx_p2_red7', '0' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT. '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Bad keys', $this->hook).'</strong></a>&nbsp;<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="' . implode(' ,', $bad_keys). '"></a></span></td>';
      update_option('fdx_p2_red7', '1' );
    }
    return $return;
  }

/* -------8
 * check DB table prefix
 */
  function db_table_prefix_check() {
    global $wpdb;
    $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'db_table_prefix_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
    $msgTIT = __('Check if table prefix is the default one <em>"wp_"</em>.', $this->hook);
    if ($wpdb->prefix == 'wp_' || $wpdb->prefix == 'wordpress_' || $wpdb->prefix == 'wp3_') {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a></td>';
      update_option('fdx_p2_red8', '1' );
   } else {
       $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
       $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
       update_option('fdx_p2_red8', '0' );
    }
    return $return;
  }

/* -------9
 * check if global WP debugging is enabled
 */
  function debug_check() {
  $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'debug_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Check if general debug mode is enabled.', $this->hook);
    if (defined('WP_DEBUG') && WP_DEBUG) {
     $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
     $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Enabled', $this->hook).'</strong></a></td>';
     update_option('fdx_p2_yel2', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
     update_option('fdx_p2_yel2', '0' );
    }
    return $return;
  }

/* -------10
 * compare WP Blog Url with WP Site Url
 */
  function blog_site_url_check() {
   $msgTIT = __('Check if WordPress installation address is the same as the site address.', $this->hook);
     $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'blog_site_url_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
    $siteurl = get_bloginfo('url');
    $wpurl = get_bloginfo('wpurl');
    if ($siteurl == $wpurl) {
       $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
       $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a></td>';
    update_option('fdx_p2_yel3', '1' );
    } else {
       $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
       $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
    update_option('fdx_p2_yel3', '0' );
    }
    return $return;
  }

/* -------11
 * uploads_browsable
 */
 function uploads_browsable() {
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'uploads_browsable' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Check if <em>uploads</em> folder is browsable by browsers.', $this->hook);
   $upload_dir = wp_upload_dir();
   $args = array('method' => 'GET', 'timeout' => 5, 'redirection' => 0,
                  'httpversion' => 1.0, 'blocking' => true, 'headers' => array(), 'body' => null, 'cookies' => array());
    $response = wp_remote_get(rtrim($upload_dir['baseurl'], '/') . '/?nocache=' . rand(), $args);
    if (is_wp_error($response)) {
       $return['status'] = '<span class="pb_label pb_label-desat">&Oslash;</span>';
       $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions" style="text-decoration: line-through">' .$msgTIT  . '</span></td><td><code>-----</code></td>';
    } elseif ($response['response']['code'] == '200' && stripos($response['body'], 'index') !== false) {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT  . '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></td>';
      update_option('fdx_p2_red9', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
       update_option('fdx_p2_red9', '0' );
    }
    return $return;
  }

/* -------12
 * check if anyone can register on the site
 */
   function anyone_can_register() {
   $msgTIT = __('Check if <em>"anyone can register"</em> option is enabled.', $this->hook);
   $test = get_option('users_can_register');
   if ($test) {
       $return['status'] = '<span class="pb_label pb_label-info">&#10003;</span>';
       $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.admin_url('options-general.php').'" title="'.__('Fix', $this->hook ).'"><strong>'.__('Enabled', $this->hook).'</strong></a></td>';
     } else {
        $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
        $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
     }
     return $return;
   }

/* -------13
 * is theme/plugin editor disabled?
 */
   function file_editor() {
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'file_editor' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Check if plugins/themes file editor is enabled.', $this->hook);
    if (defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT) {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
      update_option('fdx_p2_red10', '0' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Enabled', $this->hook).'</strong></a></td>';
      update_option('fdx_p2_red10', '1' );
    }
    return $return;
   }

/* -------14
 * check if "admin" exists
 */
  function user_exists($username = 'admin') {
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'user_exists' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Check if user with username <em>"admin"</em> exists.', $this->hook);
    // Define the function
    if (username_exists($username) ) {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a></td>';
      update_option('fdx_p2_red11', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
     $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
     update_option('fdx_p2_red11', '0' );
    }
    return $return;
  }

/* -------15
 * check if user with DB ID 1 exists
 */
   function id1_user_check() {
   $url = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'id1_user_check' ), menu_page_url( $this->hook . '-'.$this->_p2, false ) );
   $msgTIT = __('Test if user with <em> "ID=1" </em> is administrator.', $this->hook);
   $check = get_userdata(1);
     if ($check) {
       if( user_can( 1, 'activate_plugins' ) ) {
       // id 1 is adm
       $return['status'] = '<span class="pb_label pb_label-important">X</span>';
       $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT  . '</span></td><td><a href="'.$url.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Yes', $this->hook).'</strong></a>';
       update_option('fdx_p2_red12', '1' );
  }
else {
       //id 1 no adm
       $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
       $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
       update_option('fdx_p2_red12', '0' );
}
    } else {
      // id 1 no exist
       $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
       $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</td><td>&nbsp;</td>';
       update_option('fdx_p2_red12', '0' );
 }
    return $return;
   }



/* -------16
 * bruteforce user login
 */
//-1
 Public static function try_login($username, $password) {
    $user = apply_filters('authenticate', null, $username, $password);
    if (isset($user->ID) && !empty($user->ID)) {
      return true;
    } else {
      return false;
    }
  }
//-2
function bruteforce_login() {
   $msgTIT = sprintf( __('Check admin password strength with a <em>%s</em> most commonly used' , $this->hook) , '1050' );
   $passwords = file(plugins_url( 'libs/brute-force-dictionary.txt', dirname(__FILE__)), FILE_IGNORE_NEW_LINES);
   $bad_usernames = array();
    $users = get_users(array('role' => 'administrator'));
    foreach ($users as $user) {
      foreach ($passwords as $password) {
        if (self::try_login($user->user_login, $password)) {
          $bad_usernames[] = $user->user_login;
          break;
        }
      }
    }
    if (empty($bad_usernames)){
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>&nbsp;</td>';
      update_option('fdx_p2_red13', '0' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-important">X</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT . '</span></td><td><a href="'. admin_url('profile.php'). '" title="'.__('Fix', $this->hook ).'"><strong>'.__('Weak Password', $this->hook).'</strong></a>&nbsp; <span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.__('Following users have extremely weak passwords: ', $this->hook).implode(' ,', $bad_usernames).'"></a></span></td>';
      update_option('fdx_p2_red13', '1' );
    }
    return $return;
  }
//------------------------------------------------------------------------

/* -------17
 *
 */
  function secure_hidden_login() {
  $settings = Total_Security::fdx_get_settings();

   $msgTIT = __('Check if', $this->hook).' <em>"'. __('Secure Hidden Login', $this->hook).'"</em> &nbsp;'.__('is enabled', $this->hook);
    // Define the function
    if ( !$settings['p6_check_1'] ) {
      $return['status'] = '<span class="pb_label pb_label-warning">!</span>';
      $return['msg'] = '<tr class="alternate"><td><span class="fdx-actions">'.$msgTIT .'</span></td><td><a href="'. admin_url('admin.php?page='.$this->hook . '-'.$this->_p6). '" title="'.__('Fix', $this->hook ).'"><strong>'. __('Disabled', $this->hook) .'</strong></a></td>';
      update_option('fdx_p2_yel6', '1' );
    } else {
      $return['status'] = '<span class="pb_label pb_label-success">&#10003;</span>';
      $return['msg'] = '<tr><td><span class="fdx-actions">'.$msgTIT .'</span></td><td>'. __('Enabled', $this->hook) .'</td>';
      update_option('fdx_p2_yel6', '0' );
    }
    return $return;
  }



} // class fdx_tests
?>