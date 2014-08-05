	<?php
	/**
		* Webservice For, Fetching User Details Information.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getUserDetailsInformation()
	{		
		$jsonData=$_REQUEST['UserInfo'];
        $jsonData = json_decode($jsonData, true);
        $name = $jsonData['name']; 
		$address = $jsonData['address'];
		$age = $jsonData['age'];
		$contactNo = $jsonData['contactNo'];
		$emailID = $jsonData['emailID'];
		$emailID = strtoupper($emailID);
		$userName = $jsonData['userName'];
		$password = $jsonData['password'];
		$empID = $jsonData['empID'];
		$category = $jsonData['category'];
		
		if( $name == "" || $address == "" || $age == "" || $contactNo == "" || $emailID == "" || $userName == "" || $password == "" || $empID == "" || $category == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      
			date_default_timezone_set('Asia/Calcutta'); 
            $createdDate=date('Y-m-d H:i:s');
			
			mysql_query( "INSERT INTO User_Detail_T(NAME,ADDRESS,AGE,CONTACT_NO,EMAIL_ADDRESS,USER_NAME,PASSWORD,EMPLOYEE_ID,CATEGORY,CREATED_DATE) VALUES('$name','$address','$age','$contactNo','$emailID','$userName','$password','$empID','$category','$createdDate')" );
		    $lastInsertId = mysql_insert_id();
			if(!empty($lastInsertId)){
				
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