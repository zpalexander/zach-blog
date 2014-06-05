<?php
// phpinfo
if ($target == 'phpinfo'){
phpinfo();
return;
}

echo '<div class="fdx-popup"><table class="widefat"><thead><tr><th><strong>';
//-----------------------------------------

if ($target == 'install_file_check'){
echo __('Check if \'<em>install.php</em>\' file is accessible via HTTP on the default location.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Once you install WP this file becomes useless and there\'s no reason to keep it in the default location and accessible via HTTP.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>' .sprintf(__('This is a very easy problem to solve. Rename <code>install.php</code> (you\'ll find it in the wp-admin folder) to something more unique like <code>install-%s.php"</code>; delete it; move it to another location or chmod it so it\'s not accessible via HTTP.', $this->hook), rand() ) . '</p>';

} elseif ($target == 'upgrade_file_check'){
echo __('Check if \'<em>upgrade.php</em>\' file is accessible via HTTP on the default location.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Besides the security issue it\'s never a good idea to let people run any database upgrade scripts without your knowledge. This is a useful file but it should not be accessible on the default location.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>' .sprintf(__('This is a very easy problem to solve. Rename <code>upgrade.php</code> (you\'ll find it in the wp-admin folder) to something more unique like <code>upgrade-%s.php"</code>; move it to another location or chmod it so it\'s not accessible via HTTP. <br/>Don\'t delete it! You may need it later on.', $this->hook), rand() ) . '</p>';

} elseif ($target == 'db_password_check'){
echo __('Test the strength of WordPress database password.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo __('Although most servers are configured so that the database can\'t be accessed from other hosts that doesn\'t mean your database passsword should be \'12345\'. Choose a proper password, at least 8 characters long with a combination of letters, numbers and special characters.', $this->hook);
echo '</tr><tr class="alternate"><td><p>' .__('To change the database password open cPanel, Plesk or some other hosting control panel you have. Find the option to change the database password and be sure you make the new password strong enough. After the password is changed open <code>wp-config.php</code> and change the password.', $this->hook) . '</p>';
echo '<pre class="fdx_snippet">
/** MySQL database password */
define(\'DB_PASSWORD\', \'YOUR_NEW_DB_PASSWORD_GOES_HERE\');
</pre>';

} elseif ($target == 'salt_keys_check'){
echo __('Check if all security keys and salts have proper values.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Security keys are used to ensure better encryption of information stored in the user\'s cookies and hashed passwords. You don\'t have to remember these keys. In fact once you set them you\'ll never see them again. Therefore there\'s no excuse for not setting them properly.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td><p>' . sprintf( __('Security keys (there are eight) are defined in <code>wp-config.php</code>. They should be as unique and as long as possible. WordPress made a <a href="%s" target="_blank"><strong>Script</strong></a> which helps you generate those strings. Please use it! After the script generates strings those 8 lines of code should look something like this:', $this->hook), 'https://api.wordpress.org/secret-key/1.1/salt/' ) . '</p>';
echo '<pre class="fdx_snippet">
define(\'AUTH_KEY\',         \')k#we,!+j[N2^,El,FA$10]cW6o N+ssS:_/Tz)}j^n|NcXfBlYA7Z`\');
define(\'SECURE_AUTH_KEY\',  \'rMIpsab s+};(Q]d2,Z(0]cW6o N+ssS:#Eb8c_-mk8HYx=+kxSF]T`\');
define(\'LOGGED_IN_KEY\',    \'%F:n[-Sxy-D0]cW6o N+ssS0]cW6o N+ssS::$1ni]-Nic}EfaY0=+5\');
define(\'NONCE_KEY\',        \'7R+wxWgb4;eJz&mm8(4m0]cW6o N+ssS:!P|x3/y)E{ve24~A--xgVX\');
define(\'AUTH_SALT\',        \'%23bpPY2;/^(D6pRMnU0]cW6o N+ssS:~+5I`]#8}+H,MH[O6I`=Q:#\');
define(\'SECURE_AUTH_SALT\', \'YIg7KE_WLitb+E&HSx90]cW6o N+ssS:4 %D6A wf)n2}&%o2sDQs;R\');
define(\'LOGGED_IN_SALT\',   \'*T-::}g6O0_DR62JXyfq0]cW6o N+ssS:,_2++hY Y[KXwK,iu#-eh>\');
define(\'NONCE_SALT\',       \'-Lp~dMDK#v(-_w#?ps0]cW6o N+ssS:L{9Ffk&x:zMg:p=R ueshS*!\');
</pre>';

} elseif ($target == 'db_table_prefix_check'){
echo __('Check if table prefix is the default one \'<em>wp_</em>\'.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Knowing the names of your database tables can help an attacker dump the table\'s data and get to sensitive information like password hashes. Since WP table names are predefined the only way you can change table names is by using a unique prefix. One that\'s different from <code>wp_</code> or any similar variation such as <code>wordpress_</code>.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>';
echo '<p>' .__('If you\'re doing a fresh installation defining a unique table prefix is easy. Open <code>wp-config.php</code> where the table prefix is defined. Enter something unique like <code>afx33_</code> and install WP.', $this->hook) . '</p>';
echo '<p>' .sprintf(__('If you already have WP site running and want to change the table prefix things are a bit more complicated and you should only do the change if you\'re comfortable doing some changes to your DB data via phpMyAdmin or a similar GUI. Detailed instruction can be found on <a href="%s"><strong>here!</strong></a>', $this->hook), __('http://tdot-blog.com/wordpress/6-simple-steps-to-change-your-table-prefix-in-wordpress', $this->hook) ) . '</p>';
echo '<p>' .__('<strong>Remember</strong> - always backup your files and database before making any changes to the database!', $this->hook) . '</p>';

} elseif ($target == 'debug_check'){
echo __('Check if general debug mode is enabled.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Having any kind of debug mode (general WP debug mode in this case) or error reporting mode enabled on a production server is extremely bad. Not only will it slow down your site, confuse your visitors with weird messages it will also give the potential attacker valuable information about your system.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>';
echo '<p>' .__('General WordPress debugging mode is enabled/disabled by a constant defined in <code>wp-config.php</code>, open that file and to disable debugging:', $this->hook) . '</p>';
echo '<pre class="fdx_snippet">
define(\'WP_DEBUG\', false);
</pre>';
echo '<p>' .__('If your blog still fails on this test after you made the changes it means some plugin is enabling debug mode. Disable plugins one by one to find out which one is doing it.', $this->hook) . '</p>';

} elseif ($target == 'blog_site_url_check'){
echo __('Check if WordPress installation address is the same as the site address.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Moving WP core files to any non-standard folder will make your site less vulnerable to automated attacks. Most scripts that script kiddies use rely on default file paths. If your blog is setup on <code>"www.site.com"</code> you can put WP files in ie: <code>"www.site.com/wp-core/"</code>', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>' .sprintf(__('Site and WP address can easily be changed in Options - General. Before doing so please look this <a href="%s"><strong>detailed tutorial</strong></a> which describes what other steps are necessary to move your WP core files to another location', $this->hook), __('http://www.youtube.com/watch?v=PFfvBJVtzqA', $this->hook) ) . '</p>';

} elseif ($target == 'uploads_browsable'){
$upload_dir = wp_upload_dir();
echo __('Check if uploads folder is browsable by browsers.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Allowing anyone to view all files in the uploads folder just by point the brower to it will allow them to easily download all your uploaded files.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td><p>' .__('To fix the problem open <code>.htaccess</code> and add this directive into it:', $this->hook).'</p>';
echo '<pre class="fdx_snippet">
Options -Indexes
</pre>';
echo  '<p>' .sprintf(__('Your uploads folder: <a href="%1s"><strong>%2s</strong></a> ', $this->hook), $upload_dir['baseurl'], $upload_dir['baseurl']  ).'<p>';

} elseif ($target == 'file_editor'){
echo __('Check if plugins/themes file editor is enabled.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Plugins and themes file editor is a very convenient tool because it enables you to make quick changes without the need to use FTP. Unfortunately it\'s also a security issue because it not only shows PHP source but it also enables the attacker to inject malicious code in your site if he manages to gain access to the admin.', $this->hook) . '</p>';
echo '</strong></th></tr></thead><tbody><tr class="alternate"><td>';
echo '<p>' .__('Editor can easily be disabled by placing the following code in <code>wp-config.php</code> file.', $this->hook) . '</p>';
echo '<pre class="fdx_snippet">
define(\'DISALLOW_FILE_EDIT\', true);
</pre>';

} elseif ($target == 'user_exists'){
echo __('Check if user with username <em>"admin"</em> exists.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('If someone tries to guess your username and password or tries a brute-force attack they\'ll most probably start with username <code>\'admin\'</code>. This is the default username used by too many sites and should be removed.', $this->hook) . '</p>';
echo '</strong></th></tr></thead><tbody><tr class="alternate"><td>';
echo '<p>' .__('Create a new user and assign him the \'administrator\' role. Try not to use usernames like: <code>root</code>, <code>god</code>, <code>null</code> or similar ones. Once you have the new user created delete the <code>admin</code> one and assign all post/pages he may have created to the new user.', $this->hook) . '</p>';

} elseif ($target == 'id1_user_check'){
echo __('Test if user with <em> "ID=1" </em> is administrator.', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Although technically not a security issue having a user (which is in 99% cases an admin) with the <em> "ID=1" </em> can help an attacker in some circumstances.', $this->hook) . '</p>';
echo '</strong></th></tr></thead><tbody><tr class="alternate"><td>';
echo '<p>' .__('Fixing is easy; create a new user with the same privileges. Then delete the old one with <em> "ID=1" </em> and tell WP to transfer all of his content to the new user.', $this->hook) . '</p>';

//php info
} elseif ($target == 'php'){
echo __('Dangerous PHP Functions', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('When the PHP code is used in an improper way or any insecure php code, potentially it can messed up with a web hosting server and can simply be hacked by hackers. Insecure PHP code can literally harm your server data at the level you cannot even imagine it.', $this->hook) . '</p>';
echo '<p>' .__('Using the insecure PHP code, as a security hole hackers could enable some very dangerous and powerful PHP functions and can take control over your web hosting server. There are many such php function which should be disabled in the PHP configuration file. Let\'s check out the functions that should be disabled in the php configuration file right away on your web server.', $this->hook) . '</p>';

echo '</tr><tr class="alternate"><td>' .__('<em>disable_functions</em> is a directive used to disable the insecure php functions. Once you find the <em>disable_functions</em> directive in the configuration file <code>php.ini</code> and add the following string to the line starting with:', $this->hook) .'</p>';
echo '<pre class="fdx_snippet">
disable_functions = system,exec,passthru,shell_exec,proc_open
</pre>';
echo '<br/><p><strong>'.__('A more paranoid list of dangerous functions', $this->hook) . ':</strong></p>';
echo '<p><em><strong>disable_functions</strong></em> <code>=</code> apache_child_terminate, apache_setenv, define_syslog_variables, escapeshellarg, escapeshellcmd, eval, exec, fp, fput, ftp_connect, ftp_exec, ftp_get, ftp_login, ftp_nb_fput, ftp_put, ftp_raw, ftp_rawlist, highlight_file, ini_alter, ini_get_all, ini_restore, inject_code, mysql_pconnect, openlog, passthru, php_uname, phpAds_remoteInfo, phpAds_XmlRpc, phpAds_xmlrpcDecode, phpAds_xmlrpcEncode, popen, posix_getpwuid, posix_kill, posix_mkfifo, posix_setpgid, posix_setsid, posix_setuid, posix_setuid, posix_uname, proc_close, proc_get_status, proc_nice, proc_open, proc_terminate, shell_exec, syslog, system, xmlrpc_entity_decode</p>';

} elseif ($target == 'php2'){
echo 'PHP: <em>"allow_url_fopen"</em> - <em>"allow_url_include"</em>';
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('The PHP settings <em>allow_url_fopen</em> and <em>allow_url_include</em> allow the abuse of insecurely coded code within your WordPress setup and have been the cause for many hacked websites in the past.', $this->hook) . '</p>';
echo '<p>' .__('Having this PHP directive will leave your site exposed to cross-site attacks (XSS). There\'s absolutely no valid reason to enable this directive and using any PHP code that requires it is very risky.', $this->hook) . '</p>';

echo '</tr><tr class="alternate"><td>' .__('Once you find the directive in the configuration file <code>php.ini</code>, disable both settings.', $this->hook) .'</p>';
echo '<pre class="fdx_snippet">
allow_url_include = off
allow_url_fopen = off
</pre>';

} elseif ($target == 'chmod'){
echo __('File Permissions - chmod', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';
echo '<p>' .__('Some neat features of WordPress come from allowing various files to be writable by the web server. However, allowing write access to your files is potentially dangerous, particularly in a shared hosting environment.', $this->hook) . '</p>';
echo '<p>' .__('It is best to lock down your file permissions as much as possible and to loosen those restrictions on the occasions that you need to allow write access, or to create specific folders with less restrictions for the purpose of doing things like uploading files.', $this->hook) . '</p>';
echo '</tr><tr class="alternate"><td>';
echo '<p>' .sprintf(__('Information on file permissions in WordPress and different ways of how to change permissions can be found <a href="%s"><strong>here!</strong></a>', $this->hook), 'http://codex.wordpress.org/Changing_File_Permissions' ) . '</p>';


//table-info
} elseif ($target == 'tableinfo'){
 //datbase table
function fdx_format_size($rawSize) {
		if($rawSize / 1073741824 > 1)
			return number_format_i18n($rawSize/1048576, 1) . ' GB';
		else if ($rawSize / 1048576 > 1)
			return number_format_i18n($rawSize/1048576, 1) . ' MB';
		else if ($rawSize / 1024 > 1)
			return number_format_i18n($rawSize/1024, 1) . ' KB';
		else
			return number_format_i18n($rawSize, 0) . ' bytes';
	}
   global $wpdb;
        $prefix = $wpdb->prefix;
     	echo 'N&deg;</strong></th><th>Tables</th><th>Records</th><th>Data Usage</th><th>Index Usage</th><th>Overhead</th>';
    	echo '</tr></thead>';
    	$tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");
     	foreach($tablesstatus as  $tablestatus) {
    	if(@$no%2 == 0) {
        $style = '';
         } else {
   	 	$style = 'alternate';
 		}
		@$no++;
        if(in_array($tablestatus->Name, [$prefix."commentmeta",$prefix."comments",$prefix."links",$prefix."options",$prefix."postmeta",$prefix."posts",$prefix."terms",$prefix."term_relationships",$prefix."term_taxonomy",$prefix."usermeta",$prefix."users"])){
        $style2 = ' wptabledefault';
        } elseif (in_array($tablestatus->Name, [$prefix."total_security_log"])){
        $style2 = 'wptabledefault2';
        } else {
        $style2 = '';
        }
		echo "<tr class=\"$style\">\n";
		echo '<td>'.number_format_i18n($no).'</td>'."\n";
		echo "<td class=\"$style2\">$tablestatus->Name</td>\n";
 		echo '<td>'.number_format_i18n($tablestatus->Rows).'</td>'."\n";
		echo '<td>'.fdx_format_size($tablestatus->Data_length).'</td>'."\n";
		echo '<td>'.fdx_format_size($tablestatus->Index_length).'</td>'."\n";;
		echo '<td>'.fdx_format_size($tablestatus->Data_free).'</td>'."\n";
		@$row_usage += $tablestatus->Rows;
		@$data_usage += $tablestatus->Data_length;
		@$index_usage +=  $tablestatus->Index_length;
		@$overhead_usage += $tablestatus->Data_free;
		echo '</tr>'."\n";
	}
	echo '<tr class="thead">'."\n";
	echo '<th>&nbsp;</th>'."\n";
	echo '<th>&nbsp;</th>'."\n";
	echo '<th>'.number_format_i18n($row_usage).'</th>'."\n";
	echo '<th>'.fdx_format_size($data_usage).'</th>'."\n";
	echo '<th>'.fdx_format_size($index_usage).'</th>'."\n";
	echo '<th>'.fdx_format_size($overhead_usage).'</th>'."\n";

//debug
} elseif ($target == 'debug'){
global $wpdb;
echo '<div align="center"><a class="button button-primary" href="javascript:selectcopy(\'test.select1\')">'. __('Select All', $this->hook).' </a></div></th></tr></thead><tbody><tr><td class="alternate">';
echo '<form name="test">';
echo '<div align="center"><textarea readonly="readonly" style="width:100%; height:350px; overflow: auto;white-space: pre; font-size:11px" name="select1">';
?>
SITE_URL: <?php echo site_url() . "\n"; ?>
PLUGIN_URL: <?php echo plugins_url() . "\n"; ?>

HTTP_HOST: <?php echo $_SERVER['HTTP_HOST'] . "\n"; ?>
SERVER_PORT: <?php echo isset( $_SERVER['SERVER_PORT'] ) ? 'On (' . $_SERVER['SERVER_PORT'] . ')' : 'N/A'; echo "\n"; ?>
HTTP_X_FORWARDED_PROTO: <?php echo isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ? 'On (' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . ')' : 'N/A'; echo "\n"; ?>

MULTI-SITE: <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>
WORDPRESS VERSION: <?php echo get_bloginfo( 'version' ) . "\n"; ?>

PHP VERSION: <?php echo PHP_VERSION . "\n"; ?>
MYSQL VERSION: <?php echo $wpdb->db_version(). "\n"; ?>
WEB SERVER INFO: <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>

SESSION: <?php echo isset( $_SESSION ) ? 'Enabled' : 'Disabled'; echo "\n"; ?>
SESSION:NAME: <?php echo esc_html( ini_get( 'session.name' ) ); echo "\n"; ?>

COOKIE PATH: <?php echo esc_html( ini_get( 'session.cookie_path' ) ); echo "\n"; ?>
SAVE PATH: <?php echo esc_html( ini_get( 'session.save_path' ) ); echo "\n"; ?>
USE COOKIES: <?php echo ini_get( 'session.use_cookies' ) ? 'On' : 'Off'; echo "\n"; ?>
USE ONLY COOKIES: <?php echo ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off'; echo "\n"; ?>

PHP/CURL: <?php echo function_exists( 'curl_init'   ) ? "Supported" : "Not supported"; echo "\n"; ?>
<?php if( function_exists( 'curl_init' ) ): ?>
PHP/CURL/VER: <?php $v = curl_version(); echo $v['version']; echo "\n"; ?>
PHP/CURL/SSL: <?php $v = curl_version(); echo $v['ssl_version']; echo "\n"; ?><?php endif; ?>
PHP/FSOCKOPEN: <?php echo function_exists( 'fsockopen'   ) ? "Supported" : "Not supported"; echo "\n"; ?>
PHP/JSON: <?php echo function_exists( 'json_decode' ) ? "Supported" : "Not supported"; echo "\n"; ?>

USER AGENT: <?php echo esc_html($_SERVER['HTTP_USER_AGENT']); echo "\n"; ?>
LANGUAGE / CHARSET: <?php echo get_bloginfo('language'). ' / ' . get_bloginfo('charset'); echo "\n"; ?>
CURRENT THEME: <?php
if ( get_bloginfo( 'version' ) < '3.4' ) {
	$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
	echo $theme_data['Name'] . ': ' . $theme_data['Version'];
} else {
	$theme_data = wp_get_theme();
	echo $theme_data->Name . ': ' . $theme_data->Version;
}
echo "\n". '------------------------PLUGINS---------------------------'. "\n";
foreach (get_plugins() as $key => $plugin) {
    $isactive = "";
    if (is_plugin_active($key)) {
        $isactive = "(active)";
    }
    echo $plugin['Name'].' '.$plugin['Version'].' '.$isactive."\n";
}
//.htaccess
echo "\n". '---------------------.htaccess file------------------------';
$FDX_orig_path = ABSPATH.'./.htaccess';
      if(!file_exists($FDX_orig_path))
       {
       echo '.htaccess file does not exists!';
       } else {
              if(!is_readable($FDX_orig_path))
              {
              echo '.htaccess file cannot read!';
              } else {
              $FDX_htaccess_content = @file_get_contents($FDX_orig_path, false, NULL);
              echo $FDX_htaccess_content;
              }
       }
echo '</textarea></div></form>';
//-----------------------------------------
} elseif ($target == 'debug_log'){
echo __('Debug Mode', $this->hook);
echo '</strong></th></tr></thead><tbody><tr><td>';?>

<pre class="fdx_snippet">
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);
</pre>
<p><strong>WP_DEBUG </strong><br>
<?php _e('This is the most important constant as it determines if WordPress will use any of the other debugging constants. Thankfully it is quite simple. If set to true, debug mode is turned on. If undefined or set to false, debug mode is kept off.', $this->hook); ?>
</p>

<p><strong>WP_DEBUG_LOG</strong><br>
<?php _e('Set this constant to true and WordPress will set up PHP to write to an error log in', $this->hook); ?> <em>/wp-content/debug.log</em>.
</p>
<p><strong>WP_DEBUG_DISPLAY</strong><br>
<?php _e('Turn off the display of error messages on your site. ', $this->hook); ?>
</p>

<p><strong>display_errors</strong><br>
<?php _e('The last line in our code block turns off the display of errors, regardless of <em>php.ini</em> or <em>.htaccess</em> settings to the contrary. This is important because though WordPress can force the display of errors to be on, it won\'t force them to be off if <em>display_errors</em> is already turned on.', $this->hook); ?>
</p>

<?php
}//end
echo '</td></tr></tbody></table></div>';
echo '<script type="text/javascript">jQuery(document).ready(function($) {$("pre.fdx_snippet").snippet("php",{style:"acid",transparent:false,showNum:false,menu:false});});</script>';
