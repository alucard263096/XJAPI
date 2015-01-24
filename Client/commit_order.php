<?php
/*
 * Created on 2010-9-3
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
	require 'include/common.inc.php';
	require ROOT.'/classes/mgr/web_service_client.cls.php';

	if($_REQUEST["action"]=="do"){
	
	$arr=Array();
	
	$arr["validation_code"]=$CONFIG['validation_code'];
 $arr["customer_id"]=$_REQUEST["customer_id"];
 $arr["receiver_id"]="0";
 $arr["receiver_address"]="";
 $arr["cust_name"]=$_REQUEST["cust_name"];
 $arr["cust_address"]=$_REQUEST["cust_address"];
 $arr["cust_contact"]=$_REQUEST["cust_contact"];
 $arr["cust_fax"]=$_REQUEST["cust_fax"];

	 $arrntry=Array();
	 for($i=1;$i<=5;$i++){
		 if($_REQUEST["product_id_$i"]=="0"&&$_REQUEST["qty_$i"]=="0"){
		 continue;
		 }
		 $arrpd1=Array();
		 $arrpd1["product_id"]=$_REQUEST["product_id_$i"];
		 $arrpd1["qty"]=$_REQUEST["qty_$i"];
		 $arrpd1["single_weight"]=$_REQUEST["single_weight_$i"];
		 $arrpd1["single_fees"]=$_REQUEST["single_fees_$i"];
		 $arrntry[]=$arrpd1;

	 }
	$arr["product_list"]=$arrntry;
	//print_r($arr);
	$webServiceClient->resetClient('/order.srv.php');
	$return = $webServiceClient->getResult($arr, 'CommitSalOrder');
	$rs=$return->value();
	//print_r($rs);
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>生成订单</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link rel="stylesheet" media="screen" href="css/bootstrap.min.css">
        <link rel="stylesheet" media="screen" href="css/bootstrap-theme.min.css">

        <!-- Bootstrap Admin Theme -->
        <link rel="stylesheet" media="screen" href="css/bootstrap-admin-theme.css">
        <link rel="stylesheet" media="screen" href="css/bootstrap-admin-theme-change-size.css">

        <!-- Vendors -->
        <link rel="stylesheet" media="screen" href="vendors/bootstrap-datepicker/css/datepicker.css">
        <link rel="stylesheet" media="screen" href="css/datepicker.fixes.css">
        <link rel="stylesheet" media="screen" href="vendors/uniform/themes/default/css/uniform.default.min.css">
        <link rel="stylesheet" media="screen" href="css/uniform.default.fixes.css">
        <link rel="stylesheet" media="screen" href="vendors/chosen.min.css">
        <link rel="stylesheet" media="screen" href="vendors/selectize/dist/css/selectize.bootstrap3.css">
        <link rel="stylesheet" media="screen" href="vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/stylesheets/bootstrap-wysihtml5/core-b3.css">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script type="text/javascript" src="js/html5shiv.js"></script>
           <script type="text/javascript" src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bootstrap-admin-with-small-navbar">

        <div class="container">
            <!-- left, vertical navbar & content -->
            <div class="row">

                <!-- content -->
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h1>客户详情</h1>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default bootstrap-admin-no-table-panel">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">搜索条件</div>
                                </div>
                                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                                    <form class="form-horizontal" method="post">
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">客户ID</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="customer_id" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">法人</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="cust_name" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">法人地址</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="cust_address" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">法人联系电话</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="cust_contact" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">法人传真</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="cust_fax" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="date01">货品</label>
                                                <div class="col-lg-10">
                                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>货品ID</th>
                                                <th>货品数量</th>
                                                <th>货品单重</th>
                                                <th>货品手工费</th>
                                            </tr>
                                        </thead>
                                        <tbody>  <?php
											for($i=1;$i<=5;$i++){
												
												?>
											<tr>
												<td><?php echo $i;?></td>
												<td><input type="text" class="form-control" name="product_id_<?php echo $i;?>" value="0"></td>
												<td><input type="number" class="form-control" name="qty_<?php echo $i;?>" value="0"></td>
												<td><input type="number" class="form-control" name="single_weight_<?php echo $i;?>" value="0"></td>
												<td><input type="number" class="form-control" name="single_fees_<?php echo $i;?>" value="0"></td>
											</tr>
												<?php
											}
											?>
                                        </tbody>
                                    </table>
                                                </div>
                                            </div>
											<input  name="action" type='hidden' value='do' />
                                            <button type="submit" class="btn btn-primary">提交</button>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default bootstrap-admin-no-table-panel">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">结果</div>
                                </div>
                                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                                    <form class="form-horizontal" method="post">
									 <fieldset>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="optionsCheckbox2">结果</label>
                                                <div class="col-lg-10">
                                                    <label><?php echo $rs["result"]; ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="optionsCheckbox2">订单ID</label>
                                                <div class="col-lg-10">
                                                    <label><?php echo $rs["order_id"]; ?></label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>


        <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/twitter-bootstrap-hover-dropdown.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-admin-theme-change-size.js"></script>
        <script type="text/javascript" src="vendors/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="vendors/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="vendors/selectize/dist/js/standalone/selectize.min.js"></script>
        <script type="text/javascript" src="vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/javascripts/bootstrap-wysihtml5/wysihtml5.js"></script>
        <script type="text/javascript" src="vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/javascripts/bootstrap-wysihtml5/core-b3.js"></script>
        <script type="text/javascript" src="vendors/twitter-bootstrap-wizard/jquery.bootstrap.wizard-for.bootstrap3.js"></script>
        <script type="text/javascript" src="vendors/boostrap3-typeahead/bootstrap3-typeahead.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $('.datepicker').datepicker();
                $('.uniform_on').uniform();
                $('.chzn-select').chosen();
                $('.selectize-select').selectize();
                $('.textarea-wysihtml5').wysihtml5({
                    stylesheets: [
                        'vendors/bootstrap-wysihtml5-rails-b3/vendor/assets/stylesheets/bootstrap-wysihtml5/wysiwyg-color.css'
                    ]
                });

                $('#rootwizard').bootstrapWizard({
                    'nextSelector': '.next',
                    'previousSelector': '.previous',
                    onNext: function(tab, navigation, index) {
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        var $percent = ($current / $total) * 100;
                        $('#rootwizard').find('.progress-bar').css('width', $percent + '%');
                        // If it's the last tab then hide the last button and show the finish instead
                        if ($current >= $total) {
                            $('#rootwizard').find('.pager .next').hide();
                            $('#rootwizard').find('.pager .finish').show();
                            $('#rootwizard').find('.pager .finish').removeClass('disabled');
                        } else {
                            $('#rootwizard').find('.pager .next').show();
                            $('#rootwizard').find('.pager .finish').hide();
                        }
                    },
                    onPrevious: function(tab, navigation, index) {
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        var $percent = ($current / $total) * 100;
                        $('#rootwizard').find('.progress-bar').css('width', $percent + '%');
                        // If it's the last tab then hide the last button and show the finish instead
                        if ($current >= $total) {
                            $('#rootwizard').find('.pager .next').hide();
                            $('#rootwizard').find('.pager .finish').show();
                            $('#rootwizard').find('.pager .finish').removeClass('disabled');
                        } else {
                            $('#rootwizard').find('.pager .next').show();
                            $('#rootwizard').find('.pager .finish').hide();
                        }
                    },
                    onTabShow: function(tab, navigation, index) {
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        var $percent = ($current / $total) * 100;
                        $('#rootwizard').find('.bar').css({width: $percent + '%'});
                    }
                });
                $('#rootwizard .finish').click(function() {
                    alert('Finished!, Starting over!');
                    $('#rootwizard').find('a[href*=\'tab1\']').trigger('click');
                });
            });
        </script>
    </body>
</html>
