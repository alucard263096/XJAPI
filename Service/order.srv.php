<?php

require 'include/common.inc.php';
 require ROOT.'/classes/mgr/webservice.cls.php';
 require ROOT.'/functions/order.func.php';
 
 
 $signature=array(array('struct', 'struct'));

 //$r= test();
 //print_r($r);
 //exit;
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
 $arrpd1=Array();
 $arrpd1["product_id"]="100027";
 $arrpd1["qty"]="13";
 $arrpd1["single_weight"]="23";
 $arrpd1["single_fees"]="148";
 $arrntry[]=$arrpd1;
 $arr["product_list"]=$arrntry;
 //$res=commitSalOrder($arr);
 //print_r($res);

 $order_id=100105;

 $arr["product_list"]=$arrntry;
 $arr["validation_code"]=$CONFIG['validation_code'];
 $arr["order_id"]=$order_id;
 $arr["customer_id"]=100029;
 print_r(getOrderStatus($arr));

 $arr["start_date"]='1900-1-1';
 $arr["end_date"]='2050-1-1';
 print_r(getCustomerOrderList($arr));
 

 //print_r(getProductProperties($arr));
 exit;
 //registed methods
 $registed_method_arr=array(
		"CommitSalOrder" => array(
			"function" => "commitSalOrder",
			"signature" =>$signature,
			"docstring" => ""
		),
		"GetOrderStatus" => array(
			"function" => "getOrderStatus",
			"signature" =>$signature,
			"docstring" => ""
		),
		"GetCustomerOrderList" => array(
			"function" => "getCustomerOrderList",
			"signature" =>$signature,
			"docstring" => ""
		));
		
				
 $s = new xmlrpc_server($registed_method_arr,0);
 $s->functions_parameters_type =$CONFIG['parameter_type'];
 $s->response_charset_encoding =$CONFIG['charset'];
 $s->service();
 
 
?>