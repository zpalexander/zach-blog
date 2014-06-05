<?php
$results = get_option($this->p5_options_key);

/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('Core Scanner', $this->hook) . '</h2>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook); ?>"><?php _e('Dashboard', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p2); ?>"><?php _e('Vulnerability', $this->hook ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p3); ?>"><?php _e('File System', $this->hook); ?></a>
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p5); ?>"><?php _e('Core Scanner', $this->hook); ?></a>
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
if (!$results['last_run']) {
      echo '<div class="box-shortcode box-yellow">'.__('Not yet executed!', $this->hook).'</div>';
    } elseif ((current_time('timestamp') - 15*24*60*60) > $results['last_run']) {
      echo '<div class="box-shortcode box-yellow">'. sprintf( __('Executed for more than <code>%s</code> days. Click in button "Execute" for a new analysis.' , $this->hook) , '15' ) . '</div>';
    } else {
      echo '<div class="box-shortcode box-blue">'.__('Last run on', $this->hook).': <strong>' . date(get_option('date_format') . ', ' . get_option('time_format'), $results['last_run']) . '</strong></div>';

    }

}

/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('inc-sidebar.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables" id="hiddenoff">'; //if error


//------------postbox 1
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Core Scanner', $this->hook) . '</span>&nbsp;&nbsp;&nbsp;';
submit_button( __('Execute', $this->hook ), 'primary', 'Submit', false, array( 'id' => 'fdx-run-scan' ) );
echo '</h3><div class="inside">';
//-----------------------------------------
echo '<p>'.__('Files are scanned and compared via the <em>MD5 hashing algorithm</em> to original WordPress core files available from <strong>wordpress.org</strong>. Not every change on core files is malicious and changes can serve a legitimate purpose. However if you are not a developer and you did not change the files yourself the changes most probably come from an exploit.', $this->hook).'</p>';

if (isset($results['last_run']) && $results['last_run']) {


    } else {
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th class="fdx-status1" id="red">'.__('Unexecuted!', $this->hook).'</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      echo '</table>';
      }
    if ($results['changed_bad']) {
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th><strong style="color:red;">'. __('Modified', $this->hook). '</strong><div style="float: right"><span class="pb_label pb_label-important">X</span></div></th>';
      echo '</tr></thead>';
      echo '<tbody><tr class="alternate"><td>';
      echo '<div style="font-size: 11px">'.__('If you didn\'t modify the following files and don\'t know who did they are most probably infected by a party malicious code.', $this->hook).'</div></td></tr><td>';
      echo self::list_files($results['changed_bad'], true, true);
      echo '</td></tr></tbody>';
      echo '</table>';
    }

    if ($results['missing_bad']) {
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th><strong style="color:red;">'. __('Missing', $this->hook). '</strong><div style="float: right"><span class="pb_label pb_label-important">X</span></div></th>';
      echo '</tr></thead>';
      echo '<tbody><tr class="alternate"><td>';
      echo '<div style="font-size: 11px">'.__('Missing core files my indicate a bad auto-update or they simply were not copied on the server when the site was setup.', $this->hook).'</div></td></tr><td>';
      echo self::list_files($results['missing_bad'], false, true);
      echo '</td></tr></tbody>';
      echo '</table>';
    }

   if ($results['missing_ok']) {
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th><strong style="color:green;">'. __('Missing', $this->hook). '</strong><div style="float: right"><span class="pb_label pb_label-success">&#10003;</span></div></th>';
      echo '</tr></thead>';
      echo '<tbody><tr class="alternate"><td>';
      echo '<div style="font-size: 11px">'.__('Some files like (<strong><em>/readme.html, /license.txt, /wp-config-sample.php, /wp-admin/install.php, /wp-admin/upgrade.php</em></strong>) are not vital and should be removed. Do not restore them unless you really need them and know what you are doing.', $this->hook).'</div></td></tr><td>';
      echo self::list_files($results['missing_ok'], false, true);
      echo '</td></tr></tbody>';
      echo '</table>';
  }


    if ($results['ok']) {
      $diference = $results['total'] - sizeof($results['ok']);
      echo '<div class="clear"></div>';
      echo '<table class="widefat">';
      echo '<thead><tr>';
      echo '<th class="fdx-status1">'.__('A total of', $this->hook). ' <strong>' . $results['total'] . '</strong> '.__('files were scanned', $this->hook).', <strong>' . sizeof($results['ok']) . '</strong> '.__('are unmodified and safe, and', $this->hook). ' <strong>'. $diference . '</strong> '.__('are files modified or missing', $this->hook).  '.</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      echo '</table>';
      $fdx_p5_red_total = sizeof($results['missing_bad']) + sizeof($results['changed_bad']);
      update_option('fdx_p5_red_total', $fdx_p5_red_total );
   }

    // dialogs
    echo '<div id="source-dialog" style="display: none;" title="File source"><p>'.__('Please wait', $this->hook).'.</p></div>';
    echo '<div id="fdx-dialog-wrap"><div id="fdx-dialog"></div></div>';

    //--------------------
    echo '<div class="clear"></div></div></div>';
    //--------------------

//------------ meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//----------------------------------------- ?>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
jQuery(document).ready(function($){
  $('a.fdx-show-source').click(function() {
     $($(this).attr('href')).dialog('option', { title: '<?php _e('File Source', $this->hook); ?>', file_path: $(this).attr('data-file'), file_hash: $(this).attr('data-hash') } ).dialog('open');
      return false;
  });

  $('#source-dialog').dialog({'dialogClass': 'wp-dialog',
                              'modal': true,
                              'resizable': false,
                              'zIndex': 9999,
                              'width': 800,
                              'height': 550,
                              'hide': 'fade',
                              'open': function(event, ui) { renderSource(event, ui); fixDialogClose(event, ui); },
                              'close': function(event, ui) { jQuery('#source-dialog').html('<p><?php _e('Please wait', $this->hook) ?>.</p>') },
                              'show': 'fade',
                              'autoOpen': false,
                              'closeOnEscape': true
                              });
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
                               'width': 750,
                               'title': '<?php _e('See what has been modified', $this->hook)?>',
                               'height': 550,
                               'hide': 'fade',
                               'show': 'fade',
                               'autoOpen': false,
                               'closeOnEscape': true
                              });
//-----------------------------------------------------

// scan files
  $('#fdx-run-scan').click(function(){
    var data = {action: 'sn_core_run_scan'};

    $(this).attr('disabled', 'disabled')
           .val('<?php _e('Executing, please wait!', $this->hook) ?>');
    $.blockUI({ message: '<img src="<?php echo plugins_url( 'images/loading.gif',dirname(__FILE__));?>" width="24" height="24" border="0" alt="" /><br /><?php _e('Executing, please wait!', $this->hook) ?> <?php _e('it can take a few minutes.', $this->hook) ?>' });

    $.post(ajaxurl, data, function(response) {
     window.location.reload();
    /*  if (response != '1') {
        alert('Ajax error - js#01');
        window.location.reload();
      } else {
        window.location.reload();
      } */
    });
  }); // run tests

}); // onload


function renderSource(event, ui) {
  dialog_id = '#' + event.target.id;
  jQuery.post(ajaxurl, {action: 'sn_core_get_file_source', filename: jQuery('#source-dialog').dialog('option', 'file_path'), hash: jQuery('#source-dialog').dialog('option', 'file_hash')}, function(response) {
      if (response) {
        if (response.err) {
          jQuery(dialog_id).html('<p><b><?php _e('An error occured', $this->hook) ?>.</b> ' + response.err + '</p>');
        } else {
          jQuery(dialog_id).html('<pre class="brush: php"></pre>');
          jQuery('pre', dialog_id).text(response.source);
          jQuery('pre', dialog_id).snippet(response.ext, {style: '<?php echo $this->p5_snippet ?>'});
        }
      } else {
        alert('<?php echo _e('An undocumented error occured. The page will reload', $this->hook); ?>.');
        window.location.reload();
      }
    }, 'json');
} // renderSource




function fixDialogClose(event, ui) {
  jQuery('.ui-widget-overlay').bind('click', function(){ jQuery('#' + event.target.id).dialog('close'); });
} // fixDialogClose
/*]]>*/
</script>