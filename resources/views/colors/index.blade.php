@extends('layout.admin')
@section('content')
<script type="text/javascript">
	function validateSearch()
    {
        $("#search_alert").html("");
		name = $("#colorName").val();
		status = $("#status").val();
		if(name == "" && status == "")
		{
			$("#error_alert").html("<?php echo Lang::get('messages.search_req');?>");
			return false;
		}
		return true;
	}
	$(function(){

		if($("#colorName").val() != "" || $("#status").val() != "")
		{
			var $slidedown = $('.searchForm');
			$slidedown.slideDown();
			$('.close-filter').fadeIn('slowly');
		}  
	});
</script>
<!-- Container Start -->
<div id="main-container" class="main-container ">
	<div class="breadcrumb-wrapper container-fluid white-bg">
		<div class="row">
			<div class="col-lg-10 col-md-10">
				<ol class="breadcrumb">
					<li>
						Miscellaneous
					</li>
					<li class="active">
						<strong>Manage Colors</strong>
					</li>				
				</ol>
			</div>
			<div class="col-lg-2 col-md-2 align-right">
				<a title="Close Filter" class="btn btn-white close-filter" style="display:none;" href="javascript:void(0)">
					<span class="label label-default"><i class="glyphicon glyphicon-remove"></i> Close</span>
				</a>
			</div>
		</div>
	</div>
	
	<div class="searchForm " style="display:none;">
		<div class="container-fluid">
			<div class="form-container">
			{!! Form::open(array('route' => 'colors.index','method'=>'GET','onSubmit' => 'return validateSearch()')) !!}
			
				<div class="form-control-wrapper">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4"> 
								{!! Form::label('colorName', 'Color Name') !!}
								{!! Form::text('colorName',Request::get('colorName'),array("placeholder"=>"Color Name",'id'=>'colorName','class'=>'form-control')) !!} 
							</div>					
							<div class="col-sm-4">											
								{!! HTML::decode(Form::label('status', 'Status <small class="mandatory">*</small>')) !!}						
								{!! Form::select('status', $status,Request::get('status') , ['id'=>'status','class'=>'form-control']) !!}
							</div>
						</div>
					</div>	
					<div id="error_alert" class="error validationAlert validationError"></div>	
					<!-- action wrapper -->
					<div class="form-group action">
						<div class="col-lg-12 pull-center buttons"> 
							{!! Form::submit('Search', array('class' => 'btn btn-red')) !!}			
							<button type="button" class="btn btn-black" onclick="doCancel('{!! URL::to('colors') !!}')">Cancel</button>
						</div>									
					</div><!-- action end -->
				</div><!-- Form control wrapper end -->
			{!! Form::close() !!}
			</div>
		</div>
	</div><!-- Search Form end -->
	
	<div class="pageHeading container-fluid">
		<div class="row ">			
			<div class="page-title-wrapper">			
				<div class="col-lg-8">
					<h2 class="page-header">Manage Colors</h2>					
				</div>
				<div class="col-lg-4">
					<div class="title-action">
						<a title="Add Color" class="btn btn-white add-shape add-icons" href="{!! route('colors.create')!!}">
							<i class="glyphicon glyphicon-plus"></i> Add Color
						</a>
						<a title="Search Filter" class="btn btn-white search-filter" href="javascript:void(0)">
							<i class="glyphicon glyphicon-filter"></i> Search
						</a>
					</div>
				</div>				
			</div>			
		</div>
	</div><!-- pageHeading end -->
	
	<div class="main-container-inner container-fluid">			
		<div class="{!! Session::get('class') !!}" id="message">
			<div class="row pageHeading">
				<div class="col-xs-12">
					{!! Session::get('message') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				@if(count($colors))
				<div class="table-responsive">
					<table id="drawingList" class="category table table-hover">
						<thead>
							<tr>
								<th class="right">#</th>
								<th class="left">Color Name</th>      
								<th class="center">Status</th>
								<th class="center">Actions</th>
							</tr>
						</thead>
					  <?php $count = ($colors->currentPage() * Config::get('global_vars.PAGINATION_LIMIT')) - Config::get('global_vars.PAGINATION_LIMIT') + 1;
					  ?>
						<tbody>
						@foreach($colors as $key)
							<tr>
								<td align="right">{!! $count++ !!}</td>
								<td>{!! $key->color !!}</td>
								<td align="center" class="status">
									@if($key->status == 'A')
									<span class="label-status label-warning-active">active</span>
									@endif
									@if($key->status == 'I')
									<span class="label-status label-warning-inactive">inactive</span>
									@endif
								</td>
								<td align="center" class="action-icon">								
									<a href="{!! URL::to('colors/'.$key->id.'/edit') !!}" data-toggle="tooltip" data-placement="bottom" title="Edit Color" class="space">
										<i class="glyphicon glyphicon-pencil"></i> 
									</a>
									{!! Form::open(array('id'=>'destroyColor'.$key->id,'method' => 'DELETE','class'=>'delete-icon', 'route' => array('colors.destroy', $key->id))) !!}
										<a  data-toggle="tooltip" data-placement="bottom" title="Delete Color" class="confirmbox" href="javascript:void(0)" onclick="confirmDelete('{!! $key->id !!}')">
											<i class="glyphicon glyphicon-trash"></i>
										</a>
									{!! Form::close() !!}
								</td>
								
							</tr>
						@endforeach
						</tbody>
				  </table><!-- table end -->
				  {!! $colors->appends(Request::except('page'))->render() !!}
				</div><!-- table responsive end -->
				@else
					<div class="alert alert-info">No Record Found</div>
				@endif
			</div>
		</div>
	</div><!-- container-inner end -->
</div><!-- container end -->	
<script>
function confirmDelete(id) {
    jConfirm('<?php echo Lang::get('messages.CONFIRM_DELETE'); ?>'+" this color?", '', function(r) {
        if (r) {
    		$('#destroyColor'+id).submit();
        }
    });
}
</script>
@stop