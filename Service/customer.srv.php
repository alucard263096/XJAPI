<?php

require 'include/common.inc.php';
 require ROOT.'/classes/mgr/webservice.cls.php';
 require ROOT.'/functions/customer.func.php';
 
 
 $signature=array(array('struct', 'struct'));

 //$r= test();
 //print_r($r);
 //exit;
 //$arr["validation_code"]=$CONFIG['validation_code'];
 //$arr["login_name"]="steve_4";
 //print_r(getCustomer($arr));
 //print_r(getProductCategory($arr));
 //print_r(getProductProperties($arr));
 //exit;
 //registed methods
 $registed_method_arr=array(
		"GetCustomer" => array(
			"function" => "getCustomer",
			"signature" =>$signature,
			"docstring" => ""
		));
		
				
 $s = new xmlrpc_server($registed_method_arr,0);
 $s->functions_parameters_type =$CONFIG['parameter_type'];
 $s->response_charset_encoding =$CONFIG['charset'];
 $s->service();
 
 
?>