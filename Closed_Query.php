	<?php
	/**
		* Webservice for, Closed Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getClosedDetails()
	{		
		$userID = $_REQUEST['userID']; //Get Request From Device
		$LastName = $_REQUEST['LastName']; //Get Request From Device
		$MobileNumber = $_REQUEST['MobileNumber'];
		$Source = $_REQUEST['Source'];
		$Destination = $_REQUEST['Destination'];
		$fromDate = $_REQUEST['fromDate']; 
		$FromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$ToDate=date('Y-m-d', strtotime($toDate));
		$fromDate = $_REQUEST['fromDate']; 
		$FromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$ToDate=date('Y-m-d', strtotime($toDate));
		
		if( $userID == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		    
			if(!empty($LastName) && !empty($MobileNumber) && !empty($Source) && !empty($Destination) && !empty($FromDate) && !empty($ToDate)){
			 $Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.SOURCE = "'.$Source.'" AND T1.DESTINATION = "'.$Destination.'" AND cast(T1.CREATED_DATE as date ) >= "'.$FromDate.'" AND '.'cast(T1.CREATED_DATE as date ) <= "'.$ToDate.'"';
		}
		else if(!empty($LastName) && $MobileNumber=="" && $Source=="" && $Destination=="" && $fromDate=="" && $toDate==""){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'"';
		}
		else if(!empty($MobileNumber) && $LastName=="" && $Source=="" && $Destination=="" && $fromDate=="" && $toDate==""){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'"';
		}
		else if(!empty($Source) && $LastName=="" && $MobileNumber=="" && $Destination=="" && $fromDate=="" && $toDate==""){
			$Values='T1.SOURCE = "'.$Source.'"';
		}
		else if(!empty($Destination) && $LastName=="" && $MobileNumber=="" && $Source=="" && $fromDate=="" && $toDate==""){
			$Values='T1.DESTINATION = "'.$Destination.'"';
		}
		else if(!empty($fromDate) && $LastName=="" && $MobileNumber=="" && $Source=="" && $Destination=="" && $toDate==""){
			$Values='cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($toDate) && $LastName=="" && $MobileNumber=="" && $Source=="" && $Destination=="" && $fromDate==""){
			$Values='cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($LastName) && !empty($MobileNumber)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.CONTACT_NO="'.$MobileNumber.'"';
		}
		else if(!empty($LastName) && !empty($Source)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.SOURCE="'.$Source.'"';
		}
		else if(!empty($LastName) && !empty($Destination)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.DESTINATION="'.$Destination.'"';
		}
		else if(!empty($LastName) && !empty($fromDate) && !empty($toDate)){
		
		    $Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($LastName) && !empty($fromDate)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($LastName) && !empty($toDate)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($LastName) && !empty($MobileNumber) && !empty($Source) && !empty($Destination) && !empty($FromDate)){
			 $Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.SOURCE = "'.$Source.'" AND T1.DESTINATION = "'.$Destination.'" AND cast(T1.CREATED_DATE as date ) >= "'.$FromDate.'"';
		}
		else if(!empty($LastName) && !empty($MobileNumber) && !empty($Source) && !empty($Destination)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.SOURCE = "'.$Source.'" AND T1.DESTINATION = "'.$Destination.'"';
		}
		else if(!empty($LastName) && !empty($MobileNumber) && !empty($Source)){
			$Values='T1.CUSTOMER_NAME = "'.$LastName.'" AND T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.SOURCE = "'.$Source.'"';
		}
		else if(!empty($MobileNumber) && !empty($Source)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.SOURCE="'.$Source.'"';
		}
		else if(!empty($MobileNumber) && !empty($Destination)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND T1.DESTINATION="'.$Destination.'"';
		}
		else if(!empty($MobileNumber) && !empty($fromDate) && !empty($toDate)){
		
		    $Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($MobileNumber) && !empty($fromDate)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($MobileNumber) && !empty($toDate)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($Source) && !empty($Destination)){
			$Values='T1.SOURCE = "'.$Source.'" AND T1.DESTINATION="'.$Destination.'"';
		}
		else if(!empty($Source) && !empty($fromDate) && !empty($toDate)){
		
		    $Values='T1.SOURCE = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($Source) && !empty($fromDate)){
			$Values='T1.SOURCE = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($Source) && !empty($toDate)){
			$Values='T1.SOURCE = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($Destination) && !empty($fromDate) && !empty($toDate)){
		
		    $Values='T1.DESTINATION = "'.$Destination.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($Destination) && !empty($fromDate)){
			$Values='T1.DESTINATION = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($Destination) && !empty($toDate)){
			$Values='T1.DESTINATION = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($fromDate) && !empty($toDate)){
			$Values='cast(T1.CREATED_DATE as date ) >="'.$FromDate.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
			
            $closedList = array();
		    $dataQueryInfo = "SELECT * FROM Query_Details_T as T1 WHERE QUERYID IN(SELECT t1.QUERYID FROM Payment_Schedule_Details_T as t1 WHERE QUERYID IN(SELECT t2.QUERYID FROM Query_Details_T as t2 WHERE USERID='$userID')) AND ".$Values." ORDER BY CREATED_DATE DESC";
			$dataResultSet = mysql_query($dataQueryInfo);
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					    
						$getClosedDeatils['queryID']=$row['QUERYID'];
						$getClosedDeatils['customerName']=$row['CUSTOMER_NAME'];
						$getClosedDeatils['contactNo']=$row['CONTACT_NO'];
						$getClosedDeatils['alterContactNo']=$row['ALTERNATE_NO'];
						$getClosedDeatils['emailID']=$row['EMAIL_ADDRESS'];
						$getClosedDeatils['Source']=$row['SOURCE'];
						$getClosedDeatils['Destination']=$row['DESTINATION'];
						$getClosedDeatils['noOFPx']=$row['NO_OF_PX'];
						$getClosedDeatils['journeyDate']=$row['JOURNEY_DATE'];
						$getClosedDeatils['returnDate']=$row['RETURN_DATE'];
						$getClosedDeatils['preference']=$row['PREFERENCE'];
						$getClosedDeatils['travelCategory']=$row['TRAVEL_CATEGORY'];
						$getClosedDeatils['ticketCategory']=$row['TICKET_CATEGORY'];
						$getClosedDeatils['priorityCategory']=$row['PRIORITY_CATEGORY'];
						$getClosedDeatils['referenceCategory']=$row['REFERENCE_CATEGORY'];					
					array_push($closedList,$getClosedDeatils);
					
				}
				$newData=json_encode(array($closedList));
				$newData=str_replace('\/', '/', $newData);
				$newData=substr($newData,1,strlen($newData)-2);
			    
				$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
				return $newData;   
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "Closed Details Not Available";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
			}
		}
	}		
	
	echo getClosedDetails();
?>