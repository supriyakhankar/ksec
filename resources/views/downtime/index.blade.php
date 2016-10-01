@extends('layout.admin')
@section('content')
<script type="text/javascript">
	function validateSearch()
    {
        $("#error_alert").html("");
		var downtimeReason = $("#downtimeReason").val();
		var subreason = $("#subreason").val();
		var status = $("#status").val();
		if(downtimeReason == "" && status == "" && subreason == "")
		{
			$("#error_alert").html("<?php echo Lang::get('messages.search_req');?>");
			return false;
		}
		return true;
	}
	$(function(){
		if($("#downtimeReason").val() != "" || $("#status").val() != "" || $("#subreason").val() != "")
		{
			var $slidedown = $('.searchForm');
			$slidedown.slideDown();
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
						<strong>Manage Downtime</strong>
					</li>				
				</ol>
			</div>
			<div class="col-lg-2 col-md-2 align-right">
				<a title="Close Filter" class="close-filter" style="display:none;" href="javascript:void(0)">
					<span class="label label-default"><i class="glyphicon glyphicon-remove"></i> Close</span>
				</a>
			</div>
		</div>
	</div>
	
	<div class="searchForm " style="display:none;">
		<div class="container-fluid">
			<div class="form-container">
			{!! Form::open(array('route' => 'downtime.index','method'=>'GET','onSubmit' => 'return validateSearch()')) !!}
				<div class="form-control-wrapper">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4">											
								{!! HTML::decode(Form::label('reason', 'Downtime Reason <small class="mandatory">*</small>')) !!}						
								{!! Form::select('downtimeReason', $data['downtimeReason'], Request::get('downtimeReason'), ['id'=>'downtimeReason','class'=>'form-control']) !!}
							</div>
							<div class="col-sm-4"> 
								{!! HTML::decode(Form::label('subreason', 'Downtime Subreason <small class="mandatory">*</small>')) !!}
								{!! Form::text('subreason',Request::get('subreason'),array("placeholder"=>"Downtime Subreason",'id'=>'subreason','class'=>'form-control')) !!}
							</div>					
							<div class="col-sm-4">											
								{!! HTML::decode(Form::label('status', 'Status <small class="mandatory">*</small>')) !!}						
								{!! Form::select('status', $data['status'], Request::get('status'), ['id'=>'status','class'=>'form-control']) !!}
							</div>
						</div>
					</div>	
					<div id="error_alert" class="error validationAlert validationError"></div>	
					<!-- action wrapper -->
					<div class="form-group action">
						<div class="col-lg-12 pull-center buttons"> 
							{!! Form::submit('Search', array('class' => 'btn btn-red')) !!}			
							<button type="button" class="btn btn-black" onclick="doCancel('{!! URL::to('downtime') !!}')">Cancel</button>
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
					<h2 class="page-header">Manage Downtime</h2>					
				</div>
				<div class="col-lg-4">
					<div class="title-action">
						@if(count($subreasons))
						<a title="Download Sheet" class="btn btn-white download-sheet" href="{!! URL::to('downtime/export') !!}">
							<i class="fa fa-file-excel-o"></i> Export
						</a>
						@endif
						<a title="Add Downtime" class="btn btn-white add-downtime add-icons" href="{!! route('downtime.create')!!}">
							<i class="glyphicon glyphicon-plus"></i> Add Downtime
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
			<div class="row ">
				<div class="col-xs-12">
					{!! Session::get('message') !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				@if(count($subreasons))
				<div class="table-responsive">
					<table id="drawingList" class="category table table-hover">
						<thead>
							<tr>
								<th class="right">#</th>
								<th class="left">Downtime Reason</th>      
								<th>Downtime Subreason</th>
								<th class="center">Status</th>
								<th class="center">Actions</th>
							</tr>
						</thead>
					 	<?php $count= ($subreasons->currentPage() * Config::get('global_vars.PAGINATION_LIMIT')) - Config::get('global_vars.PAGINATION_LIMIT') + 1;
						  ?>
						  @foreach($subreasons as $key)		
						<tbody>
							<tr>
								<td align="right">{!! $count++ !!}</td>
								<td width="25%">{!! $data['downtimeReason'][$key->downtime_reason_id]!!}</td>
								<td width="25%">{!! $key->subreason !!}</td>
								<td align="center" class="status">
									@if($key->status == 'A')
									<span class="label-status label-warning-active">active</span>
									@else
									<span class="label-status label-warning-inactive">inactive</span>
									@endif
								</td>
								<td align="center" class="action-icon">								
									<a href="{!! URL::to('downtime/'.$key->id.'/edit') !!}" data-toggle="tooltip" data-placement="bottom" title="Edit Downtime" class="space">
										<i class="glyphicon glyphicon-pencil"></i> 
									</a>
									{!! Form::open(array('id'=>'destroyDowntime'.$key->id,'method' => 'DELETE', 'class'=>'delete-icon','route' => array('downtime.destroy', $key->id))) !!}
										<a  data-toggle="tooltip" data-placement="bottom" title="Delete Downtime" class="confirmbox" href="javascript:void(0)" onclick="confirmDelete('{!! $key->id !!}')">
											<i class="glyphicon glyphicon-trash"></i>
										</a>
									{!! Form::close() !!}
								</td>
								
							</tr>
						@endforeach
						</tbody>
				  </table><!-- table end -->
					{!! $subreasons->appends(Request::except('page'))->render() !!}
				  @else
					<div class="alert alert-info">No Record Found</div>
				@endif
				</div><!-- table responsive end -->
				
			</div>
		</div>
	</div><!-- container-inner end -->
</div><!-- container end -->	
<script>
    $("#message").fadeOut(5000);
</script>
<script>
function confirmDelete(id) {
    jConfirm('<?php echo Lang::get('messages.CONFIRM_DELETE'); ?>'+" this Downtime Subreason?", '', function(r) {
        if (r) {
    		$('#destroyDowntime'+id).submit();
        }
    });
}
</script>
@stop