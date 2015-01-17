<?php
/*
 * Created on 2010-9-3
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
	require 'include/common.inc.php';
	require ROOT.'/classes/mgr/web_service_client.cls.php';

	
	$arr=Array();
	$arr["validation_code"]=$CONFIG['validation_code'];

	$webServiceClient->resetClient('/product.srv.php');
	$return = $webServiceClient->getResult($arr, 'GetProductList');
	print_r(  $return->value());
	
	$return = $webServiceClient->getResult($arr, 'GetProductCategory');
	print_r(  $return->value());

	$return = $webServiceClient->getResult($arr, 'GetProductProperties');
	print_r( $return->value());

?>