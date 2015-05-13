<?php
	
	session_start();
	
	require('lib/config/vars.php'); 
	require('lib/helper/common.php'); 
	require('lib/helper/users.php');
	require( 'lib/helper/helper.php' );

	$hlp = new helper();
	$common = new common();
	$users = new users();

	// print_r( $_GET );
	// print_r( $_POST );
	
	if( isset( $_GET[ 'a' ] ) )
	{
		$action = $_GET[ 'a' ];
		if( $action == 'login' )
		{
			$username = $_POST[ 'username' ];
			$password = $_POST[ 'password' ];
			// echo( "Username: ".$username." , password: ".$password );
		//	if( $hlp->validate_login( $username, $password ) )
		//	{
		//		echo( "0" );
		//	}
		//	else
		//		echo( "1" );
			// $users->validate_user_add( $username, $password );
			echo( ( $hlp->validate_login( $username, $password ) ) ? ( "1" ) : ( "0" ) ); // echo 1 if login unsuccessfull. 1 if successful
		}
		else if( $action == 'register' )
		{
			$username = $_POST[ 'username' ];
			$password = $_POST[ 'password' ];

			$res = $hlp->validate_register( $username, $password );
			echo( ( $res == true ) ? ( "1" ) : ( "0" ) );	
		}
		else if( $action == 'check_user_exists' )
		{
			$username = $_POST[ 'username' ];
		//	if( $users->check_user_exists( $username ) )
		//	{	
		//		echo( "1" );
		//	}
		//	else
		//		echo( "0" );
			
			echo( ( $users->check_user_exists( $username ) ) ? ( "1" ) : ( "0" ) );
		//	echo( "Action: ".$action );
		}
		else if( $action == 'logout' )
		{
			$hlp->destroy_session();	
		}
		else if( $action == 'enter_dir' )
		{
			if( isset( $_POST[ 'dir_path' ] ) )
				$dir_path = $_POST[ 'dir_path' ];

			if( is_dir( $dir_path ) )
			{
				$dir_path = ( ( isset( $_POST[ 'dir_path' ] ) ) ? ( $_POST[ 'dir_path' ] ) : ( "" ) );
				// return array with name, last modified, size, description, type	
				$dir_list = $hlp->get_directory_details( $dir_path );

				$result = array( "type" => "dir", "content" => $dir_list );
				// echo ( json_encode( $dir_list ) );
			}
			else
			{
				$file_contents = $common->get_file_contents( $dir_path );	
				$file_type = mime_content_type($dir_path);

				$a = getimagesize($dir_path);
				$image_type = $a[2];

				if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
				{
					$result = array( "type" => "image", "content" => str_replace( $DOCUMENT_ROOT, "", $dir_path ) );
				}
				else
				{
					$result = array( "type" => "file", "content" => htmlspecialchars( $file_contents ) );
				}
				
			//	if( strpos( $file_type, 'image' ) === true )
			//	{
			//		error_log("Image file");
			//		// $result = array( "image" => $dir_path );
			//		$result = array( "type" => "image", "content" => $dir_path );
			//	}
			//	else
			//	{
			//		error_log( "File" );
			//		// $result = array( "file" => htmlspecialchars( $file_contents ) );	
			//		$result = array( "type" => "file", "content" => htmlspecialchars( $file_contents ) );
			//	}
				
				// echo( json_encode( $result ) );
			}

			echo( json_encode( $result ) );
		}
	}

?>
