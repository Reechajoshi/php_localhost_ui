<?php 
	class users {
		function __construct() {
		}
		
		function validate_user_add( $username, $password ) {
			if( strlen( $username ) == 0 )
			{
				error_log( "Please provide username" );
			}
			else if( strlen( $password ) == 0 )
			{
				error_log( "Please provide password" );
			}
			else
			{
				$this->add_user( $username, $password );
			}
		}
	
		function get_user_count( $where_clause = "" )
		{
			GLOBAL $TABLE, $hlp;
			// To Get Count: 
			$cnt = $hlp->_db->get_count( $TABLE[ 'users' ], $where_clause );
			return $cnt;
		}
	
		function get_users( $where_clause = "" )
		{
			GLOBAL $TABLE, $hlp;
			// get rows 
			$rows = $hlp->_db->get_rows( $TABLE['users'], array('user_id','username'), " where username like '%%'" );
			$rows = $hlp->_db->get_rows( $TABLE['users'] );
			return $rows;
		}

		function add_user( $username, $password )
		{		
			GLOBAL $TABLE, $hlp;
						
			// To Add User: 
			$userid = $hlp->_db->get_uniq_id();
			$arr_cols = array( 'user_id', 'username', 'password' );
			$arr_vals = array( $userid, $username, md5( $password ) );
			return $hlp->_db->insert_query( $TABLE['users'], $arr_cols, $arr_vals ) ;
		}
		
		function check_user_exists( $username )
		{
			$users_arr = $this->get_users();

			foreach( $users_arr as $user_details )
			{
				if( $user_details[ 'username' ] == trim( $username ) )
				{
					return true;
				}
			}
			return false;
		}	
	
	}
	
?>
