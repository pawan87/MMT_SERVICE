	<?php
	/* 
		Webservice for Update the status.
		Created By   : Pawan Patil
        Created Date : 21th July 2014
		Usage        : This file is used for Update the Status .
		
			Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	function getStatusDetails()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		
		if( $queryID == "" ){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
			    return $newData;
		}
		else{
		       $day=0;$Hrs=0;$Min=0;$Sec=0;
			   $Tday=0;$THrs=0;$TMin=0;$TSec=0;
			   $ResultList=array();
		       $QueryResultSet=mysql_query("
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CREATED_DATE,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME,T4.DISCRIPTION,T4.SELLING_PRICE,T5.AMOUNT_COLLECTED,T5.NAV_ID,T5.BALANCE_DUE,T5.VOUCHER_REL,T6.PAY_SCH FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID INNER JOIN Client_Status_Details_T as T4 ON T3.QUERYID=T4.QUERYID INNER JOIN Closed_Query_Success_T as T5 ON T4.QUERYID=T5.QUERYID INNER JOIN Payment_Schedule_Details_T as T6 ON T5.QUERYID=T6.QUERYID WHERE T1.QUERYID='$queryID'
										  ");
			   if(mysql_num_rows($QueryResultSet) > 0){
					$ResultSet=$QueryResultSet;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
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
								$TAT = abs(strtotime($CREATED_DATE)- (strtotime($CDATE)));
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
								$getData['paySCH']=$row['PAY_SCH'];
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
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CREATED_DATE,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME,T4.DISCRIPTION,T4.SELLING_PRICE FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID INNER JOIN Client_Status_Details_T as T4 ON T3.QUERYID=T4.QUERYID  WHERE T1.QUERYID='$queryID'
										  ");
			    
               }
               if(mysql_num_rows($QueryResultSet2) > 0){
					$ResultSet=$QueryResultSet2;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
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
								$TAT = abs(strtotime($CREATED_DATE)- (strtotime($CDATE)));
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
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CREATED_DATE,T2.USER_NAME,T3.QUERY_TO_MMT,T3.CREATED_MMT_DATETIME,T3.INITIAL_RATES,T3.FIXED_RATES,T3.REVERT_TO_CUST,T3.COPY_TO_SALES,T3.CREATED_COPY_DATETIME FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID INNER JOIN Query_Status_Details_T as T3 ON T1.QUERYID=T3.QUERYID WHERE T1.QUERYID='$queryID'
										  ");	
               }
               if(mysql_num_rows($QueryResultSet3) > 0){
					$ResultSet=$QueryResultSet3;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
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
								$TAT = abs(strtotime($CREATED_DATE)- (strtotime($CDATE)));
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
			                                 SELECT T1.QUERYID,T1.CREATER_ID,T1.USERID,T1.TRAVEL_CATEGORY,T1.TICKET_CATEGORY,T1.PRIORITY_CATEGORY,T1.REFERENCE_CATEGORY,T1.CREATED_DATE,T2.USER_NAME FROM Query_Details_T as T1 INNER JOIN User_Detail_T as T2 ON T1.USERID=T2.USERID WHERE T1.QUERYID='$queryID'
										  ");
			   }
			   if(mysql_num_rows($QueryResultSet4) > 0){
					$ResultSet=$QueryResultSet4;
					while($row=mysql_fetch_array($ResultSet)){
								$getData['queryID']=$row['QUERYID'];
								$getData['createrID']=$row['CREATER_ID'];
								$getData['userID']=$row['USERID'];
								$getData['travelCategory']=$row['TRAVEL_CATEGORY'];
								$getData['ticketCategory']=$row['TICKET_CATEGORY'];
								$getData['priorityCategory']=$row['PRIORITY_CATEGORY'];
								$getData['referenceCategory']=$row['REFERENCE_CATEGORY'];
								$CREATED_DATE=$row['CREATED_DATE'];
								$getData['userName']=$row['USER_NAME'];
								
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
	}		
	
	echo getStatusDetails();
?>