<!-- permissionlist -->

@extends('layouts.main')
@section('styles')
<!-- DataTables -->
 <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Permission List</h3>
            </div>
  
<!-- 	        <div class="col-xs-8" style="padding-bottom: 10px;">
	            <a href="{{ URL::to('permission/create')}}"><input type="button" value="Create New" class="btn-success btn btn-sm button pull-left" style="font-size: 12px; font-weight: bold;"></a>
	        </div> -->

            <!-- /.box-header -->
            <div class="box-body" style="padding: 0px;">
	            <div class="col-xs-8" style="padding-bottom: 10px;" style="overflow: auto;">
	              <table id="products" class="table table-bordered table-hover">
	                <thead>
	                <tr>
	                  <th style="width:50%;">Permission Name</th>
	                  <th style="width:50%;">Display Name</th>
	                
	                </tr>
	                </thead>
	                <tbody>
	                </tbody>
	              </table>
	            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script>


$(document).ready(function() {
  var table = $('#products').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "{{URL::to('/')}}/getpermissionlist",
      "columns": [
          { "data": "name" },
          { "data": "display_name" },
         
      ],
    "order": [[1, 'asc']]
  } );
});
</script>


@endsection






