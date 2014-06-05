<?php
class FDX_CLASS_P3 {
	var $results;

	function add_result( $level, $info ) {
		$this->results[$level][] = $info;
	}

	function store_results( $done = false ) {
		$stored = get_transient( 'fdx_results_trans' );

		if ( empty($this->results) ) {
			if ( $done )
				update_option( 'fdx_results', $stored );
			return;
		}

		if ( $stored && is_array($stored) )
			$this->results = array_merge_recursive( $stored, $this->results );

		if ( $done ) {
			update_option( 'fdx_results', $this->results );
			delete_transient( 'fdx_results_trans' );
		} else {
			set_transient( 'fdx_results_trans', $this->results );
		}
	}
}
/**
 * File Scanner. Scans all files in given path for suspicious text.
 */
class File_FDX_Scanner extends FDX_CLASS_P3 {
    var $path;
	var $start;
	var $max_batch_size;
	var $paged = true;
	var $files = array();
	var $modified_files = array();
	var $skip;
	var $complete = false;


	function __construct( $path, $args ) {
	  	$this->path = $path;

		if ( ! empty($args['max']) )
			$this->max_batch_size = $args['max'];
		else
			$this->paged = false;

		$this->start = $args['start'];
		$this->skip = ltrim( str_replace( array( untrailingslashit( ABSPATH ), '\\' ), array( '', '/' ), __FILE__ ), '/' );
	}

	function run() {
		$this->get_files( $this->start );
		$this->store_results();
		return $this->complete;
	}

	function get_files( $s ) {
	   global $wp_version;
   		if ( 0 == $s ) {
			unset( $filehashes ); // use hashes of WP version
         	$hashes = dirname(dirname(__FILE__)) . '/libs/hashes-'.$wp_version.'.php';
	 		include( $hashes );
  			$this->recurse_directory( $this->path );
  			foreach( $this->files as $k => $file ) {

//--------------------------------------------severe=03.core(php)
				if ( isset( $filehashes[$file] ) ) {
                    if ( $filehashes[$file] == md5_file( $this->path.'/'.$file ) ) {
						unset( $this->files[$k] );
						continue;
				   	}
				} else {
					list( $dir ) = explode( '/', $file );
					if ( $dir == 'wp-includes' || $dir == 'wp-admin') {
						$severity = substr( $file, -4 ) == '.php' ? '03' : '03';  //severe=03 warning=02 note=01
						$this->add_result( $severity, array(
							'loc' => $file,
   						) );
					}
				}
                // severe=02.xxx
				if ( substr( $file, -4 ) == '.exe' ||
                     substr( $file, -4 ) == '.bat' ||
                     substr( $file, -4 ) == '.com' ||
                     substr( $file, -4 ) == '.scr' ||
                     substr( $file, -4 ) == '.cpl' ||
                     substr( $file, -4 ) == '.msi')  {
					$this->add_result( '02', array(
						'loc' => $file,
					) );
                  // severe=02.xx
                } else if ( substr( $file, -3 ) == '.vb' ) {
					$this->add_result( '02', array(
						'loc' => $file,
					) );
                 // warning=01.xxx
                } else if ( substr( $file, -4 ) == '.rar' ||
                            substr( $file, -4 ) == '.zip' ||
                            substr( $file, -4 ) == '.tar' ||
                            substr( $file, -4 ) == '.bz2' ) {
					$this->add_result( '01', array(
						'loc' => $file,
					) );
                // warning=01.xx
               } else if ( substr( $file, -3 ) == '.7z' ||
                           substr( $file, -3 ) == '.gz' ) {
					$this->add_result( '01', array(
						'loc' => $file,
					) );
                // warning=00.xxx
               } else if ( substr( $file, -4 ) == '.log' ||
                           substr( $file, -4 ) == '.dat' ||
                           substr( $file, -4 ) == '.bin' ||
                           substr( $file, -4 ) == '.tmp' ) {
					$this->add_result( '00', array(
						'loc' => $file,
					) );
               //warning=00.xx
               } else if ( substr( $file, -3 ) == '.db') {
					$this->add_result( '00', array(
						'loc' => $file,
		  		) );

                } else if ( substr( $file, -4 ) == '')  {
                   $this->add_result( '44', array(
						'loc' => false,
                 	) );
               }

        	}
               //end
			$this->files = array_values( $this->files );
			$result = set_transient( 'fdx_files', $this->files, 3600 );

			if ( ! $result ) {
				$this->paged = false;
				$data = array( 'files' => esc_html( serialize( $this->files ) ) );
				if ( ! empty($GLOBALS['EZSQL_ERROR']) )
					$data['db_error'] = $GLOBALS['EZSQL_ERROR'];
				$this->complete = new WP_Error( 'failed_transient', '$this->files was not properly saved as a transient', $data );
			}
		} else {
			$this->files = get_transient( 'fdx_files' );
		}

		if ( ! is_array( $this->files ) ) {
			$data = array(
				'start' => $s,
				'files' => esc_html( serialize( $this->files ) ),
			);

			if ( ! empty( $GLOBALS['EZSQL_ERROR'] ) )
				$data['db_error'] = $GLOBALS['EZSQL_ERROR'];

			$this->complete = new WP_Error( 'no_files_array', '$this->files was not an array', $data );
			$this->files = array();
			return;
		}

		// use files list to get a batch if paged
		if ( $this->paged && (count($this->files) - $s) > $this->max_batch_size ) {
			$this->files = array_slice( $this->files, $s, $this->max_batch_size );
		} else {
			$this->files = array_slice( $this->files, $s );
			if ( ! is_wp_error( $this->complete ) )
				$this->complete = true;
		}
	}

	function recurse_directory( $dir ) {
		if ( $handle = @opendir( $dir ) ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				if ( $file != '.' && $file != '..' ) {
					$file = $dir . '/' . $file;
					if ( is_dir( $file ) ) {
						$this->recurse_directory( $file );
					} elseif ( is_file( $file ) ) {
						$this->files[] = str_replace( $this->path.'/', '', $file );
					}
				}
			}
			closedir( $handle );
		}
	}


	function replace( $matches ) {
		return '$#$#' . $matches[0] . '#$#$';
	}

}
/**
 * RunEnd
 */
class RunEnd extends FDX_CLASS_P3 {
	function RunEnd() {
	  $this->store_results(true);

      $time = time();
      update_option('p3_log_time', $time );
      }
}