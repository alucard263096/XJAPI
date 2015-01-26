select 
s.FID order_id,
s.FBILLNO order_no,
s.FDATE order_date,
s.F_XJ_CONTRACTNO contract_no,
s.FRECEIVEADDRESS receive_address,
s.FRECCONTACTID reveice_contacter_id,
cc.FCONTACT contacter,
s.F_XJ_RESULT process_result  from 
T_SAL_ORDER s 
left join T_BD_CUSTCONTACT cc on s.FRECCONTACTID=cc.FENTRYID
 where s.FID=100003
 
 