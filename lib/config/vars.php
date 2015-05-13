<?php
	
	$DOCUMENT_ROOT = '/var/www/html/';	
	$SERVER_ROOT = 'localhost/';

	/** Get server information **/
	// $PROTOCOL = ( ( isset( $_SERVER[ 'HTTPS' ] ) ) ? ( 'https' ) : ( 'http' ) );	
	$PROTOCOL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']),array('off','no'))) ? 'https' : 'http';
	$HOST =  $_SERVER['HTTP_HOST']; 
	
	/** Retrive file names from the url **/
	$FILENAME = $_SERVER['PHP_SELF'];
	$FILENAME_ARR = explode( "/", $FILENAME );
	$URL_FILENAMES = array();
	
	foreach( $FILENAME_ARR as $FILE )
	{
		if( strlen( $FILE ) != 0 )
		{
			$URL_FILENAMES[] = $FILE;
		}
	}

	/** DB Variables **/	
	$DB_NAME = 'localhost_db';
	$DB_USER = 'localhost_db';
	$DB_PASSWORD = 'localhost_db';


	$TABLE = array();
	$TABLE['users'] = 'users';

	$DIR_FILE_ARR = array( "d" => "Directory", "f" => "File" );
?>
