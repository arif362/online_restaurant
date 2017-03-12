$(function() {

	$("#mobile_error").hide();
	$("#email_error").hide();
	$("#address_error").hide();
	$("#account_error").hide();
	$("#payment_error").hide();


	var error_mobile = false;
	var error_email = false;
	var error_address = false;
	var error_account = false;
	var error_payment = false;
	
	$("#c_mobile").focusout(function() {

		check_mobile();
		
	});
	
	$("#c_email").focusout(function() {

		check_email();
		
	});
	$("#c_address").focusout(function() {

		check_address();
		
	});
	$("#c_account").focusout(function() {

		check_account();
		
	});
	$("#payment_types").focusout(function() {

		check_payment();
		
	});
	
	function check_mobile() {

		var pattern = new RegExp(/^\d{11}$/);
		var mobile_length = $("#c_mobile").val().length;
		
		if(pattern.test($("#c_mobile").val())){
			$("#mobile_error").hide();
		} else {
			$("#mobile_error").html("Mobile Number Should be 11 digits only. ");
			$("#mobile_error").show();
			error_mobile = true;
		}

	}

	function check_email() {

		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	
		if(pattern.test($("#c_email").val())) {
			$("#email_error").hide();
		} else {
			$("#email_error").html("Invalid email address");
			$("#email_error").show();
			error_email = true;
		}
	
	}
	function check_address() {

		var address_length = $("#c_address").val().length;
		
		if(address_length < 1) {
			$("#address_error").html("Fill Up Your Address");
			$("#address_error").show();
			error_address = true;
		} else {
			$("#address_error").hide();
		}

	}

	function check_account() {

		var pattern = new RegExp(/^\d{11,16}$/);
		var mobile_length = $("#c_account").val().length;
		
		if(pattern.test($("#c_account").val())){
			$("#account_error").hide();
		} else {
			$("#account_error").html("Account Number Should be 11 to 16 digits ");
			$("#account_error").show();
			error_account = true;
		}

	}
	function check_payment() {

		var payment= $("#payment_types").val();
		
		if(payment <1) {
			$("#payment_error").html("Select Payment Types");
			$("#payment_error").show();
			error_payment = true;
		} else {
			$("#payment_error").hide();
		}

	}


	$("#order_form").submit(function() {
											
		error_mobile = false;
		error_email = false;
		error_address = false;
		error_account = false;
		error_payment = false;
									
		check_mobile();
		check_email();
		check_address();
		check_account();
		check_payment();
		
		
		if(error_mobile == false && error_email == false && error_address == false && error_account == false && error_payment == false )
			
		{
			return true;	
		} 
		else {
			return false;	
		}

	});

});