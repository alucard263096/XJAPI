<?php
require ROOT.'/classes/datamgr/product.cls.php';
 
 function getProductList($arr){
	Global $productMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$productMgr->getProductList($arr["update_date"]);
	return $result;
 }

 
 function getProductCategory($arr){
	Global $productMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$productMgr->getProductCategory();
	return $result;
 }
 
 function getProductProperties($arr){
	Global $productMgr,$CONFIG;

	if($arr["validation_code"]!=$CONFIG['validation_code']){
		return Array();
	}
	
	$result=$productMgr->getProductProperties();
	return $result;
 }

?>