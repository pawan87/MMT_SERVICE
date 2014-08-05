	<?php
	/**
		 Add Closed Query Payment Details Into Database.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getClosedPaymentDetails()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		$DDWPAY = $_REQUEST['DDWPAY'];
		$amountCollected = $_REQUEST['amountCollected'];
		$NAVID = $_REQUEST['NAVID'];
		$commitRO = $_REQUEST['commitRO'];
		$commitHO = $_REQUEST['commitHO'];
		$balanceDue = $_REQUEST['balanceDue'];
		$Description = $_REQUEST['Description'];
		$ApproveDate = $_REQUEST['approveDate'];
		$voucherRel = $_REQUEST['voucherRel'];
		if( $queryID == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
			return $newData;
		}
		else{
		        $ResultList=array();
			    date_default_timezone_set('Asia/Calcutta'); 
                $createdDate=date('Y-m-d H:i:s');
				/*Get Query Details Created Date */
				$GetCreatedDateQuery=mysql_query("SELECT * FROM Query_Details_T WHERE QUERYID='$queryID'");
				while($DateRowSet=mysql_fetch_array($GetCreatedDateQuery)){
					$Query_CREATED_DATE=$DateRowSet['CREATED_DATE'];
					$Query_CREATED_DATE=date('Y-m-d', strtotime($Query_CREATED_DATE));
				}
				
				if(!empty($Description)){
					 mysql_query("INSERT INTO Closed_Query_Failure_T(QUERYID,DESCRIPTION,CREATED_DATE) VALUES('$queryID','$Description','$createdDate')");
					 $lastInsertId = mysql_insert_id();
					 if(!empty($lastInsertId)){
			    
							$errorCode = "1";
							$errorMsg = "Success Description".$Description;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
							return $newData;
				     }
					 else{
					
							$errorCode = "2";
							$errorMsg = "Fail Description";
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
							return $newData;
					 }
				}
				else if(!empty($voucherRel)){
					 mysql_query("UPDATE Closed_Query_Success_T SET VOUCHER_REL='$createdDate',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 $errorCode = "1";
					 $errorMsg = "Success Voucher Release Date".$voucherRel;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
					 return $newData;
				}
				else if(!empty($balanceDue)){
					 mysql_query("UPDATE Closed_Query_Success_T SET BALANCE_DUE='$balanceDue',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 $errorCode = "1";
					 $errorMsg = "Success Balance Due".$balanceDue;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
					 return $newData;
				}
				else if(!empty($commitHO)){
					 mysql_query("UPDATE Closed_Query_Success_T SET COMMIT_HO='$commitHO',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 /* Get Cost From Database */
					 $getQueryValue=mysql_query("SELECT COST FROM Client_Status_Details_T WHERE QUERYID='$queryID'");
					 while($r=mysql_fetch_array($getQueryValue)){
					   $cost=$r['COST'];
					 }
					 /* Get Allocated Amount From Database */
					 $getQueryAllocatedValue=mysql_query("SELECT AMOUNT_COLLECTED FROM Closed_Query_Success_T WHERE QUERYID='$queryID'");
					 while($r2=mysql_fetch_array($getQueryAllocatedValue)){
					   $Allocated_values=$r2['AMOUNT_COLLECTED'];
					 }
					 $Total_Cost_Value=$cost - $Allocated_values;
					 /* Update Balance Due Filed */ 
					  mysql_query("UPDATE Closed_Query_Success_T SET BALANCE_DUE='$Total_Cost_Value',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 
					 $errorCode = "1";
					 $errorMsg = "Success Commit HO".$commitHO;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\",\"Cost\":\"".$Total_Cost_Value."\"}}"; 
					 return $newData;
				}
				else if(!empty($commitRO)){
					 mysql_query("UPDATE Closed_Query_Success_T SET COMMIT_RO='$commitRO',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 $errorCode = "1";
					 $errorMsg = "Success Commit RO".$commitRO;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
					 return $newData;
				}
				else if(!empty($NAVID)){
					 mysql_query("UPDATE Closed_Query_Success_T SET NAV_ID='$NAVID',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 $errorCode = "1";
					 $errorMsg = "Success Nav Id".$NAVID;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
					 return $newData;
				}
				else if(!empty($amountCollected)){
					 mysql_query("UPDATE Closed_Query_Success_T SET AMOUNT_COLLECTED='$amountCollected',CREATED_DATE='$createdDate' WHERE QUERYID='$queryID'");
					 $errorCode = "1";
					 $errorMsg = "Success Amount Collected".$amountCollected;
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
					 return $newData;
				}
				else if(!empty($DDWPAY)){
				     if($DDWPAY=='Approval'){
						mysql_query("INSERT INTO Closed_Query_Success_T(QUERYID,DDW_PAYMENT,APPROVAL_DATE,CREATED_DATE) VALUES('$queryID','$DDWPAY','$ApproveDate','$createdDate')");
					 }else{
						mysql_query("INSERT INTO Closed_Query_Success_T(QUERYID,DDW_PAYMENT,CREATED_DATE) VALUES('$queryID','$DDWPAY','$createdDate')");
					 }
						$lastInsertId = mysql_insert_id();
			            if(!empty($lastInsertId)){
							$errorCode = "1";
							$errorMsg = "Success ".$queryID.' DDW PAYMENT '.$DDWPAY;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
							return $newData;
						 }else{
							$errorCode = "2";
							$errorMsg = "Register Fail";
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
							return $newData;
						 }
				}
				else if(!empty($queryID)){
				  
					 $QueryResult01=mysql_query("SELECT * FROM Closed_Query_Success_T WHERE QUERYID='$queryID'");
					 $QueryResult02=mysql_query("SELECT * FROM Closed_Query_Failure_T WHERE QUERYID='$queryID'");
					 if(mysql_num_rows($QueryResult01) > 0){
							
							while($Row=mysql_fetch_array($QueryResult01)){
								$getData['queryID']=$Row['QUERYID'];
								$getData['DDWPAY']=$Row['DDW_PAYMENT'];
								$getData['amountCollected']=$Row['AMOUNT_COLLECTED'];
								$getData['NAVID']=$Row['NAV_ID'];
								$getData['commitRO']=$Row['COMMIT_RO'];
								$getData['commitHO']=$Row['COMMIT_HO'];
								$getData['balanceDue']=$Row['BALANCE_DUE'];
								$Approve_date=$Row['APPROVAL_DATE'];
								if(substr_count($Approve_date, '0000')){
								   $Approve_date="";
								}else{
								   $Approve_date=$Row['APPROVAL_DATE'];
								}
								$getData['approveDate']=$Approve_date;
								$Voucher_Rel=$Row['VOUCHER_REL'];
								if(substr_count($Voucher_Rel, '0000')){
								   $Voucher_Rel="";
								}else{
								   $Voucher_Rel=$Row['APPROVAL_DATE'];
								}
								$getData['approveDate']=$Approve_date;
								$getData['voucherRel']=$Voucher_Rel;
								$getData['createdDate']=$Query_CREATED_DATE;
								$getData['Description']="";
								array_push($ResultList,$getData);
							}
							    $newData=json_encode(array($ResultList));
							    $newData=str_replace('\/', '/', $newData);
							    $newData=substr($newData,1,strlen($newData)-2);
						        $newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
							    return $newData; 
					 }
					 else if(mysql_num_rows($QueryResult02) > 0){
							
							while($Row1=mysql_fetch_array($QueryResult02)){
							    $getData['queryID']=$Row1['QUERYID'];
								$getData['DDWPAY']="";
								$getData['amountCollected']="";
								$getData['NAVID']="";
								$getData['commitRO']="";
								$getData['commitHO']="";
								$getData['balanceDue']="";
								$getData['approveDate']="";
								$getData['voucherRel']="";
								$getData['Description']=$Row1['DESCRIPTION'];
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
							$errorMsg = "Result Empty";
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\",\"createdDate\":\"".$Query_CREATED_DATE."\"}}"; 
							return $newData;
					 }
				}
		}	
			
     }		
	
	echo getClosedPaymentDetails();
?>