<?php 
	class common {
		function __construct() {	
			
		}
		
		/** SESSION FUNCTIONS **/

		function set_session( $key, $value ) {
			GLOBAL $_SESSION;
			$_SESSION[$key] = $value;
		}
		
		function get_session( $key, $default = "" ) {
			return ( ( isset( $_SESSION[ $key ] ) ) ? ( $_SESSION[ $key ] ) : ( $default ) );
		}
	
		function unset_session( $key ) {
			unset( $_SESSION[ $key ] );
		}

		/** DIRECTORY FUNCTIONS **/
		function get_directories( $parent_dir = null ) {
			$dir_list_arr = array();
			$dir_root = ( $parent_dir ) ? ( $parent_dir ) : ( $_SERVER[ 'DOCUMENT_ROOT' ] );	
			
			$dir_root .= ( substr( $dir_root, -1 ) == '/' ) ? ( '' ) : ( '/' );
			
			if( is_dir( $dir_root ) )	
			{
				$dir_list = glob( $dir_root."*" );
			}

			foreach( $dir_list as $dir )	
			{
				if( is_dir( $dir ) )
				{
					$dir_list_arr[]['d'] = $dir;
				}
				else
				{
					$dir_list_arr[]['f'] = $dir;
				}
			}

			return $dir_list_arr;
		}
		
		function get_file_name_from_dir( $dir_path ) {
			$dir_arr = explode( "/", $dir_path );
			$dir_arr_cnt = count( $dir_arr );
			return $dir_arr[ $dir_arr_cnt - 1 ];
		}

		function get_size( $file_path ) {
			if( is_dir( $file_path ) )
			{
			//	$output = `du -s $file_path`;
			//	if( preg_match('/([0-9]+)(t.*)/',$output,$match) )
			//	{
			//		$size = $match[1];
			//	}

				$output = exec('du -sk ' . $file_path );
				$filesize = trim(str_replace($file_path , '', $output)) * 1024;
			}
			else
			{
				$filesize = filesize( $file_path );	
			}

			return $filesize;
		}

		function get_file_contents( $file_path ) {
			if( file_exists( $file_path ) )
			{
				$file_contents = file_get_contents( $file_path );	
				return $file_contents;
			}
			else
				return "File Could not be displayed";
		}
		
	}
?>
