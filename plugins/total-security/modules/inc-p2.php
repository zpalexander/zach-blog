<?php
$tests = get_option($this->p2_options_key);
$tests2 = array();

$p2_url1 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'php' ), menu_page_url( $this->hook . '-'.$this->_p2 , false ) );
$p2_url2 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'php2' ), menu_page_url( $this->hook . '-'.$this->_p2 , false ) );
$p2_url3 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'chmod' ), menu_page_url( $this->hook . '-'.$this->_p2 , false ) );
/* ----------------------------------
 * MYSQL VERSION
 */
global $wpdb;
		$parent_class_test = array(
						'title'			=>	    'MySQL Version',
						'suggestion'	=>		$this->mySQL_lastver,
						'value'			=>		$wpdb->db_version(),
						'tip'			=>		'<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.__('Version of your database server (mysql) as reported to this script by WordPress.', $this->hook ).'"></a></span>',
					);
		if ( version_compare( $wpdb->db_version(), $this->mySQL_lastver, '<' ) ) {
			$parent_class_test['status'] = 'INFO';
		} else {
			$parent_class_test['status'] = 'OK';
		}
		array_push( $tests2, $parent_class_test );

/* ----------------------------------
 * PHP VERSION
 */
	$parent_class_test = array(
					'title'			=>		'PHP Version',
					'suggestion'	=>		$this->php_lastver,
					'value'			=>		phpversion(),
					'tip'			=>		'<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.__('Version of PHP currently running on this site.', $this->hook ).'"></a></span>',
				);
	if ( version_compare( PHP_VERSION, $this->php_lastver, '<' ) ) {
		$parent_class_test['status'] = 'INFO';
	} else {
		$parent_class_test['status'] = 'OK';
	}
	array_push( $tests2, $parent_class_test );

/* ----------------------------------
 * PHP max_execution_tim
 */
$parent_class_test = array(
					'title'			=>		'PHP <em>max_execution_time</em>',
					'suggestion'	=>		'60s',
					'value'			=>		ini_get( 'max_execution_time' ).'s',
					'tip'			=>		'<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.__('Maximum amount of time that PHP allows scripts to run. After this limit is reached the script is killed. The more time available the better. 30 seconds is most common though 60 seconds is ideal.', $this->hook ).'"></a></span>',
				);
	if ( ini_get( 'max_execution_time' )  < 60 ) {
		$parent_class_test['status'] = 'INFO';
	} else {
		$parent_class_test['status'] = 'OK';
	}
	array_push( $tests2, $parent_class_test );

/* ----------------------------------
 * MEMORY LIMIT
 */
	if ( !ini_get( 'memory_limit' ) ) {
		$parent_class_val = 'unknown';
	} else {
		$parent_class_val = ini_get( 'memory_limit' );
	}
	$parent_class_test = array(
					'title'			=>		'PHP Memory Limit',
					'suggestion'	=>		'256M',
					'value'			=>		$parent_class_val,
					'tip'			=>		'<span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.__('The amount of memory this site is allowed to consume. (256M+ best)', $this->hook ).'"></a></span>',
				);
	if ( preg_match( '/(\d+)(\w*)/', $parent_class_val, $matches ) ) {
		$parent_class_val = $matches[1];
		$unit = $matches[2];
		// Up memory limit if currently lower than 256M.
		if ( 'g' !== strtolower( $unit ) ) {
			if ( ( $parent_class_val < 256 ) || ( 'm' !== strtolower( $unit ) ) ) {
				$parent_class_test['status'] = 'INFO';
			} else {
				$parent_class_test['status'] = 'OK';
			}
		}
	} else {
		$parent_class_test['status'] = 'ERROR';
	}
	array_push( $tests2, $parent_class_test );

if ($tests['last_run']) {
/* ----------------------------------
 * php allow_url_include
 */
	$parent_class_test = array(
						'title'			=>	    'PHP <em>allow_url_include</em>',
						'suggestion'	=>		__('Turned Off', $this->hook),
						'tip'			=>		'',
					);
		if ( ini_get('allow_url_include') == 1) {
			$parent_class_test['status'] = 'WARNING';
            $parent_class_test['value'] = '<a href="'.$p2_url2.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Turned On', $this->hook).'</strong></a>';
            update_option('fdx_p2_yel5', '1' );
        } else {
			$parent_class_test['status'] = 'OK';
            $parent_class_test['value'] = __('Turned Off', $this->hook);
             update_option('fdx_p2_yel5', '0' );
		}
		array_push( $tests2, $parent_class_test );

/* ----------------------------------
 * php allow_url_fopen
 */
	$parent_class_test = array(
						'title'			=>	    'PHP <em>allow_url_fopen</em>',
						'suggestion'	=>		__('Turned Off', $this->hook),
   						'tip'			=>		'',
					);
		if ( ini_get('allow_url_fopen') == 1) {
			$parent_class_test['status'] = 'WARNING';
            $parent_class_test['value'] = '<a href="'.$p2_url2.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Turned On', $this->hook).'</strong></a>';
            update_option('fdx_p2_yel4', '1' );
        } else {
			$parent_class_test['status'] = 'OK';
            $parent_class_test['value'] = __('Turned Off', $this->hook);
            update_option('fdx_p2_yel4', '0' );
		}
		array_push( $tests2, $parent_class_test );

/* Dangerous PHP Functions
 * exec,passthru,shell_exec,proc_open,system
 */
	$disabled_functions = ini_get( 'disable_functions' );
	if ( $disabled_functions == '' ) {
		$disabled_functions = __('none', $this->hook );
	}
	$parent_class_test = array(
					'title'			=>		__('Dangerous PHP Functions', $this->hook ),
					'suggestion'	=>		__('Disable All', $this->hook ),
					'tip'			=>		'',
				);
  //   $disabled_functions_array = explode( ',', $disabled_functions );
       $disabled_functions_array = array_map('trim', explode(',', $disabled_functions)); //ignore space
       $parent_class_test['status'] = 'WARNING';
       $parent_class_test['value'] = '<a href="'.$p2_url1.'" class="fdx-dialog" title="'.__('Fix', $this->hook ).'"><strong>'.__('Disabled', $this->hook ).'</strong></a>:&nbsp; <span class="fdx-info"><a class="pluginbuddy_tip" href="javascript:void(0)" title="'.$disabled_functions.'"></a></span>';
       update_option('fdx_p2_yel7', '1' );
        if (
		( true === in_array( 'exec', $disabled_functions_array ) )
		&&
		( true === in_array( 'system', $disabled_functions_array ) )
        &&
		( true === in_array( 'passthru', $disabled_functions_array ) )
        &&
		( true === in_array( 'shell_exec', $disabled_functions_array ) )
        &&
		( true === in_array( 'proc_open', $disabled_functions_array ) )
        ) {
		$parent_class_test['status'] = 'OK';
        $parent_class_test['value'] = __('Disabled', $this->hook ).':&nbsp; <span class="fdx-info"><a class="pluginbuddy_tip" title="'.$disabled_functions.'"></a></span>';

        update_option('fdx_p2_yel7', '0' );
	}
	array_push( $tests2, $parent_class_test );

} //if no run

/* -------3
 * File Permissions - chmod
 */
define( 'FDX_P1_URL1', $p2_url3 );
define( 'FDX_P1_TIT1', __('Fix', $this->hook ) );
function fdx_check_perms($name,$path,$perm, $class) {
   clearstatcache();
   $current_perms = @substr(sprintf("%o", fileperms($path)), -3);
   if ( $perm == $current_perms ) {
            echo '<tr>';
            echo '<td>' . $name .'</td>';
            echo '<td>'.$perm.'</td>';
            echo '<td><code>'. $current_perms .'</code></td>';
            echo '<td><span class="pb_label pb_label-success">&#10003;</span></td>';
            update_option('fdx_p2_red2', '0' ); //2
            update_option('fdx_p2_red3', '0' );
    } elseif ($current_perms == '0') {
            echo '<tr class="alternate">';
            echo '<td>' . $name .'</td>';
            echo '<td>'.$perm.'</td>';
            echo '<td><code>---</code></td>';
            echo '<td><span class="pb_label pb_label-desat">&Oslash;</span></td>';
            echo '</tr>';
    } else {
           echo '<tr class="alternate">';
           echo '<td>' . $name .'</td>';
           echo '<td>'.$perm.'</td>';
           echo '<td><a href="'.FDX_P1_URL1.'" class="fdx-dialog" title="'.FDX_P1_TIT1.'"><strong><code>'. $current_perms.'</a></code></strong></td>';

         if ($name == "<span id='mime2'>.htaccess</span>") {
           echo '<td><span class="pb_label pb_label-'.$class.'">X</span></td>';
           update_option('fdx_p2_red2', '1' );

         } elseif ($name == "<span id='mime3'>wp-config.php</span>") {
              echo '<td><span class="pb_label pb_label-'.$class.'">X</span></td>';
           update_option('fdx_p2_red3', '1' );

         } else {
             echo '<td><span class="pb_label pb_label-'.$class.'">&#10003;</span></td>';

         }
           echo '</tr>';
    }
}

/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('Vulnerability', $this->hook) . '</h2>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook); ?>"><?php _e('Dashboard', $this->hook); ?></a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p2); ?>"><?php _e('Vulnerability', $this->hook ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p3); ?>"><?php _e('File System', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p5); ?>"><?php _e('Core Scanner', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p4); ?>">404 Log</a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p6); ?>"><?php _e('Settings', $this->hook); ?></a>
</h2>
<?php
//display warning if test were never run
if (!$tests['last_run']) {
    echo '<div class="box-shortcode box-yellow">'.__('Not yet executed!', $this->hook).'</div>';
    } elseif ((current_time('timestamp') - 15*24*60*60) > $tests['last_run']) {
    echo '<div class="box-shortcode box-yellow">'. sprintf( __('<strong>Warning:</strong> The vulnerability information for this system is <code>%s</code> days old!' , $this->hook) , '15' ) . '</div>';
    } else {
    echo '<div class="box-shortcode box-blue">'.__('Last run on', $this->hook).': <strong>' . date(get_option('date_format') . ', ' . get_option('time_format'), $tests['last_run']) . '</strong></div>';
}


/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('inc-sidebar.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//------------postbox 1
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Vulnerability', $this->hook) . '</span>&nbsp;&nbsp;&nbsp;';
submit_button( __('Execute', $this->hook ), 'primary', 'Submit', false, array( 'id' => 'run-tests' ) );
echo '</h3><div class="inside">';
//left
echo '<p>'.__('These tests covers most of the hardening tips of the WordPress Security Codex and includes a lot of additional security checks.', $this->hook);
echo '<br />'.__('It was designed to clearly show at a single glance what security problems exist in your website and to provide you with all the information needed to understand these issues and eliminate them.', $this->hook).'</p>';

      if ($tests['last_run']) {
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th>'.__('WordPress Security Checks', $this->hook).'</th>';
      echo '<th style="width: 120px;"><small>', __('Result', $this->hook), '</small></th> ';
      echo '<th style="width: 30px;"></th>';
      echo '</tr></thead>';
      echo '<tbody>';
        // test Results
        foreach($tests['test'] as $test_name => $details) {
          echo  $details['msg'];
          echo '<td>'. strval($details['status']) . '</td></tr>';
       } // foreach
      echo '</tbody>';
      echo '</table>';

//--------------------
             echo '<table class="widefat"><thead><tr class="thead">';
             echo '<th>', __('Server Configuration', $this->hook ), '</th>',
					 '<th style="width: 120px;"><small>', __('Recommendation', $this->hook ), '</small></th>',
                     '<th style="width: 120px;"><small>', __('Result', $this->hook), '</small></th>',
					 '<th style="width: 30px;"></th>';

            echo '</tr></thead><tbody>';
	    	foreach( $tests2 as $parent_class_test ) {
			echo '<tr>';
		 	echo '	<td>' . $parent_class_test['title'] . '</td>';
			echo '	<td>' . $parent_class_test['tip'] . $parent_class_test['suggestion'] . '</td>';
			echo '	<td>' . $parent_class_test['value'] . '</td>';
			//echo '	<td>' . $parent_class_test['status'] . '</td>';
			echo '	<td>';
			if ( $parent_class_test['status'] == 'OK' ) {
				echo '<span class="pb_label pb_label-success">&#10003;</span>';
			} elseif ( $parent_class_test['status'] == 'FAIL' ) {
			echo '<span class="pb_label pb_label-important">X</span>';
			} elseif ( $parent_class_test['status'] == 'WARNING') {
				echo '<span class="pb_label pb_label-warning">!</span>';
		    } elseif ( $parent_class_test['status'] == 'INFO') {
				echo '<span class="pb_label pb_label-info">&#10003;</span>';
			} elseif ( $parent_class_test['status'] == 'ERROR') {
				echo '<span class="pb_label pb_label-desat">&Oslash;</span>';
			}
			echo '</td></tr>';
	     	}
           echo '</tbody></table>';
    echo '<table class="widefat">';
  	echo '<thead><tr>';
    echo '<th>'.__('File Permissions - ', $this->hook).'chmod </th>';
    echo '<th style="width: 120px;"><small>'.__('Recommendation', $this->hook ).'</small></th>';
    echo '<th style="width: 120px;"><small>'.__('Result', $this->hook).'</small></th>';
    echo '<th  style="width: 30px;"></th>';
  	echo '</tr></thead><tbody>';
    $siteurl = get_bloginfo('url');
    $wpurl = get_bloginfo('wpurl');
    fdx_check_perms("<span id='mime0'>/</span>","../","755", "info");
    fdx_check_perms("<span id='mime1'>wp-admin</span>","../wp-admin","755", "info");
	fdx_check_perms("<span id='mime1'>wp-content</span>","../wp-content","755", "info");
    fdx_check_perms("<span id='mime1'>wp-includes</span>","../wp-includes","755", "info");
    if ($siteurl == $wpurl) {
    fdx_check_perms("<span id='mime2'>.htaccess</span>",ABSPATH."/.htaccess","444", "important");
    fdx_check_perms("<span id='mime3'>index.php</span>",ABSPATH."/index.php","640", "info");
    } else {
     fdx_check_perms("<span id='mime2'>.htaccess</span>",dirname(ABSPATH)."/.htaccess","444", "important");
     fdx_check_perms("<span id='mime3'>index.php</span>",dirname(ABSPATH)."/index.php","640", "info");
    }
    fdx_check_perms("<span id='mime3'>wp-config.php</span>","../wp-config.php","400", "important");
    fdx_check_perms("<span id='mime3'>wp-blog-header.php</span>","../wp-blog-header.php","640", "info");
    echo '</tbody></table>';



          } else {
     echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th class="fdx-status1" id="red">'.__('Unexecuted!', $this->hook).'</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      echo '</table>';
      }



//--------------------
echo '<div class="clear"></div></div></div>';

echo '<div id="fdx-dialog-wrap"><div id="fdx-dialog"></div></div>'; //popup

//------------ meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//----------------------------------------- ?>
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($){
//  $('#run-tests').removeAttr('disabled');
  // run tests, via ajax
  $('#run-tests').click(function(){
    var data = {action: 'sn_run_tests'};
     $(this).attr('disabled', 'disabled')
           .val('<?php _e('Executing, please wait!', $this->hook) ?>');
           $.blockUI({ message: '<img src="<?php echo plugins_url( 'images/loading.gif',dirname(__FILE__));?>" width="24" height="24" border="0" alt="" /><br /><?php _e('Executing, please wait!', $this->hook) ?> <?php _e('it can take a few minutes.', $this->hook) ?>' });
    $.post(ajaxurl, data, function(response) {
          window.location.reload();
    });
  }); // run tests
//-----------------------------------------------------
$('a.fdx-dialog').click(function(event) {
              event.preventDefault();
              var link = $(this).attr('href');
              $("#fdx-dialog").load(link,function(){
               $( "#fdx-dialog-wrap" ).dialog( "open" );
              });
              return false;
});
$('#fdx-dialog-wrap').dialog({'dialogClass': 'wp-dialog',
                               'modal': true,
                               'resizable': false,
                               'zIndex': 9999,
                               'width': 700,
                               'title': '<?php _e('Details, tips and help', $this->hook)?>',
                               'height': 550,
                               'hide': 'fade',
                               'show': 'fade',
                               'autoOpen': false,
                               'closeOnEscape': true
                              });
//---------------------
});
</script>