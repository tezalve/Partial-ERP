@extends('layouts.main')

@section('styles')
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
  <style>

  body {font-family: Arial;}

  /* Style the tab */
  .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
  }

  /* Style the buttons inside the tab */
  .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
  }

  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }

  /* Create an active/current tablink class */
  .tab button.active {
    background-color: #ccc;
  }

  /* Style the tab content */
  .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
  }
  .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
  }
  .kv-avatar {
      display: inline-block;
  }
  .kv-avatar .file-input {
      display: table-cell;
      width: 213px;
  }
  .kv-reqd {
      color: red;
      font-family: monospace;
      font-weight: normal;
  }
  .btn-secondary {
    margin-top: 5px;
  }
  .btn-file{
    margin-top: 5px;	
  }
  </style>
@stop

@section('content')
  
  <div class="box box-default">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#Asset_List" data-toggle="tab" aria-expanded="true">Asset List</a></li>
          <li class=""><a href="#Asset_Type" data-toggle="tab" aria-expanded="false">Asset Type</a></li>
          <li class=""><a href="#Brand" data-toggle="tab" aria-expanded="false">Brand</a></li>
          <li class=""><a href="#Asset_Return_Type" data-toggle="tab" aria-expanded="false">Return Type</a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="Asset_List">
            <div class="box box-default">
              <div class="box-body">
                <div class="row">
                  <div class="box-header with-border">
                    <a href="{{ route('asset.create') }}" button type="button" class="btn-success btn btn-sm button pull-left" style="font-size: 12px; font-weight: bold">Add Asset</a>
                  </div>

                  <div class="col-md-12"> 
                    <div class="form-group col-lg-12 col-md-12 col-xs-12" style="overflow: auto;">   	
                      <table id="asset-table" class="table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th style="width: 12%">Picture</th>
                            <th style="width: 28%">Description</th>
                            <th style="width: 12%">Asset Type</th>
                            <th style="width: 12%">Brand</th>
                            <th style="width: 12%">Model</th>
                            <th style="width: 12%">Edit</th>
                            <th style="width: 12%">Delete</th>
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
          </div>

          <div class="tab-pane" id="Asset_Type">
            <div class="box-body">
              <div class="row">
                <div class="box-header with-border">
                  <button button type="button" class="btn-success btn btn-sm button pull-left" data-toggle="modal" data-target="#modal_asset_type" data-whatever="@mdo" style="font-size: 12px; font-weight: bold">Add Asset Type</button>
                </div>

                <div class="modal fade" id="modal_asset_type" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      @include('assettype.create')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-md-12"> 
                  @include('assettype.index')
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="Brand">
            <div class="box-body">
              <div class="row">
                <div class="box-header with-border">
                  <button type="button" class="btn-success btn btn-sm button pull-left" data-toggle="modal" data-target="#modal_brand" data-whatever="@mdo" style="font-size: 12px; font-weight: bold">Add Brand</button>
                </div>
        
                <div class="modal fade" id="modal_brand" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      @include('assetbrand.create')
                    </div>
                  </div>
                </div>
          
                <div class="box-body">
                  <div class="row">
                    @include('assetbrand.index')
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="Asset_Return_Type">
            <div class="box-body">
              <div class="row">
                <div class="box-header with-border">
                  <button button type="button" class="btn-success btn btn-sm button pull-left" data-toggle="modal" data-target="#modal_asset_return_type" data-whatever="@mdo" style="font-size: 12px; font-weight: bold">Add Asset Type</button>
                </div>

                <div class="modal fade" id="modal_asset_return_type" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      @include('assetreturntype.create')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-md-12"> 
                  @include('assetreturntype.index')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('script')
  <script scr="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

  <script src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

  <script src="{{asset('js/fileinput.js')}}"></script>
  <!-- <script src="{{asset('js/bootstrap.min.js')}}"></script> -->

  <script>
    $(document).ready(function($) {

        // $('#date_of_birth').datepicker({
        //   // startDate: new Date() ,
        //   autoclose: true
        // });


      var btnCust = '<button type="button"  class="btn btn-secondary" title="Add picture tags" ' + 
          'onclick="alert(\'Call your custom code here.\')">' +
          '<i class="glyphicon glyphicon-tag"></i>' +
          '</button>'; 
      $("#avatar").fileinput({
          overwriteInitial: true,
          maxFileSize: 1500,
          showClose: false,
          showCaption: false,
          browseLabel: '',
          removeLabel: '',
          browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
          removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
          removeTitle: 'Cancel or reset changes',
          elErrorContainer: '#kv-avatar-errors-1',
          msgErrorClass: 'alert alert-block alert-danger',
          defaultPreviewContent: '<img src="{{asset('img/default_avatar_male.jpg')}}" alt="Your Avatar">',
          layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
          allowedFileExtensions: ["jpg", "png", "gif"]
      });
    });
  </script>

  <script>
    $('#asset_type_form').on('submit',(function(e) {
      e.preventDefault();
      $("#btnSubmit").attr("disabled", true);
      $("#btnSubmit").val('Please wait..');
        
      var formData = new FormData(this);

      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){


            if(data.success == true) {

                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
                  alert(data.message);
                  window.location.replace('/asset');

            }else{
                  // toastr.error(data.messages);
                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
            }
          }
      });
    }));
    $('#brand_form').on('submit',(function(e) {
      e.preventDefault();

      $("#btnSubmit").attr("disabled", true);
      $("#btnSubmit").val('Please wait..');
        
      var formData = new FormData(this);

      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){


            if(data.success == true) {
                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
                  alert(data.message);
                  window.location.replace('/asset');

            }else{
                  // toastr.error(data.messages);
                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
            }
          }
      });
    }));
    $('#asset_return_type_form').on('submit',(function(e) {
      e.preventDefault();
      $("#btnSubmit").attr("disabled", true);
      $("#btnSubmit").val('Please wait..');
        
      var formData = new FormData(this);

      $.ajax({
          type:'POST',
          url: $(this).attr('action'),
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){


            if(data.success == true) {
                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
                  alert(data.message);
                  window.location.replace('/asset');

            }else{
                  $('#btnSubmit').attr("disabled", false);
                  $("#btnSubmit").val('Submit');
                  alert(data.message);
                  window.location.replace('/asset');
            }
          }
      });
    }));
  </script>
  <script>
    $(document).ready(function($) {
     $.ajax({
      type:   'POST', 
      url :   "{{URL::to('/')}}/brand_list",
      headers:{
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },        
      dataType: 'json',
          success: function(data) {
              var dataSet = data.data;
              table = $('#brand-table').DataTable( {
                  destroy:    true,
                  paging:     true,
                  searching:  true,
                  ordering:   true,
                  bInfo:      true,  
                  "data":     dataSet,

              "columns": [
                                                  
                  { "data": "id" },
                  { "data": "brand_name" },
                  { "data": "Link",
                      "mRender": function(data, type, full) {
                          return '<a  data-brand_id="' + full.id + '" data-brand_name="' + full.brand_name + '"  class="btn btn-primary btn-flat btn-sm showme"> <span class="glyphicon glyphicon-edit">Edit</a>';
                      }
                  },
                  { "data": "Link",
                      "mRender": function (data, type, full) {
                      return '<form action="{{URL::to('/')}}/brand/'+full.id+'"  method="POST"> {{ csrf_field() }} {{ method_field('DELETE') }} <button type="submit" class="btn btn-danger" title="delete" onclick="return confirm(&#39;Are you sure you want to delete this item?&#39;);">Delete</button></form>';
                      }
                  },
              ],
              "order": [[0,'asc']]
              });
          }
      });

      $.ajax({
        type:   'POST', 
        url :   "{{URL::to('/')}}/asset_type_list",
        headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },        
        dataType: 'json',
            success: function(data) {
                var dataSet = data.data;
                table = $('#assetType-table').DataTable( {
                    destroy:    true,
                    paging:     true,
                    searching:  true,
                    ordering:   true,
                    bInfo:      true,  
                    "data":     dataSet,

                "columns": [
                                                    
                    { "data": "id" },
                    { "data": "asset_type_name" },
                    { "data": "Link",
                        "mRender": function(data, type, full) {
                            return '<a  data-asset_type_id="' + full.id + '" data-asset_type_name="' + full.asset_type_name + '"  class="btn btn-primary btn-flat btn-sm showme"> <span class="glyphicon glyphicon-edit">Edit</a>';
                        }
                    },
                    { "data": "Link",
                        "mRender": function (data, type, full) {
                        return '<form action="{{URL::to('/')}}/asset_type/'+full.id+'"  method="POST"> {{ csrf_field() }} {{ method_field('DELETE') }} <button type="submit" class="btn btn-danger" title="delete" onclick="return confirm(&#39;Are you sure you want to delete this item?&#39;);">Delete</button></form>';
                        }
                    },
                ],
                "order": [[0,'asc']]
                });
            }
      });

      $.ajax({
      type:   'POST', 
      url :   "{{URL::to('/')}}/return_type_list",
      headers:{
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },        
      dataType: 'json',
          success: function(data) {
              var dataSet = data.data;
              table = $('#assetReturnType-table').DataTable( {
                  destroy:    true,
                  paging:     true,
                  searching:  true,
                  ordering:   true,
                  bInfo:      true,  
                  "data":     dataSet,

              "columns": [
                                                  
                  { "data": "id" },
                  { "data": "asset_return_type_name" },
                  { "data": "Link",
                      "mRender": function(data, type, full) {
                          return '<a  data-asset_return_type_id="' + full.id + '" data-asset_return_type_name="' + full.asset_return_type_name + '"  class="btn btn-primary btn-flat btn-sm showme"> <span class="glyphicon glyphicon-edit">Edit</a>';
                      }
                  },
                  { "data": "Link",
                      "mRender": function (data, type, full) {
                      return '<form action="{{URL::to('/')}}/assetreturntype/'+full.id+'"  method="POST"> {{ csrf_field() }} {{ method_field('DELETE') }} <button type="submit" class="btn btn-danger" title="delete" onclick="return confirm(&#39;Are you sure you want to delete this item?&#39;);">Delete</button></form>';
                      }
                  },
              ],
              "order": [[0,'asc']]
              });
          }
      });
    });

    $('#brand-table').on('click', '.showme', function() {
      $("#brand_id").attr("value", $(this).data('brand_id'));
      $('#brand_id').val($(this).data('brand_id'));
      $('#brand_name').val($(this).data('brand_name'));
      $('#modal_brand').modal('show');
      console.log($('#brand_id').val());
    });
    $('#modal_brand').on('hidden.bs.modal', function() {
      location.reload();
    })

    $('#assetType-table').on('click', '.showme', function() {
      
      $('#asset_type_id').val($(this).data('asset_type_id'));
      $('#asset_type_name').val($(this).data('asset_type_name'));
      $('#modal_asset_type').modal('show');
      console.log($('#asset_type_id').val());
    });
    $('#modal_asset_type').on('hidden.bs.modal', function() {
      location.reload();
    })

    $('#assetReturnType-table').on('click', '.showme', function() {
      $("#asset_return_type_id").attr("value", $(this).data('asset_return_type_id'));
      $('#asset_return_type_id').val($(this).data('asset_return_type_id'));
      $('#asset_return_type_name').val($(this).data('asset_return_type_name'));
      $('#modal_asset_return_type').modal('show');
      console.log($('#asset_return_type_id').val());
    });
    $('#modal_asset_return_type').on('hidden.bs.modal', function() {
      location.reload();
    })

  </script>

  <script>
  $(document).ready(function($) {
    $.ajax({
      type:   'POST', 
      url :   "{{URL::to('/')}}/asset_list",
      headers:{
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },        
      dataType: 'json',
          success: function(data) {
              var dataSet = data.data;
              table = $('#asset-table').DataTable( {
                  destroy:    true,
                  paging:     true,
                  searching:  true,
                  ordering:   true,
                  bInfo:      true,  
                  "data":     dataSet,

              "columns": [
                                                  
                  { "data": "Link",
                      "mRender": function(data, type, full) {
                          return '<img style="max-width:100%" src="/asset_images/'+full.imgpath+'" </img>';
                      }
                  },
                  { "data": "description" },
                  { "data": "asset_type" },
                  { "data": "brand" },
                  { "data": "model" },
                  { "data": "Link",
                      "mRender": function(data, type, full) {
                          return '<a  href="{{URL::to('/')}}/asset/'+full.id+'/edit" data-asset_type_id="' + full.id + '" data-description="' + full.description + '" data-model="' + full.model + '" class="btn btn-primary btn-flat btn-sm showme2"> <span class="glyphicon glyphicon-edit">Edit</a>';
                      }
                  },
                  { "data": "Link",
                      "mRender": function (data, type, full) {
                      return '<form action="{{URL::to('/')}}/asset/'+full.id+'"  method="POST"> {{ csrf_field() }} {{ method_field('DELETE') }} <button type="submit" class="block btn btn-danger" title="delete" onclick="return confirm(&#39;Are you sure you want to delete this item?&#39;);">Delete</button></form>';
                      }
                  },
              ],
              "order": [[0,'asc']]
              });
          }
    });
  });

  $('#asset-table').on('click', '.showme', function() {
    $('#asset_id').val($(this).data('asset_id'));
    $('#description').val($(this).data('description'));
    $('#model').val($(this).data('model'));
    console.log($('#description').val());
  });
  </script>

  <script type="text/javascript">
    $('#asst_type_id').select2({
      placeholder: 'Enter Asset Type',
      allowClear: true,
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/asset_type_list_data',
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
        cache: true
      }
    });

    $('#brnd_id').select2({
      placeholder: 'Enter Brand',
      allowClear: true,
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/brand_list_data',
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
        cache: true
      }
    });
  </script>

@stop