<?php

/* set the email of the recipient (your email) */
$recipient = "info@example.com";


if ( isset($_POST['submit']) ) // just send the email if the $_POST variable is set
{
	$name = $_POST['name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
	$message = $_POST['message'];
	
	$subject = "Email From Website: " . $name; // subject of the email msg
	
	$errors = array(); // empty array of the err
	
	/*
	 * The fields
	 * 1st param: submitted data
	 * 2nd param: reuqired (TRUE) or not (FALSE)  
	 * 3rd param: the name for the error
	*/
	$fields = array(
		'name'		=> array($name, TRUE, "Name"),
		'phone' 	    => array($phone, FALSE, "Phone"),
		'email' 	=> array($email, TRUE, "E-mail Address"),
		'message' 	=> array($message, TRUE, "Your Message"),
	);
	
	$i=0;
	foreach ($fields as $key => $field) {
		if ( FALSE == test_field( $field[0], $field[1] ) ) {
			$errors[$key] = "The field '".$field[2]."' is required.";
		}
		$i++;
	}
	
	//var_dump($errors);
	
	if (empty($errors)) { // if there is no errors, we can send the mail
		$body = "";
		$body .= "----- SENDER INFO -----\n\n";
		$body .= "Name: ".$fields['name'][0]."\n";
		$body .= "Email: ".$fields['email'][0]."\n";
		$body .= "Website: ".$fields['phone'][0]."\n";
		$body .= "\n\n----- Message -----\n\n";
		$body .= $fields['message'][0];
		
		if( mail( $recipient, $subject, $body, "FROM: ".$fields['email'][0] ) ) { // try to send the message, if not successful, print out the error
			message_was_sent($fields);
		
        } else {
			echo "It is not possible to send the email. Check out your PHP settings!";
			print_the_form($errors, $fields);
		}
	} else { // if there are any errors
		print_the_form($errors, $fields);
	}	
} else {
	print_the_form();
}

/**
 * prints out the form if necessary
 */
function print_the_form($errors = array(), $fields = null) {
	?> 

                        <div class="col-md-3 col-md-offset-2">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Name:">
                                <?php show_error('name', $errors); ?>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email:">
                                <?php show_error('email', $errors); ?>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="phone" placeholder="Phone:">
                                <?php show_error('phone', $errors); ?>
                            </div>
                        </div>                
                        <div class="col-md-5">
                                <textarea class="form-control" name="message" placeholder="Message:" rows="6"></textarea>
                                <?php show_error('message', $errors); ?>
                        </div>                
                        <div class="col-md-5 text-right">
                        <input type="hidden" value="1" name="submit" />
                        <button type="submit" class="btn btn-default">Submit</button>
                        </div>                
                        <div class="clearfix"></div>
	
	<?php
}

function message_was_sent($fields) { // notification that sending the mail was successful
	?> 
	<p class="text-info">Your message was sent successfully!</p>
	<?php
}

/**
 * Returns TRUE if field is required and OK
 */
function test_field($content, $required) {
	if ( TRUE === $required ) {
	    return strlen($content) > 0;
        
	} else {
		return TRUE;
	}
}

/**
 * Add the appropirate class name to the specified input field
 */
function error_class($name, $errors) {
	if ( array_key_exists( $name, $errors ) ) {
		echo " error";
	}
}

/**
 * repopulate the data when the form is submitted and errors returned
 */
function inpt_value($name, $fields) {
	if ( null === $fields ) {
		return;
	} else {
		echo $fields[$name][0];
	}
} 

function show_error( $name, $errors ) {
	if ( array_key_exists( $name, $errors ) )
	echo '<div class="help-block"> ' . $errors[$name] . ' </div>';
}
