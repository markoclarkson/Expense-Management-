<?php
	$name = $_POST['name'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$email_from = 'darshturakhia@gmail.com';
	$email_subject = "New Contact For Expense Manager";
	$email_body = "User Name : $name. \n"."User Email : $email. \n"."User Telephone : $telephone. \n"."User Subject : $subject. \n"."User Message : $message. \n";
	$to = "darshturakhia@gmail.com";
	$headers = "From : $email_from \r\n";
	$headers = "Reply-To : $email \r\n";
	if(mail($to, $email_subject, $email_body))
	{
		echo "Mail Sent successfully !!! ";
		header("location: index.html");
	}
	else
	{
		echo "Mail sending Failed !!! ";
	}
?>