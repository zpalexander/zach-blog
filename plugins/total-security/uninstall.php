<?php
/**
 * Code used when the plugin is removed (not just deactivated but actively deleted through the WordPress Admin).
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// ALL Settings
delete_option('fdx_settings');

//database version (total_security_log)
delete_option( 'fdx_db1_version' );

//drop database tables
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->base_prefix . "total_security_log" );

// donate time d1
delete_option('fdx1_hidden_time');
