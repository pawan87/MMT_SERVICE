	<?php
	/**
		* Webservice for, Search Query Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getSearchDetails()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		$category = $_REQUEST['category'];
		$searchList = array();
			if(!empty($queryID)){
				
				$dataQueryInfo = "SELECT * FROM Query_Details_T WHERE QUERYID >'$queryID' AND TRAVEL_CATEGORY='$category' LIMIT 100";
				$dataResultSet = mysql_query($dataQueryInfo);
			}
			else{
			   
			   $dataQueryInfo = "(SELECT * FROM Query_Details_T WHERE TRAVEL_CATEGORY='domestic' ORDER BY TRAVEL_CATEGORY LIMIT 30) UNION (SELECT * FROM Query_Details_T WHERE TRAVEL_CATEGORY='international' ORDER BY TRAVEL_CATEGORY LIMIT 30)";
			   $dataResultSet = mysql_query($dataQueryInfo);
			}
			
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					
					$getSearchQueryDeatils['queryID']=$row['QUERYID'];
					$getSearchQueryDeatils['customerName']=$row['CUSTOMER_NAME'];
					$getSearchQueryDeatils['contactNo']=$row['CONTACT_NO'];
					$getSearchQueryDeatils['alternateNo']=$row['ALTERNATE_NO'];
					$getSearchQueryDeatils['emailID']=$row['EMAIL_ADDRESS'];
					$getSearchQueryDeatils['Source']=$row['SOURCE'];
					$getSearchQueryDeatils['Destination']=$row['DESTINATION'];
					$getSearchQueryDeatils['noOFPx']=$row['NO_OF_PX'];
					$getSearchQueryDeatils['journeyDate']=$row['JOURNEY_DATE'];
					$getSearchQueryDeatils['returnDate']=$row['RETURN_DATE'];
					$getSearchQueryDeatils['preference']=$row['PREFERENCE'];
					$getSearchQueryDeatils['travelCategory']=$row['TRAVEL_CATEGORY'];
					$getSearchQueryDeatils['ticketCategory']=$row['TICKET_CATEGORY'];
					$getSearchQueryDeatils['priorityCategory']=$row['PRIORITY_CATEGORY'];
					$getSearchQueryDeatils['referenceCategory']=$row['REFERENCE_CATEGORY'];
					
					array_push($searchList,$getSearchQueryDeatils);
				}
				$newData=json_encode(array($searchList));
				$newData=str_replace('\/', '/', $newData);
				$newData=substr($newData,1,strlen($newData)-2);
			    
				$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
				return $newData;   
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "Result Not Found";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
				
			}
	}		
	
	echo getSearchDetails();
?>