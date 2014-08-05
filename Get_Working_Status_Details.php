	<?php
	/**
		* Webservice for, Working Status Details.
	
	*/
	include_once('DBConnect.php'); //Database Connection
	function getWorkingDetails()
	{		
		$queryID = $_REQUEST['queryID']; //Get Request From Device
		
		if( $queryID == "" ){
			
			$errorCode = "0";
			$errorMsg = "Please Send Valid Information";
			$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
			return $newData;
		}
		else{
		      
            $closedList = array();
			$dataQueryInfo = "SELECT * FROM Query_Status_Details_T WHERE QUERYID='$queryID'";
			$dataResultSet = mysql_query($dataQueryInfo);
			if(mysql_num_rows($dataResultSet) > 0){
				
				while($row=mysql_fetch_array($dataResultSet)){
					
					$getWorkingDeatils['queryID']=$row['QUERYID'];
					$getWorkingDeatils['MMT']=$row['QUERY_TO_MMT'];
					$getWorkingDeatils['InitialRates']=$row['INITIAL_RATES'];
					$getWorkingDeatils['FixexRates']=$row['FIXED_RATES'];
					$getWorkingDeatils['RevertCust']=$row['REVERT_TO_CUST'];
					$getWorkingDeatils['CopyToSale']=$row['COPY_TO_SALES'];						
					array_push($closedList,$getWorkingDeatils);
					
				}
				$newData=json_encode(array($closedList));
				$newData=str_replace('\/', '/', $newData);
				$newData=substr($newData,1,strlen($newData)-2);
			    
				$newData="{\"data\":{\"Error_Code\":\"1\",\"Error_Msg\":\"Success\",\"result\":".$newData."}}";
				return $newData;   
		    }
			else{
			
				$errorCode = "2";
				$errorMsg = "Working Status Details Not Available";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
			}
		}
	}		
	
	echo getWorkingDetails();
?>