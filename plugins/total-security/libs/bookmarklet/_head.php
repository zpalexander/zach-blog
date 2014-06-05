<?php
/*!
* Total Security Plugin
* http://fabrix.net/total-security/
*/

// load wp-load.php
require_once( dirname (dirname( dirname( dirname( dirname( __FILE__ ))))) . '/../wp-load.php' );

if (!class_exists('Total_Security')) {
echo '<div style="text-align: center; margin-top: 20px"><h1 style="color: #FF0000">ERROR</h1><h2>The Plugin <a href="http://fabrix.net/total-security/" target="_blank">Total Security</a> this Deactivated!</h2></div>';
die();
}
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" type="text/css" href="../../css/bookmarklet.css" media="screen" />
<style type="text/css">
div.loading-invisible{display:none;}
div.loading-visible{display:block;position:absolute;top:2px;left:0;width:100%;text-align:center;}
div.loading-visible p{ font-family: "Courier New", Courier, monospace; font-size: 12px; font-weight: bold; color: #C0C0C0;margin-top: 5px }
</style>