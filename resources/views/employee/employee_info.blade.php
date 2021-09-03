@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">

<style type="text/css">
	/*body {padding:3%;background:#fff}*/

	img{
		width: 210px;
		height: 210px;
	}

	input[type=file]{
		padding:10px;
		/*background:#2d2d2d;*/
	}

	.bold-off {
	    font-weight: normal !important;
	}
	.panel-heading {
	    padding: 0
	}
	.panel-heading a {
	    display: block;
	    padding: 20px 10px;
	}
	.panel-heading a.collapsed {
	    background: #fff
	}
	.panel-heading a {
	    background: #f7f7f7;
	    border-radius: 5px;
	}
	.panel-heading a:after {
	    content: '-'
	}
	.panel-heading a.collapsed:after {
	    content: '+'
	}
	.nav.nav-tabs li a,
	.nav.nav-tabs li.active > a:hover,
	.nav.nav-tabs li.active > a:active,
	.nav.nav-tabs li.active > a:focus {
	    border-bottom-width: 0px;
	    outline: none;
	}
	.nav.nav-tabs li a {
	    padding-top: 20px;
	    padding-bottom: 20px;
	}
	.tab-pane {
	    background: #fff;
	    padding: 10px;
	    border: 1px solid #ddd;
	    margin-top: -1px;
	}

	/* used for sidebar tab/collapse*/
	@media (max-width: 991px) {
	  .visible-tabs {
	    display: none;
	  }
	}

	@media (min-width: 992px) {
	  .visible-tabs {
	    display: block !important;
	  }
	}

	@media (min-width: 992px) {
	  .hidden-tabs {
	    display: none !important;
	  }
	}

</style>

@endsection

@section('content')


<div class="box box-primary">

	<div class="box-header with-border">
		<h5 class="box-title" style="font-size: 25px;">{{$employee->employee_name}}</h5>
<!-- 			@permission('PrintEmployeeInfo')
			<a  href="<?=$employee->id?>/print" target="_blank"><input type="button"  value="Print" class="btn btn-sm button  btn-flat " ></a>
			
			@endpermission

			@permission('EditEmployeeInfo')
			<a  href="<?=$employee->id?>/edit"><input type="button"  value="Edit" class="btn btn-sm button btn-flat "></a>
            @endpermission -->
		<div class="box-tools pull-right">

			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

		</div>
	</div>

	<!-- <div class="container"> -->
	<div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          
          
         <!--begin tabs going in narrow content -->
            <ul class="nav nav-tabs sidebar-tabs" id="sidebar" role="tablist">
              <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Personal Information</a></li>
              <li><a href="#tab-2" role="tab" data-toggle="tab">Official Information</a></li>
              @permission('DocumentArchiveOwnOnly')
              <li><a href="#tab-3" role="tab" data-toggle="tab">Documents</a></li>
              @endpermission
              <li><a href="#tab-4" role="tab" data-toggle="tab">Skill</a></li>
              <li><a href="#tab-5" role="tab" data-toggle="tab">Assigned Asset</a></li>
              <li><a href="#tab-6" role="tab" data-toggle="tab">History</a></li>
              <li>
					@permission('PrintEmployeeInfo')
					<a  href="<?=$employee->id?>/print" target="_blank"><input type="button"  value="Print" class="btn btn-sm button  btn-flat " ></a>
					@endpermission

              </li>
              <li>     	
					@permission('EditEmployeeInfo')
					<a  href="<?=$employee->id?>/edit"><input type="button"  value="Edit" class="btn btn-sm button btn-flat "></a>
		            @endpermission
              </li>
              
            </ul><!--/.nav-tabs.sidebar-tabs -->
           
            <div class="tab-content">
              	<div class="tab-pane active" id="tab-1">
	                 <!-- <p>Recent content</p> -->
					<div class="box-body tabcontent" id="basicinfo">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-xs-12 personal-info">
								
								{{-- <div class="form-group has-feedback {{ $errors->has('employee_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Employee Name</label>
									<label class="col-lg-9 control-label">{{$employee->employee_name}}</label>
								</div> --}}

								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Nickname</label>
									<label class="col-lg-9 control-label">{{$employee->nickname}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('present_address') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Present Address</label>
									<label class="col-lg-9 control-label">{{$employee->present_address}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('permanent_address') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Permanent Address</label>
									<label class="col-lg-9 control-label">{{$employee->permanent_address}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('contact_number') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Contact Number</label>
									<label class="col-lg-9 control-label">{{$employee->contact_number}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Email</label>
									<label class="col-lg-9 control-label">{{$employee->email}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('gender') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Gender</label>
									@if ($employee->gender == 1)
									<label class="col-lg-9 control-label">Male</label>
									@else
									<label class="col-lg-9 control-label">Female</label>
									@endif
								</div>

						
								<div class="form-group has-feedback {{ $errors->has('religion') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Religion</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->religion}}</label>
								</div> 

								<div class="form-group has-feedback {{ $errors->has('marital_status') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Marital Status</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->marital_status}}</label>
								</div> 
						

								<div class="form-group has-feedback {{ $errors->has('blood_group') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Blood Group</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->blood_group}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Date of Birth</label>
									<label class="col-lg-9 control-label">{{  date('d-m-Y', strtotime(str_replace('-', '/', $employee->dob ))) }}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('nid') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">NID / Smart Card</label>
									<label class="col-lg-9 control-label">{{$employee->nid}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('tin') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">TIN</label>
									<label class="col-lg-9 control-label">{{$employee->tin}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('father_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Father's Name</label>
									<label class="col-lg-9 control-label">{{$employee->father_name}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('mothers_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Mother's Name</label>
									<label class="col-lg-9 control-label">{{$employee->mother_name}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('last_education') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Highest Education</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->education_name}}</label>
								</div>

							</div>
							<div class="col-lg-4 col-md-4 col-xs-12 text-center">
								<img  id="blah" src="{{asset('employee_image/'.$employee->Images)}}" alt="your image" />
							</div>
						</div>
					</div>
              	</div>

              	<div class="tab-pane" id="tab-2">
	                 <!-- <p>Popular Content</p> -->
					<div class="box-body tabcontent" id="jobinfo">
						<div class="row">
				    			<div class="col-lg-12 col-md-12 col-xs-12">
							        
									<input type="text" id="hrm_employee_job_info_id" name="hrm_employee_job_info_id" value="{{$editemployee[0]->hrm_employee_job_info_id}}"" class="hidden">


									<input type="text" id="employee_id" name="employee_id" value="{{$employee->id}}" class="hidden">



								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Employee Code</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->employee_code}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Department</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->depertment_name}}</label>
								</div>


								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Designation</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->designation_name}}</label>
								</div>  			

						
						 		<div class="form-group has-feedback {{ $errors->has('category_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Employee Category</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->category_name}}</label>
								</div>  			


						 		<div class="form-group has-feedback {{ $errors->has('section_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Sub-department</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->section_name}}</label>
								</div>   
									
						
								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Job Placement</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->location_name}}</label>
								</div>  			

								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Working Shift</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->shift_name}}</label>
								</div>  			



								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Overtime Status</label>
                                       	@if ($editemployee[0]->overtime_status or old('overtime_status') == 1)
									        <label class="col-lg-9 control-label">Yes</label>

										@else
									        <label class="col-lg-9 control-label">No</label>
      									@endif

								</div>  


								<div class="form-group has-feedback {{ $errors->has('insurance') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Insurance</label>
                                       	@if ($editemployee[0]->insurance or old('insurance') == 1)
									        <label class="col-lg-9 control-label">Yes</label>

										@else
									        <label class="col-lg-9 control-label">No</label>
      									@endif

								</div>  


								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Plant/Work Place</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->plant_name}}</label>
								</div> 


								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Reporting to</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->manage_by_name}}</label>
								</div>  			







					             @if (Config::get('module_config.payroll_module') == 1)

								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Salary Grade</label>
									<label class="col-lg-9 control-label">{{$employee_salary_grade[0]->grade_name}}</label>
								</div>  
					            
					            @endif

								
								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Gross Salary</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->basic_salary}}</label>
								</div>

								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Employee Status</label>
									<label class="col-lg-9 control-label">{{$editemployee[0]->employeestatus_name}}</label>
								</div>  



								<div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">
									<label class="col-lg-3 control-label">Joining Date</label>
									<label class="col-lg-9 control-label">{{  date('d-m-Y', strtotime(str_replace('-', '/', $editemployee[0]->joining_date ))) }}</label>
								        
								</div>

								


							   @if($editemployee[0]->employeestatus_id==1)
										<div class="form-group has-feedback col-lg-12 col-md-12 col-xs-12">
											<label class="col-lg-3 control-label">Probation Period </label>
											<label class="col-lg-9 control-label">{{$editemployee[0]->period}}<span style="margin-left: 5px;">Months</span> </label>
										</div>
									@else
							        	<div class="form-group has-feedback  col-lg-12 col-md-12 col-xs-12">
											<label class="col-lg-3 control-label">Confirmation Date</label>
											<label class="col-lg-9 control-label">{{  date('d-m-Y', strtotime(str_replace('-', '/', $editemployee[0]->confirmation_date ))) }}</label>
										        
										</div>

										<div class="form-group has-feedback  col-lg-12 col-md-12 col-xs-12">
											<label class="col-lg-3 control-label">Job Duration</label>
											<label class="col-lg-9 control-label">{{$editemployee[0]->jobduration}}</label>
										</div>
								@endif 
								






				    			</div>
				   			
				    		</div>
					</div>                     
              	</div><!--/.tab-pane -->

              	<div class="tab-pane" id="tab-3">
	                 <!-- <p>Tag Content</p> -->
					<div class="box-body tabcontent" id="documents">

						<div class="box-body">
							<div class="row">
						        <div class="form-group col-lg-12 col-md-12 col-xs-12"> 

						          <div class="col-lg-3 col-md-3 col-xs-12 form-group" style="padding-left: 0px; padding-top: 10px;">  
						            <label control-label">File Type</label> 
						            <select style="width: 100%;" class="form-control select2" id="file_type" name="file_type" required>
						            </select>
						         
						          </div>

									<table id="list_table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 20%">Date</th>
												<th style="width: 20%">File Type</th>
												<th style="width: 20%">File Title</th>
												<th style="width: 50%">Note</th>
												<th style="width: 5%">View</th>
												<th style="width: 5%">Download</th>
												<!-- <th style="width: 10%">Delete</th> -->
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

              	<div class="tab-pane" id="tab-4">
				  	<div class="box-body tabcontent" id="skill">
						<div class="box-body">
							<div class="row">
								<div class="form-group col-lg-12 col-md-12 col-xs-12"> 
									<table id="skill_table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 30%">Skill Name</th>
												<th style="width: 70%">Description</th>
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

				<div class="tab-pane" id="tab-5">
				  	<div class="box-body tabcontent" id="Assigned Asset">
						<div class="box-body">
							<div class="row">
								<div class="form-group col-lg-12 col-md-12 col-xs-12"> 
									<table id="asset_table" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 70%">Assigned Asset</th>
												<th style="width: 30%">Assigned Date</th>
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

              	<div class="tab-pane" id="tab-6">
	                 <!-- <p>Tag Content</p> -->
					<div class="box-body tabcontent" id="history">

						<div class="box-body">
							<div class="row">
						        <div class="form-group col-lg-12 col-md-12 col-xs-12"> 


									<table id="list_table_history" class="table table-bordered table-hover" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="width: 0%"></th>
												<th style="width: 20%">Employee Activity</th>
												<th style="width: 10%">Start Date</th>
												<th style="width: 10%">End Date</th>
												<th style="width: 15%">Location</th>
												<th style="width: 15%">Department</th>
												<th style="width: 15%">Designation</th>
												<th style="width: 15%">Category</th>
												<th style="width: 15%">Salary</th>
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


            </div><!--/.tab-content -->

        </div> 
    </div>
    <!--/.container -->
</div>

@endsection

@section('script')
<script src="{{asset('js/fileinput.js')}}"></script>

<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function($) {
    dataLoad = function(){

	skill_table = $('#skill_table').DataTable( {
		destroy:    true,
		paging:     false,
		searching:  false,
		ordering:   false,
		bInfo:      false,
		"ajax": {
			"url": "{{URL::to('/')}}/skill_employeewise_list_post",
			"type": "POST",
			"headers":{'X-CSRF-TOKEN': '{{ csrf_token() }}'},  
			"data":
			{
				employee_id: $("#employee_id").val()
			}                
		},
		"columns": [
			{ "data": "skill_name" },
			{ "data": "description" }
		],
		"order": [[0,'asc']]
	});

	asset_table = $('#asset_table').DataTable( {
		destroy:    true,
		paging:     false,
		searching:  false,
		ordering:   false,
		bInfo:      false,
		"ajax": {
			"url": "{{URL::to('/')}}/asset_assign_list_post",
			"type": "POST",
			"headers":{'X-CSRF-TOKEN': '{{ csrf_token() }}'},  
			"data":
			{
				employee_id: $("#employee_id").val()
			}                
		},
		"columns": [
			{ "data": "asset" },
			{ "data": "MYDATE" }
		],
		"order": [[0,'asc']]
	});



      if ($("#file_type").val() == null){
        file_type = 0;
      }else{
        file_type = $("#file_type").val();
      }

      if ($("#employee_id").val() == null){
        employee_id = 0;
      }else{
        employee_id = $("#employee_id").val();
      }


      	// $.ajax({
	    //     type:   'POST', 
	    //     url :   "{{URL::to('/')}}/employeewisefile_list",
	    //     headers:{
	    //               'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    //             },
	    //     data:   {
	    //        // date_from: $("#date_from").val(),
	    //        // date_to: $("#date_to").val(),
	    //        file_type: file_type,
	    //        employee_id:employee_id,
	    //     },        
	    //     dataType: 'json',
	    //     success: function(data) {
	    //         var dataSet = data.data;
	    //         table = $('#list_table').DataTable( {
	    //           destroy:    true,
	    //           paging:     false,
	    //           searching:  false,
	    //           ordering:   true,
	    //           bInfo:      true,  
	    //           "data":     dataSet,

	    //         "columns": [
	                                                      
	    //           { "data": "attached_date" },                     
	    //           { "data": "file_type_name" },                     
	    //           { "data": "file_title" },                     
	    //           { "data": "note" },
	    //           { "data": "Link",
	    //             // "mRender": function (data, type, full) {
	    //             //     return '<a href="{{URL::to('/')}}/document_archive/'+full.hrm_employee_file_id+'/view" target="_blank"  class="btn btn-info btn-sm btn-flat"><span class="glyphicon glyphicon-resize-full"></span> View</a>';
	    //             // }
	    //             "mRender": function (data, type, full) {
	    //             // return '<a data-hrm_employee_file_id="'+full.hrm_employee_file_id+'" class="btn btn-primary btn-single btn-sm showme"> View</a>';            
	    //             return '<a data-hrm_employee_file_id="'+full.hrm_employee_file_id+'" class="btn btn-info btn-sm btn-flat showme"><span class="glyphicon glyphicon-resize-full"></span> View</a>';
	    //             }                
	    //           },                     
	    //           { "data": "Link",
	    //             "mRender": function (data, type, full) {
	    //                 return '<a href="{{URL::to('/')}}/document_archive/'+full.hrm_employee_file_id+'/download" class="btn btn-success btn-sm btn-flat"><span class="glyphicon "></span> Download</a>';
	    //             }
	    //           },                         
	    //         ],
	    //         "order": [[0,'asc']]
	    //         });
	    //     }
      	// });
    } 

	dataLoad();


   // $('#date_from').datepicker({
   //    autoclose: true
   //  });

   // $('#date_to').datepicker({
   //    autoclose: true
   //  });

	$file_type = $('#file_type').select2({
		      placeholder: 'Enter File Type',
		      allowClear: true,
		      ajax: {
		        dataType: 'json',
		        url: '{{URL::to('/')}}/file_type_list',
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

	$file_type.on('select2:select', function (e) {
	    dataLoad();
	});

	$file_type.on('select2:unselect', function (e) {
	    $('#file_type').val(null).trigger("change");
	    dataLoad();
	});


	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#blah')
				.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	function openCity(evt, cityName) {
	    // Declare all variables
	    var i, tabcontent, tablinks;

	    // Get all elements with class="tabcontent" and hide them
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }

	    // Get all elements with class="tablinks" and remove the class "active"
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }

	    // Show the current tab, and add an "active" class to the button that opened the tab
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}


      	$.ajax({
	        type:   'POST', 
	        url :   "{{URL::to('/')}}/employeehistory_list",
	        headers:{
	                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
	                },
	        data:   {
	           employee_id:employee_id,
	        },        
	        dataType: 'json',
	        success: function(data) {
	            var dataSet = data.data;
	            table = $('#list_table_history').DataTable( {
	              destroy:    true,
	              paging:     false,
	              searching:  false,
	              ordering:   true,
	              bInfo:      false,  
	              "data":     dataSet,
	            "columnDefs": [
                  {
                      "targets": [ 0 ],
                      "visible": false,
                      "searchable": true
                  }
                 ],
	            "columns": [
	                                                      
	              { "data": "id" },                     
	              { "data": "description" },                     
	              { "data": "start_date" },                     
	              { "data": "end_date" },                     
	              { "data": "location_name" },                     
	              { "data": "depertment_name" },                     
	              { "data": "designation_name" },                     
	              { "data": "category_name" },                     
	              { "data": "basic_salary" },                     
	            ],
	            "order": [[0,'asc']]
	            });
	        }
      	});




});

</script>


<script type="text/javascript">
	
$(document).ready(function($) {

  $('#list_table').on('click', '.showme', function(e){
    event.preventDefault();
      $.ajax({
          type: 'GET', 
          url : '{{URL::to('/')}}/document_archive/'+$(this).data('hrm_employee_file_id')+'/view',
          success : function (data) {
            console.log(data);
            $("#fileshow").html(data);
          }
      }); 
    // $("#load_file").animatedModal();
    $('#load_file').modal('show');
  });

});	
</script>




    <!-- modal -->
  <div id="load_file" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="h_iframe" id="fileshow" style="text-align: center;">
                 
                  </div>

              </div>
              <div class="modal-footer">
                  <button class="btn btn-secondary"
                  data-dismiss="modal">
                  close
                  </button>

              </div>
          </div>
      </div>
  </div>
    <!-- modal -->

@endsection