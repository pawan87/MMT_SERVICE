	<?php
	/* 
		Webservice for Get All Reports.
		Created By   : Pawan Patil
        Created Date : 21th July 2014
		Usage        : This file is used for Getting Deffient Reports .
		
			Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	function getStatusDetails()
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
		else if(!empty($MobileNumber) && !empty($fromDate)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($MobileNumber) && !empty($toDate)){
			$Values='T1.CONTACT_NO = "'.$MobileNumber.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
		}
		else if(!empty($Source) && !empty($Destination)){
			$Values='T1.SOURCE = "'.$Source.'" AND T1.DESTINATION="'.$Destination.'"';
		}
		else if(!empty($Source) && !empty($fromDate)){
			$Values='T1.SOURCE = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) >="'.$FromDate.'"';
		}
		else if(!empty($Source) && !empty($toDate)){
			$Values='T1.SOURCE = "'.$Source.'" AND cast(T1.CREATED_DATE as date ) <="'.$ToDate.'"';
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
		
		
		       $day=0;$Hrs=0;$Min=0;$Sec=0;
			   $Tday=0;$THrs=0;$TMin=0;$TSec=0;
			   $ResultList=array();
			  
		       $QueryResultSet=mysql_query("
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CREATED_DATE,T1.CUSTOMER_NAME,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME,T4.DISCRIPTION,T4.SELLING_PRICE,T5.AMOUNT_COLLECTED,T5.NAV_ID,T5.BALANCE_DUE,T5.VOUCHER_REL FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID INNER JOIN Client_Status_Details_T as T4 ON T3.QUERYID=T4.QUERYID INNER JOIN Closed_Query_Success_T as T5 ON T4.QUERYID=T5.QUERYID  WHERE ".$Values."
										  ");
			   if(mysql_num_rows($QueryResultSet) > 0){
					$ResultSet=$QueryResultSet;
					while($row=mysql_fetch_array($ResultSet)){
					            $QID=$row['QUERYID'];
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
								$getData['customerName']=$row['CUSTOMER_NAME'];
								$getData['travelCategory']=$row['TRAVEL_CATEGORY'];
								$getData['ticketCategory']=$row['TICKET_CATEGORY'];
								$getData['priorityCategory']=$row['PRIORITY_CATEGORY'];
								$getData['referenceCategory']=$row['REFERENCE_CATEGORY'];
								$CREATED_DATE=$row['CREATED_DATE'];
								$getData['userName']=$row['USER_NAME'];
								$getData['MMT']=$row['QUERY_TO_MMT'];
								$CREATED_MMT_DATETIME=$row['CREATED_MMT_DATETIME'];
								$CREATED_DATE = abs(strtotime($CREATED_DATE)- (strtotime($CREATED_MMT_DATETIME)));
								 
								if($CREATED_DATE >=86400){
								   $day=floor(($CREATED_DATE/86400));
								   $Hrs=floor(($CREATED_DATE % 86400) /3600);
								   $Min=floor((($CREATED_DATE % 86400) % 3600) / 60);
								   $Sec=floor((($CREATED_DATE % 86400) % 3600) % 60);
								}else if($CREATED_DATE >= 3600){
								   $Hrs=floor($CREATED_DATE / 3600);
								   $Min=floor(($CREATED_DATE  % 3600)/60);
								   $Sec=$CREATED_DATE % 60;
								  
								}else{
									 $Min=floor($CREATED_DATE / 60);
									 $Sec=$CREATED_DATE % 60;
								   
								}
								$getData['firstRevert_Days']=$day;
								$getData['firstRevert_Hrs']=$Hrs;
								$getData['firstRevert_Min']=$Min;
								$getData['firstRevert_Sec']=$Sec;
								$getData['initialRates']=$row['INITIAL_RATES'];
								$getData['fixedRates']=$row['FIXED_RATES'];
								$getData['revertToCust']=$row['REVERT_TO_CUST'];
								$getData['copyToSale']=$row['COPY_TO_SALES'];
								$CDATE=$row['CREATED_COPY_DATETIME'];
								$CREATED_DATE1=$row['CREATED_DATE'];
								$TAT = abs(strtotime($CREATED_DATE1)- (strtotime($CDATE)));
								if(substr_count($CDATE, '0000')){
									$Flag=0;
								}
								if($Flag==0){
									$TAT=0;
								}else{
									$TAT = abs(strtotime($CREATED_DATE1)- (strtotime($CDATE)));
								}
								if($TAT >=86400){
								   $Tday=floor(($TAT/86400));
								   $THrs=floor(($TAT % 86400) /3600);
								   $TMin=floor((($TAT % 86400) % 3600) / 60);
								   $TSec=floor((($TAT % 86400) % 3600) % 60);
								}else if($TAT >= 3600){
								   $THrs=floor($TAT / 3600);
								   $TMin=floor(($TAT  % 3600)/60);
								   $TSec=$TAT % 60;
								  
								}else{
									 $TMin=floor($TAT / 60);
									 $TSec=$TAT % 60;
								   
								}
								$getData['Tat_Days']=$Tday;
								$getData['Tat_Hrs']=$THrs;
								$getData['Tat_Min']=$TMin;
								$getData['Tat_Sec']=$TSec;
								$getData['Description']=$row['DISCRIPTION'];
								$getData['sellingPrice']=$row['SELLING_PRICE'];
								$getData['paymentCollected']=$row['AMOUNT_COLLECTED'];
								$getData['navID']=$row['NAV_ID'];
								$getData['balanceDue']=$row['BALANCE_DUE'];
								$VOUCHER_DATE=$row['VOUCHER_REL'];
								if(substr_count($VOUCHER_DATE, '0000')){
								   $getData['voucherStatus ']='pending';
								}else{
								   $getData['voucherStatus ']='mailed';
							    }
								$GetPshQuery=mysql_query("SELECT * FROM Payment_Schedule_Details_T WHERE QUERYID='$QID'");
								if(mysql_num_rows($GetPshQuery) > 0){
								    While($PH=mysql_fetch_array($GetPshQuery)){
										 $PSHVALUE.=$PH['PAY_SCH'].',';
									}
								}else{
									  $getData['paySCH']="";
								}
								
								$getData['paySCH']=$PSHVALUE;
								array_push($ResultList,$getData);
			        }
								$newData=json_encode(array($ResultList));
								$newData=str_replace('\/', '/', $newData);
							    $newData=substr($newData,1,strlen($newData)-2);
						        $newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
							    return $newData; 
			   }
              else{
					 $QueryResultSet2=mysql_query("
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CUSTOMER_NAME,T1.CREATED_DATE,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME,T4.DISCRIPTION,T4.SELLING_PRICE FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID INNER JOIN Client_Status_Details_T as T4 ON T3.QUERYID=T4.QUERYID  WHERE ".$Values."
										  ");
			    
               }
               if(mysql_num_rows($QueryResultSet2) > 0){
					$ResultSet=$QueryResultSet2;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
								$getData['customerName']=$row['CUSTOMER_NAME'];
								$getData['travelCategory']=$row['TRAVEL_CATEGORY'];
								$getData['ticketCategory']=$row['TICKET_CATEGORY'];
								$getData['priorityCategory']=$row['PRIORITY_CATEGORY'];
								$getData['referenceCategory']=$row['REFERENCE_CATEGORY'];
								$CREATED_DATE=$row['CREATED_DATE'];
								$getData['userName']=$row['USER_NAME'];
								$getData['MMT']=$row['QUERY_TO_MMT'];
								$CREATED_MMT_DATETIME=$row['CREATED_MMT_DATETIME'];
								$CREATED_DATE = abs(strtotime($CREATED_DATE)- (strtotime($CREATED_MMT_DATETIME)));
								 
								if($CREATED_DATE >=86400){
								   $day=floor(($CREATED_DATE/86400));
								   $Hrs=floor(($CREATED_DATE % 86400) /3600);
								   $Min=floor((($CREATED_DATE % 86400) % 3600) / 60);
								   $Sec=floor((($CREATED_DATE % 86400) % 3600) % 60);
								}else if($CREATED_DATE >= 3600){
								   $Hrs=floor($CREATED_DATE / 3600);
								   $Min=floor(($CREATED_DATE  % 3600)/60);
								   $Sec=$CREATED_DATE % 60;
								  
								}else{
									 $Min=floor($CREATED_DATE / 60);
									 $Sec=$CREATED_DATE % 60;
								   
								}
								$getData['firstRevert_Days']=$day;
								$getData['firstRevert_Hrs']=$Hrs;
								$getData['firstRevert_Min']=$Min;
								$getData['firstRevert_Sec']=$Sec;
								$getData['initialRates']=$row['INITIAL_RATES'];
								$getData['fixedRates']=$row['FIXED_RATES'];
								$getData['revertToCust']=$row['REVERT_TO_CUST'];
								$getData['copyToSale']=$row['COPY_TO_SALES'];
								$CREATED_DATE1=$row['CREATED_DATE'];
								$CDATE=$row['CREATED_COPY_DATETIME'];
								$TAT = abs(strtotime($CREATED_DATE1)- (strtotime($CDATE)));
								if(substr_count($CDATE, '0000')){
									$Flag=0;
								}
								if($Flag==0){
									$TAT=0;
								}else{
									$TAT = abs(strtotime($CREATED_DATE1)- (strtotime($CDATE)));
								}
								if($TAT >=86400){
								   $Tday=floor(($TAT/86400));
								   $THrs=floor(($TAT % 86400) /3600);
								   $TMin=floor((($TAT % 86400) % 3600) / 60);
								   $TSec=floor((($TAT % 86400) % 3600) % 60);
								}else if($TAT >= 3600){
								   $THrs=floor($TAT / 3600);
								   $TMin=floor(($TAT  % 3600)/60);
								   $TSec=$TAT % 60;
								  
								}else{
									 $TMin=floor($TAT / 60);
									 $TSec=$TAT % 60;
								   
								}
								$getData['Tat_Days']=$Tday;
								$getData['Tat_Hrs']=$THrs;
								$getData['Tat_Min']=$TMin;
								$getData['Tat_Sec']=$TSec;
								$getData['Description']=$row['DISCRIPTION'];
								$getData['sellingPrice']=$row['SELLING_PRICE'];
								$getData['paymentCollected']="";
								$getData['navID']="";
								$getData['balanceDue']="";
								$getData['voucherStatus ']="";
								$getData['paySCH']="";
								array_push($ResultList,$getData);
			        }
								$newData=json_encode(array($ResultList));
								$newData=str_replace('\/', '/', $newData);
							    $newData=substr($newData,1,strlen($newData)-2);
						        $newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
							    return $newData; 
               }
               else{
					  $QueryResultSet3=mysql_query("
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CUSTOMER_NAME,T1.CREATED_DATE,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID WHERE ".$Values."
										  ");	
               }
               if(mysql_num_rows($QueryResultSet3) > 0){
					$ResultSet=$QueryResultSet3;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
								$getData['customerName']=$row['CUSTOMER_NAME'];
								$getData['travelCategory']=$row['TRAVEL_CATEGORY'];
								$getData['ticketCategory']=$row['TICKET_CATEGORY'];
								$getData['priorityCategory']=$row['PRIORITY_CATEGORY'];
								$getData['referenceCategory']=$row['REFERENCE_CATEGORY'];
								$CREATED_DATE=$row['CREATED_DATE'];
								$getData['userName']=$row['USER_NAME'];
								$getData['MMT']=$row['QUERY_TO_MMT'];
								$CREATED_MMT_DATETIME=$row['CREATED_MMT_DATETIME'];
								$CREATED_DATE = abs(strtotime($CREATED_DATE)- (strtotime($CREATED_MMT_DATETIME)));
								 
								if($CREATED_DATE >=86400){
								   $day=floor(($CREATED_DATE/86400));
								   $Hrs=floor(($CREATED_DATE % 86400) /3600);
								   $Min=floor((($CREATED_DATE % 86400) % 3600) / 60);
								   $Sec=floor((($CREATED_DATE % 86400) % 3600) % 60);
								}else if($CREATED_DATE >= 3600){
								   $Hrs=floor($CREATED_DATE / 3600);
								   $Min=floor(($CREATED_DATE  % 3600)/60);
								   $Sec=$CREATED_DATE % 60;
								  
								}else{
									 $Min=floor($CREATED_DATE / 60);
									 $Sec=$CREATED_DATE % 60;
								   
								}
								$getData['firstRevert_Days']=$day;
								$getData['firstRevert_Hrs']=$Hrs;
								$getData['firstRevert_Min']=$Min;
								$getData['firstRevert_Sec']=$Sec;
								$getData['initialRates']=$row['INITIAL_RATES'];
								$getData['fixedRates']=$row['FIXED_RATES'];
								$getData['revertToCust']=$row['REVERT_TO_CUST'];
								$getData['copyToSale']=$row['COPY_TO_SALES'];
								$CREATED_DATE1=$row['CREATED_DATE'];
							    $CDATE=$row['CREATED_COPY_DATETIME'];
								$TAT = abs(strtotime($CREATED_DATE1)- (strtotime($CDATE)));
								if($TAT >=86400){
								   $Tday=floor(($TAT/86400));
								   $THrs=floor(($TAT % 86400) /3600);
								   $TMin=floor((($TAT % 86400) % 3600) / 60);
								   $TSec=floor((($TAT % 86400) % 3600) % 60);
								}else if($TAT >= 3600){
								   $THrs=floor($TAT / 3600);
								   $TMin=floor(($TAT  % 3600)/60);
								   $TSec=$TAT % 60;
								  
								}else{
									 $TMin=floor($TAT / 60);
									 $TSec=$TAT % 60;
								   
								}
								$getData['Tat_Days']=$Tday;
								$getData['Tat_Hrs']=$THrs;
								$getData['Tat_Min']=$TMin;
								$getData['Tat_Sec']=$TSec;
								$getData['Description']="";
								$getData['sellingPrice']="";
								$getData['paymentCollected']="";
								$getData['navID']="";
								$getData['balanceDue']="";
								$getData['voucherStatus ']="";
								$getData['paySCH']="";
								array_push($ResultList,$getData);
			        }
								$newData=json_encode(array($ResultList));
								$newData=str_replace('\/', '/', $newData);
							    $newData=substr($newData,1,strlen($newData)-2);
						        $newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
							    return $newData; 
               }
               else{
					$QueryResultSet4=mysql_query("
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CUSTOMER_NAME,T1.CREATED_DATE,T2.USER_NAME FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID WHERE ".$Values."
										  ");
			   }
			   if(mysql_num_rows($QueryResultSet4) > 0){
					$ResultSet=$QueryResultSet4;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['customerName']=$row['CUSTOMER_NAME'];
								$getData['userID']=$row['USERID'];
								$getData['travelCategory']=$row['TRAVEL_CATEGORY'];
								$getData['ticketCategory']=$row['TICKET_CATEGORY'];
								$getData['priorityCategory']=$row['PRIORITY_CATEGORY'];
								$getData['referenceCategory']=$row['REFERENCE_CATEGORY'];
								$CREATED_DATE=$row['CREATED_DATE'];
								$getData['userName']=$row['USER_NAME'];
								$getData['MMT']="";
								$getData['firstRevert_Days']=$day;
								$getData['firstRevert_Hrs']=$Hrs;
								$getData['firstRevert_Min']=$Min;
								$getData['firstRevert_Sec']=$Sec;
								$getData['initialRates']="";
								$getData['fixedRates']="";
								$getData['revertToCust']="";
								$getData['copyToSale']="";
								$getData['Tat_Days']=$Tday;
								$getData['Tat_Hrs']=$THrs;
								$getData['Tat_Min']=$TMin;
								$getData['Tat_Sec']=$TSec;
								$getData['Description']="";
								$getData['sellingPrice']="";
								$getData['paymentCollected']="";
								$getData['navID']="";
								$getData['balanceDue']="";
								$getData['voucherStatus ']="";
								$getData['paySCH']="";
								array_push($ResultList,$getData);
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
	
	echo getStatusDetails();
?>