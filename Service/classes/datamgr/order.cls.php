<?php
/*
 * Created on 2011-2-7
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */  
 class OrderMgr
 {
 	private static $instance = null;
	public static $dbmgr = null;
	public static $webServiceClient = null;
	public static function getInstance() {
		return self :: $instance != null ? self :: $instance : new OrderMgr();
	}

	private function __construct() {
		
	}
	
	public  function __destruct ()
	{
		
	}

	public function getCustomerByLoginName($LoginName)
	{
		$sql="select FCUSTID,F_XJ_CUSTYPE, FDOCUMENTSTATUS,FFORBIDSTATUS from T_BD_CUSTOMER
where F_XJ_WEBLOGONNAME='$LoginName'";
		
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 

		

		return $result;
	}
 }
 
 $orderMgr=OrderMgr::getInstance();
 $orderMgr->dbmgr=$dbmgr;
 
 
 
 
?>