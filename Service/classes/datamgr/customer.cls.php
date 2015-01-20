<?php
/*
 * Created on 2011-2-7
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */  
 class CustomerMgr
 {
 	private static $instance = null;
	public static $dbmgr = null;
	public static $webServiceClient = null;
	public static function getInstance() {
		return self :: $instance != null ? self :: $instance : new CustomerMgr();
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

		if(count($result)==0){
			$ret["result"]="NO_CUSTOMER";
			return $ret;
		}
		$result=$result[0];
		if($result["FDOCUMENTSTATUS"]!="C"){
			$ret["result"]="NOT_APPROVED";
			return $ret;
		}

		if($result["FFORBIDSTATUS"]!="A"){
			$ret["result"]="FORBID";
			return $ret;
		}

		$id=$result["FCUSTID"];
		$type=$result["F_XJ_CUSTYPE"];

		//分销商
		if($type=="1"){
			$sql="select c.FCUSTID customer_id,F_XJ_CUSTYPE customer_type,FNUMBER customer_no
,FSHORTNAME shortname,FNAME name
,F_XJ_BUSINESSLICENSE business_license,FTAXREGISTERCODE tax_register_code,F_XJ_ORGANIZATIONCODE orgainzation_code
,F_XJ_LBSLOCATION lbs_point
from T_BD_CUSTOMER c
inner join T_BD_CUSTOMER_L cl on c.FCUSTID=cl.FCUSTID
where c.FCUSTID=$id;";
		}else if($type=="2"){
			$sql="select c.FCUSTID customer_id,F_XJ_CUSTYPE customer_type,FNUMBER customer_no
	,FSHORTNAME shortname,FNAME name
	,F_XJ_FRANCHISESTORE is_linkedstore,F_XJ_RETAILER retailer
	,c.F_XJ_STORETYPE store_type,storeleve.FDATAVALUE store_type_str
	,c.F_XJ_STARTBUSINESSDATE business_date
	,c.F_XJ_StoreStatus store_status,case c.F_XJ_StoreStatus when '0' then '开业' when '1' then '停业改装' else '撤店' end store_status_str
	,F_XJ_MODIFYTIMES store_modify_times
	,F_XJ_STOREFETURE store_feature
	,F_XJ_SHOPKEEPER shore_keeper
	from T_BD_CUSTOMER c
	inner join T_BD_CUSTOMER_L cl on c.FCUSTID=cl.FCUSTID
	left join T_BAS_ASSISTANTDATAENTRY_L storeleve on storeleve.FENTRYID=c.F_XJ_STORETYPE
	where c.FCUSTID=$id";
		}else{
			$sql="select c.FCUSTID customer_id,F_XJ_CUSTYPE customer_type,FNUMBER customer_no
	,FSHORTNAME shortname,FNAME name
	from T_BD_CUSTOMER c
	inner join T_BD_CUSTOMER_L cl on c.FCUSTID=cl.FCUSTID
	where c.FCUSTID=$id";

		}
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array($query); 

		$sql="select FCONTACTID id,FCONTACT name,FBIZLOCATION address
,FOFFICEPHONE officephone,FMOBILEPHONE mobilephone,FFAX fax,FEMAIL email
,FISDEFAULT isdefault,FJOB job_detail
from T_BD_CUSTCONTACT where FCUSTID=$id ";

		$query = $this->dbmgr->query($sql);
		$contact = $this->dbmgr->fetch_array_all($query); 

		$result["contact_list"]=$contact;

		$sql="select FENTRYID id, FBANKCODE bankcode,FACCOUNTNAME account_name,FISDEFAULT is_default
from T_BD_CUSTBANK where FCUSTID=$id ";

		$query = $this->dbmgr->query($sql);
		$bank_account = $this->dbmgr->fetch_array_all($query); 

		$result["backaccount_list"]=$bank_account;

		$sql="select FENTRYID id,FNUMBER address_no,FNAME address_name,FADDRESS address
,FISDEFAULTCONSIGNEE is_default_reveice_address,FISDEFAULTSETTLE is_default_receipt_address,FTCONTACT contacter_id
,FISDEFAULTPAYER is_default_paid_address,FISUSED is_used
from T_BD_CUSTLOCATION where FCUSTID=$id ";

		$query = $this->dbmgr->query($sql);
		$address_list = $this->dbmgr->fetch_array_all($query); 

		$result["address_list"]=$address_list;

		return $result;
	}
 }
 
 $customerMgr=CustomerMgr::getInstance();
 $customerMgr->dbmgr=$dbmgr;
 
 
 
 
?>