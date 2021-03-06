<?php 
$currentController  = Lib::currentController();
$currentAction      = Lib::currentAction();
$currentCA          = $currentController ."_".$currentAction;
//echo $currentController." ".$currentAction;
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>Kotak Securities - SQ Monitoring</title>
	
	<link href='//fonts.googleapis.com/css?family=Raleway:300,400,600,700,800' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
	
	
	<!-- Bootstrap -->
	{!! HTML::style('css/bootstrap.css') !!}
	{!! HTML::style('css/jquery.alerts.css') !!}
    {!! HTML::style('css/jquery-ui.css') !!}
	{!! HTML::style('css/admins/animate.css') !!}
	{!! HTML::style('css/admins/font-awesome.css') !!}
	<!-- custom style sheet -->
    {!! HTML::style('css/admins/style.css') !!}
    {!! HTML::style('css/admins/jquery.datetimepicker.css') !!}
    {!! HTML::style('css/admins/bootstrap-select.min.css') !!}
    
	
	{!! HTML::script('js/admins/jquery-1.11.1.min.js') !!}	
	{!! HTML::script('js/admins/jquery-ui.min.js') !!}
	{!! HTML::script('js/bootstrap.js') !!}
	{!! HTML::script('js/admins/jquery.metisMenu.js') !!}
	{!! HTML::script('js/admins/lib_functions.js') !!}
	{!! HTML::script('js/admins/jquery.slimscroll.js') !!}	
    {!! HTML::script('js/admins/jquery.alerts.js') !!}
	{!! HTML::script('js/admins/bootstrap-filestyle.min.js') !!}
    {!! HTML::script('js/admins/jquery-migrate-1.2.1.js')!!}
    {!! HTML::script('js/admins/jquery.datetimepicker.full.js')!!}
    {!! HTML::script('js/admins/jquery.dynotable.js')!!}
    {!! HTML::script('js/admins/bootstrap-select.min.js')!!}
    
    <script type="text/javascript">
    function doCancel(url) {
        window.location.href = url;
    }

    $.ajaxSetup({
    	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
	});
    var base_url = '{!! Request::root() !!}';
    $(document).ready(function(){
    	$("#message").delay(800).fadeOut(10000);
    	$(".validationAlert .error .validationError .alert-danger,.alert-success").delay(800).fadeOut(10000);
    });
    jQuery.fn.ForceNumericOnly =
    function () {
        return this.each(function () {
            $(this).keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
                return (
                        key == 8 ||
                        key == 13 ||
                        key == 9 ||
                        key == 45 ||
                        key == 46 ||
                        (key >= 48 && key <= 57) ||
                        (key >= 96 && key <= 105) ||
                        key == 189 ||
                        key == 173 ||key == 37 ||key == 39 ||
                        key == 109 ||
                        key == 190 ||
                        key == 110
                    );
            });
        });
    };
 

    </script>
	{!! HTML::script('js/admins/main.js') !!}
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php if($currentCA == 'admin_login') { ?> class="login-page" <?php } ?> class="pace-done fixed-sidebar fixed-nav">
	<div class="busy" id="background-loader">
		<div id="preloader">
		</div>
	</div>
	<div id="wrapper">
	<?php if($currentCA != 'admin_login' && $currentCA != 'admin_forgotpassword') { ?>      

			<!-- sidebar -->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
					<section class="logo-wrapper">
						<div class="logo-brand">
							<a class="navbar-brand" href="">KSEC</a>
						</div>
					</section>
					<ul class="nav metismenu" id="side-menu">
						@if (Lib::checkMenuAccess('user') || Lib::checkMenuAccess('role'))
						<li <?php if($currentCA == 'user_index' || $currentCA == 'user_create' || $currentCA == 'user_edit' || $currentCA == 'user_resetpassword' || $currentCA == 'role_index' || $currentCA == 'role_create' || $currentCA == 'role_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
							<a href=""><i class="icon-left fa fa-user"></i> System <i class="fa fa-angle-right"></i></a>
							<ul class="nav nav-second-level ">
								@if (Lib::checkMenuAccess('user'))								
								<li <?php if($currentCA == 'user_index' || $currentCA == 'user_create' || $currentCA == 'user_edit' || $currentCA == 'user_resetpassword') { ?> class="active" <?php } ?>>
									<a href="{!! route('users.index') !!}">Users</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('role'))								
								<li <?php if($currentCA == 'role_index' || $currentCA == 'role_create' || $currentCA == 'role_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('roles.index') !!}">Role</a>
								</li>
								@endif
							</ul>
						</li>
						@endif

						@if (Lib::checkMenuAccess('shapes') || Lib::checkMenuAccess('color') || Lib::checkMenuAccess('store') || Lib::checkMenuAccess('group') || Lib::checkMenuAccess('manufacturer') || Lib::checkMenuAccess('type') || Lib::checkMenuAccess('necksize') || Lib::checkMenuAccess('codevalue'))
                        <li <?php if($currentCA == 'account_index' || $currentCA == 'account_create' || $currentCA == 'account_edit' || $currentCA == 'shapes_index' || $currentCA == 'shapes_create' || $currentCA == 'shapes_edit' || $currentCA == 'stores_index' || $currentCA == 'stores_create' || $currentCA == 'stores_edit' || $currentCA == 'group_index' || $currentCA == 'group_create' || $currentCA == 'group_edit' || $currentCA == 'type_index' || $currentCA == 'type_create' || $currentCA == 'type_edit' || $currentCA == 'necksize_index' || $currentCA == 'necksize_create' || $currentCA == 'necksize_edit' || $currentCA == 'color_index' || $currentCA == 'color_create' || $currentCA == 'color_edit' || $currentCA == 'codevalue_index' || $currentCA == 'codevalue_create' || $currentCA == 'codevalue_edit' ) { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
							<a href="#" ><i class="icon-left fa fa-th-large"></i> Miscellaneous <i class="fa fa-angle-right"></i></a>						
							<ul class="nav nav-second-level ">
								@if (Lib::checkMenuAccess('shapes'))								
								<li <?php if($currentCA == 'shapes_index' || $currentCA == 'shapes_create' || $currentCA == 'shapes_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('shapes.index') !!}">Shapes</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('store'))								
								<li <?php if($currentCA == 'stores_index' || $currentCA == 'stores_create' || $currentCA == 'stores_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('stores.index') !!}">Stores</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('manufacturer'))								
								<li <?php if($currentCA == 'account_index' || $currentCA == 'account_create' || $currentCA == 'account_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('accounts.index') !!}">Manufacturer</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('group'))								
								<li <?php if($currentCA == 'group_index' || $currentCA == 'group_create' || $currentCA == 'group_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('groups.index') !!}">Groups</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('type'))								
								<li <?php if($currentCA == 'type_index' || $currentCA == 'type_create' || $currentCA == 'type_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('types.index') !!}">Types</a>
								</li>	
								@endif
								@if (Lib::checkMenuAccess('necksize'))								
								<li <?php if($currentCA == 'necksize_index' || $currentCA == 'necksize_create' || $currentCA == 'necksize_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('neckSize.index') !!}">Neck Size</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('color'))								
								<li <?php if($currentCA == 'color_index' || $currentCA == 'color_create' || $currentCA == 'color_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('colors.index') !!}">Color</a>
								</li>
								@endif
								@if (Lib::checkMenuAccess('codevalue'))								
								<li <?php if($currentCA == 'codevalue_index' || $currentCA == 'codevalue_create' || $currentCA == 'codevalue_edit') { ?> class="active" <?php } ?>>
									<a href="{!! route('codeValue.index') !!}">Code Value</a>
								</li>
								@endif
							</ul>						
						</li>
                        @endif
						@if (Lib::checkMenuAccess('drawing') || Lib::checkMenuAccess('mold') || Lib::checkMenuAccess('machinemodel') || Lib::checkMenuAccess('machine') || Lib::checkMenuAccess('downtime') || Lib::checkMenuAccess('defect') || Lib::checkMenuAccess('planning') || Lib::checkMenuAccess('hourlyentry') || Lib::checkMenuAccess('dailyentry'))
                        <li <?php if($currentCA == 'drawing_index' || $currentCA == 'drawing_create' || $currentCA == 'drawing_edit' || $currentCA == 'mold_index' || $currentCA == 'mold_create' || $currentCA == 'mold_edit' || $currentCA == 'machinemodel_index' || $currentCA == 'machinemodel_create' || $currentCA == 'machinemodel_edit' || $currentCA == 'machine_edit' || $currentCA == 'machine_index' || $currentCA == 'machine_create' || $currentCA == 'downtime_index' || $currentCA == 'downtime_create' || $currentCA == 'downtime_edit'  || $currentCA == 'planning_index' || $currentCA == 'planning_create' || $currentCA == 'planning_edit' || $currentCA == 'dailyentry_index' || $currentCA == 'dailyentry_create' || $currentCA == "dailyentry_showdailyentry" ||$currentCA == 'hourlyentry_index' || $currentCA == 'hourlyentry_create' || $currentCA == 'hourlyentry_edit' || $currentCA == 'defect_index' || $currentCA == 'defect_create' || $currentCA == 'defect_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
							<a href="javascript:void(0)" >
								<i class="icon-left fa fa-industry"></i> Production <i class="fa fa-angle-right"></i>
							</a>
							<ul class="nav nav-second-level ">
								@if (Lib::checkMenuAccess('drawing') || Lib::checkMenuAccess('mold') || Lib::checkMenuAccess('machinemodel') || Lib::checkMenuAccess('machine') || Lib::checkMenuAccess('downtime') || Lib::checkMenuAccess('defect'))
								<li <?php if($currentCA == 'drawing_index' || $currentCA == 'drawing_create' || $currentCA == 'drawing_edit' || $currentCA == 'mold_index' || $currentCA == 'mold_create' || $currentCA == 'mold_edit' || $currentCA == 'machinemodel_index' || $currentCA == 'machinemodel_create' || $currentCA == 'machinemodel_edit' || $currentCA == 'machine_edit' || $currentCA == 'machine_index' || $currentCA == 'machine_create' || $currentCA == 'downtime_index' || $currentCA == 'downtime_create' || $currentCA == 'downtime_edit' || $currentCA == 'defect_index' || $currentCA == 'defect_create' || $currentCA == 'defect_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="#" >Masters <i class="fa fa-angle-right"></i></a>
									<ul class="nav nav-third-level ">
										@if (Lib::checkMenuAccess('drawing'))
										<li <?php if($currentCA == 'drawing_index' || $currentCA == 'drawing_create' || $currentCA == 'drawing_edit') { ?> class="active" <?php } ?>>
											<a href="{!! route('drawings.index') !!}">Drawings</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('mold'))
										<li <?php if($currentCA == 'mold_index' || $currentCA == 'mold_create' || $currentCA == 'mold_edit') { ?> class="active" <?php } ?>>
											<a href="{!! route('mold.index') !!}">Mold</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('machinemodel'))
										<li <?php if($currentCA == 'machinemodel_index' || $currentCA == 'machinemodel_create' || $currentCA == 'machinemodel_edit') { ?> class="active" <?php } ?>>
											<a href="{!! route('machineModel.index') !!}">Machine Model</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('machine'))
										<li <?php if($currentCA == 'machine_index' || $currentCA == 'machine_create' || $currentCA == 'machine_edit') { ?> class="active" <?php } ?> >
											<a href="{!! route('machine.index') !!}">Machine</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('downtime'))
										<li <?php if($currentCA == 'downtime_index' || $currentCA == 'downtime_create' || $currentCA == 'downtime_edit') { ?> class="active" <?php } ?>>
											<a href="{!! route('downtime.index') !!}">Downtime</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('defect'))
										<li <?php if($currentCA == 'defect_index' || $currentCA == 'defect_create' || $currentCA == 'defect_edit') { ?> class="active" <?php } ?>>
											<a href="{!! route('defect.index') !!}">Defect</a>
										</li>
										@endif
									</ul>
								</li>
								@endif								
							</ul>
							 <ul class="nav nav-second-level ">
							 	@if(Lib::checkMenuAccess('planning') || Lib::checkMenuAccess('hourlyentry') || Lib::checkMenuAccess('dailyentry'))
								<li <?php if($currentCA == 'planning_index' || $currentCA == 'planning_create' || $currentCA == 'planning_edit' || $currentCA == 'dailyentry_index' || $currentCA == 'dailyentry_create' || $currentCA == 'dailyentry_edit' || $currentCA == "dailyentry_showdailyentry" || $currentCA == 'hourlyentry_index' || $currentCA == 'hourlyentry_create' || $currentCA == 'hourlyentry_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="javascript:void(0)" >Transactions <i class="fa fa-angle-right"></i></a>
									<ul class="nav nav-third-level ">
										@if (Lib::checkMenuAccess('planning'))
										<li <?php if($currentCA == 'planning_index' || $currentCA == 'planning_create' || $currentCA == 'planning_edit') { ?> class="active" <?php } ?>>
											<a href="{!!URL::to('planning')!!}">Planning</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('hourlyentry'))
										<li <?php if($currentCA == 'hourlyentry_index' || $currentCA == 'hourlyentry_create' || $currentCA == 'hourlyentry_edit') { ?> class="active" <?php } ?>>
											<a href="{!!URL::to('hourlyEntry')!!}">Hourly Entry</a>
										</li>
										@endif
										@if (Lib::checkMenuAccess('dailyentry'))
										<li <?php if($currentCA == 'dailyentry_index' || $currentCA == 'dailyentry_create' || $currentCA == 'dailyentry_edit' || $currentCA == "dailyentry_showdailyentry") { ?> class="active" <?php } ?>>
											<a href="{!!URL::to('dailyEntry')!!}">Daily Entry</a>
										</li>
										@endif
									</ul>
								</li>
								@endif								
							</ul> 
						</li>
						@endif
						@if (Lib::checkMenuAccess('product') || Lib::checkMenuAccess('item') || Lib::checkMenuAccess('packingmatrix') || Lib::checkMenuAccess('invert') || Lib::checkMenuAccess('rejection'))
						<li <?php if($currentCA == 'product_index' || $currentCA == 'product_create' || $currentCA == 'product_edit' || $currentCA == 'item_index' || $currentCA == 'item_create' || $currentCA == 'item_edit' || $currentCA == 'packing_index' || $currentCA == 'packing_create' || $currentCA == 'packing_edit' || $currentCA == 'invert_index' || $currentCA == 'invert_create' || $currentCA == 'invert_edit' || $currentCA == 'rejection_index' || $currentCA == 'rejection_create' || $currentCA == 'rejection_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
							<a href="javascript:void(0)" >
								<i class="icon-left glyphicon glyphicon-inbox"></i> Inventory <i class="fa fa-angle-right"></i>
							</a>
							<ul class="nav nav-second-level ">
								@if (Lib::checkMenuAccess('product') || Lib::checkMenuAccess('item'))
								<li <?php if($currentCA == 'product_index' || $currentCA == 'product_create' || $currentCA == 'product_edit' || $currentCA == 'item_index' || $currentCA == 'item_create' || $currentCA == 'item_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="#" >Masters <i class="fa fa-angle-right"></i></a>
									<ul class="nav nav-third-level ">
										@if(Lib::checkMenuAccess('product'))
										<li <?php if($currentCA == 'product_index' || $currentCA == 'product_create' || $currentCA == 'product_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
											<a href="{!! route('product.index') !!}">Product</a>
										</li>
										@endif
										@if(Lib::checkMenuAccess('item'))
										<li <?php if($currentCA == 'item_index' || $currentCA == 'item_create' || $currentCA == 'item_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
											<a href="{!! route('item.index') !!}">Item</a>
										</li>
										@endif
									</ul>
								</li>
								@endif								
							</ul>
							<ul class="nav nav-second-level ">
								@if(Lib::checkMenuAccess('packingmatrix'))
								<li <?php if($currentCA == 'packing_index' || $currentCA == 'packing_create' || $currentCA == 'packing_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="lavascript:void(0)" >Matrix <i class="fa fa-angle-right"></i></a>
									<ul class="nav nav-third-level ">
										@if(Lib::checkMenuAccess('packingmatrix'))
										<li <?php if($currentCA == 'packing_index' || $currentCA == 'packing_create' || $currentCA == 'packing_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
											<a href="{!! route('packing.index') !!}">Packing</a>
										</li>
										@endif
									</ul>
								</li>
								@endif								
							</ul>
							<ul class="nav nav-second-level ">
								@if(Lib::checkMenuAccess('invert') || Lib::checkMenuAccess('rejection'))
								<li <?php if($currentCA == 'invert_index' || $currentCA == 'invert_create' || $currentCA == 'invert_edit' || $currentCA == 'rejection_index' || $currentCA == 'rejection_create' || $currentCA == 'rejection_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="lavascript:void(0)" >Transaction <i class="fa fa-angle-right"></i></a>
									<ul class="nav nav-third-level ">
										@if(Lib::checkMenuAccess('invert'))
										<li <?php if($currentCA == 'invert_index' || $currentCA == 'invert_create' || $currentCA == 'invert_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
											<a href="{!!URL::to('invert')!!}">Inward</a>
										</li>
										@endif
										@if(Lib::checkMenuAccess('rejection'))
										<li <?php if($currentCA == 'rejection_index' || $currentCA == 'rejection_create' || $currentCA == 'rejection_edit') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
											<a href="{!!URL::to('rejection')!!}">Rejection</a>
										</li>
										@endif
									</ul>
								</li>
								@endif								
							</ul>
						</li>
						@endif
						@if (Lib::checkMenuAccess('report'))
						<li <?php if($currentCA == 'report_productionreport' || $currentCA == 'report_managementreport') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>>
							<a href="javascript:void(0)" >
								<i class="icon-left glyphicon glyphicon-inbox"></i> Reports <i class="fa fa-angle-right"></i>
							</a>
							<ul class="nav nav-second-level ">
								@if (Lib::checkActionAccess('report','productionreport'))
								<li <?php if($currentCA == 'report_productionreport') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="{!! URL::to('report/production-report') !!}" >Production Report</a>
								</li>
								@endif
								@if (Lib::checkActionAccess('report','managementreport'))								
								<li <?php if($currentCA == 'report_managementreport') { ?> class="active dropdown" <?php } else {?> class="dropdown" <?php }?>> 
									<a href="{!! URL::to('report/management-report') !!}" >Management Report</a>
								</li>
								@endif
							</ul>
						</li>
						@endif
						<li>
							<a href="#"><i class="icon-left glyphicon glyphicon-tasks"></i> Costing </a>
						</li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->   
			</nav><!-- /.navbar-static-side -->
		<?php } ?>
		<div id="page-wrapper" class="gray-bg">
		<?php if($currentCA != 'admin_login' && $currentCA != 'admin_forgotpassword') { ?>
			<div class="container-fluid">
			<div class="row border-bottom">
			<nav style="margin-bottom: 0" role="navigation" class="navbar navbar-static-top">
				<div class="top-links">
					<div class="navbar-header">
						<a href="javascript:void(0)" class="navbar-minimalize btn btn-red ">
							<i class="fa fa-bars"></i> 
						</a>						
					</div>
					<div class="welcomeWrapper center-content">
						<span class="m-r-sm text-muted welcome-message">Welcome {{@Sentinel::getUser()->first_name .' '.@Sentinel::getUser()->last_name }} | <span class="extracontent"> Unit: {!! Session::get('unitName')!!} | Type: {!! Session::get('userRole')!!} | Last Login: {!! Lib::convertDateFormat("Y-m-d H:i:s",@Sentinel::getUser()->last_login,"d-m-Y h:i A")!!}</span></span>
					</div>
					<ul class="nav navbar-top-links setting-links navbar-right">
						<!--<li>
							<span class="m-r-sm text-muted welcome-message">Welcome {{@Sentinel::getUser()->first_name .' '.@Sentinel::getUser()->last_name }}</span>
						</li>-->						
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="javascript::void(0)">
								<i class="fa fa-gear fa-fw"></i> Settings <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">    
								<li <?php if($currentCA == 'admin_profile') { ?> class="active" <?php } ?> > 
									<a href="{!! URL::to('admin/profile') !!}"><i class="fa fa-sign-out"></i> Update Profile </a> 
								</li>
								<li <?php if($currentCA == 'admin_changepassword') {?> class="active" <?php }?> > 
									<a href="{!! URL::to('admin/change-password') !!}">Change Password </a> 
								</li>                        
								<li>
									<a href="{!!URL::to('admin/logout')!!}"><i class="fa fa-sign-out"></i> Log Out</a> 
								</li>
							</ul>
							<!-- /.dropdown-user -->
						</li>
					</ul>
				</div><!-- top links -->
				</nav>
			</div><!-- row header -->
			</div>
			<?php } ?>
			<div id="maincontent"> @yield('content') </div>
			<?php if($currentCA != 'admin_login' && $currentCA != 'admin_forgotpassword') { ?>
			<div class="footer fixed">
				<p>
					<!-- <strong>Copyright</strong> <a href="">Sunpet</a> &copy; 2015  -->
				</p>
			</div><!-- footer -->
			<?php } ?>
		</div>
		<!-- /#page-wrapper -->
	</div>
    <!-- /#wrapper -->
</body>
</html>
