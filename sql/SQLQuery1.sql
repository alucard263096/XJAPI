select FCUSTID,F_XJ_CUSTYPE,F_XJ_CUSTYPE, FDOCUMENTSTATUS,FFORBIDSTATUS 
from T_BD_CUSTOMER
where 1=1
and F_XJ_WEBLOGONNAME='steve';
update T_BD_CUSTOMER set F_XJ_CUSTYPE='1' where FCUSTID=100029;
update T_BD_CUSTOMER set F_XJ_CUSTYPE='2' where FCUSTID=100030;
update T_BD_CUSTOMER set F_XJ_CUSTYPE='3' where FCUSTID=100031;

select c.FCUSTID customer_id,F_XJ_CUSTYPE customer_type,FNUMBER customer_no
,FSHORTNAME shortname,FNAME name
,F_XJ_FRANCHISESTORE is_linkedstore,F_XJ_RETAILER retailer
,c.F_XJ_STORETYPE store_type,storeleve.FDATAVALUE store_type_str
,c.F_XJ_STARTBUSINESSDATE business_date
,c.F_XJ_StoreStatus store_status,case c.F_XJ_StoreStatus when '0' then '开业' when '1' then '停业改装' else '撤店' end store_status_str
from T_BD_CUSTOMER c
inner join T_BD_CUSTOMER_L cl on c.FCUSTID=cl.FCUSTID
left join T_BAS_ASSISTANTDATAENTRY_L storeleve on storeleve.FENTRYID=c.F_XJ_STORETYPE
where c.FCUSTID=100030;
