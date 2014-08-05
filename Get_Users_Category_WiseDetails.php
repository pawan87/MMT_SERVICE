	<?php
	/*
	Webservice for Get_Users_Category_WiseDetails
	Created By   : Pawan Patil
	Created Date : 5th August 2014
	Usage        : This file is used for Send All Users Details Category-Wise.
	Copyright@Techila Solutions
	*/
	include_once('DBConnect.php'); //Database Connection
	include_once('JSON.php');
	function getUserCategoryWiseDetails()
	{		
		
        $category = $_REQUEST['category']; 
		/* Check Request Is Empty Or Not */
		if( $category == "" ){
			
				$errorCode = "0";
				$errorMsg = "Please Send Valid Information";
				$newData = "{\"data\":{\"Error_Code\":\"".$errorCode."\",\"Error_Msg\":\"".$errorMsg."\"}}"; //Json Format Response
				return $newData;
		}
		else{
		       $ResultList = array();
			   /* Get User Details */
			   $ResultSet=mysql_query("SELECT * FROM User_Detail_T WHERE CATEGORY='$category' ORDER BY CREATED_DATE DESC");
			   if(mysql_num_rows($ResultSet) > 0){
					while($row = mysql_fetch_array($ResultSet)){
						
						$getData['userID']=$row['USERID'];
						$getData['contactNumber']=$row['CONTACT_NO'];
						$getData['emailAddress']=$row['EMAIL_ADDRESS'];
						$getData['userName']=$row['USER_NAME'];
						$getData['name']=$row['NAME'];
						$getData['address']=$row['ADDRESS'];
						$getData['age']=$row['AGE'];
						$getData['createdDate']=$row['CREATED_DATE'];
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
}		
	
	echo getUserCategoryWiseDetails();
?>