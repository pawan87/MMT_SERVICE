	<?php
	/*
	Webservice for Get_Client_Status_Details.
	Created By   : Pawan Patil
	Created Date : 20th July 2014
	Usage        : This file is used for update and insert all client status details.
	Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getClientStatusDetails()
	{		
		
        $queryID = $_REQUEST['queryID']; 
		$Description = $_REQUEST['Description'];
		$category = $_REQUEST['Category'];
		$clientStatus = $_REQUEST['clientStatus'];
		$Cost = $_REQUEST['Cost'];
		$GPM = $_REQUEST['GPM'];
		$sellingPrice = $_REQUEST['sellingPrice'];
	    $paymentSCH1 = $_REQUEST['paymentSCH'];
		$paymentSCH=explode(",",$paymentSCH1);
		$deferredReason = $_REQUEST['deferredReason'];
		if( $queryID == "" ){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
		}
		else{
		       $ResultList=array();
			   date_default_timezone_set('Asia/Calcutta'); 
               $createdDate=date('Y-m-d H:i:s');
				/* Check Field */
					if(!empty($paymentSCH1)){
					    $countPay=sizeof($paymentSCH);
						mysql_query("UPDATE Query_Details_T SET STATUS='F' WHERE QUERYID='$queryID'");
						$checkpayschQuery=mysql_query("SELECT * FROM Payment_Schedule_Details_T WHERE QUERYID='$queryID'");
							
							if(mysql_num_rows($checkpayschQuery) > 0){
							        
							      mysql_query("DELETE FROM Payment_Schedule_Details_T WHERE QUERYID='$queryID'");
							}
						for($j=0;$j<$countPay;$j++){
						  
						   $checkpayschQuery=mysql_query("SELECT * FROM Payment_Schedule_Details_T WHERE QUERYID='$queryID'");
							
							if(mysql_num_rows($checkpayschQuery) > 0){
							        
							      	 mysql_query("INSERT INTO Payment_Schedule_Details_T(QUERYID,PAY_SCH,CREATED_DATE) VALUES('$queryID','".$paymentSCH[$j]."','$createdDate')");
							}
						   else{
								 mysql_query("INSERT INTO Payment_Schedule_Details_T(QUERYID,PAY_SCH,CREATED_DATE) VALUES('$queryID','".$paymentSCH[$j]."','$createdDate')");
							}
						}
						
						$lastInsertId = mysql_insert_id();
			            if(!empty($lastInsertId)){
							$errorCode = "1";
							$errorMsg = "Success Pay".$paymentSCH;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
						}else{
							$errorCode = "2";
							$errorMsg = "Register Fail";
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
						}
					}
					else if(!empty($sellingPrice)){
						 mysql_query("UPDATE Client_Status_Details_T SET SELLING_PRICE='$sellingPrice' WHERE QUERYID='$queryID'");
						    $errorCode = "1";
							$errorMsg = "Success ".$sellingPrice;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
					}
					else if(!empty($GPM)){
						 mysql_query("UPDATE Client_Status_Details_T SET GPM='$GPM' WHERE QUERYID='$queryID'");
						    $errorCode = "1";
							$errorMsg = "Success ".$GPM;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
					}
					else if(!empty($Cost)){
						 mysql_query("UPDATE Client_Status_Details_T SET COST='$Cost' WHERE QUERYID='$queryID'");
						    $errorCode = "1";
							$errorMsg = "Success ".$Cost;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
					}
					else if(!empty($clientStatus) || !empty($category)){
					    	
							if(empty($clientStatus)){
								mysql_query("UPDATE Client_Status_Details_T SET CATEGORY='$category' WHERE QUERYID='$queryID'");
								$errorCode = "1";
								$errorMsg = "Success ".$category;
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
								return $newData;
							 }else{
							    
								mysql_query("UPDATE Client_Status_Details_T SET CLIENT_STATUS='$clientStatus',CATEGORY='$category' WHERE QUERYID='$queryID'");
								if($clientStatus == 'Failed'){
								mysql_query("UPDATE Query_Details_T SET STATUS='F' WHERE QUERYID='$queryID'");
								}
								
								$errorCode = "1";
								$errorMsg = "Success ".$category.' Client Status '.$clientStatus;
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
								return $newData;
							 }
							
					}
					else if(!empty($deferredReason)){
					        
							mysql_query("UPDATE Query_Details_T SET STATUS='F' WHERE QUERYID='$queryID'");
							mysql_query("UPDATE Client_Status_Details_T SET DEFERED_REASON='$deferredReason',CLIENT_STATUS='Closed' WHERE QUERYID='$queryID'");
							  
						        $errorCode = "1";
								$errorMsg = "Success".$category.' Defer Reason '.$deferredReason;
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
								return $newData;
					}
					else if(!empty($Description)){
						mysql_query("INSERT INTO Client_Status_Details_T(QUERYID,DISCRIPTION,CREATED_DATE) VALUES('$queryID','$Description','$createdDate')");
						$lastInsertId = mysql_insert_id();
			            if(!empty($lastInsertId)){
							$errorCode = "1";
							$errorMsg = "Success ".$queryID.' Description '.$Description;
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
							return $newData;
						 }else{
							$errorCode = "2";
							$errorMsg = "Register Fail";
							$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}";
							return $newData;
						 }
					}
					else if(!empty($queryID))
					{ 
					    
					    $paycheckQuery=mysql_query("SELECT * FROM Payment_Schedule_Details_T WHERE QUERYID='$queryID'");
						$payCount=mysql_num_rows($paycheckQuery);
						while($RowPay=mysql_fetch_array($paycheckQuery)){
						         $Pay_Sch.=$RowPay['PAY_SCH'].',';
								
						}
						
					    $checkRowValue=mysql_query("SELECT * FROM Client_Status_Details_T WHERE QUERYID='$queryID'");
				        if(mysql_num_rows($checkRowValue) > 0){
							while($row=mysql_fetch_array($checkRowValue)){
								$getData['queryID']=$row['QUERYID'];
								$getData['Description']=$row['DISCRIPTION'];
								$getData['Category']=$row['CATEGORY'];
								$getData['clientStatus']=$row['CLIENT_STATUS'];
								$getData['Cost']=$row['COST'];
								$getData['GPM']=$row['GPM'];
								$getData['sellingPrice']=$row['SELLING_PRICE'];
								$getData['paymentSCH']=$Pay_Sch;
								$getData['deferredReason']=$row['DEFERED_REASON'];
								
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
								$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; 
								return $newData;
						}
					}
				/* End  Check Field */
			
		}
}		
	
	echo getClientStatusDetails();
?>