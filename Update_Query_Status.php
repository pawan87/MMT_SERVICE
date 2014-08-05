	<?php
	/**
		* Webservice for, Update Query Status Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getLoginDetails()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		$Status = $_REQUEST['Status'];
		$userID = $_REQUEST['userID'];
		
		if( $queryID == "" || $Status == "" || $userID == ""){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		    date_default_timezone_set('Asia/Calcutta'); 
            $createdDate=date('Y-m-d H:i:s');
			mysql_query("UPDATE Query_Details_T SET STATUS='$Status',USERID='$userID',UPDATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
			
			/* Get User Name */
			$GetUserName=mysql_query("SELECT USER_NAME FROM User_Detail_T WHERE USERID='$userID'");
			while($ROW=mysql_fetch_array($GetUserName)){
				$userName=$ROW['USER_NAME'];
			}
			$errorCode = "1";
			$errorMsg = "Success";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\",\"userName\":\"".$userName."\"}}"; //Json Format Response
			return $newData;
			
		}
	}		
	
	echo getLoginDetails();
?>