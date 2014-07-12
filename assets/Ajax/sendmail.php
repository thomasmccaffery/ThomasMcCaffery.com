<?php
$to = "tom@thomasmccaffery.com"; 
$subject = "Message From The Website";
$headers = "Name: Form Mailer";
$date = date ("l, F jS, Y"); 
$time = date ("h:i A"); 
$msg = "$subject  $date, hour: $time.\n\n\n\n"; 
$TempA=array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	foreach ($_POST as $key => $value) { 
		$msg .= ucfirst ($key) ." : ". $value . "\n\n"; 
		array_push($TempA,$value);
	}
}

if($TempA[0] == '' || $TempA[1] == '' || $TempA[2] == '') {
	echo "<div class='alert alert-error'>Please fill out all forms!</div>"; 
} else {
	if(mail($to, $subject, $msg)) { echo "<div class='alert alert-success'><strong>Message sent!</strong> Thanks, I'll get back to you shortly!</div>"; } 
	else { echo "<div class='alert alert-error'><strong>An error has been occurred!</strong>Please Try Later.</div>"; }
} 

?>