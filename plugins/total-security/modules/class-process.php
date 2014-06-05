<?php
class FDX_Process extends Total_Security {

function __construct() {
              if (isset( $_POST['fdx_page']) ) {
			  add_filter('init', array( $this, 'fdx_update_post_settings') );
              }

$this->fdx_exe_function();
}


/*
 * Exe Global Function
 */

function fdx_exe_function() {
global $wpdb, $fdx_db_version;
$fdx_db_version = '1.0';
$installed_ver = get_option( 'fdx_db1_version' );

// if no exist or different versions
if( !get_site_option( 'fdx_db1_version' )  || get_site_option( 'fdx_db1_version' ) != $fdx_db_version ) {

$tables = "CREATE TABLE " . $wpdb->base_prefix . "total_security_log (
id int(11) NOT NULL AUTO_INCREMENT ,
timestamp int(10) NOT NULL ,
host varchar(20) ,
url varchar(255) ,
referrer varchar(255) ,
PRIMARY KEY  (id)
);";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $tables );

update_option( 'fdx_db1_version', $fdx_db_version ); //remove only uninstall
     }
}

/*
 * Executes appropriate process function based on post variable
 */
function fdx_update_post_settings() {
		   switch ( $_POST['fdx_page'] ) {
                    case 'fdx_form_all':
					$this->fdx_process_all();
                    # first donation hidding time 'now'
                    if( !get_site_option( 'fdx1_hidden_time' ) ) {
                    $time = time();
                    update_option('fdx1_hidden_time', $time ); //grava o tempo em
                    }
					break;
                    case 'fdx_reset':
				    update_option( 'fdx_settings', false );
					break;

                    case 'fdx_clean':
				    $this->fdx_process_clean();
					break;

                    case 'hide_message':
				    # Hide donation message for 33 days
                    $time = time() + 33 * 24 * 60 * 60;
                    update_option('fdx1_hidden_time', $time );
					break;
    }
}

/*
 * Process All
 */
function fdx_process_all(){
            if ( isset( $_POST['p2_select_1'] ) ) {
        	$settings['p2_op1'] = $_POST['p2_select_1'];
            }

            if ( isset( $_POST['p3_select_1'] ) ) {
        	$settings['p3_op1'] = $_POST['p3_select_1'];
            }

            if ( isset( $_POST['p4_check_1'] ) ) {
				$settings['p4_check_1'] = true;
			} else {
				$settings['p4_check_1'] = false;
			}

            if ( isset( $_POST['p4_check_2'] ) ) {
				$settings['p4_check_2'] = true;
			} else {
				$settings['p4_check_2'] = false;
			}

            if ( isset( $_POST['p4_check_3'] ) ) {
				$settings['p4_check_3'] = true;
			} else {
				$settings['p4_check_3'] = false;
			}

             if ( isset( $_POST['p6_check_1'] ) ) {
				$settings['p6_check_1'] = true;
			} else {
				$settings['p6_check_1'] = false;
			}

            if ( isset( $_POST['p7_check_1'] ) ) {
				$settings['p7_check_1'] = true;
			} else {
				$settings['p7_check_1'] = false;
			}
//----------text
            if ( isset($_POST['p6_key']) ) {
	        $settings['p6_key'] = stripslashes($_POST['p6_key']);
			}
            if ( isset($_POST['p6_url']) ) {
	          $settings['p6_url'] = stripslashes($_POST['p6_url']);
	   		}
update_option( 'fdx_settings', $settings );
}


/*
 * P4 - Clean Database
 */
function fdx_process_clean(){
global $wpdb;
    $wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "total_security_log" );
}


}// end class

