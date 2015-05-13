<div id="wrapper">
<?php 
	if( ( strlen( $common->get_session( 'username' ) ) != 0 ) && ( strlen( $common->get_session( 'user_id' ) ) ) != 0 )
	{
		$html->show_header();
		$html->show_home_page();	
	}
	else
	{
		// echo( "user not logged in" );
		$html->show_login_register_btn();
		$html->show_login_register();
	}
?>
</div>


