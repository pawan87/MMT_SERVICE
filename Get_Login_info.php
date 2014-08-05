	<?php
	/**
		* Webservice for, Login Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getLoginDetails()
	{		
		$emailID = $_REQUEST['emailID']; //Get Request From Device
		$emailID = strtoupper($emailID);
		$password = $_REQUEST['Password'];
		
		if( $emailID == "" || $password == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      
            $loginList = array();
			$dataQueryInfo = "SELECT * FROM User_Detail_T WHERE EMAIL_ADDRESS='$emailID' AND BINARY PASSWORD='$password'";
			$dataResultSet = mysql_query($dataQueryInfo);
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					
					$getLoginDeatils['userID']=$row['USERID'];
					$getLoginDeatils['category']=$row['CATEGORY'];
										
					array_push($loginList,$getLoginDeatils);
					
				}
				$newData=json_encode(array($loginList));
				$newData=str_replace('\/', '/', $newData);
				$newData=substr($newData,1,strlen($newData)-2);
			    
				$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
				return $newData;   
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "User Not Available";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
			}
		}
	}		
	
	echo getLoginDetails();
?>