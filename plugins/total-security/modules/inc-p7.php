<?php
/* wrap
*********************************************************************************/
echo '<div class="wrap">';
echo '<h2>'. $this->pluginname . ' : ' . __('Log Viewer', $this->hook) . '</h2>';

/* poststuff and sidebar
*********************************************************************************/
echo '<div id="poststuff">';
//form
echo '<form method="post" action="">';
// postbox 1
?>

	<?php
		if ( empty( FDX_CLASS_P7::$current_log ) ) {
			$html = '';
		} else {
		    $html = '<pre>';
			$regex = '/(\]\\s(.*?)\:)/'; // capture name error
			$html .= '<table width="350" class="table_log">';
			$html .= '<tbody><tr>';
     		for ( $i=0; $i < count( FDX_CLASS_P7::$current_log ); $i++ ) {
				if ( strpos( FDX_CLASS_P7::$current_log[$i], date( 'd-M-Y' ) ) !== false ) {
					preg_match_all( $regex, FDX_CLASS_P7::$current_log[$i], $lines[$i] );
					$errors[] = $lines[$i][2][0];
				}
			}
			foreach ( array_count_values( $errors ) as $error => $num ) {
				$html .=  '<tr><td class="left-widget">' . $error . '</td><td class="right-widget">' . $num . '</td></tr>';
			}
			$html .= '</tbody></table>';
			$html .= '</pre>';
 		}
		$html .= '<div class="clear"></div>';
		// end div.wpvl-widget
		echo $html;


      // buttons
    $numErrors = FDX_CLASS_P7::count_errors();
echo '<div class="button_submit"><p>';
echo submit_button( __('Clear Log', $this->hook ).': '.$numErrors, 'secondary', 'fdx-clear-log', false, array( 'id' => 'fdx-clear-log' ) ) ;
echo '</p></div>';
echo '</form>'; //form 1
?>

<?php
		   $html = '<pre id="scrollable">';
				if ( is_array( FDX_CLASS_P7::$current_log ) && !empty( FDX_CLASS_P7::$current_log ) ) {
					$html .= '<table class="table_log">';
					$html .= '<tbody><tr><td>';
					for ( $i=1; $i <= count( FDX_CLASS_P7::$current_log ); $i++ ) {
						$html .= '<div>' . $i . '</div>';
					}
					$html .= '</td><td>';
					foreach ( FDX_CLASS_P7::$current_log as $line => $string ) {
                         if(preg_match("/PHP Fatal error:/", $string)) {
                         $style2 = 'fdx-colo0';
                         } elseif  (preg_match("/PHP Deprecated:/", $string)) {
                         $style2 = 'fdx-colo2';
                         } elseif  (preg_match("/PHP Warning:/", $string)) {
                         $style2 = 'fdx-colo3';
                         } elseif  (preg_match("/PHP Notice:/", $string)) {
                         $style2 = 'fdx-colo1';
                         } elseif  (preg_match("/PHP Strict Standards:/", $string)) {
                         $style2 = '';
                         } else {
                         $style2 = 'fdx-colo4';
                         }
 						$html .= '<div class="'.$style2.'">' .  $string  . '</div>';
					}
					$html .= '</td></tr></tbody></table>';
				} else {
					$html .= sprintf( __( '%1sWithout Error%2s','wpvllang' ), '<p class="str">','</p>' );
				}
		  $html .= '</pre>';

				echo $html;
?>



<div class="clear"></div>

<?php

// postbox-container | post-body | poststuff | wrap
echo '</div></div>';
//----------------------------------------- ?>
