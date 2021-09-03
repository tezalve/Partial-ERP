<!-- create_bloodgroup -->
@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<style >

/*This is for Coloring Heading */
.with-border{
    animation-name: header;
    animation-duration: 6s;
    animation-iteration-count: infinite;
}

@keyframes header {
      0%   {background-color: #99ccff;}
      25%  {background-color: #ff9980;}
      50%  {background-color:#ffe0b3; }
      100% {background-color:#8cd98c; }
}
/*End This is for Coloring Heading */


/*This is for Text Box Style*/
input[type="text"],
select.form-control {
  background: transparent;
  border: none;
  border-bottom: 1px solid #000000;
  -webkit-box-shadow: none;
  box-shadow: none;
  border-radius: 0;
}

input[type="text"]:focus,
select.form-control:focus {
  -webkit-box-shadow: none;
  box-shadow: none;
}

/*END This is for Text Box Style*/

</style>

@endsection
@section('content')
<section class="content">
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{$dashboard_data[0]->location}}</h3>
          <h4>Location</h4>
        </div>
        <div class="icon">
          <i class="ion ion-location"></i>
        </div>
        <a href="{{ URL::to('/common_dashboard/1')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{$dashboard_data[0]->department}}<sup style="font-size: 20px"></sup></h3>
          <h4>Department</h4>
        </div>
        <div class="icon">
          <i class="fa fa-codepen"></i>
        </div>
        <a href="{{ URL::to('/common_dashboard/2')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$probation_employee[0]->probation_employee}}</h3>
          <h4>Probation Employee</h4>
        </div>
        <div class="icon">
          <i class="fa fa-group"></i>
        </div>
        <a href="{{ URL::to('/common_dashboard/3')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{$dashboard_data[0]->total_employee}}</h3>
          <h4>Total Employee</h4>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ URL::to('/common_dashboard/4')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
  
  
  <div class="row" >
        <div class="form-group  col-lg-8 col-md-8 col-xs-12" style="font-size: 12px">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Probation Employee(s) are waiting for confirmation</h3>
                  
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <table id="list_table" class="table table-bordered table-hover " cellspacing="0" width="100%" >
                    <thead>
                      <tr>
                        <th style="width: 30%">Employee Name</th>
                        <th style="width: 15%">Department</th>
                        <th style="width: 10%">Designation</th>
                        <th style="width: 15%">Location</th>
                        <th style="width: 10%">Joining Date</th>
                        <th style="width: 10%">Probable Confirm Date</th>
                        <th style="width: 10%">Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
        </div>

    <div class="col-lg-4 col-md-8 col-xs-12" style="font-size: 12px">
      
        <div class="box box-primary">
            
            <div class="box-header with-border">
              <h3 class="box-title">Personal Work Note</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>



            <div class="box-body ">
                <div class="col-md-10 col-xs-10">
                    <input type="text" class="form-control" maxlength="145" name="my_note" id="my_note" placeholder="Type Your Work Note.."    autofocus>
                </div> 
                
                <div class="col-md-2 col-xs-2">  
                  <button type="button" id="add" class="fa fa-plus bg-aqua btn" style="font-size:20px;color:green"></button>
                </div> 

                <table id="mynote_table" class="table table-bordered table-hover  " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 95%">Particulars</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

      </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Shortcut Link </h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="form-group col-lg-12 col-md-12 col-xs-12" style="font-size: 12px;">
                @foreach($data as $key)
                <ul>
                  <li><a href="{{$key->link_address}}"> {{$key->title}}</a></li>
                </ul>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

  
  </div>
 
  @endsection
  @section('script')
  <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
  <script>

    $(document).ready(function($) {
        $.ajax({
            type: 'POST',
            url: "{{URL::to('/')}}/provision_employeelist",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                var dataSet = data.data;
                table = $('#list_table').DataTable({
                    destroy: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    bInfo: true,
                    "data": dataSet,
                    "columns": [{
                            "data": "Link",
                            "mRender": function(data, type, full) {
                                return '<a target="_blank"  href="{{URL::to('employeeinfo')}}/' + full.id + '">' + full.employee_name + '</a>';
                            }
                        },
                        {"data": "depertment_name"},
                        {"data": "designation_name"},
                        {"data": "location_name"},
                        {"data": "joining_date"},
                        {"data": "probable_date"},
                        { "data": "Link",
                            "mRender": function (data, type, full) {
                            return '<a href="{{URL::to('/')}}/probation/'+full.id+'"  class="btn btn-info btn-sm btn-flat"><span class="glyphicon glyphicon-ok">Pending</a>';
                            }
                        },


                    ],
                    "order": [
                        [1, 'asc']
                    ]
                });
            }
        });
    


        $('#add').click(function(event){
            var _token = $("input[name='_token']").val();
            var mynote = $("#my_note").val();
            $.ajax({
               type:'POST',
               url:'{{URL::to('/')}}/mynote_store',
               data:{ _token:_token ,mynote:mynote},
               success:function(data){
                  if(data.massages == true){
                      $("#my_note").val('');
                      dataLoad();
                  }else{

                  }
               }
            });
        });  


        dataLoad = function(){

              $.ajax({
                  type: 'POST',
                  url: "{{URL::to('/')}}/mynote_list",
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  dataType: 'json',
                  success: function(data) {
                      var dataSet = data.data;
                      mytable = $('#mynote_table').DataTable({
                          destroy: true,
                          paging: false,
                          searching: false,
                          ordering: true,
                          bInfo: false,
                          // columnDefs: [
                          // { "width": "150px", "targets": [0] },       
                          // { "width": "40px", "targets": [1] }
                          // ],
                          // fixedColumns: true,
                          "data": dataSet,
                          "columns": [
                              {"data": "my_note"},
                              { "data": "Link",
                              "mRender": function (data, type, full) {
                              return '<button type="button" class="fa fa-trash delete-button btn btn-flat"  style="font-size:14px;color:red" id="'+full.id+'" ></button>';
                                }
                              },
                          ],
                          "order": [
                              [1, 'asc']
                          ]
                      });
                  }
              });
          }
      dataLoad();
  });  

  $('#mynote_table tbody').on('click','.delete-button',function(){
      var delete_object = $(this).parents('tr');
      $.ajax({
          method: 'GET',
          url: '{{URL::to('/')}}/my_note/'+$(this).attr('id')+'/cancel',
          dataType: 'json',
          success: function(data) {
            console.log(data.massages);
            if(data.massages == true){
              mytable.row( delete_object ).remove().draw();
                       
            }else{
                          
            }
          }
      });        
  })







//  $(document).ready(function($) {
//     $.ajax({
//         type: 'POST',
//         url: "{{URL::to('/')}}/long_service_employeelist",
//         headers: {
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         },
//         dataType: 'json',
//         success: function(data) {
//             var dataSet = data.data;
//             table = $('#long_service_list_table').DataTable({
//                 destroy: false,
//                 paging: true,
//                 searching: true,
//                 ordering: false,
//                 bInfo: false,
//                 "data": dataSet,
//                 "columns": [{
//                         "data": "Link",
//                         "mRender": function(data, type, full) {
//                             return '<a target="_blank"  href="{{URL::to(' / ')}}/employeeinfo/' + full.id + '">' + full.employee_name + '</a>';
//                         }
//                     },
//                     {
//                         "data": "designation_name"
//                     },
//                     {
//                         "data": "location_name"
//                     },
//                     // { "data": "depertment_name" },
//                     // { "data": "contact_number" },
//                     {
//                         "data": "jobduration"
//                     },
//                 ],
//                 "order": [
//                     [1, 'asc']
//                 ]
//             });
//         }
//     });
// });

</script>
@endsection