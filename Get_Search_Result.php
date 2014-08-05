	<?php
	/* 
		Webservice for Get All Reports.
		Created By   : Pawan Patil
        Created Date : 21th July 2014
		Usage        : This file is used for Getting Deffient Reports .
		
			Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	function getSearchResults()
	{		
		$LastName = $_REQUEST['LastName']; //Get Request From Device
		$MobileNumber = $_REQUEST['MobileNumber'];
		$Source = $_REQUEST['Source'];
		$Destination = $_REQUEST['Destination'];
		$fromDate = $_REQUEST['fromDate']; 
		$FromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$ToDate=date('Y-m-d', strtotime($toDate));
		
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
		   
			   $ResultList=array();
			  
		       $QueryResultSet=mysql_query("SELECT T1.QUERYID,T1.CUSTOMER_NAME,T1.CONTACT_NO,T1.ALTERNATE_NO,T1.EMAIL_ADDRESS,T1.SOURCE,T1.DESTINATION,T1.NO_OF_PX,T1.JOURNEY_DATE,T1.RETURN_DATE,T1.PREFERENCE,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY FROM Query_Details_T as T1 WHERE ".$Values." ORDER BY T1.CREATED_DATE DESC");
			   if(mysql_num_rows($QueryResultSet) > 0){
						while($row=mysql_fetch_array($QueryResultSet)){
						
						$getSearchQueryDeatils['queryID']=$row['QUERYID'];
						$getSearchQueryDeatils['customerName']=$row['CUSTOMER_NAME'];
						$getSearchQueryDeatils['contactNo']=$row['CONTACT_NO'];
						$getSearchQueryDeatils['alterContactNo']=$row['ALTERNATE_NO'];
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
						
						array_push($ResultList,$getSearchQueryDeatils);
					}
					$newData=json_encode(array($ResultList));
					$newData=str_replace('\/', '/', $newData);
					$newData=substr($newData,1,strlen($newData)-2);
					
					$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
					return $newData;   
			   }
               else{
					$errorCode = "2";
				    $errorMsg = "Result Not Found";
				    $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
				    return $newData;
			   }
	}		
	
	echo getSearchResults();
?>