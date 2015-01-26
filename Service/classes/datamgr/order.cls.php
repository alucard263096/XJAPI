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

	public function commitSalOrder($inarray)
	{
		$customer_id=$inarray["customer_id"];
		$receiver_id=$inarray["receiver_id"];
		$receiver_address=$inarray["receiver_address"];
		$cust_name=$inarray["cust_name"];
		$cust_address=$inarray["cust_address"];
		$cust_contact=$inarray["cust_contact"];
		$cust_fax=$inarray["cust_fax"];

		$sql="select FCUSTID,F_XJ_CUSTYPE, FDOCUMENTSTATUS,FFORBIDSTATUS from T_BD_CUSTOMER
where FCUSTID=$customer_id 
and FDOCUMENTSTATUS='C' 
and FFORBIDSTATUS='A'";
		
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 
		
		if(count($result)==0){
			$ret["result"]="INACTIVE_CUSTOMER";
			return $ret;
		}
		

		$product_list=$inarray["product_list"];
		$material_list="";
		foreach($product_list as $value){
			$product_id=$value["product_id"];
			$sql="
		select m.FMATERIALID 
 from t_BD_Material m
inner join t_BD_MaterialBase base on m.FMATERIALID=base.FMATERIALID
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and m.FMATERIALID=$product_id ";
		
			$query = $this->dbmgr->query($sql);
			$result = $this->dbmgr->fetch_array_all($query); 
			if(count($result)==0){
				$material_list.=",$product_id";
			}
		}
		if($material_list!=""){
			$ret["result"]="INACTIVE_MATERIAL";
			$ret["inactive_material"]=$material_list;
			return $ret;
		}

		$this->dbmgr->begin_trans();
 
		$order_id=$this->getId('FID','t_sal_order');//$result["id"];
		
		$sql="INSERT INTO [T_SAL_ORDER]
           ([FID]
           ,[FBILLTYPEID]
           ,[FBILLNO]
           ,[FDATE]
           ,[FCUSTID]
           ,[FSALEORGID]
           ,[FSALEGROUPID]
           ,[FSALEDEPTID]
           ,[FSALERID]
           ,[FCREATORID]
           ,[FCREATEDATE]
           ,[FMODIFIERID]
           ,[FMODIFYDATE]
           ,[FDOCUMENTSTATUS]
           ,[FAPPROVERID]
           ,[FAPPROVEDATE]
           ,[FCLOSESTATUS]
           ,[FCLOSERID]
           ,[FCLOSEDATE]
           ,[FCANCELSTATUS]
           ,[FCANCELLERID]
           ,[FCANCELDATE]
           ,[FRECEIVEID]
           ,[FSETTLEID]
           ,[FCHARGEID]
           ,[FVERSIONNO]
           ,[FCHANGEREASON]
           ,[FCHANGEDATE]
           ,[FCHANGERID]
           ,[FNOTE]
           ,[FBUSINESSTYPE]
           ,[FHEADLOCID]
           ,[FHEADLOCADDRESS]
           ,[FHEADDELIVERYWAY]
           ,[FCOUNTRY]
           ,[FRECEIVEADDRESS]
           ,[FCREDITCHECKRESULT]
           ,[FOBJECTTYPEID]
           ,[FFINALVERSION]
           ,[FORIGINALFID]
           ,[FCORRESPONDORGID]
           ,[FRECCONTACTID]
           ,[F_XJ_ORDERTYPE]
           ,[F_XJ_SALETYPE]
           ,[F_XJ_GOLDTYPE]
           ,[F_XJ_CUSTARTIFICIAL]
           ,[F_XJ_CUSTADDRESS]
           ,[F_XJ_CUSTTEL]
           ,[F_XJ_CUSTFAX]
           ,[F_XJ_CONTRACTNO]
           ,[F_XJ_SECOND]
           ,[F_XJ_FAX]
           ,[F_XJ_ADDRESS]
           ,[F_XJ_ARTIFICIAL]
           ,[F_XJ_TEL])
     VALUES
           ($order_id
           ,'eacb50844fc84a10b03d7b841f3a6278'
           ,''
           ,getdate()
           ,$customer_id
           ,1
           ,0
           ,0
           ,0
           ,100001
           ,getdate()
           ,100001
           ,getdate()
           ,'Z'
           ,0
           ,NULL
           ,'A'
           ,0
           ,NULL
           ,'A'
           ,0
           ,NULL
           ,$customer_id
           ,$customer_id
           ,$customer_id
           ,'000'
           ,''
           ,NULL
           ,0
           ,''
           ,'NORMAL'
           ,0
           ,''
           ,''
           ,''
           ,'$receiver_address'
           ,'0'
           ,'SAL_SaleOrder'
           ,'1'
           ,0
           ,0
           ,$receiver_id
           ,'Cust'
           ,'ZG'
           ,'Cust'
           ,'$cust_name'
           ,'$cust_address'
           ,'$cust_contact'
           ,'$cust_fax'
           ,''
           ,''
           ,''
           ,''
           ,''
           ,'')";
		   
		$fin_entry_id=$this->getId('FENTRYID','T_SAL_ORDERFIN');//$result["id"];
		$query = $this->dbmgr->query($sql);
		$sql="INSERT INTO [T_SAL_ORDERFIN]
           ([FENTRYID]
           ,[FID]
           ,[FFINDATE]
           ,[FRECEIPTORGID]
           ,[FSETTLEORGID]
           ,[FSETTLEMODEID]
           ,[FEXCHANGETYPEID]
           ,[FEXCHANGERATE]
           ,[FLOCALCURRID]
           ,[FBILLTAXAMOUNT_LC]
           ,[FBILLAMOUNT_LC]
           ,[FBILLALLAMOUNT_LC]
           ,[FSETTLECURRID]
           ,[FPRICELISTID]
           ,[FDISCOUNTLISTID]
           ,[FPAYADVANCERATE]
           ,[FPAYADVANCEAMOUNT]
           ,[FBILLTAXAMOUNT]
           ,[FBILLAMOUNT]
           ,[FBILLALLAMOUNT]
           ,[FPRICETIMEPOINT]
           ,[FACCOUNTCONDITION]
           ,[FNEEDPAYADVANCE]
           ,[FISINCLUDEDTAX]
           ,[FRECCONDITIONID]
           ,[FRECBILLID]
           ,[FJOINORDERAMOUNT]
           ,[FJOINSTOCKAMOUNT]
           ,[FCRECHKSTATUS]
           ,[FCRECHKAMOUNT]
           ,[FCRECHKDAYS]
           ,[FCRECHKUSERID])
     VALUES
           ($fin_entry_id
           ,$order_id
           ,NULL
           ,0
           ,0
           ,0
           ,1
           ,1
           ,1
           ,0
           ,0
           ,0
           ,1
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,'1'
           ,0
           ,0
           ,0
           ,0
           ,'A'
           ,0
           ,0
           ,'')";
		$query = $this->dbmgr->query($sql);
		$seq=0;
		$entry_id=$this->getId('FENTRYID','T_SAL_ORDERENTRY');
		foreach($product_list as $value){
			$entry_id=$entry_id+1;
			$product_id=$value["product_id"];
			$qty=$value["qty"];
			$single_weight=$value["single_weight"];
			$fees=$value["single_fees"];
			$total_weight=$qty*$single_weight;
			$totalfees=$fees*$total_weight;
			$seq++;
			$sql="INSERT INTO [T_SAL_ORDERENTRY]
           ([FENTRYID]
           ,[FID]
           ,[FSEQ]
           ,[FMAPID]
           ,[FMAPNAME]
           ,[FMATERIALID]
           ,[FAUXPROPID]
           ,[FBOMID]
           ,[FUNITID]
           ,[FQTY]
           ,[FBASEUNITID]
           ,[FBASEUNITQTY]
           ,[FNOTE]
           ,[FMRPFREEZESTATUS]
           ,[FFREEZEDATE]
           ,[FFREEZERID]
           ,[FMRPTERMINATESTATUS]
           ,[FTERMINATERID]
           ,[FTERMINATESTATUS]
           ,[FTERMINATEDATE]
           ,[FMRPCLOSESTATUS]
           ,[FLOT]
           ,[FCHANGEFLAG]
           ,[FSTOCKORGID]
           ,[FSTOCKID]
           ,[FLOCKQTY]
           ,[FLOCKFLAG]
           ,[FOWNERTYPEID]
           ,[FOWNERID]
           ,[FLOT_TEXT]
           ,[FPRODUCEDATE]
           ,[FEXPIRYDATE]
           ,[FEXPUNIT]
           ,[FEXPPERIOD]
           ,[FRETURNTYPE]
           ,[FBFLOWID]
           ,[FPRIORITY]
           ,[FMTONO]
           ,[FRESERVETYPE]
           ,[FPLANDELIVERYDATE]
           ,[FDELIVERYSTATUS]
           ,[FOLDQTY]
           ,[FPROMOTIONMATCHTYPE]
           ,[F_XJ_QTY]
           ,[F_XJ_WEIGHTQTY]
           ,[F_XJ_PRICE]
           ,[F_XJ_MODEAMOUNT]
           ,[F_XJ_AMOUNT])
     VALUES
           ($entry_id
           ,$order_id
           ,$seq
           ,''
           ,''
           ,$product_id
           ,0
           ,0
           ,10097
           ,$qty
           ,10097
           ,$qty
           ,''
           ,'A'
           ,NULL
           ,0
           ,'A'
           ,0
           ,''
           ,NULL
           ,'A'
           ,0
           ,''
           ,1
           ,0
           ,0
           ,'0'
           ,'BD_OwnerOrg'
           ,1
           ,''
           ,NULL
           ,NULL
           ,''
           ,0
           ,''
           ,'813eb52e-5864-4742-8213-d8f9b0972d4f'
           ,0
           ,''
           ,'1'
           ,NULL
           ,'A'
           ,0
           ,''
           ,$single_weight
           ,$total_weight
           ,$fees
           ,0
           ,$totalfees)";
			$query = $this->dbmgr->query($sql);
			
			$sql="INSERT INTO [T_SAL_ORDERENTRY_D]
           ([FID]
           ,[FENTRYID]
           ,[FDELIVERYMAXQTY]
           ,[FDELIVERYMINQTY]
           ,[FDELIVERYCONTROL]
           ,[FTRANSPORTLEADTIME]
           ,[FPLANDELIVERYDATE]
           ,[FDELIVERYDATE]
           ,[FBASEDELIVERYMAXQTY]
           ,[FBASEDELIVERYMINQTY])
     VALUES
           ($order_id
           ,$entry_id
           ,$qty
           ,$qty
           ,0
           ,0
           ,DATEADD(dd,1,GETDATE())
           ,getdate()
           ,$qty
           ,$qty)";
			$query = $this->dbmgr->query($sql);
			
			$sql="INSERT INTO [T_SAL_ORDERENTRY_E]
           ([FENTRYID]
           ,[FID]
           ,[FOEMINSTOCKJOINQTY]
           ,[FBASEOEMINSTOCKJOINQTY])
     VALUES
           ($entry_id
           ,$order_id
           ,0
           ,0)";
			$query = $this->dbmgr->query($sql);
			
			$sql="INSERT INTO [T_SAL_ORDERENTRY_F]
           ([FENTRYID]
           ,[FID]
           ,[FPRICECOEFFICIENT]
           ,[FPRICE]
           ,[FTAXRATE]
           ,[FTAXPRICE]
           ,[FPRICEUNITID]
           ,[FPRICEUNITQTY]
           ,[FDISCOUNTRATE]
           ,[FTAXNETPRICE]
           ,[FAMOUNT]
           ,[FAMOUNT_LC]
           ,[FALLAMOUNT]
           ,[FALLAMOUNT_LC]
           ,[FDISCOUNT]
           ,[FRECEIPTORGID]
           ,[FSETTLEORGID]
           ,[FTAXAMOUNT]
           ,[FTAXAMOUNT_LC]
           ,[FACCOUNTCONDITION]
           ,[FLIMITDOWNPRICE]
           ,[FSETTLETYPEID]
           ,[FBEFDISAMT]
           ,[FBEFDISALLAMT]
           ,[FTAXCOMBINATION]
           ,[FRECEIPTCONDITIONID]
           ,[FSYSPRICE]
           ,[FISFREE]
           ,[FVALUE]
           ,[FTAXVALUE]
           ,[FPRICELISTENTRY]
           ,[FPRICEPLAN])
     VALUES
           ($entry_id
           ,$order_id
           ,1
           ,0
           ,17
           ,0
           ,10097
           ,$qty
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,1
           ,1
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,0
           ,'0'
           ,0
           ,0
           ,0
           ,'')";
			$query = $this->dbmgr->query($sql);
			
			$detail_id=$this->getId('FDETAILID','T_SAL_ORDERENTRYDELIPLAN');
			$sql="INSERT INTO [T_SAL_ORDERENTRYDELIPLAN]
           ([FDETAILID]
           ,[FENTRYID]
           ,[FSEQ]
           ,[FDELIVERYDATE]
           ,[FDELIVERYTIME]
           ,[FPLANUNITID]
           ,[FPLANQTY]
           ,[FDELICOMMITQTY]
           ,[FDELIREMAINQTY]
           ,[FSTOCKORGID]
           ,[FSTOCKID]
           ,[FDETAILLOCID]
           ,[FDETAILLOCADDRESS]
           ,[FTRANSPORTLEADTIME]
           ,[FPLANDELIVERYDATE]
           ,[FBASEPLANQTY]
           ,[FBASEDELICOMMITQTY]
           ,[FBASEDELIREMAINQTY]
           ,[FPLANBASEUNITID]
           ,[FRELBILLNO])
     VALUES
           ($detail_id
		   ,$entry_id
           ,$order_id
           ,DATEADD(dd,1,GETDATE())
           ,null
           ,10097
           ,$qty
           ,0
           ,$qty
           ,0
           ,0
           ,0
           ,'$receiver_address'
           ,0
           ,DATEADD(dd,1,GETDATE())
           ,$qty
           ,0
           ,$qty
           ,10097
           ,'')";
			$query = $this->dbmgr->query($sql);
		}
		$this->dbmgr->commit_trans();

			$ret["result"]="SUCCESS";
			$ret["order_id"]=$order_id;
			return $ret;
	}
	
	public function getId($fk,$tablename){
		$sql="select isnull(max($fk),100000)+1 id from $tablename";
		
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array($query); 

		return $result["id"];
	}

	public function getOrderStatus($order_id,$customer_id){
		
		$sql="select 
s.FID order_id,
s.FBILLNO order_no,
CONVERT(varchar(100),s.FDATE, 20) order_date,
s.F_XJ_CONTRACTNO contract_no,
s.FRECEIVEADDRESS receive_address,
s.FRECCONTACTID reveice_contacter_id,
cc.FCONTACT contacter,
s.F_XJ_RESULT process_result,
s.FDOCUMENTSTATUS order_status,
s.FCLOSESTATUS close_status,
s.FCUSTID customer_id  from 
T_SAL_ORDER s 
left join T_BD_CUSTCONTACT cc on s.FRECCONTACTID=cc.FENTRYID
 where s.FID=$order_id and s.FCUSTID=$customer_id
 ";
 
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 

		if(count($result)==0){
			$ret["result"]="NO_RECORD";
			return $ret;
		}
		$order=$result[0];
		if($order["order_status"]=="Z"
		||$order["order_status"]=="A"
		||$order["order_status"]=="B"){
			$res="WAIT_APPROVE";
		}
		if($order["order_status"]=="D"){
			$res="REJECT";
		}
		if($order["order_status"]=="C"){
			$res="WAIT_OUTSTOCK";
		}
		if($order["close_status"]=="B"){
			$res="OUTSTOCKED";
		}
		
		$sql=" select se.FENTRYID row_id,
 se.FSEQ seq,
 se.FMATERIALID product_id,
 se.FQTY qty,
 se.F_XJ_QTY single_weight,
 se.F_XJ_WEIGHTQTY totle_weight,
 se.F_XJ_PRICE handling_fees,
 se.F_XJ_AMOUNT total_fees,
 isnull(solk.FBASEUNITQTYOLD,0) outstock_qty,
 isnull(solk.FBASEUNITQTY,0) outstock_weight,
 isnull(relk.FBASICUNITQTY,0) receiveable_weight
 from T_SAL_ORDER s
 inner join T_SAL_ORDERENTRY se on s.FID=se.FID
 left join T_SAL_OUTSTOCKENTRY_LK solk on se.FENTRYID=solk.FSID and solk.FRULEID='XJ_SalOrderToXJ_SalOut' and solk.FSTABLENAME='T_SAL_ORDERENTRY'
 left join T_AR_RECEIVABLEENTRY_LK relk on solk.FENTRYID=relk.FSID and relk.FRULEID='AR_OutStockToReceivableMap' and relk.FSTABLENAME='T_SAL_OUTSTOCKENTRY'
 where s.FID=$order_id ";
		
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 
		$order["order_detail"]=$result;
		
		$Array=Array();
		$Array["result"]=$res;
		$Array["sale_order"]=$order;
		return $Array;
	}
	
	
	public function getCustomerOrderList($customer_id,$start_date,$end_date){
		
		$sql="select 
s.FID order_id,
s.FBILLNO order_no,
CONVERT(varchar(100),s.FDATE, 20) order_date,
s.F_XJ_CONTRACTNO contract_no,
s.FRECEIVEADDRESS receive_address,
s.FRECCONTACTID reveice_contacter_id,
cc.FCONTACT contacter,
s.F_XJ_RESULT process_result,
s.FDOCUMENTSTATUS order_status,
s.FCLOSESTATUS close_status,
s.FCUSTID customer_id  from 
T_SAL_ORDER s 
left join T_BD_CUSTCONTACT cc on s.FRECCONTACTID=cc.FENTRYID
 where  s.FCUSTID=$customer_id and s.FDATE>='$start_date' and s.FDATE<='$end_date'
 order by order_date
 ";
 
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 
		$count=count($result);
		for($i=0;$i<$count;$i++){
			if($result[$i]["order_status"]=="Z"
			||$result[$i]["order_status"]=="A"
			||$result[$i]["order_status"]=="B"){
				$res="WAIT_APPROVE";
			}
			if($result[$i]["order_status"]=="D"){
				$res="REJECT";
			}
			if($result[$i]["order_status"]=="C"){
				$res="WAIT_OUTSTOCK";
			}
			if($result[$i]["close_status"]=="B"){
				$res="OUTSTOCKED";
			}
			$result[$i]["order_result"]=$res;
			$order_id=$result[$i]["order_id"];
			$sql=" select se.FENTRYID row_id,
 se.FSEQ seq,
 se.FMATERIALID product_id,
 se.FQTY qty,
 se.F_XJ_QTY single_weight,
 se.F_XJ_WEIGHTQTY totle_weight,
 se.F_XJ_PRICE handling_fees,
 se.F_XJ_AMOUNT total_fees,
 isnull(solk.FBASEUNITQTYOLD,0) outstock_qty,
 isnull(solk.FBASEUNITQTY,0) outstock_weight,
 isnull(relk.FBASICUNITQTY,0) receiveable_weight
 from T_SAL_ORDER s
 inner join T_SAL_ORDERENTRY se on s.FID=se.FID
 left join T_SAL_OUTSTOCKENTRY_LK solk on se.FENTRYID=solk.FSID and solk.FRULEID='XJ_SalOrderToXJ_SalOut' and solk.FSTABLENAME='T_SAL_ORDERENTRY'
 left join T_AR_RECEIVABLEENTRY_LK relk on solk.FENTRYID=relk.FSID and relk.FRULEID='AR_OutStockToReceivableMap' and relk.FSTABLENAME='T_SAL_OUTSTOCKENTRY'
	 where s.FID=$order_id ";
			
			$query = $this->dbmgr->query($sql);
			$detail = $this->dbmgr->fetch_array_all($query); 
			$result[$i]["order_detail"]=$detail;
		
		}
		
		return $result;
	}
 }
 
 $orderMgr=OrderMgr::getInstance();
 $orderMgr->dbmgr=$dbmgr;
 
 
 
 
?>