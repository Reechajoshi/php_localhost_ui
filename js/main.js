$(document).ready(function(){
	helper.init();
});

function validate_login_register(key) {
	var username_id = key+"_username";	
	var password_id = key + "_password";
	var confirm_password_id = key + "_confirm_password";

	var username = $("#" + username_id).val();
	var password = $("#"+password_id).val();
	var confirm_password = $("#"+confirm_password_id).val();

	/** NEW CODE DIFF METHODS FOR LOGIN REGISTER **/
	if( key == 'login' ) // if key is login, validate login operation
	{
		validate_login( username, password );
	}
	else // if key is register, validat register opertation
	{
		validate_register( username, password, confirm_password );	
	}
}


function validate_login( username, password ) {

	if( username.length == 0 )
	{
		alert( "Please enter the username" );
	}
	else if( password.length == 0 )
	{
		alert( "Please enter the password" );
	}
	else
	{
		check_user_exists( 'login', username, password );
	}
}

function validate_register( username, password, confirm_password ) {

	if( username.length == 0 )
	{
		alert( "Please enter the Username" );
	}
	else if( password.length == 0 )
	{
		alert( "Please provide the password" );
	}	
	else if( confirm_password.length == 0 )
	{
		alert( "Please provide confirm password" );
	}
	else if( password != confirm_password )
	{
		alert( "The password and cofirm password should be the same." );
	}
	else
	{
		// alert( "Add user 2" );
		check_user_exists( 'register', username, password );
	}
}
function check_user_exists( key, username, password ) {
	var url_val = helper._SERVER_ROOT + "ajax.php?a=check_user_exists";
	var data_string = 'username='+username;
	
	$.ajax({
		url: url_val, 
		type: 'POST',
		data: data_string,
		success: function(result) {

			if( ( ( key == 'register' ) && ( result == "0" ) ) || ( ( key == 'login' ) && ( result == "1" ) ) )
			{
				perform_login_register( key, username, password );
			}
			else
			{
				alert( ( key == 'register' ) ? ( "User already exists!" ) : ( "User doesnot exist!" ) );
			}
		},
		error: function(error) {
		}
	});
	
}

function perform_login_register( key, username, password ) {
	var url_val = helper._SERVER_ROOT + "ajax.php?a="+key;
	var data_string = 'username=' + username + '&password=' + password; 
	
	$.ajax({
		url: url_val, 
		type: 'POST',
		data: data_string,
		success: function(result){
			console.log( "result" + result );
			if( result == '1' )
			{
				alert( ( key == 'login' ) ? ( "Login Successful" ) : ( "User added successfully" ) );
				// window.location.reload(true);
				window.location = "index.php";	
			}
			else
			{
				alert( "Invalid Credentials" );
				window.location.reload(true); // reload
			}
		},
		error: function(error) {
		}
	});
}

function show_login_register(key) {
	if( key == 'login' )
	{
		// $('#login_wrapper').show();
		$('#login_wrapper').css('display','table');
		// $('#register_wrapper').hide();
		$('#register_wrapper').css('display','none');
	}
	else if( key == 'register' )
	{
		// $('#login_wrapper').hide();
		$('#login_wrapper').css('display','none');
		// $('#register_wrapper').show();	
		$('#register_wrapper').css('display','table');	
	}
	else
	{
	}
}

function perform_logout() {
	var url_val = helper._SERVER_ROOT + "ajax.php?a=logout";
	
	$.ajax({
		url: url_val, 
		type: 'POST',
		success: function(result) {
			alert( "Logged out successfully" );	
			window.location = "index.php";			
		},
		error: function(error) {
		}
	});
}

/* function enter_dir(dir_path) {
	var url_val = helper._SERVER_ROOT + "ajax.php?a=enter_dir";
	var data_string = 'dir_path='+dir_path;
	
	var dir_path_arr = dir_path.split("/");
	console.log( dir_path_arr[ ( dir_path_arr.length - 1 ) ] );
	var curr_dir = dir_path_arr[ ( dir_path_arr.length - 1 ) ];
	var current_path = $("#current_path").html() + curr_dir + "/";
	$("#current_path").html(current_path);
	
	$.ajax({
		url: url_val, 
		type: 'POST',
		data: data_string,
		success: function(result) {
			var is_json = true;
			try {
				var json_response = JSON.parse(result);
			}
			catch(err) {
				is_json = false;	
			}
			
			if( is_json )
			{
				show_directory(json_response);
			}
			else
			{
				console.log( "display file" );
			}
		},
		error: function(error) {
			console.log( error );
		}
	});
} */

function enter_dir(curr_dir_div) {
	var table_row = $(curr_dir_div).parent().parent(); // get table row containing details
	var table_detail_rows = $(table_row).find(".dir_list_tbl_cont");
	
	var full_path = $(table_row).find('#full_path').html();
	var curr_dir_name = $(table_row).find('#dir_name').find('a').html();
		
	show_current_path('in', curr_dir_name);	// displays text in You are here div

	navigate_dir('in');
}

function show_current_path( nav, dir_name ) {
	current_path = $('#current_path').html();
	if( nav == 'in' ) // go inside directory
	{
		// if current path contains forward slash then append dir name or else append slash and dir name
		new_path = ( ( current_path.substr(-1) == "/" ) ? ( current_path + dir_name ) : ( current_path + "/" + dir_name ) );
		$('#current_path').html(new_path);
	}
	else // go outside directory
	{
		var current_path_arr = current_path.split("/");
		
		// if last element is empty then consider last directory as second last element.. NOT USED CURRENTLY
		var last_dir = ( current_path_arr[ current_path_arr.length - 1 ].length != 0 ) ? ( current_path_arr[ current_path_arr.length - 1 ] ) : ( current_path_arr[ current_path_arr.length - 2 ] );
		
		// if last element is forward slash then last remove second last element else remove last element
		var last_dir_idx = ( current_path_arr[ current_path_arr.length - 1 ].length != 0 ) ? ( current_path_arr.length - 1 ) : ( current_path_arr.length - 2 );

		current_path_arr.splice(last_dir_idx, 1); // remove element at last array index

		// if array is empty, new curr_dir is forward slash
		var new_curr_dir = ( ( current_path_arr.length == 1 ) && ( current_path_arr[0].length == 0 )  ) ? ( "/" ) : ( current_path_arr.join("/") );

		$('#current_path').html(new_curr_dir);
	}
		
	// $('#current_path').html( curr_path );
}

/* function show_directory( directory_list ) {
	var dir_list_tbl_content = $('#dir_list_tbl_content');
	var table_content = $(dir_list_tbl_content).find(".dir_list_tbl_row");
	
	for( var i = 1; i < $(table_content).length; i++  )
	{
		$(table_content).eq(i).remove();
	}
		
	for( var i = 0; i < directory_list.length; i++ )
	{
		var file_type = directory_list[i]['type'];
		var dir_name = directory_list[i]['dir_name'];
		var last_modified = directory_list[i]['last_modified'];
		var file_size = directory_list[i]['file_size'];
		var full_path = directory_list[i]['full_path'];

		// dynamically create div elements for each value
		var dir_list_tbl_row = $('<div/>');
		$(dir_list_tbl_row).attr({"class":"dir_list_tbl_row"});
		
		// Directory Name: 
		var dir_list_tbl_cont1 = $('<div/>');
		$(dir_list_tbl_cont1).attr({"class":"dir_list_tbl_cont", "id" : "dir_name"});		
		var dir_name_anchor = $('<a/>');
		$(dir_name_anchor).attr({"href":"#","onclick":"enter_dir('"+full_path+"'); return false;"});
		$(dir_list_tbl_cont1).append($(dir_name_anchor));
		$(dir_name_anchor).html(dir_name);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont1));

		// Create date:
		var dir_list_tbl_cont2 = $('<div/>');
		$(dir_list_tbl_cont2).attr({"class":"dir_list_tbl_cont", "id" : "last_modified"}).html(last_modified);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont2));

		// dir size:
		var dir_list_tbl_cont3 = $('<div/>');
		$(dir_list_tbl_cont3).attr({"class":"dir_list_tbl_cont", "id" :"file_size"}).html(file_size);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont3));
		
		// Description: 
		var dir_list_tbl_cont4 = $('<div/>');
		$(dir_list_tbl_cont4).attr({"class":"dir_list_tbl_cont","id":"full_path"}).html(full_path);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont4));	

		// Type
		var dir_list_tbl_cont5 = $('<div/>');
		$(dir_list_tbl_cont5).attr({"class":"dir_list_tbl_cont","id":"file_type"}).html(file_type);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont5));	

		$(dir_list_tbl_content).append($(dir_list_tbl_row));
	}
} */

/* function level_up_dir() {
		
	var current_path = $('#current_path').html(); // take the whole path from the document root 

	if( current_path != "/" )
	{
		// split current path
		var current_path_arr = current_path.split( "/" );
		current_path_arr.splice((current_path_arr.length-2), 1);
		
		var back_folder_str = current_path_arr.join("/");

		var document_root = helper._DOCUMENT_ROOT.substring(0, (helper._DOCUMENT_ROOT.length - 1));
		var back_folder_full = document_root + back_folder_str;

		var current_path = back_folder_full.replace(document_root, "");
		enter_dir(back_folder_full);
		$('#current_path').html(current_path);
	
	}
} */

function level_up_dir() {
	// this method will check if it is inside any directory and go outside directory

	var current_path = $('#current_path').html(); // first get the current path		

	if(current_path != "/")
	{
		show_current_path('out',current_path);		
		navigate_dir('out');
	}

	
//	var current_path_arr = current_path.split("/"); // split the current path
//	var current_path_len = current_path_arr.length;  
//
//	if( current_path_arr[ current_path_len - 1 ] != '' )	
//	{
//		console.log("Current Path: "+current_path);
//		show_current_path('out',current_path);	
//	}
//	else
//	{
//		alert('last one empty');
//	}
}

function navigate_dir(direction) {
	var current_path = $("#current_path").html();

	var full_path = helper._DOCUMENT_ROOT + ( ( current_path.indexOf('/') === 0 ) ? ( current_path.substring(1) ) : ( current_path ) );
	var url_val = helper._SERVER_ROOT + "ajax.php?a=enter_dir";
	var data_string = 'dir_path='+full_path;
	var json_response = null;

	$.ajax({
		url: url_val,
		type: 'POST',
		data: data_string,
		success: function(result) {
			console.log("result");
			console.log(result);
			console.log(typeof(result));

			var json_response = JSON.parse(result);
			var type = json_response.type;
		
			if( type == 'dir' )	
			{
				show_directory(json_response.content);
			}
			else
			{
				show_file( json_response );
			}

		//	var is_json = true;
		//	try {
		//		json_response = JSON.parse(result);
		//	}
		//	catch(err) {
		//		is_json = false;
		//	}
		//	
		//	if( is_json )
		//	{
		//		console.log(json_response);
		//		// show_directory(json_reponse);
		//		show_directory(json_response);
		//	}
		//	else
		//	{
		//		show_file(result);
		//		console.log("display_file");
		//	}
		},
		error: function(err) {
			console.log(err);
		}
	});
}

function show_file(response) {
	var file_type = response.type;
	var file_table_content = $('#file_table_content');
	$(file_table_content).html("");
	
	if( file_type == 'image' )
	{
		var img_url = response.content;
		var image = $('<img/>').attr('src',img_url);
		$(file_table_content).append($(image));
	}
	else
	{
		var file_content = response.content;
		var file_div = $('<div/>').attr('style','padding:5px 10px').html("<pre>"+file_content+"</pre>");
		$(file_table_content).append($(file_div));
	}

	$(file_table_content).css('display', 'table');
	$('#dir_list_tbl_content').hide();

//	var file_table_content = $('#file_table_content');
//	var file_div = $('<div/>').attr('style','padding:5px 10px').html("<pre>"+file_content+"</pre>");
//	$(file_table_content).append($(file_div));
//	$(file_table_content).css('display', 'table');
//	$('#dir_list_tbl_content').hide();
}

function show_directory(directory_list) {
	$('#file_table_content').hide();	
	var dir_list_tbl_content = $('#dir_list_tbl_content');
	$(dir_list_tbl_content).css('display','table');
	console.log('dir_list_tbl_content display attr table ');
	var table_content = $(dir_list_tbl_content).find(".dir_list_tbl_row");
	
	for( var i = 1; i < $(table_content).length; i++  )
	{
		$(table_content).eq(i).remove();
	}
		
	for( var i = 0; i < directory_list.length; i++ )
	{
		var file_type = directory_list[i]['type'];
		var dir_name = directory_list[i]['dir_name'];
		var last_modified = directory_list[i]['last_modified'];
		var file_size = directory_list[i]['file_size'];
		var full_path = directory_list[i]['full_path'];

		// dynamically create div elements for each value
		var dir_list_tbl_row = $('<div/>');
		$(dir_list_tbl_row).attr({"class":"dir_list_tbl_row"});
		
		// Directory Name: 
		var dir_list_tbl_cont1 = $('<div/>');
		$(dir_list_tbl_cont1).attr({"class":"dir_list_tbl_cont", "id" : "dir_name"});		
		var dir_name_anchor = $('<a/>');
		// $(dir_name_anchor).attr({"href":"#","onclick":"enter_dir('"+full_path+"'); return false;"});
		$(dir_name_anchor).attr({"href":"#","onclick":"enter_dir(this); return false;"});
		$(dir_list_tbl_cont1).append($(dir_name_anchor));
		$(dir_name_anchor).html(dir_name);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont1));

		// Create date:
		var dir_list_tbl_cont2 = $('<div/>');
		$(dir_list_tbl_cont2).attr({"class":"dir_list_tbl_cont", "id" : "last_modified"}).html(last_modified);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont2));

		// dir size:
		var dir_list_tbl_cont3 = $('<div/>');
		$(dir_list_tbl_cont3).attr({"class":"dir_list_tbl_cont", "id" :"file_size"}).html(file_size);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont3));
		
		// Description: 
		var dir_list_tbl_cont4 = $('<div/>');
		$(dir_list_tbl_cont4).attr({"class":"dir_list_tbl_cont","id":"full_path"}).html(full_path);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont4));	

		// Type
		var dir_list_tbl_cont5 = $('<div/>');
		$(dir_list_tbl_cont5).attr({"class":"dir_list_tbl_cont","id":"file_type"}).html(file_type);
		$(dir_list_tbl_row).append($(dir_list_tbl_cont5));	

		$(dir_list_tbl_content).append($(dir_list_tbl_row));
	}
}
