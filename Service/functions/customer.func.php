<?php
require ROOT.'/classes/datamgr/customer.cls.php';
 
 function getCustomer($arr){
	Global $customerMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$customerMgr->getCustomerByLoginName($arr["login_name"]);
	return $result;
 }

 
?>