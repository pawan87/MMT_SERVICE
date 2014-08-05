	<?php
	/* 
		Webservice for Get Allocated Details.
		Created By   : Pawan Patil
        Usage        : This file is used for Fetch all query list information whose status is N(Painding) or
					   P(Inprogress) or cs(done).
		Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	function getNewQueryRegistartion()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		$category = $_REQUEST['category'];
		
            $queryList = array();
			if(!empty($queryID)){
				
				$dataQueryInfo = "SELECT * FROM Query_Details_T WHERE QUERYID >'$queryID' AND TRAVEL_CATEGORY='$category' AND STATUS='P' ORDER BY CREATED_DATE DESC";
				$dataResultSet = mysql_query($dataQueryInfo);
			}
			else{
				
				$dataQueryInfo = "(SELECT * FROM Query_Details_T WHERE TRAVEL_CATEGORY='domestic' AND STATUS='P' ORDER BY CREATED_DATE DESC) UNION (SELECT * FROM Query_Details_T WHERE TRAVEL_CATEGORY='international' AND STATUS='P' ORDER BY CREATED_DATE DESC)";
			    $dataResultSet = mysql_query($dataQueryInfo);
			}
			
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
				$errorMsg = "Details Not Found";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
			}
			
	}		
	
	echo getNewQueryRegistartion();
?>