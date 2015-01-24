<?php

require 'include/common.inc.php';
 require ROOT.'/classes/mgr/webservice.cls.php';
 require ROOT.'/functions/order.func.php';
 
 
 $signature=array(array('struct', 'struct'));

 //$r= test();
 //print_r($r);
 //exit;
 //$res=commitSalOrder($arr);
 //print_r($res);

 //$order_id=100105;

// $arr["product_list"]=$arrntry;
 //$arr["validation_code"]=$CONFIG['validation_code'];
 //$arr["order_id"]=$order_id;
 //$arr["customer_id"]=100029;
 //print_r(getOrderStatus($arr));

 //$arr["start_date"]='1900-1-1';
 //$arr["end_date"]='2050-1-1';
 //print_r(getCustomerOrderList($arr));
 

 //print_r(getProductProperties($arr));
 //exit;
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