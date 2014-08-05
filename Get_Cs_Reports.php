	<?php
	/**
		* Webservice For, Reports.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getCSReport()
	{		
		
        $fromDate = $_REQUEST['fromDate']; 
		$fromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$toDate=date('Y-m-d', strtotime($toDate));
		
		if( $fromDate == "" || $toDate == "" ){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
		}
		else{
		       $ListOfId=array();
			   $GPM=array();
			   $GetResult=mysql_query("SELECT * FROM Query_Details_T as t2 WHERE cast(t2.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t2.CREATED_DATE as date ) <= '".$toDate."'");
			   if(mysql_num_rows($GetResult) > 0){
					while($row=mysql_fetch_array($GetResult)){
					    $getID['queryID']=$row['QUERYID'];
						$getID['customerName']=$row['CUSTOMER_NAME'];
						$getID['contactNo']=$row['CONTACT_NO'];
						$getID['alternateNo']=$row['ALTERNATE_NO'];
						$getID['emailID']=$row['EMAIL_ADDRESS'];
						$getID['Source']=$row['SOURCE'];
						$getID['Destination']=$row['DESTINATION'];
						$getID['noOFPx']=$row['NO_OF_PX'];
						$getID['journeyDate']=$row['JOURNEY_DATE'];
						$getID['returnDate']=$row['RETURN_DATE'];
						$getID['preference']=$row['PREFERENCE'];
						$getID['travelCategory']=$row['TRAVEL_CATEGORY'];
						$getID['ticketCategory']=$row['TICKET_CATEGORY'];
						$getID['priorityCategory']=$row['PRIORITY_CATEGORY'];
						$getID['referenceCategory']=$row['REFERENCE_CATEGORY'];
					   array_push($ListOfId,$getID);
					}
					$newData=json_encode(array($ListOfId));
					$newData=str_replace('\/', '/', $newData);
					$newData=substr($newData,1,strlen($newData)-2);
			    
					$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
					return $newData;
			   }
			   else{
					$errorCode = "2";
				    $errorMsg = "Records Not Found";
				    $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				    return $newData;
			   }
         }
   }		
	
	echo getCSReport();
?>