	<?php
	/**
		* Get Customer Query Information Webservice.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getNewQueryRegistartion()
	{		
		$customerName = $_REQUEST['customerName']; //Get Request From Device
		$contactNo = $_REQUEST['contactNo'];
		$alternateNo = $_REQUEST['alternateNo'];
		$emailID = $_REQUEST['emailID'];
		$source = $_REQUEST['Source'];
		$destination = $_REQUEST['Destination'];
		$noOFPx = $_REQUEST['noOFPx'];
		$journeyDate = $_REQUEST['journeyDate'];
		$returnDate = $_REQUEST['returnDate'];
		$preference = $_REQUEST['Preference'];
		$category = $_REQUEST['Category'];
		$category=explode(",",$category);
		$createrID = $_REQUEST['createrID'];
		if( $customerName == "" || $contactNo == "" || $alternateNo == "" || $emailID == "" || $source == "" || $destination == "" || $noOFPx == "" || $journeyDate == "" || $returnDate == "" || $category == "" || $preference == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      //date('Y/m/d H:i', strtotime($created_date_time1));

			date_default_timezone_set('Asia/Calcutta'); 
            $createdDate=date('Y-m-d H:i:s');
			
			//N='Pending
			$Status='N';
			mysql_query( "INSERT INTO Query_Details_T(CREATER_ID,CUSTOMER_NAME,CONTACT_NO,ALTERNATE_NO,EMAIL_ADDRESS,SOURCE,DESTINATION,NO_OF_PX,JOURNEY_DATE,RETURN_DATE,PREFERENCE,TRAVEL_CATEGORY,TICKET_CATEGORY,PRIORITY_CATEGORY,REFERENCE_CATEGORY,CREATED_DATE,STATUS) VALUES('$createrID','$customerName','$contactNo','$alternateNo','$emailID','$source','$destination','$noOFPx','$journeyDate','$returnDate','$preference','".$category[0]."','".$category[1]."','".$category[2]."','".$category[3]."','$createdDate','$Status')" );
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
	
	echo getNewQueryRegistartion();
?>