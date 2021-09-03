
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
    <h3 id="page-header" class="box-title">Asset Store</h3>
     <div class="box-tools pull-right">
        <a type="button" href="{{ URL::previous() }}" class="btn btn-box-tool"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
      </div>
  </div>

  <form method="POST" action="{{ route('assetstore.store') }}" onkeypress = "return event.keyCode != 13;" id="sales_invoice_form" enctype="multipart/form-data" file="true">
    @php $form_type ='create' @endphp
    @include('assetstore/_form')
  </form>
@endsection

@section('script')
  <script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>

  <script>
    $(document).ready(function($) {

      var table = $('#asset_store_table').DataTable({
        searching: false,
        ordering: false,
        paging: false,
        bInfo: false,

        drawCallback: function(row, data, start, end, display) {
          
          $('.select2').select2({
            placeholder: "Enter Model",
            allowClear: true,
            ajax: {
              dataType: 'json',
              url: '{{URL::to('/')}}/asset_list_data',
              headers:{
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },   
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
              templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                $(data.element).attr('data-custom-attribute', data.customValue);
                return data.text;
              },
              cache: true
            }
          });

          var api = this.api(), data;

          // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                      i : 0;
          };

          // Total over this page
          pageTotal = api
              .column( 4, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          $( api.column( 4 ).footer() ).html(
              'Total Price = '+pageTotal
          );

          pageTotal = api
              .column( 3, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          $( api.column( 3 ).footer() ).html(
              'Total QTY = '+pageTotal
          );
        }
      });

      $('#asset_store_table thead').on( 'click', '#add', function(){
        var asset_list = $('#asset_list').find(":selected").text();
        var qty = $('#qty').val();
        var price = $('#price').val();
        var product_id = $('#asset_list').val();
        console.log(product_id);

        if($('#qty').val() != '' && $('#price').val() != '' && $('#asset_list').val() != null && $('#qty').val() != '0'){
          if($('#serial').val()==0){
            table.row.add([
              asset_list,
              '<input  type="text"    name="serial[]" readonly  class="form-control price_info"   style="width: 100%;text-align:center;"  value="None">',
              price,
              qty,
              price*qty,
              '<button type="button" class="btn btn-info btn-block btn-flat btn-danger" id="row_delete">Delete</button><input name="qty_info[]" value="'+qty+'" class="hidden"><input name="price_info[]" value="'+price+'" class="hidden"><input name="product_id[]" value="'+product_id+'" class="hidden">'
            ] ).draw()
          } else{
            for(var i=0; i<qty; i++){
              table.row.add([
                asset_list,
                '<input  type="text"    name="serial[]"     class="form-control price_info"   placeholder="Serial No" style="width: 100%;text-align:center;"  value="" required>',
                price,
                1,
                price,
                '<button type="button" class="btn btn-info btn-block btn-flat btn-danger" id="row_delete">Delete</button><input name="qty_info[]" value="'+1+'" class="hidden"><input name="price_info[]" value="'+price+'" class="hidden"><input name="product_id[]" value="'+product_id+'" class="hidden">'
              ] ).draw()
            }
          }
        }
        
        $('#qty, #price').val('');
        $('#serial, #total').val(0);
        $('#asset_list').val(null).trigger('change');
        
      });

      $('#asset_store_table tbody').on( 'click', '#row_delete', function () {
        table.row (
            $(this).parents('tr')).remove().draw();
      });

      $('#asset_store_table thead').on( 'keyup mouseup mousewheel', '#price, #qty', function () {
        $('#total').val($('#price').val()*$('#qty').val());
      });
    
    });
  </script>
@endsection