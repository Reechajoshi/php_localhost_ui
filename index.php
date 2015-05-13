<?php 

session_start();

require('lib/config/vars.php'); 
require('lib/helper/common.php'); 
require('lib/helper/users.php'); 
require('lib/helper/helper.php'); 
require('lib/helper/html.php'); 


$hlp = new helper();
$common = new common();
$users = new users(); 
$html = new html(); 

?>

<html>
<?php require('lib/include/head.php'); ?>
<body>
<?php require('lib/include/main_content.php'); ?>

<?php
	
//	if( !empty( $_SESSION ) )
//	{
//		error_log( "index.php called=========" );
//		error_log( print_r( $_SESSION, true ) );
//	}
//	else
//	{
//		error_log( "session not set" );
//	}
?>

</body>
</html>
