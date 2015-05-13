<?php
	require('db.php');
	class helper {
		var $_db = null;
		
		function __construct() {
			GLOBAL $DB_NAME, $DB_PASSWORD, $DB_USER;
			$this->_db = new db('localhost', $DB_USER, $DB_NAME, $DB_PASSWORD);		
			// $this->_db = new db('localhost');
		}

		function test() {
			echo ("test works");
		}

		function validate_login( $username, $password )
		{
			GLOBAL $common, $users; 
			if( strlen( $username ) == 0 )			
			{
				error_log( "Please provide Username" );
			}
			else if( strlen( $password ) == 0 )
			{
				error_log( "Please provide Password" );
			}
			else if( $users->check_user_exists( $username ) ) // validation done again just in case js ajax call failes
			{
				return $this->login( $username, $password );	
			}
		}
		
		function login( $username, $password )
		{
			GLOBAL $TABLE, $common, $users;
			$users_arr = $users->get_users();
			$query = "SELECT * FROM users WHERE username='".$username."' and password='".md5($password)."';";

			$where_clause = " WHERE username='".$username."' and password='".md5($password)."';";
				
			if( $this->_db->get_count( $TABLE['users'], $where_clause ) == 1 )
			{
				error_log( "login successful!!" );
				$this->set_login_data($username);	
				return true;
			}
			else
			{
				error_log( "login failed!!" );
				return false;
			}
		}
	
		function set_login_data( $username ) {
			GLOBAL $common, $users, $USERNAME, $USERID;
			$user_details = $users->get_users( " where username = '".$username."'" );
			$common->set_session( 'username', $username );
			$common->set_session( 'user_id', $user_details[0]['user_id'] );
			$USERNAME = $username;
			$USERID = $user_details[0]['user_id'];
		}

		function validate_register( $username, $password ) {
			GLOBAL $common, $users;
			if( strlen( $username ) == 0 )			
			{
				error_log( "Please provide Username" );
			}
			else if( strlen( $password ) == 0 )
			{
				error_log( "Please provide Password" );
			}
			else if( $users->check_user_exists( $username ) == false ) // if user doesnot exist only then register
			{
				error_log( "Calling register user method" );
				return $this->register( $username, $password );	
			}
	
		}

		function register( $username, $password ) 
		{
			GLOBAL $TABLE, $common, $users;
			// echo( ( $users->add_user( $username, $password ) ) ? ( "1" ) : ( "0" ) );
			return $users->add_user( $username, $password );
		}
		
		function destroy_session() 
		{
			session_unset(); 
			session_destroy(); 
		}
		
		/* function display_main_content( $file_loc = null ) {
			GLOBAL $common, $DIR_FILE_ARR;
			$dirs = $common->get_directories( $file_loc );
						
			echo( '<div id="dir_list_main_content">
					<div id="dir_list_tbl_header">
						<span> You are here: </span>
						<span id="current_path"></span>
					</div>' );

			echo( '<div id="dir_list_tbl_content">' ); // display table
			echo( '<div id="dir_list_tbl_row">' ); // display table row
			echo( '<div id="dir_list_tbl_head">Name</div>' ); // display table cell
			echo( '<div id="dir_list_tbl_head">Last Modified</div>' );
			echo( '<div id="dir_list_tbl_head">Size</div>' );
			echo( '<div id="dir_list_tbl_head">Description</div>' );
			echo( '<div id="dir_list_tbl_head">Type</div>' );
			echo( '</div>' ); // display table row end
			
			foreach( $dirs as $directory )
			{
				$key = key( $directory );
				$dir_name = $common->get_file_name_from_dir( $directory[ $key ] );
				$last_modified = date ("F d Y H:i:s", filemtime( $directory[ $key ] ) );
				$file_size = $common->get_size( $directory[ $key ] );
				echo( '<div id="dir_list_tbl_row">' ); // display table row
				echo( '<div class="dir_list_tbl_cont"><a href="#" onclick="enter_dir(\''.$directory[ $key ].'\'); return false;" >'.$dir_name.'</a></div>' );
				echo( '<div class="dir_list_tbl_cont">'.$last_modified.'</div>' ); // display table cell
				echo( '<div class="dir_list_tbl_cont">'.$file_size.'</div>' ); // display table cell
				echo( '<div class="dir_list_tbl_cont">'.$directory[ $key ].'</div>' ); // display table cell
				echo( '<div class="dir_list_tbl_cont">'.$DIR_FILE_ARR[ $key ].'</div>' ); // display table cell
				echo( '</div>' );
			}			
			
			echo( '</div>' ); // display table end
		
			echo('</div>' ); // directory main list content end
		} */
	
		function get_directory_details( $dir_path = null ) {
			GLOBAL $common;
			$dirs = $common->get_directories( $dir_path );
			$dir_details = array();
			foreach( $dirs as $directory )
			{
				$key = key( $directory );	

				$dir_details[] = array(
					'type' => key( $directory ),
					'dir_name' => $common->get_file_name_from_dir( $directory[ $key ] ),
					'last_modified' => date ("F d Y H:i:s", filemtime( $directory[ $key ] ) ),
					'file_size' => $common->get_size( $directory[ $key ] ),
					'full_path' => $directory[ $key ],
				);
			}
			
			return $dir_details;
		}
			
	}
	
?>
