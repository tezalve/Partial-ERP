
@extends('layouts.main')
@section('styles')
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">

  <style type="text/css">
  .table>tbody>tr>td, .table>tbody>tr>th, 
  .table>tfoot>tr>td, .table>tfoot>tr>th, 
  .table>thead>tr>td, .table>thead>tr>th{
    padding: 5px;
  } 
  </style>
@endsection

@section('content')
<div class="box box-default">
  
  <div class="box-header with-border" style="position: inherit;">
    <h3 id="page-header" class="box-title">Asset Return</h3>
     <div class="box-tools pull-right">
          <a type="button" href="{{ URL::previous() }}" class="btn btn-box-tool"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
  </div>

  <form method="POST" action="{{ route('assetreturn.store') }}" onkeypress = "return event.keyCode != 13;" id="asset_return_form" enctype="multipart/form-data" file="true">

    @php $form_type ='create' @endphp
    @include('assetreturn/_form')

  </form>
@endsection

@section('script')
<script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<script>
  $(document).ready(function($) {
    $employee = $('#employee_name').select2({
      placeholder: 'Enter an Employee Name',
      allowClear: true,
        ajax: {
            dataType: 'json',
            url: "{{URL::to('/')}}/assigned_list_employee",
            delay: 250,    			
          data: function(params) {
              return {
                term: params.term
              }
          },
            processResults: function (data, params) {
              params.page = params.page || 1;
              return {
                results: data,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            },
            cache: true
        }
    });

    $asset_return = $('#asset_return_type_id').select2({
        placeholder: 'Enter Return Type',
        allowClear: true,
        ajax: {
          dataType: 'json',
          url: '{{URL::to('/')}}/return_type_list_data',
          delay: 250,
          data: function(params) {
            return {
              term: params.term
            }
          },
          processResults: function (data, params) {
            params.page = params.page || 1;
            return {
              results: data
            };
          },
          cache: true
        }
    });
    
    $asset = $('#asset_id').select2({
        placeholder: 'Select Employee'
    });

    $employee.on("select2:select", function (e) {
      $("#asset_id"). empty();
      $("#employee_id").val($(this).select2('data')['0']['id']);
      $("#hrm_asset_assign_master_id").val($(this).select2('data')['0']['hrm_asset_assign_master_id']);
      var asset_select = $('#asset_id');
      $.ajax({
        dataType: 'json',
        url: '{{URL::to('/')}}/asset_assign_list_get',
      }).then(function (data) {
        // create the option and append to Select2
        var id = $("#employee_id").val();
        var i;
        for(i=0; i<data.data.length; i++){
          if(data.data[i].employee_id == id){
            var option = new Option(data.data[i].asset, data.data[i].id, true, true);
            asset_select.append(option).trigger('change');
          }
        }
        // manually trigger the `select2:select` event
        asset_select.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
      });
    });
  });
</script>
@stop
