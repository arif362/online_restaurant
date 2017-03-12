$(function() {

	$("#name_error_message").hide();
	$("#username_error_message").hide();
	$("#email_error_message").hide();
	$("#address_error_message").hide();
	$("#mobile_error_message").hide();
	$("#day_error_message").hide();
	$("#month_error_message").hide();
	$("#year_error_message").hide();
	$("#gender_error_message").hide();
	$("#password_error_message").hide();
	$("#retype_password_error_message").hide();
	$("#pic_error_message").hide();

	var error_name = false;
	var error_username = false;
	var error_email = false;
	var error_address = false;
	var error_mobile = false;
	var error_day = false;
	var error_month = false;
	var error_year = false;
	var error_gender = false;
	var error_password = false;
	var error_retype_password = false;
	var error_pic = false;

	$("#form_name").focusout(function() {

		check_name();
		
	});
	
	$("#form_username").focusout(function() {

		check_username();
		
	});
	$("#form_email").focusout(function() {

		check_email();
		
	});
	$("#form_address").focusout(function() {

		check_address();
		
	});
	$("#form_mobile").focusout(function() {

		check_mobile();
		
	});
	$("#form_day").focusout(function() {

		check_day();
		
	});
	$("#form_month").focusout(function() {

		check_month();
		
	});
	$("#form_year").focusout(function() {

		check_year();
		
	});
	$("#form_gender").focusout(function() {

		check_gender();
		
	});

	$("#form_password").focusout(function() {

		check_password();
		
	});

	$("#form_retype_password").focusout(function() {

		check_retype_password();
		
	});
	
	$("#form_pic").focusout(function() {

		check_pic();
		
	});
	
	function check_name() {
	
		var pattern = new RegExp(/^[a-zA-Z][a-zA-Z\. ]*$/);
		
		if(pattern.test($("#form_name").val())) {
			$("#name_error_message").hide();
		} else {
			$("#name_error_message").html("Name Should be Letters Only. (dot and space are allowed)");
			$("#name_error_message").show();
			error_name = true;
		}
	
	}
	function check_username() {
	
		var username_length = $("#form_username").val().length;
		
		if(username_length < 5 || username_length > 20) {
			$("#username_error_message").html("Should be between 5-20 characters");
			$("#username_error_message").show();
			error_username = true;
		} else {
			$("#username_error_message").hide();
		}
	
	}
	
	function check_email() {

		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	
		if(pattern.test($("#form_email").val())) {
			$("#email_error_message").hide();
		} else {
			$("#email_error_message").html("Invalid email address");
			$("#email_error_message").show();
			error_email = true;
		}
	
	}
	function check_address() {

		var address_length = $("#form_address").val().length;
		
		if(address_length < 1) {
			$("#address_error_message").html("Fill Up Your Address");
			$("#address_error_message").show();
			error_address = true;
		} else {
			$("#address_error_message").hide();
		}

	}

	function check_mobile() {

		var pattern = new RegExp(/^\d{11}$/);
		var mobile_length = $("#form_mobile").val().length;
		
		if(pattern.test($("#form_mobile").val())){
			$("#mobile_error_message").hide();
		} else {
			$("#mobile_error_message").html("Mobile Number Should be 11 digits ( + or - symbol are not allowed)");
			$("#mobile_error_message").show();
			error_mobile = true;
		}

	}
	function check_day() {

		var day= $("#form_day").val();
		
		if(day <1) {
			$("#day_error_message").html("Select Day.");
			$("#day_error_message").show();
			error_day = true;
		} else {
			$("#day_error_message").hide();
		}
	}
	function check_month() {

		var month= $("#form_month").val();
		
		if(month <1) {
			$("#month_error_message").html("Select Month.");
			$("#month_error_message").show();
			error_month = true;
		} else {
			$("#month_error_message").hide();
		}
	}
	function check_year() {

		var year= $("#form_year").val();
		
		if(year <1) {
			$("#year_error_message").html("Select Year");
			$("#year_error_message").show();
			error_year = true;
		} else {
			$("#year_error_message").hide();
		}

	}
	function check_gender() {

		var gender= $("#form_gender").val();
		
		if(gender <1) {
			$("#gender_error_message").html("Select Gender Types");
			$("#gender_error_message").show();
			error_gender = true;
		} else {
			$("#gender_error_message").hide();
		}


	}

	function check_password() {
	
		var password_length = $("#form_password").val().length;
		
		if(password_length < 8) {
			$("#password_error_message").html("Password Must be at least 8 characters");
			$("#password_error_message").show();
			error_password = true;
		} else {
			$("#password_error_message").hide();
		}
	
	}

	function check_retype_password() {
	
		var password = $("#form_password").val();
		var retype_password = $("#form_retype_password").val();
		
		if(password !=  retype_password) {
			$("#retype_password_error_message").html("Passwords don't match");
			$("#retype_password_error_message").show();
			error_retype_password = true;
		} else {
			$("#retype_password_error_message").hide();
		}
	
	}
	function check_pic() {

		var pic= $("#form_pic").val().length;
		
		if(pic <1) {
			$("#pic_error_message").html("Browse Your Photo Only jpg, jpeg, png and gif format images are allowed to upload.");
			$("#pic_error_message").show();
			error_pic = true;
		} else {
			$("#pic_error_message").hide();
		}


	}


	$("#registration_form").submit(function() {
											
		error_name = false;
		error_username = false;
		error_email = false;
		error_address = false;
		error_mobile = false;
		error_day = false;
		error_month = false;
		error_year = false;
		error_gender = false;
		error_password = false;
		error_retype_password = false;
		error_pic = false;
											
		check_name();
		check_username();
		check_email();
		check_address();
		check_mobile();
		check_day();
		check_month();
		check_year();
		check_gender();
		check_password();
		check_retype_password();
		check_pic();
		
		if(error_name == false && error_username == false && error_email == false && error_address == false && error_mobile == false && error_day == false && error_month == false && error_year == false && error_gender == false && error_password == false && error_retype_password == false && error_pic== false)
			
		{
			return true;	
		} 
		else {
			return false;	
		}

	});

});