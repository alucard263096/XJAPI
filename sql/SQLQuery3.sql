select m.FMASTERID product_id,
m.FNUMBER product_no,
ml.FNAME,
base.F_XJ_ALIAS alias,
base.F_XJ_CATEGORY category,
base.F_XJ_CLASS class,
base.F_XJ_CLASS3 class3,
base.F_XJ_CLASS4 class4,
base.F_XJ_CLASS4 class4,
base.F_XJ_Style style,
base.F_XJ_GOLDMATERIAL goldmaterial,
base.F_XJ_REFSIZE size,
base.F_XJ_PROCESSINGCHANGES processingchanges,
base.F_XJ_CERTIFICATESNO certificatesno,
base.F_XJ_THEME theme,
base.F_XJ_FIT fitgroup,
base.F_XJ_FORM manner,
m.FMODIFYDATE modifydate
 from t_BD_Material m
inner join T_BD_MATERIAL_L ml on m.FMASTERID=ml.FMATERIALID and ml.FLOCALEID=2052
inner join t_BD_MaterialBase base on m.FMASTERID=base.FMATERIALID
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and base.F_XJ_GOODSTYPE=2
order by modifydate;

select gw.* from XJ_T_GoodsWeight gw
inner join T_BD_MATERIAL m on gw.FMATERIALID=m.FMASTERID
inner join t_BD_MaterialBase base on m.FMASTERID=base.FMATERIALID
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and base.F_XJ_GOODSTYPE=2;

select c.FID id,FNAME name from XJ_t_Category c
inner join XJ_t_Category_L cl on c.FID=cl.FID
where FDOCUMENTSTATUS='C'
and FFORBIDSTATUS='A'
and c.F_XJ_LASTCLASS=0;

select a.FID mid,a.FENTRYID id, FDATAVALUE name from T_BAS_ASSISTANTDATAENTRY a
inner join T_BAS_ASSISTANTDATAENTRY_L al on a.FENTRYID=al.FENTRYID
where a.FID='005056c000089b2311e49642de9fb429';


select gw.FMATERIALID gw.XJ_T_GoodsWeight from XJ_T_GoodsWeight gw
inner join T_BD_MATERIAL m on gw.FMATERIALID=m.FMASTERID
inner join t_BD_MaterialBase base on m.FMASTERID=base.FMATERIALID
where base.FISSALE=1 
and m.FDOCUMENTSTATUS='C' 
and m.FFORBIDSTATUS='A'
and base.F_XJ_GOODSTYPE=2