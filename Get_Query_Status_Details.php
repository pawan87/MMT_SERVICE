	<?php
	/**
		* Webservice For, Fetching Query Status Details Information.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	
	function getQueryStatusDetails()
	{		
		$queryID = $_REQUEST['queryID'];
		$MMT = $_REQUEST['MMT'];
		$Initial = $_REQUEST['Initial'];
		$Rates = $_REQUEST['Rates'];
		$Revert = $_REQUEST['Revert'];
		$Copy = $_REQUEST['Copy'];
		if( $queryID == "" && $MMT == "" && $Initial == "" && $Rates == "" && $Revert == "" && $Copy == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      
				date_default_timezone_set('Asia/Calcutta'); 
				$createdDate=date('Y-m-d H:i:s');
				
				$QuerySet=mysql_query("SELECT * FROM Query_Status_Details_T WHERE QUERYID='$queryID'");
				if(mysql_num_rows($QuerySet) > 0)
				{
						
						if($MMT != ""){
						
								mysql_query("UPDATE Query_Status_Details_T SET QUERY_TO_MMT='Done',CREATED_MMT_DATETIME='$createdDate' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Query Status Updated Successfully";
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
								return $newData;
						}
					    else if($Initial != ""){
						
								mysql_query("UPDATE Query_Status_Details_T SET INITIAL_RATES='Done',CREATED_INTTIAL_DATETIME='$createdDate' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Query Status Updated Successfully";
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
								return $newData;
						}
						else if($Rates != ""){
						
								mysql_query("UPDATE Query_Status_Details_T SET FIXED_RATES='Done',CREATED_FIXEDRATES_DATETIME='$createdDate' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Query Status Updated Successfully";
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
								return $newData;
						}
						else if($Revert != ""){
						
								mysql_query("UPDATE Query_Status_Details_T SET REVERT_TO_CUST='Done',CREATED_REVERT_DATETIME='$createdDate' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Query Status Updated Successfully";
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
								return $newData;
						}
						else if($Copy != ""){
						        
								date_default_timezone_set('Asia/Calcutta'); 
								$createdDate=date('Y-m-d H:i:s');
								mysql_query("UPDATE Query_Details_T SET STATUS='CS',UPDATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
								mysql_query("UPDATE Query_Status_Details_T SET COPY_TO_SALES='Done',CREATED_COPY_DATETIME='$createdDate' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Query Status Updated Successfully";
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
								return $newData;
						}
				}
				else
				{
						
						if($MMT != ""){
						  
							    mysql_query( "INSERT INTO Query_Status_Details_T(QUERYID,QUERY_TO_MMT,CREATED_MMT_DATETIME) VALUES('$queryID','Done','$createdDate')" );
								$lastInsertId = mysql_insert_id();
								if(!empty($lastInsertId)){
									
									$errorCode = "1";
									$errorMsg = "Query Status Updated Successfully";
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
						else if($Initial != ""){
						
								mysql_query( "INSERT INTO Query_Status_Details_T(QUERYID,INITIAL_RATES,CREATED_INTTIAL_DATETIME) VALUES('$queryID','Done','$createdDate')" );
								$lastInsertId = mysql_insert_id();
								if(!empty($lastInsertId)){
									
									$errorCode = "1";
									$errorMsg = "Query Status Updated Successfully";
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
						else if($Rates != ""){
						
								mysql_query( "INSERT INTO Query_Status_Details_T(QUERYID,FIXED_RATES,CREATED_FIXEDRATES_DATETIME) VALUES('$queryID','Done','$createdDate')" );
								$lastInsertId = mysql_insert_id();
								if(!empty($lastInsertId)){
									
									$errorCode = "1";
									$errorMsg = "Query Status Updated Successfully";
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
						else if($Revert != ""){
						
								mysql_query( "INSERT INTO Query_Status_Details_T(QUERYID,REVERT_TO_CUST,CREATED_REVERT_DATETIME) VALUES('$queryID','Done','$createdDate')" );
								$lastInsertId = mysql_insert_id();
								if(!empty($lastInsertId)){
									
									$errorCode = "1";
									$errorMsg = "Query Status Updated Successfully";
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
						else if($Copy != ""){
						
								mysql_query( "INSERT INTO Query_Status_Details_T(QUERYID,COPY_TO_SALES,CREATED_COPY_DATETIME) VALUES('$queryID','Done','$createdDate')" );
								$lastInsertId = mysql_insert_id();
								if(!empty($lastInsertId)){
									
									$errorCode = "1";
									$errorMsg = "Query Status Updated Successfully";
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
			}
	}		
	
	echo getQueryStatusDetails();
?>