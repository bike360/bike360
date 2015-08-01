<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
Print '<script>alert("Entering into php block");</script>';
	$FName = mysql_real_escape_string($_POST['FName']);
	$LName = mysql_real_escape_string($_POST['LName']);
	$SellerType = mysql_real_escape_string($_POST['SellerType']);
	$MobileNo = mysql_real_escape_string($_POST['MobileNo']);
	$WhatsAppNo = mysql_real_escape_string($_POST['WhatsAppNo']);
	$EmailID = mysql_real_escape_string($_POST['EmailID']);
	$Password = mysql_real_escape_string($_POST['Password1']);
	$encPass = md5($Password);
	//$WhatsAppNo = mysql_real_escape_string($_POST['WhatsAppNo']);
    
	$ip=$_SERVER['REMOTE_ADDR'];
	//echo '<script>alert("MobileNo:"' . $MobileNo .');</script>';
	$description = "Requested from IP addr" . $ip ;
	
	
	?>
	
<?php
	mysql_connect("localhost", "root","") or die(mysql_error()); //Connect to server
	mysql_select_db("bike") or die("Cannot connect to database"); //Connect to database
	$query = mysql_query("Select * from user_details WHERE MOB_NO='$MobileNo'"); //Query the users table
	$exists = mysql_num_rows($query);
	//while($row = mysql_fetch_array($query))
	if($exists > 0) //display all rows from query
	{
		Print '<script>alert("Mobile No is already registered!");</script>'; //Prompts the user
		Print '<script>window.location.assign("Seller_Registration.php");</script>'; // redirects to register.php
	}
	else 
	{
		//Print '<script>alert("Inserting into DB!");</script>';
		mysql_query("INSERT INTO user_details (FNAME, LNAME, MOB_NO, WHATSAPP_CONTACT, PASSWORD, TYPE, DESCRIPTION) VALUES ('$FName','$LName','$MobileNo','$WhatsAppNo','$encPass','$SellerType','$ip')"); //Inserts the value to table users
		Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
		
		//UPLOADING PHOTO
		if(!empty($_FILES["fileToUpload"]["name"]))
		{
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
		}
		
		//Sending email to the user
		/*
		$to = 'soubanik@gmail.com';
			//define the subject of the email
		$subject = 'Test email'; 
		//define the message to be sent. Each line should be separated with \n
		$message = "Hello World!\n\nThis is my first mail."; 
		//define the headers we want passed. Note that they are separated with \r\n
		$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com";
		//send the email
		$mail_sent = @mail( $to, $subject, $message, $headers );
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
		echo $mail_sent ? "Mail sent" : "Mail failed";
		*/
		Print '<script>window.location.assign("Index.php");</script>'; // redirects to register.php
	}
}
?>
