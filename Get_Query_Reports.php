	<?php
	/* 
		Webservice for Get Query Reports.
		Created By   : Pawan Patil
		Usage        : This file is used for generate Reports.
		Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getReport()
	{		
		
        $fromDate = $_REQUEST['fromDate']; 
		$fromDate=date('Y-m-d', strtotime($fromDate)); //Convert Date Format
		$toDate = $_REQUEST['toDate'];
		$toDate=date('Y-m-d', strtotime($toDate));
		$category = $_REQUEST['Category'];
		
		if( $fromDate == "" || $toDate == "" || $category == "" ){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
		}
		else{
		       $Convert=array();
			   $GPM=array();
			   date_default_timezone_set('Asia/Calcutta'); 
               $createdDate=date('Y-m-d H:i:s');
			   /* Get All Relations ID From Database using Date wise */
			   if($category =='All'){
					 $Get_Query_Result_Set=mysql_query("
												 SELECT t1.QUERYID, t2.QUERYID As QID, t3.USERID FROM Closed_Query_Success_T as t1 INNER JOIN Query_Details_T as t2
                                                 ON t1.QUERYID = t2.QUERYID INNER JOIN User_Detail_T as t3
                                                 ON t2.CREATER_ID = t3.USERID WHERE cast(t2.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t2.CREATED_DATE as date ) <= '".$toDate."'
			                                    ");
					
                    $Get_Total_Query_Result=mysql_query("SELECT count(*) as total FROM Query_Details_T WHERE cast(Query_Details_T.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(Query_Details_T.CREATED_DATE as date ) <= '".$toDate."'");
					while($GetCount=mysql_fetch_array($Get_Total_Query_Result)){
						$QueryTotal=$GetCount['total'];
					}
			   }
			   else{
					 $Get_Query_Result_Set=mysql_query("
												 SELECT t1.QUERYID, t2.QUERYID AS QID, t3.USERID FROM Closed_Query_Success_T as t1 INNER JOIN Query_Details_T as t2
                                                 ON t1.QUERYID = t2.QUERYID INNER JOIN User_Detail_T as t3
                                                 ON t2.CREATER_ID = t3.USERID WHERE t3.CATEGORY = '$category' AND cast(t2.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(t2.CREATED_DATE as date ) <= '".$toDate."'
			                                    ");
					$Get_Total_Query_Result=mysql_query("SELECT count(*) as total FROM Query_Details_T INNER JOIN User_Detail_T ON Query_Details_T.CREATER_ID=User_Detail_T.USERID WHERE cast(Query_Details_T.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(Query_Details_T.CREATED_DATE as date ) <= '".$toDate."' AND User_Detail_T.CATEGORY='$category'");
					while($GetCount=mysql_fetch_array($Get_Total_Query_Result)){
						 $QueryTotal2=$GetCount['total'];
					}						
				}
				if(mysql_num_rows($Get_Query_Result_Set) > 0){
					while($Row=mysql_fetch_array($Get_Query_Result_Set)){
						 $QUERYID=$Row['QID'];
						/* Get Voucher Release Count Here */
								 $Get_Voucher_Result=mysql_query("
																 SELECT VOUCHER_REL,QUERYID FROM Closed_Query_Success_T WHERE 
																 QUERYID='$QUERYID'
								                                 ");
								$Get_Voucher_Result2=mysql_query("
																 SELECT VOUCHER_REL FROM Closed_Query_Success_T WHERE 
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
										 
											  $VOUCHER01[]=$row3['VOUCHER_REL'];
										 }
									} /* While2 loop end */
                                     $Get_All_Voucher_count=sizeof($VOUCHER01);									
                                }
                                else{
								
								    $p=0;
								    $VOUCHER=$p;
                                } /* End If */
								/* Code For Getting GPM %  */
								$GpmQueryDetails=mysql_query("SELECT GPM FROM Client_Status_Details_T WHERE QUERYID='$QUERYID'");
								while($row4=mysql_fetch_array($GpmQueryDetails)){
									  $GPMSum+=$row4['GPM'];
									  if($row4['GPM'] != ""){
										$GPMTOTAL[]=$row4['GPM'];
									  }
								} 
					} /*End While1 */
				}
				else{
					 $errorCode = "2";
					 $errorMsg = "Query Details Not Found";
					 $newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
					 return $newData;
				} /* End If */
			    /* Calculate Convert Percentage */
				if($category=='All'){
				    $NumberOf_Query_Total=$QueryTotal;
					if($Get_All_Voucher_count!=0){
					  $VOUCHER= $Get_All_Voucher_count/$QueryTotal;
					  $VOUCHER=$VOUCHER * 100;
					}else{ $Get_All_Voucher_count = 0; }
				}else{
					$NumberOf_Query_Total=$QueryTotal2;
					if($Get_All_Voucher_count!=0){
					  $VOUCHER= $Get_All_Voucher_count/$QueryTotal2;
					  $VOUCHER=$VOUCHER * 100;
					}else{ $Get_All_Voucher_count = 0; }
				}
				/* Check record is exists or not */
			    $checkCovertQuery=mysql_num_rows($Get_Query_Result_Set);
				if($checkCovertQuery == 0){
					$p=0;
					$VOUCHER=$p;
				}
				/* Calculate GPM % */
				if($GPMSum==""){
				   $GPMSum=0;
				   $GPMSum1=0;
				}else{
				    $GPM_TOTAL=sizeof($GPMTOTAL);
					$GPMSum1=$GPMSum / $GPM_TOTAL;
				}
				/* Get Hot,Cold,Deferred,Closed,Success,Failure Percentage */
				$InProgressResultSet=mysql_query("SELECT * FROM Client_Status_Details_T as ct WHERE cast(ct.CREATED_DATE as date ) >= '".$fromDate."' AND  cast(ct.CREATED_DATE as date ) <= '".$toDate."'");
				$NumberOf_Query_InProgress_Total=mysql_num_rows($InProgressResultSet);
				  if($NumberOf_Query_InProgress_Total > 0){
					while($Query_Set=mysql_fetch_array($InProgressResultSet)){
						$CATEGORY=$Query_Set['CATEGORY'];
						$CLIENT_STATUS=$Query_Set['CLIENT_STATUS'];
						if($CATEGORY=='Hot'){ $Hot_count[]=$Query_Set['CATEGORY']; }
						if($CATEGORY=='Cold'){ $Cold_count[]=$Query_Set['CATEGORY']; }
						if($CATEGORY=='Closed'){ $Closed_count[]=$Query_Set['CATEGORY']; }
						if($CATEGORY=='Defer'){ $Defer_count[]=$Query_Set['CATEGORY']; }
						if($CLIENT_STATUS=='Success'){ $Success_count[]=$Query_Set['CLIENT_STATUS']; }
						if($CLIENT_STATUS=='Failed'){ $Failed_count[]=$Query_Set['CLIENT_STATUS']; }
							
					}
					    $HotCount = sizeof($Hot_count)/$NumberOf_Query_InProgress_Total;
						$HotCount= $HotCount * 100;
						  
						$ColdCount = sizeof($Cold_count)/$NumberOf_Query_InProgress_Total;
						$ColdCount= $ColdCount * 100;
						  
						$ClosedCount = sizeof($Closed_count)/$NumberOf_Query_InProgress_Total;
						$ClosedCount= $ClosedCount * 100;
						  
						$DeferCount = sizeof($Defer_count)/$NumberOf_Query_InProgress_Total;
						$DeferCount= $DeferCount * 100;
						  
						$SuccessCount = sizeof($Success_count)/$NumberOf_Query_InProgress_Total;
						$SuccessCount= $SuccessCount * 100;
						  
						$FailedCount = sizeof($Failed_count)/$NumberOf_Query_InProgress_Total;
						$FailedCount= $FailedCount * 100;
				  }else{
				        $HotCount=0;
						$ColdCount=0;
						$ClosedCount=0;
						$DeferCount=0;
						$SuccessCount=0;
						$FailedCount=0;
				  }
				  
				/* End Code Here */
				
				$errorCode = "1";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"No of Query\":\"".$NumberOf_Query_Total."\",\"No Of Convert\":\"".$Get_All_Voucher_count."\",\"Convert %\":\"".$VOUCHER."\",\"GPM %\":\"".$GPMSum1."\",\"Net GPM\":\"".$GPMSum."\",\"No of Query In Progress\":\"".$NumberOf_Query_InProgress_Total."\",\"Hot %\":\"".$HotCount."\",\"Cold %\":\"".$ColdCount."\",\"Closed %\":\"".$ClosedCount."\",\"Defer %\":\"".$DeferCount."\",\"Success %\":\"".$SuccessCount."\",\"Failed %\":\"".$FailedCount."\"}}"; //Json Format Response
				return $newData;
         }
   }		
	
	echo getReport();
?>