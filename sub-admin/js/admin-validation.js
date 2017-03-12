$(function() {

	$("#sub_name_error").hide();
	$("#restaurant_name_error").hide();
	$("#sub_username_error").hide();
	$("#sub_email_error").hide();
	$("#sub_address_error").hide();
	$("#sub_mobile_error").hide();
	$("#sub_day_error").hide();
	$("#sub_month_error").hide();
	$("#sub_year_error").hide();
	$("#sub_sex_error").hide();
	$("#sub_types_error").hide();
	$("#sub_password1_error").hide();
	$("#sub_password2_error").hide();
	$("#restaurant_logo_error").hide();
	$("#sub_pic_error").hide();
	$("#sub_sign_error").hide();

	var error_sub_name = false;
	var error_restaurant_name = false;
	var error_sub_username = false;
	var error_sub_email = false;
	var error_sub_address = false;
	var error_sub_mobile = false;
	var error_sub_day = false;
	var error_sub_month = false;
	var error_sub_year = false;
	var error_sub_sex = false;
	var error_sub_types = false;
	var error_sub_password1 = false;
	var error_sub_password2 = false;
	var error_restaurant_logo = false;
	var error_sub_pic = false;
	var error_sub_sign = false;

	$("#sub_name").focusout(function() {

		check_sub_name();
		
	});
	$("#restaurant_name").focusout(function() {

		check_restaurant_name();
		
	});
	$("#sub_username").focusout(function() {

		check_sub_username();
		
	});
	$("#sub_email").focusout(function() {

		check_sub_email();
		
	});
	$("#sub_address").focusout(function() {

		check_sub_address();
		
	});
	$("#sub_mobile").focusout(function() {

		check_sub_mobile();
		
	});
	$("#sub_day").focusout(function() {

		check_sub_day();
		
	});
	$("#sub_month").focusout(function() {

		check_sub_month();
		
	});
	$("#sub_year").focusout(function() {

		check_sub_year();
		
	});
	$("#sub_sex").focusout(function() {

		check_sub_sex();
		
	});
	$("#sub_types").focusout(function() {

		check_sub_types();
		
	});
	$("#sub_password1").focusout(function() {

		check_sub_password1();
		
	});

	$("#sub_password2").focusout(function() {

		check_sub_password2();
		
	});
	
	$("#restaurant_logo").focusout(function() {

		check_restaurant_logo();
		
	});
	
	$("#sub_pic").focusout(function() {

		check_sub_pic();
		
	});	$("#sub_sign").focusout(function() {

		check_sub_sign();
		
	});
	
	function check_sub_name() {
	
		var pattern = new RegExp(/^[a-zA-Z][a-zA-Z\. ]*$/);
		
		if(pattern.test($("#sub_name").val())) {
			$("#sub_name_error").hide();
		} else {
			$("#sub_name_error").html("Name Should be Letters Only. (dot and space are allowed)");
			$("#sub_name_error").show();
			error_sub_name = true;
		}
	
	}
	function check_restaurant_name() {
	
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		
		if(pattern.test($("#restaurnt_name").val())) {
			$("#restaurant_name_error").hide();
		} else {
			$("#restaurant_name_error").html("Should be Characters Only.");
			$("#restaurant_name_error").show();
			error_restaurant_name = true;
		}
	
	}
	function check_sub_username() {
	
		var username_length = $("#sub_username").val().length;
		
		if(username_length < 5 || username_length > 20) {
			$("#sub_username_error").html("Should be between 5-20 characters");
			$("#sub_username_error").show();
			error_sub_username = true;
		} else {
			$("#sub_username_error").hide();
		}
	
	}
	
	function check_sub_email() {

		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	
		if(pattern.test($("#sub_email").val())) {
			$("#sub_email_error").hide();
		} else {
			$("#sub_email_error").html("Invalid email address");
			$("#sub_email_error").show();
			error_sub_email = true;
		}
	
	}
	function check_sub_address() {

		var address_length = $("#sub_address").val().length;
		
		if(address_length < 1) {
			$("#sub_address_error").html("Fill Up Address");
			$("#sub_address_error").show();
			error_sub_address = true;
		} else {
			$("#sub_address_error").hide();
		}

	}

	function check_sub_mobile() {

		var pattern = new RegExp(/^\d{11}$/);
		var mobile_length = $("#sub_mobile").val().length;
		
		if(pattern.test($("#sub_mobile").val())){
			$("#sub_mobile_error").hide();
		} else {
			$("#sub_mobile_error").html("Mobile Number Should be 11 digits ( + or - symbol are not allowed)");
			$("#sub_mobile_error").show();
			error_sub_mobile = true;
		}

	}
	function check_sub_day() {

		var day= $("#sub_day").val();
		
		if(day <1) {
			$("#sub_day_error").html("Select Day.");
			$("#sub_day_error").show();
			error_sub_day = true;
		} else {
			$("#sub_day_error").hide();
		}
	}
	function check_sub_month() {

		var month= $("#sub_month").val();
		
		if(month <1) {
			$("#sub_month_error").html("Select Month.");
			$("#sub_month_error").show();
			error_sub_month = true;
		} else {
			$("#sub_month_error").hide();
		}
	}
	function check_sub_year() {

		var year= $("#sub_year").val();
		
		if(year <1) {
			$("#sub_year_error").html("Select Year");
			$("#sub_year_error").show();
			error_sub_year = true;
		} else {
			$("#sub_year_error").hide();
		}

	}
	function check_sub_sex() {

		var sex= $("#sub_sex").val();
		
		if(sex <1) {
			$("#sub_sex_error").html("Select Gender Types");
			$("#sub_sex_error").show();
			error_sub_sex = true;
		} else {
			$("#sub_sex_error").hide();
		}
	}
	function check_sub_types() {

		var types= $("#sub_types").val();
		
		if(types <1) {
			$("#sub_types_error").html("Select Admin Types");
			$("#sub_types_error").show();
			error_sub_types = true;
		} else {
			$("#sub_types_error").hide();
		}
	}
	function check_sub_password1() {
	
		var password_length = $("#sub_password1").val().length;
		
		if(password_length < 8) {
			$("#sub_password1_error").html("Password Must be at least 8 characters");
			$("#sub_password1_error").show();
			error_sub_password1 = true;
		} else {
			$("#sub_password1_error").hide();
		}
	
	}

	function check_sub_password2() {
	
		var password = $("#sub_password1").val();
		var retype_password = $("#sub_password2").val();
		
		if(password !=  retype_password) {
			$("#sub_password2_error").html("Passwords don't match");
			$("#sub_password2_error").show();
			error_sub_password2 = true;
		} else {
			$("#sub_password2_error").hide();
		}
	
	}
	function check_restaurant_logo() {

		var restaurant_logo= $("#restaurant_logo").val().length;
		
		if(restaurant_logo <1) {
			$("#restaurant_logo_error").html("Browse Your Photo Only jpg, jpeg, png and gif subat images are allowed to upload.");
			$("#restaurant_logo_error").show();
			error_restaurant_logo = true;
		} else {
			$("#restaurant_logo_error").hide();
		}
	}
	function check_sub_pic() {

		var sub_pic= $("#sub_pic").val().length;
		
		if(sub_pic <1) {
			$("#sub_pic_error").html("Browse Your Photo Only jpg, jpeg, png and gif subat images are allowed to upload.");
			$("#sub_pic_error").show();
			error_sub_pic = true;
		} else {
			$("#sub_pic_error").hide();
		}
	}
	function check_sub_sign() {

		var sub_sign= $("#sub_sign").val().length;
		
		if(sub_sign <1) {
			$("#sub_sign_error").html("Browse Your Photo Only jpg, jpeg, png and gif subat images are allowed to upload.");
			$("#sub_sign_error").show();
			error_sub_sign= true;
		} else {
			$("#sub_sign_error").hide();
		}
	}

	$("#sub_registration").submit(function() {
											
		error_sub_name = false;
		error_restaurant_name = false;
		error_sub_username = false;
		error_sub_email = false;
		error_sub_address = false;
		error_sub_mobile = false;
		error_sub_day = false;
		error_sub_month = false;
		error_sub_year = false;
		error_sub_sex = false;
		error_sub_types = false;
		error_sub_password1 = false;
		error_sub_password2 = false;
		error_restaurant_logo = false;
		error_sub_pic = false;
		error_sub_sign = false;
											
		check_sub_name();
		check_restaurant_name();
		check_sub_username();
		check_sub_email();
		check_sub_address();
		check_sub_mobile();
		check_sub_day();
		check_sub_month();
		check_sub_year();
		check_sub_sex();
		check_sub_types();
		check_sub_password1();
		check_sub_password2();
		check_restaurant_logo();
		check_sub_pic();
		check_sub_sign();
		
		if(error_sub_name == false && error_restaurant_name == false && error_sub_username == false && error_sub_email == false && error_sub_address == false && error_sub_mobile == false && error_sub_day == false && error_sub_month == false && error_sub_year == false && error_sub_sex == false && error_sub_types == false && error_sub_password1 == false && error_sub_password2 == false && error_restaurant_logo == false && error_sub_pic == false && error_sub_sign == false)
			
		{
			return true;	
		} 
		else {
			return false;	
		}

	});

});