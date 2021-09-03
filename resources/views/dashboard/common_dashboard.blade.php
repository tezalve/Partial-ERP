<!-- create_employee -->
<!-- create_marital_status -->
@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bootstrapvalidator/bootstrapValidator.min.css')}}">
<style type="text/css">
	.header{
		/*font-size: 17px;*/
	}
</style>
@endsection
@section('content')
<div class="box box-primary">
	<!-- <div class="box-header with-border"> -->
<!-- 		<h3 class="box-title">{{$company_name}}</h3> <br>
		<h3 class="box-title">{{$address}}</h3><br>
		<h3 class="box-title">{{$title}}</h3> -->
	<!-- 	<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div> -->
	<!-- </div> -->

	@php
	$count_employee = 0
	@endphp
	<div class="box-body">
		<div class="row">
				<div class="col-md-6" >
					<div style="text-align: center;">
						<h4 class="" style="font-weight:bold;">{{$company_name}}</h4>
						<h5 class="" style="font-weight:bold;">{{$address}}</h5>
						<h5 class="" style="font-weight:bold;" >{{$title}}</h5>
					</div>
					<table id="list_table" class="table table-bordered table-hover " cellspacing="0" width="100%" >
						<thead>
							<tr>
								<th style="width: 10%">Sl.No</th>
								<th style="width: 50%">Description</th>
								<th style="width: 40%">Employee(s)</th>
								
							</tr>
						</thead>
						<tbody>
						
						@foreach ($data as $data)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$data->description}}</td>
								<td>{{$data->count_employee}}</td>
								
							</tr>
							<?php $count_employee += $data->count_employee ?>
						@endforeach
			            	<tr>
								<th></th>
								<th>Total:</th>
								<th>{{$count_employee}}</th>			            	
			            	</tr>
						</tbody>
						<!-- <tfoot> -->

			            <!-- </tfoot> -->
					</table>
					
				</div>
		</div>
	</div>
</form>
</div>
@endsection
@section('script')
<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/bootstrapvalidator/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript">
	
// $(document).ready( function () {
    var table = $('#list_table').DataTable({
			destroy: false,
			paging: false,
			searching: false,
			ordering: false,
			bInfo: false,
		    // "footerCallback": function ( row, data, start, end, display ) {
		    //     var api = this.api(), data;
		    //     var intVal = function ( i ) {
		    //         return typeof i === 'string' ?
		    //             i.replace(/[\$,]/g, '')*1 :
		    //             typeof i === 'number' ?
		    //                 i : 0;
		    //     };

		    //       total_quantity = api
		    //         .column(2)
		    //         .data()
		    //         .reduce( function (a, b) {
		    //             	return intVal(a) + intVal(b);
		    //         },0);

		    // 	$( api.column( 1 ).footer() ).html(' Total :');
		    // 	$( api.column( 2 ).footer() ).html(total_quantity);
		    	
		    // }


    });
    // table.column( 2 ).data().sum();
// } );

</script>
@endsection