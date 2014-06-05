<?php
$results = get_option($this->p5_options_key); //time
$tests = get_option($this->p2_options_key); //time
$p2_url2 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'phpinfo' ), menu_page_url( $this->hook , false ) );
$p2_url3 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'tableinfo' ), menu_page_url( $this->hook , false ) );
$p2_url4 = add_query_arg( array( 'popup' => 'pp_page', 'target' => 'debug' ), menu_page_url( $this->hook , false ) );
/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('Dashboard', $this->hook) . '</h2>';
?>
<h2 class="nav-tab-wrapper">
<a class="nav-tab nav-tab-active" href="<?php echo admin_url('admin.php?page='.$this->hook); ?>"><?php _e('Dashboard', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p2); ?>"><?php _e('Vulnerability', $this->hook ); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p3); ?>"><?php _e('File System', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p5); ?>"><?php _e('Core Scanner', $this->hook); ?></a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p4); ?>">404 Log</a>
<a class="nav-tab" href="<?php echo admin_url('admin.php?page='.$this->hook . '-'.$this->_p6); ?>"><?php _e('Settings', $this->hook); ?></a>
</h2>



<?php
if (!$tests['last_run']) {
echo <<<END
<style type="text/css">
#hiddenoff3 {opacity:0.1!important;}
</style>
END;
echo '<div class="box-shortcode box-yellow">'.__( 'Vulnerability', $this->hook ).': '.__('Unexecuted!', $this->hook).'</div>';
}
if( !get_site_option( 'p3_log_time' ) ) {
echo <<<END
<style type="text/css">
#hiddenoff2 {opacity:0.1!important;}
</style>
END;
echo '<div class="box-shortcode box-yellow">'.__( 'File System', $this->hook ).': '.__('Unexecuted!', $this->hook).'</div>';
}
if (!$results['last_run']) {
echo <<<END
<style type="text/css">
#hiddenoff {opacity:0.1!important;}
</style>
END;
echo '<div class="box-shortcode box-yellow">'.__( 'Core Scanner', $this->hook ).': '.__('Unexecuted!', $this->hook).'</div>';
}

/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff"><div id="post-body" class="metabox-holder columns-2">';
include('inc-sidebar.php'); //include
echo '<div class="postbox-container"><div class="meta-box-sortables">';

//------------postbox
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Security Status', $this->hook) . '</span></h3>';
echo '<div class="inside">';
//p2
$p2_yel_total = get_site_option( 'fdx_p2_yel_total' );
$p2_red_total = get_site_option( 'fdx_p2_red_total' );
$yel_total2 =  '2'+$p2_yel_total;
//p3
$p3_red_op1 = get_site_option( 'fdx_p3_red_op1' );
$p3_red_op2 = get_site_option( 'fdx_p3_red_op2' );
$p3_red_total = $p3_red_op1+$p3_red_op2;

//p5
$p5_red_total = get_site_option( 'fdx_p5_red_total' );
//######################################################################
      $rating = '10';
      if ( ($rating >= 0) AND ($rating <= 1) ) {$level = __('Low', $this->hook);}
      if ( ($rating >= 2) AND ($rating <= 4) ) {$level = __('Medium', $this->hook);}
      if ( ($rating >= 5) AND ($rating <= 7) ) {$level = __('High', $this->hook);}
      if ( ($rating >= 8) AND ($rating <= 10) ) {$level = __('Critical', $this->hook);}
//######################################################################
      echo '<table class="widefat topLoader">';
      echo '<thead><tr>';
      echo '<th>&nbsp;</th><th><small>'.__('Last run on', $this->hook).'</small></th><th style="text-align: center"><small>'.__('Medium Risk', $this->hook).'</small></th><th style="text-align: center"><small>'.__('High Risk', $this->hook).'</small></th><th style="text-align: center"><small>'. __('Overall Risk Rating', $this->hook) . '</small></th>';
      echo '</tr></thead><tbody><tr id="hiddenoff">';
      echo '<td><h1><a href="'. admin_url('admin.php?page='.$this->hook . '-'.$this->_p5). '">'.__( 'Core Scanner', $this->hook ).'</a></h1></td><td class="fdx_ratingtime">' . date(get_option('date_format') . ', ' . get_option('time_format'), $results['last_run']) . '</td><td class="fdx_rating">';

      if ($p5_red_total == '0' ) {
      echo '<span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span id="r-0"></span>';
      } else {
      echo '<span class="pb_label pb_label-info">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-important">1</span></td><td class="fdx_rating"><span id="r-9"></span>';
      }
      echo '</tr><tr class="alternate" id="hiddenoff2"><td><h1><a href="'. admin_url('admin.php?page='.$this->hook . '-'.$this->_p3). '">'.__( 'File System', $this->hook ).'</a></h1></td><td class="fdx_ratingtime">' . date(get_option('date_format') . ', ' . get_option('time_format'), get_site_option( 'p3_log_time') ) . '</td><td class="fdx_rating">';

     if ($p3_red_total == '0') {
      echo '<span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span id="r-1"></span>';
     } else {
      echo '<span class="pb_label pb_label-info">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-important">1</span></td><td class="fdx_rating"><span id="r-8"></span>';
     }

      echo '</td></tr><tr id="hiddenoff3"><td><h1><a href="'. admin_url('admin.php?page='.$this->hook . '-'.$this->_p2). '">'.__( 'Vulnerability', $this->hook ).'</a></h1></td><td class="fdx_ratingtime">' . date(get_option('date_format') . ', ' . get_option('time_format'), $tests['last_run']) . '</td><td class="fdx_rating">';

      if ($p2_yel_total == '0' && $p2_red_total == '0') {
      echo '<span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span id="r-2"></span>';

      } elseif ($p2_yel_total != '0' && $p2_red_total == '0') {
      echo '<span class="pb_label pb_label-warning">'.$p2_yel_total.'</span></td><td class="fdx_rating"><span class="pb_label pb_label-important">'.$p2_red_total.'</span></td><td class="fdx_rating"><span id="r-'.$yel_total2.'"></span>';

      } elseif ($p2_yel_total == '0' && $p2_red_total != '0') {
      echo '<span class="pb_label pb_label-success">&#10003;</span></td><td class="fdx_rating"><span class="pb_label pb_label-important">'.$p2_red_total.'</span></td><td class="fdx_rating"><span id="r-9"></span>';

      } else {
      echo '<span class="pb_label pb_label-warning">'.$p2_yel_total.'</span></td><td class="fdx_rating"><span class="pb_label pb_label-important">'.$p2_red_total.'</span></td><td class="fdx_rating"><span id="r-9"></span>';
       }

     echo '</tr></tbody></table>';

//--------------------
echo '<div class="clear"></div></div></div>';


//------------postbox
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>'. __('Additional Info', $this->hook) . '</span></h3>';
echo '<div class="inside">';

echo '<p>'.__(' You can see all identified security problems of your website at one glance. Each security problem comes with a detailed description and all the information needed so you can eliminate the problems and get secure. Any red or orange dots? Follow the instructions and turn them into green dots!', $this->hook).'</p>';
echo '<h3>'.__('All security checks are assigned one of the following risks', $this->hook).':</h3>';
echo '<p><span class="pb_label pb_label-success">&#10003;</span> '.__('No security risk has been identified.', $this->hook).'<br>';
echo '<span class="pb_label pb_label-warning">!</span> '.__('A medium security risk, resolve it as soon as possible.', $this->hook).'<br>';
echo '<span class="pb_label pb_label-important">X</span><strong> '.__('The identified security issues have to be resolved immediately.', $this->hook).'</strong><br>';
echo '<span class="pb_label pb_label-info">&#10003;</span> '.__('No security risk.', $this->hook). ' <em>('.__('If possible, replace', $this->hook).')</em><br>';
echo '<span class="pb_label pb_label-desat">&Oslash;</span> '.__('Error / Unable / Deactivated', $this->hook). ' <em>('.__('No risk assessment', $this->hook).')</em></p>';
echo '</div></div>';

//------------postbox
echo '<div class="postbox">';
echo '<div class="handlediv" title="' . __('Click to toggle', $this->hook) . '"><br /></div><h3 class="hndle"><span>Bookmarklets '. __('and useful information', $this->hook) . '.</span></h3>';
echo '<div class="inside">';
echo '<p class="bookmarklet"><code><a class="pluginbuddy_tip" title="'.__('Drag this link to your bookmark bar, or right-click the link and add to Favorites', $this->hook). '" onclick="window.alert(\''.__('Drag this link to your bookmark bar, or right-click the link and add to Favorites', $this->hook). '\');return false;" href="javascript:(function(){w=410;h=650;window.open(\''.plugins_url( 'libs/bookmarklet/password_hash.php',dirname(__FILE__) ).'\',null,\'width=\'+w+\',height=\'+h+\',left=\'+parseInt((screen.availWidth/2)-(765/2))+\',top=\'+parseInt((screen.availHeight/3)-(102/2))+\'resizable=0toolbar=0,scrollbars=1,location=0,status=0,menubar=0\');})();">Password Hash&rsaquo;&rsaquo;&rsaquo;</code></a>';
echo ' - '.__('Use to generate your passwords. It creates unique, secure passwords that are very easy for you to retrieve but no one else. Nothing is stored anywhere, anytime, so there\'s nothing to be hacked, lost, or stolen.', $this->hook). ' [<strong><a href="http://www.passwordmaker.org/" target="_blank">?</a></strong>]</p>';
echo '<hr><div style="text-align: center"><a class="button newWindow pluginbuddy_tip" href="'.$p2_url2.'" data-width="700" data-height="600" rel="1" id="pop_lats" title="'.__('Display Extended PHP Settings via phpinfo()', $this->hook).'">Phpinfo()</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$p2_url4.'" class="button fdx-dialog pluginbuddy_tip" title="'.__('Debug information is used to provide help.', $this->hook).'">'.__('Debug', $this->hook).'</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$p2_url3.'" class="button fdx-dialog pluginbuddy_tip" title="'.__('Tables in blue = Wordpress Default, Table in Green = Total Security Plugin', $this->hook).'">'.__('Database Info', $this->hook).'</a></div>';
echo '<div id="fdx-dialog-wrap"><div id="fdx-dialog"></div></div>'; //popup


//------------ meta-box-sortables | postbox-container | post-body | poststuff | wrap
echo '</div></div></div></div></div>';
//-----------------------------------------
?>
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
