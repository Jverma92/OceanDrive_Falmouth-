<?php
/*
sets the email address that you want the form to be submitted to.
*/
$webmaster_email = "oceandrivefalmouth@gmail.com";

/*
sets the URLs of the supporting pages.
*/
$feedback_page = "index.php";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*.
If you add a form field, you will need to add it here.
*/
$email_address = $_REQUEST['email_address'] ;
$comments = $_REQUEST['Comments'] ;
$first_name = $_REQUEST['first_name'] ;
$msg =
"First Name: " . $first_name . "\r\n" .
"Email: " . $email_address . "\r\n" .
"Comments: " . $comments ;

/*
Checks for email injection.
Specifically, carriage returns - used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email_address'])) {
header( "Location: $thankyou_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($first_name) || empty($email_address)) {
header( "Location: $error_page" );
}

/*
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email_address) || isInjected($first_name)  || isInjected($comments) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>
