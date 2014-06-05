<?php
$settings = Total_Security::fdx_get_settings();
$p6_url1 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'debug_log' ), menu_page_url( $this->hook , false ) );
/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('Settings', $this->hook) . '</h2>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook); ?>"><?php _e('Dashboard', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p2); ?>"><?php _e('Vulnerability', $this->hook ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p3); ?>"><?php _e('File System', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p5); ?>"><?php _e('Core Scanner', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p4); ?>">404 Log</a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p6); ?>"><?php _e('Settings', $this->hook); ?></a>
</h2>
<?php

//mesages alert
if ( isset($_POST['fdx_page']) ) {
echo '<div class="box-shortcode box-green"><strong>' . __( 'Settings updated', $this->hook ) . '.</strong></div>';
}


/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('inc-sidebar.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//form
echo '<form method="post" action="">';
      wp_nonce_field();
echo '<input type="hidden" name="fdx_page" value="fdx_form_all" />';

// postbox 1
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Secure Hidden Login', $this->hook) . '</span></h3>';
echo '<div class="inside">'; ?>
<?php _e('Allows you to create custom URLs for user\'s login, logout and admin\'s login page, without editing any <em>.htaccess</em> files. Those attempting to gain access to your login form will be automatcally redirected to a customizable URL.', $this->hook); ?>
<table style="width:100%;" class="widefat">
<?php
if ( $settings['p6_check_1'] ) {
$urlLogin = get_bloginfo('wpurl');
echo '<thead><tr><th>';
echo __( 'Login url', $this->hook ) . ': <a href="'.$urlLogin.'/wp-login.php?login_key='. $settings['p6_key'] . '"><code>'.$urlLogin.'/wp-login.php?login_key='. $settings['p6_key'] . '</a></code><br/>' . __( 'You need to remember new address to login!', $this->hook );
echo '</th></tr></thead>';
}
?>
<tbody>
<tr><td><input type="checkbox" class="check" id="p6_check_1" name="p6_check_1"<?php if ( $settings['p6_check_1'] ) echo ' checked'; ?> /> <strong><?php _e( 'Hide "wp-login.php" and "wp-admin" folder', $this->hook ); ?></strong></td></tr>
 <tr class="alternate"><td>
<input type="text" name="p6_key" value="<?php echo( htmlentities( $settings['p6_key'], ENT_COMPAT, "UTF-8" ) ); ?>" /> <?php _e( 'Secret key', $this->hook ); ?>
<hr>
<input type="text" name="p6_url" value="<?php echo( htmlentities( $settings['p6_url'], ENT_COMPAT, "UTF-8" ) ); ?>" /> <?php _e( 'URL to redirect unauthorized attempts', $this->hook ); ?><br>
<small><?php _e( 'Leave blank for 404 page or "/" for home. Tip: add eg. /intrusion-detection/ for log in Error 404 Log', $this->hook ); ?></small>


</td>
</tr>
</tbody>
</table>


<?php
echo '</div></div>';
echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Vulnerability', $this->hook) . '</span></h3>';
echo '<div class="inside">'; ?>

<p><strong><?php _e( 'Maximum script execution time', $this->hook ); ?>:</strong> </p>
<select name="p2_select_1">
<option value="100"<?php if ( $settings['p2_op1'] == '100' ) echo " selected"; ?>>100</option>
<option value="200"<?php if ( $settings['p2_op1'] == '200' ) echo " selected"; ?>>200</option>
<option value="300"<?php if ( $settings['p2_op1'] == '300' ) echo " selected"; ?>>300</option>
<option value="400"<?php if ( $settings['p2_op1'] == '400' ) echo " selected"; ?>>400</option>
<option value="500"<?php if ( $settings['p2_op1'] == '500' ) echo " selected"; ?>>500</option>
<option value="0"<?php if ( $settings['p2_op1'] == '0' ) echo " selected"; ?>>~0~</option>
</select>
 <?php _e( 'Maximum number of seconds tests are allowed to run.', $this->hook ); ?>


<?php
echo '</div></div>';
echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('File System', $this->hook) . '</span></h3>';
echo '<div class="inside">'; ?>
<p><strong><?php _e( 'Number of files per batch', $this->hook ); ?>: </strong> </p>
<select name="p3_select_1">
<option value="100"<?php if ( $settings['p3_op1'] == '100' ) echo " selected"; ?>>100</option>
<option value="200"<?php if ( $settings['p3_op1'] == '200' ) echo " selected"; ?>>200</option>
<option value="500"<?php if ( $settings['p3_op1'] == '500' ) echo " selected"; ?>>500</option>
<option value="1000"<?php if ( $settings['p3_op1'] == '1000' ) echo " selected"; ?>>1000</option>
<option value="2000"<?php if ( $settings['p3_op1'] == '2000' ) echo " selected"; ?>>2000</option>
<option value="5000"<?php if ( $settings['p3_op1'] == '5000' ) echo " selected"; ?>>5000</option>
</select>
<?php _e( 'To help reduce memory limit errors the scan processes a series of file batches.', $this->hook); ?>



<?php
echo '</div></div>';
echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>404 Log</span></h3>';
echo '<div class="inside">'; ?>
<?php _e( 'Logs 404 (Page Not Found) errors on your site, this also gives the added benefit of helping you find hidden problems causing 404 errors on unseen parts of your site as all errors will be logged.', $this->hook); ?>
<hr>
<p><input type="checkbox" class="check" id="p4_check_1" name="p4_check_1"<?php if ( $settings['p4_check_1'] ) echo ' checked'; ?> /> <strong><?php _e( 'Enable the Error 404 Log reporting', $this->hook ); ?></strong>
</p><p style="margin-left: 15px"><input type="checkbox" class="check" id="p4_check_2" name="p4_check_2"<?php if ( $settings['p4_check_2'] ) echo ' checked'; ?> /> <?php _e( 'Ignore visits from robots', $this->hook ); ?>.</p>
<p style="margin-left: 15px"><input type="checkbox" class="check" id="p4_check_3" name="p4_check_3"<?php if ( $settings['p4_check_3'] ) echo ' checked'; ?> /> <?php _e( 'Ignore visits which don\'t have an HTTP Referrer', $this->hook ); ?>.</p>

<?php
echo '</div></div>';
echo '<div class="postbox">';//------------postbox 1
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Log Viewer', $this->hook) . ' <em>(debug.log)</em></span></h3>';
echo '<div class="inside">'; ?>
<p><input type="checkbox" class="check" id="p7_check_1" name="p7_check_1"<?php if ( $settings['p7_check_1'] ) echo ' checked'; ?> /> <?php _e( 'Enable the admin bar Log Viewer', $this->hook ); ?>.<br>
<small><?php _e('Adds a debug menu to the admin bar that shows real-time debugging information.', $this->hook); ?> </small></p>
<hr>



<p><?php echo sprintf(__('To turn on debug logging, simply add the following line of code to your %s file', $this->hook), '<em><strong>wp-config.php</strong></em>');?> (<a class="fdx-dialog" href="<?php echo $p6_url1;?>" title=""><?php _e('more info', $this->hook); ?></a>)</p>
<pre>
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors',0 );
</pre>






<?php //--------------------------------------------- end
echo '</div></div>';

// buttons
echo '<div class="button_submit">';
echo submit_button( __('Save all options', $this->hook ), 'primary', 'Submit', false, array( 'id' => '' ) ) ;
echo '</div>';
echo '</form>'; //form 1

echo '<div class="button_reset">';
echo '<form method="post" action="">';
echo '<input type="hidden" name="fdx_page" value="fdx_reset" />';
echo submit_button( __('Restore Defaults', $this->hook ), 'secondary', 'Submit' , false, array( 'id' => 'space', 'onclick' => 'return confirm(\'' . esc_js( __( 'Restore Default Settings?',  $this->hook ) ) . '\');' ) );
echo '</form>';//form 2
echo '</div>';

echo '<div id="fdx-dialog-wrap"><div id="fdx-dialog"></div></div>'; //popup
// meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//----------------------------------------- ?>
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($){
 $('a.fdx-dialog').click(function(event) {
              event.preventDefault();
              var link = $(this).attr('href');
              $("#fdx-dialog").load(link,function(){
               $( "#fdx-dialog-wrap" ).dialog( "open" );
              });
              return false;
});
$('#fdx-dialog-wrap').dialog({ 'dialogClass': 'wp-dialog',
                               'modal': true,
                               'resizable': false,
                               'zIndex': 9999,
                               'width': 700,
                               'title': '<?php _e('Additional Info', $this->hook)?>',
                               'height': 550,
                               'hide': 'fade',
                               'show': 'fade',
                               'autoOpen': false,
                               'closeOnEscape': true
                              });
});
</script>