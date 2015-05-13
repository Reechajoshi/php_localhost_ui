<?php
	
	class db {
		var $conn = null;
		var $is_connected = null;
		
		function __construct($server_name, $db_user, $db_name, $db_password) {
			try {
				$this->conn = new PDO('mysql:host='.$server_name.';dbname='.$db_name, $db_user, $db_password);
			   	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->is_connected = true;
			   
			} catch(PDOException $e) {
				$this->is_connected = false;
				echo 'ERROR: ' . $e->getMesage();
			}
		}

		function get_uniq_id($string="") {
		//	if( strlen( $salt ) = 0 )
		//	{
		//		return( uniqid( $salt ) );
		//	}
		//	else
		//		return( uniqid() );
			return md5( uniqid( $string ) ); 
		}	

		function insert_query( $table_name, $cols, $vals ) {
			if( $this->is_connected )	
			{
				$val_count = count( $vals );
				// create query array
				$val_arr = array_fill( 0, $val_count, "?" );
				
				$cols_query = "( ".implode(",", $cols)." )";
				$vals_query = "( ".implode(",", $val_arr)." )";
				
				$query = "INSERT INTO ".$table_name." ".$cols_query." VALUES".$vals_query;
				
				$res = $this->conn->prepare($query);
				return $res->execute($vals);
			}
			else
				error_log( "Could not connect to DB" );
		}
	
		function get_count( $table_name, $where_clause = '' )
		{
			$sql = "SELECT count(*) FROM `$table_name` ".$where_clause;
			$result = $this->conn->prepare($sql); 
			$result->execute(); 
			return ( $result->fetchColumn() );
		}
		
		function get_rows( $table_name, $cols_arr=array(), $where_clause="" )
		{
			$result_set = array();
			if( !empty( $cols_arr ) )
				$cols_val = implode( ",", $cols_arr );
			else
				$cols_val = "*";

			$query = "SELECT $cols_val FROM $table_name ";

			if( strlen( $where_clause ) != 0 )
			{
				$query .= $where_clause;
			}
				
			foreach( $this->conn->query( $query ) as $row )
			{
				$result_set[] = $row;	
			}

			return $result_set;
		}
	}
?>
