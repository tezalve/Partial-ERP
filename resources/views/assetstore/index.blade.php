@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">

<style>
td.details-control {
   background: url('{{URL::to('/')}}/dist/img/details_open.png') no-repeat center center;
   cursor: pointer;
}
tr.shown td.details-control {
   background: url('{{URL::to('/')}}/dist/img/details_close.png') no-repeat center center;
}
.img {
height: 100px
}
h1 {
text-align: center
}
</style>
@stop

@section('content')
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Asset Store List</h3>
			
			<div class="box-tools pull-right">
				<a type="button" href="{{ URL('/') }}" class="btn btn-box-tool"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
			</div>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group col-lg-12 col-md-12 col-xs-12">
						<a href="{{ route('assetstore.create')}}"><input type="button" value="Store Asset" class="btn-success btn btn-sm button pull-left" style="font-size: 12px; font-weight: bold;"></a>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group col-lg-12 col-md-12 col-xs-12">
						<table id="branch-table" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 10%">Details</th>
									<th style="width: 15%">Purchase No</th>
									<th style="width: 15%">Date</th>
									<th style="width: 15%">Notes</th>
									<th style="width: 25%">Quantity</th>
									<th style="width: 25%">Total</th>
									<th style="width: 25%">Actions</th>
								</tr>
							</thead>

							<tbody>
							</tbody>
						</table>					
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('script')
	<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

	<script type="text/javascript">
		$(document).ready(function($) {
			$.ajax({
			type:   'POST', 
			url :   "{{URL::to('/')}}/asset_store_list",
			headers:{
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},        
			dataType: 'json',
				success: function(data) {
					var dataSet = data.data;
					table = $('#branch-table').DataTable( {
						destroy:    true,
						paging:     true,
						searching:  true,
						ordering:   true,
						bInfo:      true,  
						"data":     dataSet,

					"columns": [
						{
							"className":      'details-control',
							"orderable":      true,
							"data":           null,
							"defaultContent": ''
						},
						{ "data": "purchase_no" },
						{ "data": "purchase_date" },
						{ "data": "note" },
						{ "data": "qty" },
						{ "data": "total" },
						{ "data": "Link",
							"mRender": function(data, type, full) {
								return '<a  href="{{URL::to('/')}}/assetstore/'+full.id+'/edit" data-asset_type_id="' + full.id + '" data-description="' + full.description + '" data-model="' + full.model + '" class="btn btn-primary btn-flat btn-sm showme2"> <span class="glyphicon glyphicon-edit">Edit</a>';
							}
                 		 },
					],
					"order": [[0,'asc']]
					});
				}
			});
		});
	</script>
	
	<script>
		function format(d) {
		console.log(d);
		return '<table class="table table-bordered table-hover" cellspacing="0" width="100%">'+
				'<tr>'+
				'<td>'+"Item Description"+'</td>'+
				'<td>'+"Serial"+'</td>'+
				'<td>'+"Price"+'</td>'+
				'<td>'+"Quantity"+'</td>'+
				'<td>'+"Total"+'</td>'+
				'</tr>'+
				'<tr>'+
				'<td>'+d.item_description+'</td>'+
				'<td>'+d.serial+'</td>'+
				'<td>'+d.price+'</td>'+
				'<td>'+d.qty2+'</td>'+
				'<td>'+d.total2+'</td>'+
				'</tr>'+  
			'</table>';
		}

		$('#branch-table tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = table.row( tr );
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
			}
		}); 
	</script>
@endsection