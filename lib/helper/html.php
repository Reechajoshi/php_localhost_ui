<?php
	
	class html {
		function __constructor() {
			
		}

		function show_login_register() {

			// SHOW LOGIN BOX
			echo( '<div id="login_wrapper">
					<div id="login">
						<div id="login_box">
							<div class="login_field_container">
								<div class="login_field">Username: </div>
								<div class="login_field"><input name="login_username" id="login_username" value="" /></div>
							</div>
							<div class="login_field_container">
								<div class="login_field">Password: </div>
								<div class="login_field"><input type="password" name="login_password" id="login_password" value="" /></div>
							</div>
							<div class="login_field_container">
								<div class="login_field"><a href="#" onclick="validate_login_register(\'login\'); return false;">Login</a></div>
							</div>
						</div>
					</div>
				</div>
			' );
		
			// SHOW REGISTER BOX
			echo( '<div id="register_wrapper">
				<div id="register">
				<div id="register_box">
				<div class="register_field_container">
					<div class="register_field">Username: </div>
					<div class="register_field"><input type="text" name="register_username" id="register_username" /></div>
				</div>	
				<div class="register_field_container">
					<div class="register_field">Password:</div>
					<div class="register_field"> <input type="password" name="register_password" id="register_password" /></div>
				</div>
				<div class="register_field_container"> 
					<div class="register_field">Confirm Password: </div>
					<div class="register_field"><input type="password" name="register_confirm_password" id="register_confirm_password" /></div>
				</div>
				<div class="register_field_container">
					<div class="register_field"><a href="#" onclick="validate_login_register(\'register\'); return false;">Sign Up</a></div>
				</div>
			</div></div>' );

		}

		function show_login_register_btn() {
			
			// DISPLAYS LOGIN REGISTER BUTTONS
			echo( '<div id="login_register_container">
					<div id="login_container">
						<a href="#" onclick="show_login_register(\'login\'); return false;">Login</a>
					</div>
					<div id="register_container">
						<a href="#" onclick="show_login_register(\'register\'); return false;">Register</a>
					</div>
					<div class="clear"></div>
			</div>' );
		}

		function show_home_page() {
			GLOBAL $hlp;
			echo( '<div id="main_content">
				<div id="dir_list_header_container">
					<div id="dir_list_header">
						
					</div>
					<div id="dir_list_commands">
						<!-- <div id="add_dir">
							<a href="#" onclick="add_directory(); return false;">Add</a>
						</div>
						<div id="test_dir">
							<a href="#">test 2</a>
						</div> -->
					</div>
					<div class="clear"></div>
				</div>' );		
			
			// display_main_content();	
			$this->display_main_content();
			
			echo( '</div>' );
		}

		function display_main_content() {
			GLOBAL $common, $DIR_FILE_ARR, $hlp, $SERVER_ROOT;
			$dirs = $common->get_directories();
						
			echo( '<div id="dir_list_main_content">
					<div class="dir_list_tbl_header">
						<div id="curr_path_container">
							<span> You are here: </span>
							<span id="current_path">/</span>
						</div>
						<div id="back_btn_container">
							<a href="#" onclick="level_up_dir(\'/jobportal/js/localhost/myscripts/oftv3/old_index.html\'); return false;"> &lt; &lt; Back </a>
						</div>
						<div class="clear"></div>
					</div>' );

			echo( '<div id="dir_list_tbl_content">' ); // display table
			echo( '<div class="dir_list_tbl_row">' ); // display table row
			echo( '<div class="dir_list_tbl_head">Name</div>' ); // display table cell
			echo( '<div class="dir_list_tbl_head">Last Modified</div>' );
			echo( '<div class="dir_list_tbl_head">Size</div>' );
			echo( '<div class="dir_list_tbl_head">Description</div>' );
			echo( '<div class="dir_list_tbl_head">Type</div>' );
			echo( '</div>' ); // display table row end

			$directory_details = $hlp->get_directory_details();
			foreach( $directory_details as $directory )			
			{
				// print_r( $directory );
				echo( '<div class="dir_list_tbl_row">
					<div class="dir_list_tbl_cont" id="dir_name">
						<!-- <a href="#" onclick="enter_dir(\''.$directory[ 'full_path' ].'\'); return false;">'.$directory[ 'dir_name' ].'</a> -->
					<a href="#" onclick="enter_dir(this); return false;">'.$directory[ 'dir_name' ].'</a>
					</div>
					<div class="dir_list_tbl_cont" id="last_modified">'.$directory[ 'last_modified' ].'</div>
					<div class="dir_list_tbl_cont" id="file_size">'.$directory[ 'file_size' ].'</div>
					<div class="dir_list_tbl_cont" id="full_path">'.$directory[ 'full_path' ].'</div>
					<div class="dir_list_tbl_cont" id="file_type">'.$DIR_FILE_ARR[ $directory[ 'type' ] ].'</div>
				</div>' );
			}
			
			echo( '</div>' ); // display table end
			

			// display file div
			echo('<div id="file_table_content"></div>');			

			echo('</div>' ); // directory main list content end
		} 

		function show_header() {
			GLOBAL $USERNAME, $USERID;
			echo( '<div id="header">
				<div class="header_col">
					<div class="header_col" id="username_lbl">Logged In As: </div>
					<div class="header_col" id="username_val">'.$_SESSION[ 'username' ].'</div>
				</div>
				<div class="logout_container">
					<a href="#" id="logout_btn" onclick="perform_logout(); return false;">Logout</a>
				</div>
				<div class="clear"></div>
			</div>' );
		}
	}
	
?>
