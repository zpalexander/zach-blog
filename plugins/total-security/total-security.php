<?php
/*
 * Plugin Name: Total Security
 * Plugin URI: http://fabrix.net/total-security/
 * Description: Checks your WordPress installation and provides detailed reporting on discovered vulnerabilities, anything suspicious and how to fix them.
 * Version: 3.2.1
 * Author: Fabrix DoRoMo
 * Author URI: http://fabrix.net
 * License: GPL2+
 * Text Domain: total-security
 * Domain Path: /lang
 * Copyright 2014 - fabrix.net
 */

class Total_Security {
        public $min_wp_ver 	        = '3.9'; //
  		public $pluginversion 	    = '3.2.1';

        public $php_lastver 	    = '5.5.11'; // PHP - http://php.net/downloads.php
        public $mySQL_lastver 	    = '5.6.17'; // MYSQL - http://dev.mysql.com/downloads/

        public $pluginname			= 'Total Security';
        public $hook 				= 'total-security';
        public $_p2 	            = 'vulnerability_scan';
        public $_p3 	            = 'unsafe_files_search';
        public $_p4 	            = 'error-404-log';
        public $_p5 	            = 'core_exploit_scanner';    // $this->hook . '-'.$this->_p5
        public $_p6 	            = 'settings';
        public $_p7 	            = 'php-log';
        public $accesslvl			= 'manage_options';
        public $p2_options_key   	= 'p2_log_time';
        public $p5_options_key   	= 'p5_log_time';
        public $p5_salt         	= 'p5_hash';
        public $p5_snippet         	= 'neon';                     // http://steamdev.com/snippet/
        public $p6_slug         	= 'login_key';                // /wp-login.php?login_key=1234
        public $fdx_defaults        = array(
                 'p2_op1'             => '300',
                 'p3_op1'             => '1000',
                 'p4_check_1'         => 0,
                 'p4_check_2'         => 0,
                 'p4_check_3'         => 0,
                 'p6_check_1'         => 0,
                 'p6_key'             => '1234',
                 'p6_url'             => '',
                 'p7_check_1'         => 0
                  );
        //----------------------------------------------
        public $option_urllog       = 'http://www.senderbase.org/lookup/?search_string=';  //http://whois.domaintools.com/
        //----------------------------------------------
        public $sbar_homepage       = 'http://wordpress.org/extend/plugins/total-security/';
        public $sbar_glotpress      = 'http://translate.fabrix.net/projects/total-security';
        public $sbar_rss            = 'http://feeds.feedburner.com/fdxplugins/';

	function __construct() {
	    $settings = $this->fdx_get_settings();
	    load_plugin_textdomain( $this->hook, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' ); // Load plugin text domain
    	add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );  // Register admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );// Register admin scripts
        add_action( 'admin_menu', array( $this, 'action_menu_pages' ) ); // Registers all WordPress admin menu items
      //-------------P3
        add_action( 'wp_ajax_fdx-scanner_file_scan', array( $this, 'fdx_ajax_file_scan' ));
        add_action( 'wp_ajax_fdx-run_end', array( $this, 'fdx_run_end' ));

      //-------------P5
        add_action('wp_ajax_sn_core_get_file_source', array($this, 'get_file_source'));
        add_action('wp_ajax_sn_core_run_scan', array($this, 'scan_files'));

      //--------------ALL
       register_activation_hook( __FILE__, array( $this, 'fdx_activate' ) );
       register_deactivation_hook( __FILE__, array( $this, 'fdx_deactivate' ) );

        require_once( 'modules/class-process.php' );
        new FDX_Process();

      //-------------P6

      if ( $settings['p6_check_1'] ) {
        add_action('init', array( $this, 'init' ), 1);
        add_action('site_url', array( $this, 'add_login_key_to_action_from' ), 101, 4 );
        add_filter('login_url', array( $this,'add_key_login_to_url'), 101, 2);
        add_filter('lostpassword_url', array( $this,'add_key_login_to_url'), 101, 2);
        add_filter('register', array( $this,'add_key_login_to_url'), 101, 2);
        add_filter('logout_url', array( $this,'fdx_logout_home'), 101, 2 );
      }

     //-------------P2
        require_once( 'modules/class-p2.php' );
        new FDX_CLASS_P2();

     //-------------P3
        require_once( 'modules/class-p3.php' );
        new FDX_CLASS_P3();

     //-------------P4
        global $fdx_lg;
        require_once( 'modules/class-p4.php' );
        $fdx_lg = new FDX_CLASS_P4();

     //-------------P7
        if ( $settings['p7_check_1'] ) {
        require_once( 'modules/class-p7.php' );
        new FDX_CLASS_P7();
        }

}

/*
|--------------------------------------------------------------------------
| [ALL] - Registers And Enqueues Admin-Specific Styles
|--------------------------------------------------------------------------
*/
public function register_admin_styles() {
             if ( isset( $_GET['page'] ) && strpos( $_GET['page'], $this->hook ) !== false ) {
             wp_enqueue_style('wp-jquery-ui-dialog');
             wp_enqueue_style('fdx-core', plugins_url( 'css/admin.css',__FILE__ ), array(), $this->pluginversion );
             wp_enqueue_style('fdx-snippet', plugins_url( 'css/snippet.min.css',__FILE__ ), array(), $this->pluginversion );
    }
}

/*
|--------------------------------------------------------------------------
| [ALL] - Registers and enqueues admin-specific JavaScript.
|--------------------------------------------------------------------------
*/
public function register_admin_scripts() {
              if ( isset( $_GET['page'] ) && strpos( $_GET['page'], $this->hook ) !== false ) {
              wp_enqueue_script('jquery-ui-dialog');
              wp_enqueue_script('dashboard');
              wp_enqueue_script('postbox');
              wp_enqueue_script( 'admin-core', plugins_url( 'js/admin.js',__FILE__), array(), $this->pluginversion);
              #[P2|P3|P5]
              wp_enqueue_script( 'fdx-blockUI', plugins_url( 'js/jquery.blockUI.js',__FILE__), array(), $this->pluginversion);
              wp_enqueue_script( 'fdx-snippet', plugins_url( 'js/snippet.min.js',__FILE__), array(), $this->pluginversion);
    }
}

/*
|--------------------------------------------------------------------------
| [ALL] - Registers all admin menu items.
|--------------------------------------------------------------------------
*/
function action_menu_pages() {
$settings = $this->fdx_get_settings();
$p2_red_total = get_site_option( 'fdx_p2_red_total' );
#p3
$p3_red_op1 = get_site_option( 'fdx_p3_red_op1' );
$p3_red_op2 = get_site_option( 'fdx_p3_red_op2' );
$p3_red_total = $p3_red_op1+$p3_red_op2;
#p5
$p5_red_total = get_site_option( 'fdx_p5_red_total' );

if ($p5_red_total != '0'){ $p5_red = '1';} else { $p5_red = '0';};
if ($p3_red_total != '0'){ $p3_red = '1';} else { $p3_red = '0';};

$fail_total = $p2_red_total+$p5_red+$p3_red;

//--------------------------------------
if ( $p2_red_total == '0' && $p5_red_total == '0' && $p3_red_total == '0'  ){
$fdx_menu_title = __( $this->pluginname, $this->hook );
} else {
$fdx_menu_title = __( $this->pluginname, $this->hook )." <span class='update-plugins count-" . $fail_total . "'><span class='plugin-count'>" . number_format_i18n( $fail_total ) . "</span></span>";
}
//--------------------------------------
 			add_menu_page(
				__( $this->pluginname, $this->hook ) . ' - ' . __( 'Dashboard', $this->hook ),
				$fdx_menu_title,
				$this->accesslvl,
				$this->hook,
				array( $this, 'fdx_options_subpanel_p1' ),
		    	'dashicons-shield-alt'
			);

			add_submenu_page(
					$this->hook,
					__( $this->pluginname, $this->hook ) . ' - ' . __( 'Vulnerability', $this->hook ),
					__( 'Vulnerability', $this->hook ),
					$this->accesslvl,
                      $this->hook . '-'.$this->_p2,
					array( $this, 'fdx_options_subpanel_p2' )
				);

                add_submenu_page(
					$this->hook,
					__( $this->pluginname, $this->hook ) . ' - ' . __( 'File System', $this->hook ),
					__( 'File System', $this->hook ),
					$this->accesslvl,
                      $this->hook . '-'.$this->_p3,
					array( $this, 'fdx_options_subpanel_p3' )
				);

                add_submenu_page(
					$this->hook,
					__( $this->pluginname, $this->hook ) . ' - ' . __( 'Core Scanner', $this->hook ),
				    __( 'Core Scanner', $this->hook ),
					$this->accesslvl,
                    $this->hook . '-'.$this->_p5,
					array( $this, 'fdx_options_subpanel_p5' )
				);

            add_submenu_page(
					$this->hook,
					__( $this->pluginname, $this->hook ) . ' - 404 Log',
					'404 Log',
					$this->accesslvl,
                      $this->hook . '-'.$this->_p4,
					array( $this, 'fdx_options_subpanel_p4' )
				);

if ( $settings['p7_check_1'] ) {
             add_submenu_page(
                  	null,                                              // -> Set to null - will hide menu link
				    '',                                                // -> Page Title
					'',                                                // -> Title that would otherwise appear in the menu
					$this->accesslvl,                                  // -> Capability level
                    $this->hook . '-'.$this->_p7,                      // -> Still accessible via admin.php?page=menu_handle
					array( $this, 'fdx_options_subpanel_p7' )          // -> To render the page
              );
}
               add_submenu_page(
					$this->hook,
					__( $this->pluginname, $this->hook ) . ' - ' . __( 'Settings', $this->hook ),
					__( 'Settings', $this->hook ),
					$this->accesslvl,
                    $this->hook . '-'.$this->_p6,
					array( $this, 'fdx_options_subpanel_p6' )
				);


				//Make the dashboard the first submenu item and the item to appear when clicking the parent.
				global $submenu;
				if ( isset( $submenu[$this->hook] ) ) {
					$submenu[$this->hook][0][0] = __( 'Dashboard', $this->hook );
    			}
   #p5 popup
   if ( isset($_GET['view']) && 'diff' == $_GET['view'] ) {
    self::fdx_diff_page();
    die();
   #p2 popup
   } elseif ( isset($_GET['popup']) && 'pp_page' == $_GET['popup'] ) {
    self::fdx_popup_page();
    die();
   }
}

/*
|--------------------------------------------------------------------------
| [ALL] - Includes
|--------------------------------------------------------------------------
*/

#Popup-----------------ALL
function fdx_popup_page() {
     $target = $_GET['target'];
    if ($target){
    include('modules/inc-popup.php');
    }
}

#Dashboard-------------P1
function fdx_options_subpanel_p1() {
require_once ('modules/inc-p1.php');
}

#Vulnerability---------P2
function fdx_options_subpanel_p2() {
require_once ('modules/inc-p2.php');
}

#File System-----------P3
function fdx_options_subpanel_p3() {
require_once ('modules/inc-p3.php');
}

#404 logs--------------P4
function fdx_options_subpanel_p4() {
require_once ('modules/inc-p4.php');
}

#Core Scanner----------P5
function fdx_options_subpanel_p5() {
require_once ('modules/inc-p5.php');
}

#Settings and Setup----P6
function fdx_options_subpanel_p6() {
require_once ('modules/inc-p6.php');
}

#PHP Debug Log--------P7
function fdx_options_subpanel_p7() {
require_once ('modules/inc-p7.php');
}


/*
|--------------------------------------------------------------------------
| [P3] - AJAX callback to initiate a file scan.
|--------------------------------------------------------------------------
*/
function fdx_ajax_file_scan() {
   $settings = $this->fdx_get_settings();
	check_ajax_referer( 'fdx-scanner_scan' );

	$start = (int) $_POST['start'];

    $max = $settings['p3_op1'];

	$args = compact( 'start', 'max' );

	$scanner = new File_FDX_Scanner( ABSPATH, $args );
	$result = $scanner->run();
    if ( is_wp_error($result) ) {
		$message = $result->get_error_message();
		$data = $result->get_error_data();
		echo json_encode( array( 'status' => 'error', 'message' => $message, 'data' => $data ) );
	} else if ( $result ) {
		echo json_encode( array( 'status' => 'complete' ) );
	} else {
		echo json_encode( array( 'status' => 'running', 'data' => __('Scanner filesystem', $this->hook). ': ' . ($start+$max) . '...' ) );
	}

	exit;
}

/*
|--------------------------------------------------------------------------
| [P3] - AJAX run_end
|--------------------------------------------------------------------------
*/
function fdx_run_end() {
	check_ajax_referer( 'fdx-scanner_scan' );
	$scanner = new RunEnd();
	$scanner->RunEnd();
	exit;
}

/*
|--------------------------------------------------------------------------
| [P3] - Display table of results.
|--------------------------------------------------------------------------
*/
public function fdx_show_results( $results ) {
    $result = '';
   //  severe=03 warning=02 note=01
	foreach ( array('03','02','00', '01') as $l ) {
		if ( ! empty($results[$l]) ) {
            $result .= '<table class="widefat"><thead><tr>';
            if ( $l == '00' ) $result .= '<th>'. __('Log, Binary, Data and Temporary files', $this->hook).'.<div style="float: right"><code>'. count($results[$l]) .' '. __('matches', $this->hook).'</code><span class="pb_label pb_label-info">&#10003;</span></div></th>' ;
            if ( $l == '01' ) $result .= '<th>'. __('Compressed files', $this->hook).'.<div style="float: right"><code>'. count($results[$l]) .' '. __('matches', $this->hook).'</code><span class="pb_label pb_label-info">&#10003;</span></div></th>';
            if ( $l == '02' ) $result .= '<th>'. __('Dangerous and malicious files', $this->hook).'.<div style="float: right"><code>'. count($results[$l]) .' '. __('matches', $this->hook).'</code><span class="pb_label pb_label-important">X</span></div></th>';
            if ( $l == '03' ) $result .= '<th>'. __('Unknown file found in WP core', $this->hook).'.<div style="float: right"><code>'. count($results[$l]) .' '. __('matches', $this->hook).'</code><span class="pb_label pb_label-important">X</span></div></th>';
         	$result .= '</tr></thead><tbody><tr><td><ul class="fdx-list">';
        		foreach ( $results[$l] as $r )
				$result .= self::fdx_draw_row( $r );
			$result .= '</ul></td></tr></tbody></table>';
        }
	}
    update_option('fdx_p3_red_op1', count(@$results['02']) );
    update_option('fdx_p3_red_op2', count(@$results['03']) );
	echo $result;
}

/*
|--------------------------------------------------------------------------
| [P3] - Draw a single result row.
|--------------------------------------------------------------------------
*/
public function fdx_draw_row( $r ) {
    $ext = pathinfo($r['loc'], PATHINFO_EXTENSION); //show only file extension
	$html = '<li id="ext-'.$ext.'" >' . esc_html( $r['loc'] ). '</li>';
 	return $html;
}

/*
|--------------------------------------------------------------------------
| [P3] - Results page
|--------------------------------------------------------------------------
*/
public function fdx_results_page() {
	delete_transient( 'fdx_results_trans' );
	delete_transient( 'fdx_files' );
	$results = get_option( 'fdx_results' );
     if ( ! $results ) {
echo '<table class="widefat">';
echo '<thead>';
echo '<tr><th>'. __('Nothing Found!', $this->hook).'<div style="float: right"><span class="pb_label pb_label-success">&#10003;</span></div></th>';
echo '</tr></thead><tbody><tr><td>-</td></tr></tbody>';
echo '</table>';
} else {
        self::fdx_show_results( $results );
     }
 }

/*
|--------------------------------------------------------------------------
| [P5] - ajax for viewing file source
|--------------------------------------------------------------------------
*/
function get_file_source() {
    $out = array();
    if (!current_user_can('administrator') || md5($this->p5_salt . stripslashes(@$_POST['filename'])) != $_POST['hash']) {
      $out['err'] = 'Cheating are you?';
      die(json_encode($out));
    }
    $out['ext'] = pathinfo(@$_POST['filename'], PATHINFO_EXTENSION);
    $out['source'] = '';
     if (is_readable($_POST['filename'])) {
      $content = file_get_contents($_POST['filename']);
      if ($content !== FALSE) {
        $out['err'] = 0;
        $out['source'] = utf8_encode($content);
      } else {
        $out['err'] = 'File is empty.';
      }
    } else {
      $out['err'] = 'File does not exist or is not readable.';
    }
    die(json_encode($out));
  }

/*
|--------------------------------------------------------------------------
| [P5] - do the actual scanning
|--------------------------------------------------------------------------
*/
  function scan_files() {
    global $wp_version;
    $results['missing_ok'] = $results['missing_bad'] = $results['changed_bad'] = array();
    $results['ok'] = array();
    $results['last_run'] = current_time('timestamp');
    $results['total'] = 0;
    $i = 0;
    $missing_ok = array('readme.html', 'license.txt', 'wp-config-sample.php',
                        'wp-admin/install.php', 'wp-admin/upgrade.php');
      // hashes files
      require 'libs/hashes-'. $wp_version.'.php';
      $results['total'] = sizeof($filehashes);
      foreach ($filehashes as $file => $hash) {
        clearstatcache();
        if (file_exists(ABSPATH . $file)) {
          if ($hash == md5_file(ABSPATH . $file)) {
            $results['ok'][] = $file;
        } else {
            $results['changed_bad'][] = $file;
          }
        } else {
          if (in_array($file, $missing_ok)) {
            $results['missing_ok'][] = $file;
        } else {
            $results['missing_bad'][] = $file;
          }
        }
      } // foreach file
      update_option($this->p5_options_key, $results);
      return;
  }

/*
|--------------------------------------------------------------------------
| [P5] - helper function for listing files
|--------------------------------------------------------------------------
*/
  function list_files($files, $view = false) {
    $out = '';
    $out .= '<ul class="fdx-list">';
    foreach ($files as $file) {
      $ext = pathinfo($file, PATHINFO_EXTENSION); //show only file extension
      $out .= '<li id="ext-'.$ext.'" >';
      $out .=  ' ' . $file;
      if ($view) {
        $out .= ' <a data-hash="' . md5($this->p5_salt . ABSPATH . $file) . '" data-file="' . ABSPATH . $file . '" href="#source-dialog" class="fdx-show-source" title="'.__('View file source', $this->hook).'"><code id="c0">S</code></a>';
        $url = add_query_arg( array( 'view' => 'diff', 'file' => $file ), menu_page_url( $this->hook . '-'.$this->_p5, false ) );
        $out .= ' <a  href="' . esc_attr($url) . '" class="fdx-dialog" title="'.__('See what has been modified', $this->hook).'"><code id="c0">&ETH;</code></a>';
       }
       $out .= '</li>';
    }
    $out .= '</ul>';
    return $out;
  }

/*
|--------------------------------------------------------------------------
| [P5] - Diff Page
|--------------------------------------------------------------------------
*/
function fdx_diff_page() {
	$file = $_GET['file'];
    echo '<div class="fdx-popup">';
	echo '<h2>'.__('Changes made to file', $this->hook). ': <code>' . esc_html($file) . '</code></h2>';
	echo self::fdx_display_file_diff( $file );
    echo '</div>';
}

/*
|--------------------------------------------------------------------------
| [P5] - Generate the diff of a modified core file.
|--------------------------------------------------------------------------
*/
function fdx_display_file_diff( $file ) {
require_once( 'modules/class-p5.php' );
	global $wp_version;
	// core file names have a limited character set
	$file = preg_replace( '#[^a-zA-Z0-9/_.-]#', '', $file );
	if ( empty( $file ) || ! is_file( ABSPATH . $file ) )
		return '<p>Sorry, an error occured. This file might not exist!</p>';
	$key = $wp_version . '-' . $file;
	$cache = get_option( 'exploitscanner_diff_cache' );
	if ( ! $cache || ! is_array($cache) || ! isset($cache[$key]) ) {
		$url = "http://core.svn.wordpress.org/tags/$wp_version/$file";
		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) || 200 != $response['response']['code'] )
			return '<p>Sorry, an error occured. Please try again later.</p>';
		$clean = $response['body'];
		if ( is_array($cache) ) {
			if ( count($cache) > 4 ) array_shift( $cache );
			$cache[$key] = $clean;
		} else {
			$cache = array( $key => $clean );
		}
		update_option( 'exploitscanner_diff_cache', $cache );
	} else {
		$clean = $cache[$key];
	}
	$modified = file_get_contents( ABSPATH . $file );
	$text_diff = new Text_Diff( explode( "\n", $clean ), explode( "\n", $modified ) );
	$renderer = new FDX_Text_Diff_Renderer();
	$diff = $renderer->render( $text_diff );
	$r  = "<table class=\"fdxdiff\">";
	$r .= "<tbody>\n$diff\n</tbody>\n";
	$r .= "</table>";
	return $r;
}

/*
|--------------------------------------------------------------------------
| [P6] -  Get settings defaults
|--------------------------------------------------------------------------
*/
function fdx_get_settings() {
	$settings = $this->fdx_defaults;
	$wordpress_settings = get_option( 'fdx_settings' );
	if ( $wordpress_settings ) {
		foreach( $wordpress_settings as $key => $value ) {
			$settings[ $key ] = $value;
		}
	}
	return $settings;
}


/*
|--------------------------------------------------------------------------
| [P6] -  add login key to action
|--------------------------------------------------------------------------
*/
public function add_login_key_to_action_from($url, $path, $scheme, $blog_id ){
$settings = $this->fdx_get_settings();
if ($url)
        	if ($scheme=='login' || $scheme=='login_post' )
            	return add_query_arg($this->p6_slug, $settings['p6_key'], $url);
        return $url;
    }

/*
|--------------------------------------------------------------------------
| [P6] - add key login to url
|--------------------------------------------------------------------------
*/
public function add_key_login_to_url($url, $redirect='0'){
$settings = $this->fdx_get_settings();
	  	if ($url)
       		return add_query_arg($this->p6_slug, $settings['p6_key'], $url);
    }

/*
|--------------------------------------------------------------------------
| [P6] - logout home
|--------------------------------------------------------------------------
*/
public function fdx_logout_home($logouturl, $redir) {
       $redir = get_option('siteurl');
         return $logouturl . '&amp;redirect_to=' . urlencode($redir);
}


/*
|--------------------------------------------------------------------------
| [P6] - block_access
|--------------------------------------------------------------------------
*/
public function block_access(){
          $settings = $this->fdx_get_settings();
          $url=esc_url('http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI']);
          status_header( 404 );
          nocache_headers();
          if ( !$settings['p6_url'] ) {
          require_once( get_404_template() );
          } else {
          header( 'Location: '. $settings['p6_url'] ) ;
          }
        die();
}

/*
|--------------------------------------------------------------------------
| [P6] - init
|--------------------------------------------------------------------------
*/
function init(){
     $settings = $this->fdx_get_settings();
       //
       if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin/')!==false) {
                      if ( !is_user_logged_in() ) {
                      $this->block_access();
                      }
               }
        if ( (isset($_GET[$this->p6_slug]) && $_GET[$this->p6_slug]==$settings['p6_key']) )  { //off
           } else { //on
            if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-login.php')!==false) {
                $this->block_access();
            }
        }
  }

function fdx_activate() {
update_option( 'fdx_settings', $this->fdx_defaults );
}

/*
|--------------------------------------------------------------------------
| [ALL] - Clean-Up When Deactivated
|--------------------------------------------------------------------------
*/
function fdx_deactivate() {
    delete_option($this->p2_options_key); //p2_log_time
    delete_option($this->p5_options_key); //p5_log_time
    delete_option( 'fdx_results' ); //p3
    delete_option( 'p3_log_time' ); //p3 log

// red
delete_option('fdx_p2_red2');
delete_option('fdx_p2_red3');
delete_option('fdx_p2_red4');
delete_option('fdx_p2_red5');
delete_option('fdx_p2_red6');
delete_option('fdx_p2_red7');
delete_option('fdx_p2_red8');
delete_option('fdx_p2_red9');
delete_option('fdx_p2_red10');
delete_option('fdx_p2_red11');
delete_option('fdx_p2_red12');
delete_option('fdx_p2_red13');
//yel
delete_option('fdx_p2_yel1');
delete_option('fdx_p2_yel2');
delete_option('fdx_p2_yel3');
delete_option('fdx_p2_yel4');
delete_option('fdx_p2_yel5');
delete_option('fdx_p2_yel6');
delete_option('fdx_p2_yel7');
//total
delete_option('fdx_p2_yel_total');
delete_option('fdx_p2_red_total');
delete_option('fdx_p5_red_total');
delete_option('fdx_p3_red_op1');
delete_option('fdx_p3_red_op2');

}


}
$total_security = new Total_Security();