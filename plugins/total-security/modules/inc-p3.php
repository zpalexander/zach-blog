<?php
$settings = Total_Security::fdx_get_settings(); 

/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('File System', $this->hook) . '</h2>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook); ?>"><?php _e('Dashboard', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p2); ?>"><?php _e('Vulnerability', $this->hook ); ?></a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p3); ?>"><?php _e('File System', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p5); ?>"><?php _e('Core Scanner', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p4); ?>">404 Log</a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p6); ?>"><?php _e('Settings', $this->hook); ?></a>
</h2>
<?php
// minimal version of WP core
 if (!version_compare(get_bloginfo('version'), $this->min_wp_ver,  '>=')) {

 echo '<div class="box-shortcode box-red">'. sprintf( __('This feature requires the WordPress version <code>%1s</code> or above, to function properly. You\'re using WordPress version <code>%2s</code>, please <a href="%3s">update</a>.' , $this->hook) , $this->min_wp_ver, get_bloginfo('version'), admin_url('update-core.php') ) . '</div>';
 echo <<<END
<style type="text/css">
#hiddenoff {opacity:0.4 !important;}
</style>
<script>
jQuery(document).ready(function($){
$("#hiddenoff  :input").attr("disabled", true);
});
</script>
END;

} else {
//display warning if test were never run
if( !get_site_option( 'p3_log_time' ) ) {
     echo '<div class="box-shortcode box-yellow">'.__('Not yet executed!', $this->hook).'</div>';
    } elseif ((current_time('timestamp') - 15*24*60*60) > get_site_option( 'p3_log_time' ) ) {
    echo '<div class="box-shortcode box-yellow">'. sprintf( __('Warning: Executed for more than <code>%s</code> days. Click in button "Execute" for a new analysis.' , $this->hook) , '15' ) . '</div>';
    } else {
     echo '<div class="box-shortcode box-blue">'.__('Last run on', $this->hook).':<strong>' . date(get_option('date_format') . ', ' . get_option('time_format'), get_site_option( 'p3_log_time') ) . '</strong></div>';
    }
}

/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('inc-sidebar.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables" id="hiddenoff">'; //if error

 if ( isset($_POST['action']) && 'scan' == $_POST['action'] ) {
		check_admin_referer( 'fdx-scan_all' );

		$scanner = new File_FDX_Scanner( ABSPATH, array( 'start' => 0) );
        $scanner->run();
    	$scanner = new RunEnd();
		$scanner->RunEnd();
	}

//------------postbox 1
echo '<form action="" method="post">';
echo '<input type="hidden" name="action" value="scan" />';
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('File System', $this->hook) . '</span>&nbsp;&nbsp;&nbsp;';
submit_button( __('Execute', $this->hook ), 'primary', 'Submit', false, array( 'id' => 'run-scanner' ) );
echo '</h3><div class="inside">';
echo '<p>' . __('Scours your file system by suspicious or potentially malicious files, compressed, log, binary, data, and temporary files. And any unknown file in WP core.', $this->hook ).'</p><p>';

echo __('Detects unknown file found in WP core', $this->hook ).': <code>*'.__('any file', $this->hook ).'</code><br />';
echo __('Detects suspicious or potentially malicious files', $this->hook ).': <code>*.exe</code> | <code>*.com</code> | <code>*.scr</code> | <code>*.bat</code> | <code>*.msi</code> | <code>*.vb</code> | <code>*.cpl</code><br />';
echo __('Detects compressed files', $this->hook ).': <code>*.zip</code> | <code>*.rar</code> | <code>*.7z</code> | <code>*.gz</code> | <code>*.tar</code> | <code>*.bz2</code><br />';
echo __('Detects log, binary, data and temporary files', $this->hook ).': <code>*.log</code> | <code>*.dat</code> | <code>*.bin</code> | <code>*.tmp</code></p>';




//-----------------------------------------

if( !get_site_option( 'p3_log_time' ) ) {
   echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th class="fdx-status1" id="red">'.__('Unexecuted!', $this->hook).'</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      echo '</table>';

} else {

/**
 * Display results.
 */
self::fdx_results_page();
}


//--------------------
echo '<div class="clear"></div></div></div></form>';
//--------------------

//meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//-----------------------------------------
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#run-scanner').click( function() {

          $('#diableclick').attr('disabled', 'disabled');
		   //-----------------------------------
		    $(this).attr('disabled', 'disabled')
           .val('<?php _e('Executing, please wait!', $this->hook) ?>');
    		$.blockUI({ message: '<img src="<?php echo plugins_url( 'images/loading.gif',dirname(__FILE__));?>" width="24" height="24" border="0" alt="" /><br /><div id="scan-loader" style="display:none;"><span><?php _e('Executing, please wait!', $this->hook) ?></span></div>' });
           //-----------------------------------
          max = <?php echo $settings['p3_op1']; ?> ;
  			$.ajaxSetup({
				type: 'POST',
				url: ajaxurl,
				complete: function(xhr,status) {
					if ( status != 'success' ) {
						$('#scan-loader img').hide();
						$('#scan-loader span').html( '<?php _e('An error occurred. Please try again later', $this->hook); ?>.' );
					}
				}
			});

			$('#scan-results').hide();
			$('#scan-loader').show();
	  fdx_file_scan(0);
			return false;
		});

	});

	var fdx_nonce = '<?php echo wp_create_nonce( 'fdx-scanner_scan' ); ?>',
	fdx_file_scan = function(s) {
		jQuery.ajax({
			data: {
				action: 'fdx-scanner_file_scan',
				start: s,
   			   	_ajax_nonce: fdx_nonce
			}, success: function(r) {
				var res = jQuery.parseJSON(r);
				if ( 'running' == res.status ) {
					jQuery('#scan-loader span').html(res.data);
					fdx_file_scan(s+max, max);
				} else if ( 'error' == res.status ) {
					// console.log( r );
					jQuery('#scan-loader img').hide();
					jQuery('#scan-loader span').html(
						'An error occurred: <pre style="overflow:auto">' + r.toString() + '</pre>'
					);
				} else {
                    fdx_db_scan();
				}
			}
		});
	}, fdx_db_scan = function() {
		jQuery('#scan-loader span').html('<?php _e('Scan complete', $this->hook); ?>...');
		jQuery.ajax({
			data: {
				action: 'fdx-run_end',
				_ajax_nonce: fdx_nonce
			}, success: function(r) {
				jQuery('#scan-loader img').hide();
				jQuery('#scan-loader span').html('<?php _e('Refresh the page to view the results', $this->hook); ?>.');
				window.location.reload(false);
			}
		});
	};
</script>