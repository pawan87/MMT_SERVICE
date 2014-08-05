	<?php
	/* 
		Webservice for Get User Login Details.
		Created By   : Pawan Patil
        Created Date : 14th July 2014
		How it works : We simply take Login from user and check user is available or not.
			Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getUserDetailsInformation()
	{		
	    $userID = $_REQUEST['userID']; 
		$name = $_REQUEST['name']; 
		$address = $_REQUEST['address'];
		$age = $_REQUEST['age'];
		$contactNo = $_REQUEST['contactNo'];
		$emailID = $_REQUEST['emailID'];
		$emailID = strtoupper($emailID);
		$userName = $_REQUEST['userName'];
		$ran= rand(0,10000000);
		$password = $userName.'_'.$ran;
		$category = $_REQUEST['category'];
		
		if( $userID == "" || $name == "" || $address == "" || $age == "" || $contactNo == "" || $emailID == "" || $userName == "" || $category == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      
			date_default_timezone_set('Asia/Calcutta'); 
            $createdDate=date('Y-m-d H:i:s');
			$CheckQuery=mysql_query("SELECT * FROM User_Detail_T WHERE USERID='$userID'");
			while($row=mysql_fetch_array($CheckQuery)){
			  $EMAIL_ADDRESS=$row['EMAIL_ADDRESS'];
			}
			mysql_query( "INSERT INTO User_Detail_T(NAME,ADDRESS,AGE,CONTACT_NO,EMAIL_ADDRESS,USER_NAME,PASSWORD,CATEGORY,CREATED_DATE) VALUES('$name','$address','$age','$contactNo','$emailID','$userName','$password','$category','$createdDate')" );
		    $lastInsertId = mysql_insert_id();
			if(!empty($lastInsertId)){
				
				  /* Mail Function */
				  $to  = $EMAIL_ADDRESS;
					// subject
					$subject = 'MMT App Password Information';
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
									<h4>Your Email Id :</h4></td><td><b style="text-decoration:underline">'.$emailID.'</b></td>
									</tr>
									<tr>
									<td>
									<h4>Your Current Password Is :</h4></td><td><b style="text-decoration:underline">'.$password.'</b></td>
									</tr>
								   </div>
								</body>
							</html>
							 ';
					  $headers.= "MIME-version: 1.0\n";
                      $headers.= "Content-type: text/html; charset= iso-8859-1\n";
                      $headers.= "From: info@phbjharkhand.in\r\n";
                      mail($to, $subject, $message, $headers);
				  /* End here */
				$errorCode = "1";
				$errorMsg = "Registration Successfully";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
				return $newData;
				
			}
			else{
			
				$errorCode = "2";
				$errorMsg = "Registration Fail";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
				return $newData;
			}
			
		}
		
				
	}		
	
	echo getUserDetailsInformation();
?>