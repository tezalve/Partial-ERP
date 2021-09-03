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
      <h3>Edit Asset</h3>
      
      <div class="row">
      <form action="{{ route('asset.update', $asset->id) }}" onkeypress="return event.keyCode != 13;" files="true" id="asset_form" >
        {{ method_field('put') }}
        @php $form_type ='edit' @endphp
        @include('assetinformation._form')
      </form>
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
    $('#asset_form').on('submit',(function(e) {
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
                      window.location.replace('/asset');
                      console.log('f');

                }else{
                      // toastr.error(data.messages);
                      $('#btnSubmit').attr("disabled", false);
                      $("#btnSubmit").val('Submit');
                      console.log('lse');
                }
              }
          });
    }));
  </script>

  <script type="text/javascript">
    $('#asset_type_id').select2({
      placeholder: 'Enter Asset Type',
      allowClear: true,
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/asset_type_list_data',
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

    // select old value
    var asset_type_select = $('#asset_type_id');
    $.ajax({
      dataType: 'json',
      url: '{{URL::to('/')}}/asset_type_list_data',
    }).then(function (data) {
        // create the option and append to Select2
        var assetid = {{ $assetid }};
        console.log(data);
        var i;
        for(i=0; i<data.length; i++){
          if(data[i].id == assetid){
            break;
          }
        }
        var option = new Option(data[i].text, data[i].id, true, true);
        asset_type_select.append(option).trigger('change');
        console.log('here');
        // manually trigger the `select2:select` event
        asset_type_select.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
    });

    $('#brand_id').select2({
      placeholder: 'Enter Brand',
      allowClear: true,
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/brand_list_data',
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

    // select old value
    var brand_select = $('#brand_id');
    $.ajax({
      dataType: 'json',
      url: '{{URL::to('/')}}/brand_list_data',
    }).then(function (data) {
        // create the option and append to Select2
        var brandid = {{ $brandid }};
        console.log(data);
        var i;
        for(i=0; i<data.length; i++){
          if(data[i].id == brandid){
            break;
          }
        }
        var option = new Option(data[i].text, data[i].id, true, true);
        brand_select.append(option).trigger('change');
        // manually trigger the `select2:select` event
        brand_select.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
    });
  </script>

  <script type="text/javascript">

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#imgup').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
  
  </script>

@stop