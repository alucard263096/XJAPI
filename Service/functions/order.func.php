<?php
require ROOT.'/classes/datamgr/order.cls.php';
 
 function commitSalOrder($arr){
	Global $orderMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$orderMgr->commitSalOrder($arr);
	return $result;
 }

 
?>