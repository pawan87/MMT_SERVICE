<?php

$link = mysql_connect("localhost","phbjhqjx_mmtdb","Mtt@123");
if($link) {
	if(!mysql_select_db('phbjhqjx_MMTDB',$link)){
		echo "<h1>Invalid Database Selected.</h1>";
		die; 
	}
} else { 
	echo "<h1>Database Connection Error.</h1>";
	die;
}
?>
