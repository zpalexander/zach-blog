<?php
class FDX_CLASS_P7 extends Total_Security {
 	public static $file_log;
	public static $current_log;
	public function __construct() {

		self::$file_log = ini_get( 'error_log' );

		$this->fdx_clear_log();

		if ( file_exists( self::$file_log ) && is_readable( self::$file_log ) ) {
			self::$current_log = file( self::$file_log, FILE_IGNORE_NEW_LINES );
			self::$current_log = array_reverse( self::$current_log, true );
			}
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
        add_action( 'admin_bar_menu', array( $this, 'admin_bar_item' ), 99 );
	}

//-------------------------------------------
	public function admin_bar_item( $admin_bar ) {
			$num = $this->count_errors();
            $style = 'margin: 0;padding: 0 7px 0 7px;font-weight: bold !important; background-color: #ff8922 !important;background-image: -moz-linear-gradient(bottom, #ee6f00, #ff8922) !important;background-image: -webkit-gradient(linear, left bottom, left top, from(#ee6f00), to(#ff8922)) !important;';
            $title = '<div style="'.$style.'">'.$num.'</div>';
			if ( $num > 0) {
				$admin_bar->add_node( array(
					'id'		=>	'fdx-adm-debug',
					'title'		=>	$title,
					'href'		=>	admin_url( 'admin.php?page='.$this->hook . '-'.$this->_p7),
					'meta'		=>	array('title'		=>	__( 'View Log', 'wpvllang' ),
                                          'target'	=>	'')
					)
				);
			}
	}


//-------------------------------------------
	public static function count_errors() {
		$count_errors = 0;
		if ( is_array( self::$current_log ) && ! empty( self::$current_log ) ) {
			$i = 1;
			foreach ( self::$current_log as $line ) {
				if ( strpos( $line, date( 'd-M-Y' ) ) !== false ) {
					$errors[] = $i;
					$i++;
				}
			}
			if ( isset( $errors ) )
				$count_errors = count( $errors );
		}
		return $count_errors;
	}
//-------------------------------------------
	public function fdx_clear_log() {
		if ( isset( $_POST['fdx-clear-log'] ) ) {
			$clear = fopen( self::$file_log, 'w' );
			fclose( $clear );
			// Update self::$file_log
			self::$file_log = ini_get( 'error_log' );
			add_action( 'admin_notices', array( $this, 'fdx_notice_clear_log' ) );
		}
	}

//-------------------------------------------
	public function fdx_notice_clear_log() {
		echo '<div class="box-shortcode box-green"><strong>' . __( 'All logs were Deleted', $this->hook ) . '!</strong></div>';
	}

//-------------------------------------------
} //class
