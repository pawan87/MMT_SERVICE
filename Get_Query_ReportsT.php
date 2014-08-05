	<?php
	/**
		* Webservice For, Reports.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getReport()
	{		
		
        $fromDate = $_REQUEST['fromDate']; 
		$fromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$toDate=date('Y-m-d', strtotime($toDate));
		$Flag = $_REQUEST['Flag'];
		$category = $_REQUEST['Category'];
		if( $fromDate == "" || $toDate == "" || $Flag == "" || $category == ""){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
		}
		else{
		       $getList = array();
			   date_default_timezone_set('Asia/Calcutta'); 
               $createdDate=date('Y-m-d H:i:s');
			   /* Get All Relations ID From Database using Date wise */
			   if($category =='All' && $Flag =='NFQ'){
					 
                    $Get_Total_Query_Result=mysql_query("SELECT * FROM Query_Details_T WHERE cast(Query_Details_T.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(Query_Details_T.CREATED_DATE as date ) <= '".$toDate."'");
					 if(mysql_num_rows($Get_Total_Query_Result) > 0){
						while($row=mysql_fetch_array($Get_Total_Query_Result)){
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
							array_push($getList,$getSearchQueryDeatils);
						}
						$newData=json_encode(array($getList));
						$newData=str_replace('\/', '/', $newData);
						$newData=substr($newData,1,strlen($newData)-2);
						
						$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
						return $newData; 
				   }else{
						$errorCode = "2";
						$errorMsg = "Result Not Found";
						$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
						return $newData;
				   }
			   }
			   else if($category !='All' && $Flag =='NFQ'){
					 
						$Get_Total_Query_Result=mysql_query("SELECT t1.QUERYID,t1.CUSTOMER_NAME,t1.CONTACT_NO,t1.ALTERNATE_NO,t1.EMAIL_ADDRESS,t1.SOURCE,t1.DESTINATION,t1.NO_OF_PX,t1.JOURNEY_DATE,t1.RETURN_DATE,t1.PREFERENCE,t1.TRAVEL_CATEGORY,t1.TICKET_CATEGORY,t1.PRIORITY_CATEGORY,t1.REFERENCE_CATEGORY FROM Query_Details_T as t1 INNER JOIN User_Detail_T as t2 ON t1.CREATER_ID=t2.USERID WHERE cast(t1.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t1.CREATED_DATE as date ) <= '".$toDate."' AND t2.CATEGORY='$category'");
					if(mysql_num_rows($Get_Total_Query_Result) > 0){
						while($row=mysql_fetch_array($Get_Total_Query_Result)){
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
							array_push($getList,$getSearchQueryDeatils);
						}
						 $newData=json_encode(array($getList));
						 $newData=str_replace('\/', '/', $newData);
						 $newData=substr($newData,1,strlen($newData)-2);
						
						 $newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
						 return $newData; 	
					}else{
						 $errorCode = "2";
						 $errorMsg = "Result Not Found";
						 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
						 return $newData;
                    }					
				}
				/* Check No of Convert Records */
				if($category =='All' && $Flag =='Convert'){
					
						$Get_Query_Result_Set=mysql_query("
												 SELECT t1.QUERYID, t2.QUERYID As QID, t3.USERID FROM Closed_Query_Success_T as t1 INNER JOIN Query_Details_T as t2
                                                 ON t1.QUERYID = t2.QUERYID INNER JOIN User_Detail_T as t3
                                                 ON t2.CREATER_ID = t3.USERID WHERE cast(t2.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t2.CREATED_DATE as date ) <= '".$toDate."'
			                                    ");
						if(mysql_num_rows($Get_Query_Result_Set) > 0){
							while($Row=mysql_fetch_array($Get_Query_Result_Set)){
							
								$QUERYID=$Row['QID'];
								$Get_Voucher_Result=mysql_query("
																 SELECT VOUCHER_REL,QUERYID FROM Closed_Query_Success_T WHERE 
																 QUERYID='$QUERYID'
								                                 ");
								$Get_Voucher_Result2=mysql_query("
																 SELECT * FROM Closed_Query_Success_T WHERE 
																 QUERYID='$QUERYID'
								                                 ");
								while($CRow=mysql_fetch_array($Get_Voucher_Result)){
										         $CheckValue=$CRow['QUERYID'];
                                }		
                                 if(!empty($CheckValue)){								
									while($row3=mysql_fetch_array($Get_Voucher_Result2)){
									 
									 $VOUCHER_DATE=$row3['VOUCHER_REL'];
									 if(substr_count($VOUCHER_DATE, '0000')){
											   $VOUCHER_COUNT1="";
										 }else{
										 
											   $QUERYID01=$row3['QUERYID'];
											   $GetDetailsQuery=mysql_query("SELECT * FROM Query_Details_T WHERE QUERYID='$QUERYID01'");
											   while($row=mysql_fetch_array($GetDetailsQuery)){
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
													array_push($getList,$getSearchQueryDeatils);
											   }
											     	
										 }
									} 
                                     							
                                }else{
									$errorCode = "2";
									$errorMsg = "Result Not Found";
									$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
									return $newData;
                                }								
								 								 
							} //First While Loop
							$newData=json_encode(array($getList));
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
				else if($category !='All' && $Flag =='Convert'){
						$Get_Query_Result_Set=mysql_query("
												 SELECT t1.QUERYID, t2.QUERYID AS QID, t3.USERID FROM Closed_Query_Success_T as t1 INNER JOIN Query_Details_T as t2
                                                 ON t1.QUERYID = t2.QUERYID INNER JOIN User_Detail_T as t3
                                                 ON t2.CREATER_ID = t3.USERID WHERE t3.CATEGORY = '$category' AND cast(t2.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t2.CREATED_DATE as date ) <= '".$toDate."'
			                                    ");
						if(mysql_num_rows($Get_Query_Result_Set) > 0){
							while($Row=mysql_fetch_array($Get_Query_Result_Set)){
							
								$QUERYID=$Row['QID'];
								$Get_Voucher_Result=mysql_query("
																 SELECT VOUCHER_REL,QUERYID FROM Closed_Query_Success_T WHERE 
																 QUERYID='$QUERYID'
								                                 ");
								$Get_Voucher_Result2=mysql_query("
																 SELECT * FROM Closed_Query_Success_T WHERE 
																 QUERYID='$QUERYID'
								                                 ");
								while($CRow=mysql_fetch_array($Get_Voucher_Result)){
										         $CheckValue=$CRow['QUERYID'];
                                }		
                                 if(!empty($CheckValue)){								
									while($row3=mysql_fetch_array($Get_Voucher_Result2)){
									 
									 $VOUCHER_DATE=$row3['VOUCHER_REL'];
									 if(substr_count($VOUCHER_DATE, '0000')){
											   $VOUCHER_COUNT1="";
										 }else{
										 
											   $QUERYID01=$row3['QUERYID'];
											   $GetDetailsQuery=mysql_query("SELECT * FROM Query_Details_T WHERE QUERYID='$QUERYID01'");
											   while($row=mysql_fetch_array($GetDetailsQuery)){
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
													array_push($getList,$getSearchQueryDeatils);
											   }
											     	
										 }
									} 
                                     							
                                }else{
									$errorCode = "2";
									$errorMsg = "Result Not Found";
									$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
									return $newData;
                                }								
								 								 
							} //First While Loop
							$newData=json_encode(array($getList));
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
				
         }
   }		
	
	echo getReport();
?>