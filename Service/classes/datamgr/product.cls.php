<?php
/*
 * Created on 2011-2-7
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */  
 class ProductMgr
 {
 	private static $instance = null;
	public static $dbmgr = null;
	public static $webServiceClient = null;
	public static function getInstance() {
		return self :: $instance != null ? self :: $instance : new ProductMgr();
	}

	private function __construct() {
		
	}
	
	public  function __destruct ()
	{
		
	}

	public function getProductList($lastUpdatedDate)
	{
		$sql="
		select m.FMATERIALID product_id,
m.FNUMBER product_no,
ml.FNAME product_name,
base.F_XJ_ALIAS alias,
base.F_XJ_CATEGORY category,
cl1.FNAME category_name,
base.F_XJ_CLASS class,
cl2.FNAME class_name,
base.F_XJ_CLASS3 class3,
cl3.FNAME class3_name,
base.F_XJ_CLASS4 class4,
cl4.FNAME class4_name,
base.F_XJ_Style style,
base.F_XJ_GOLDMATERIAL goldmaterial,
base.F_XJ_REFSIZE size,
base.F_XJ_PROCESSINGCHANGES processingchanges,
base.F_XJ_CERTIFICATESNO certificatesno,
base.F_XJ_THEME theme,
base.F_XJ_FIT fitgroup,
base.F_XJ_FORM manner,
base.F_XJ_STANDARDWEIGHT standard_weight
 from t_BD_Material m
inner join T_BD_MATERIAL_L ml on m.FMATERIALID=ml.FMATERIALID and ml.FLOCALEID=2052
inner join t_BD_MaterialBase base on m.FMATERIALID=base.FMATERIALID
left join XJ_t_Category_L cl1 on base.F_XJ_CATEGORY=cl1.FID and cl1.FLOCALEID=2052
left join XJ_t_Category_L cl2 on base.F_XJ_CLASS=cl2.FID and cl2.FLOCALEID=2052
left join XJ_t_Category_L cl3 on base.F_XJ_CLASS3=cl3.FID and cl3.FLOCALEID=2052
left join XJ_t_Category_L cl4 on base.F_XJ_CLASS4=cl4.FID and cl4.FLOCALEID=2052
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and base.F_XJ_GOODSTYPE=2";
if($lastUpdatedDate!=""){

$sql=$sql."and  m.fmodifydate>='$lastUpdatedDate'";

}

		

		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 


		$sql="
select gw.FMATERIALID product_id,gw.F_XJ_WEIGHTDECIMAL product_weight 
 from XJ_T_GoodsWeight gw
inner join T_BD_MATERIAL m on gw.FMATERIALID=m.FMATERIALID
inner join t_BD_MaterialBase base on m.FMATERIALID=base.FMATERIALID
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and base.F_XJ_GOODSTYPE=2";
if($lastUpdatedDate!=""){

$sql=$sql."and  m.fmodifydate>='$lastUpdatedDate'";

}

		$query = $this->dbmgr->query($sql);
		$wgresult = $this->dbmgr->fetch_array_all($query); 

		$mcount=count($result);

		for($i=0;$i<$mcount;$i++){

			$weightls=Array();
			$wcount=count($wgresult);
			for($j=0;$j<$wcount;$j++){

				$wrs=$wgresult[$j];
				if($wrs["product_id"]==$result[$i]["product_id"]){
					$weightls[]=$wrs;
				}
			}
			$result[$i]["weightlist"]=$weightls;
		}
		return $result;
	}

	public function getProductCategory(){

		$sql="select c.FID id,c.F_XJ_LASTCLASS lastclassid,cl.FNAME name 
		from XJ_t_Category c
inner join XJ_t_Category_L cl on c.FID=cl.FID
where FDOCUMENTSTATUS='C'
and FFORBIDSTATUS='A'";
		
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 

		$category=$this->loopCategory($result,0);
		return $category;
	}

	public function loopCategory($result,$lastid){
		$arr=Array();
		$count=count($result);

		for($i=0;$i<$count;$i++){
			if($result[$i]["lastclassid"]==$lastid){
				$arr[]=$result[$i];
			}
		}
		
		$count=count($arr);
		for($i=0;$i<$count;$i++){
			$carr=$this->loopCategory($result,$arr[$i]["id"]);
			$arr[$i]["subclass"]=$carr;
		}

		return $arr;
	}

	public function getProductProperties(){

		$arr=Array();
		$arr["参考尺寸"]=$this->getPropertiesEntry("005056c000089b2311e49643695897d3");
		$arr["风格"]=$this->getPropertiesEntry("005056c000089b2311e49643b56dca74");
		$arr["金料"]=$this->getPropertiesEntry("005056c000089b2311e49643160432e5");
		$arr["款式"]=$this->getPropertiesEntry("005056c000089b2311e49642de9fb429");
		$arr["适宜人群"]=$this->getPropertiesEntry("005056c000089b2311e49643a492056b");
		$arr["主题"]=$this->getPropertiesEntry("005056c000089b2311e49643884afc4e");

		return $arr;

	}

	public function getPropertiesEntry($id){
		$sql="select a.FID mid,a.FENTRYID id, FDATAVALUE name from T_BAS_ASSISTANTDATAENTRY a
inner join T_BAS_ASSISTANTDATAENTRY_L al on a.FENTRYID=al.FENTRYID
where a.FID='$id';";
		$query = $this->dbmgr->query($sql);
		$result = $this->dbmgr->fetch_array_all($query); 
		return $result;
	}
 }
 
 $productMgr=ProductMgr::getInstance();
 $productMgr->dbmgr=$dbmgr;
 
 
 
 
?>