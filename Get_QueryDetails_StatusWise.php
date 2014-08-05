	<?php
	/* 
		Webservice for Get Query Details Status-Wise.
		Created By   : Pawan Patil
        Created Date : 18th July 2014
		Usage        : This file is used for Fetch all query list information whose status is N(Painding) 
					   or P(Inprogress) or cs(done).
		
			Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	function getNewQueryRegistartion()
	{		
		$status = $_REQUEST['status']; //Get Request From Device
		/* Check Request Is Empty Or Not */
		if( $status == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      //date('Y/m/d H:i', strtotime($created_date_time1));
            $queryList = array();
			$dataQueryInfo = "SELECT * FROM Query_Details_T WHERE STATUS='$status' ORDER BY CREATED_DATE DESC";
			$dataResultSet = mysql_query($dataQueryInfo);
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					
					$getQueryDeatils['queryID']=$row['QUERYID'];
					$getQueryDeatils['customerName']=$row['CUSTOMER_NAME'];
					$getQueryDeatils['contactNo']=$row['CONTACT_NO'];
					$getQueryDeatils['alternateNo']=$row['ALTERNATE_NO'];
					$getQueryDeatils['emailID']=$row['EMAIL_ADDRESS'];
					$getQueryDeatils['source']=$row['SOURCE'];
					$getQueryDeatils['destination']=$row['DESTINATION'];
					$getQueryDeatils['noOfPx']=$row['NO_OF_PX'];
					$getQueryDeatils['journeyDate']=$row['JOURNEY_DATE'];
					$getQueryDeatils['returnDate']=$row['RETURN_DATE'];
					$getQueryDeatils['preference']=$row['PREFERENCE'];
					$getQueryDeatils['travelCategory']=$row['TRAVEL_CATEGORY'];
					$getQueryDeatils['ticketCategory']=$row['TICKET_CATEGORY'];
					$getQueryDeatils['priorityCategory']=$row['PRIORITY_CATEGORY'];
					$getQueryDeatils['referenceCategory']=$row['REFERENCE_CATEGORY'];
					$getQueryDeatils['createdDate']=$row['CREATED_DATE'];
					$getQueryDeatils['status']=$row['STATUS'];
					
					array_push($queryList,$getQueryDeatils);
					
				}
				$newData=json_encode(array($queryList));
				$newData=str_replace('\/', '/', $newData);
				$newData=substr($newData,1,strlen($newData)-2);
			    
				$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
				return $newData;   
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "Query Details Not Available";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
			}
		}
	}		
	
	echo getNewQueryRegistartion();
?>