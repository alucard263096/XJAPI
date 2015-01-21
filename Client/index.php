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

	
	$webServiceClient->resetClient('/customer.srv.php');
	$arr["login_name"]="steve_4";
	$return = $webServiceClient->getResult($arr, 'GetCustomer');
	print_r( $return->value());

	
	$webServiceClient->resetClient('/order.srv.php');
 $arr["validation_code"]=$CONFIG['validation_code'];
 $arr["customer_id"]="100029";
 $arr["receiver_id"]="100034";
 $arr["receiver_address"]="diqiuzhongguancun";
 $arr["cust_name"]="caisun";
 $arr["cust_address"]="this is address";
 $arr["cust_contact"]="13434565543";
 $arr["cust_fax"]="4546654";
 $arrntry=Array();
 $arrpd1=Array();
 $arrpd1["product_id"]="100028";
 $arrpd1["qty"]="3";
 $arrpd1["single_weight"]="123";
 $arrpd1["single_fees"]="48";
 $arrntry[]=$arrpd1;
 $arrpd2=Array();
 $arrpd2["product_id"]="100027";
 $arrpd2["qty"]="13";
 $arrpd2["single_weight"]="23";
 $arrpd2["single_fees"]="148";
 $arrntry[]=$arrpd2;
 $arr["product_list"]=$arrntry;
	$return = $webServiceClient->getResult($arr, 'CommitSalOrder');
	print_r( $return->value());

?>