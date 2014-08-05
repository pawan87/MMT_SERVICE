	<?php
	/**
		* Webservice for, Forgot Password Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getForgotPasswordDetails()
	{		
		$emailID = $_REQUEST['emailID']; //Get Request From Device
		
		if( $emailID == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		    
			$dataQueryInfo = "SELECT * FROM User_Detail_T WHERE EMAIL_ADDRESS='$emailID'";
			$dataResultSet = mysql_query($dataQueryInfo);
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					
					$Email_ID=$row['EMAIL_ADDRESS'];
					$PASSWORD=$row['PASSWORD'];
					
				}
				
					$to  = $Email_ID;
					// subject
					$subject = 'Assignment App Password Information';
					// message
					$message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							   <html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
								</head>
								<body>
								   <div style="width:60.5%;margin-left:20%;background:blue;height:50px;padding:5px;float:left;text-align:center;color:white">
				                    <h2>Assignment App</h2>
								   </div>
								   <div style="width:60%;margin-left:20%;border:solid 1px gray;height:70px;padding:5px;float:left">
								    <table>
									<tr>
									<td>
									<h4>Your Current Password Is :</h4></td><td><b style="text-decoration:underline">'.$PASSWORD.'</b></td>
									</tr>
								   </div>
								</body>
							</html>
							 ';
					  $headers.= "MIME-version: 1.0\n";
                      $headers.= "Content-type: text/html; charset= iso-8859-1\n";
                      $headers.= "From: info@phbjharkhand.in\r\n";
                      mail($to, $subject, $message, $headers);
					
					$errorCode = "1";
					$errorMsg = "Password Send Successfully";
					$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
					return $newData;
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "User Not Available,Invalid Email Address";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
				
			}
			
		}
	}		
	
	echo getForgotPasswordDetails();
?>