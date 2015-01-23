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
 
 
 function getOrderStatus($arr){
	Global $orderMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$orderMgr->getOrderStatus($arr["order_id"],$arr["customer_id"]);
	return $result;
 }
 
 function getCustomerOrderList($arr){
	Global $orderMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$orderMgr->getCustomerOrderList($arr["customer_id"],$arr["start_date"],$arr["end_date"]);
	return $result;
 }
 
 
?>