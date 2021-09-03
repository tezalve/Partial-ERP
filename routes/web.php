<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });
// https://orangehrm-demo-6x.orangehrmlive.com/client/#/noncore/dashboard/index


Auth::routes();

Route::get('/',function(){
	return redirect('home');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('/home',		'HomeController');
});

   


//UsersController
Route::resource('users',				'UsersController');
Route::post('userslocationlist',		'UsersController@userslocationlist');
Route::get('reset',	            		'UsersController@reset');
Route::post('users_list',	            'UsersController@users_list');
Route::get('users/{id}/cancel/',		'UsersController@cancel');
Route::get('users/{id}/reactive/',		'UsersController@reactive');
Route::get('users/{id}/edit/',	    	'UsersController@edit');
Route::get('users/{id}/reset/',	    	'UsersController@reset');
Route::get('resetmypassword',	    	'UsersController@resetmypassword');
Route::post('password_reset',	        'UsersController@password_reset');


Route::get('role',	            		'UsersController@role');
Route::post('role_list',	            'UsersController@role_list');
Route::post('role_store',	            'UsersController@role_store');

// Permission Controller

Route::resource('permission',			'PermissionsController');
Route::get('getpermissionlist',			'PermissionsController@getpermissionlist');

Route::get('role_permission',			'PermissionsController@role_permission_display');
Route::post('submit_role_permission',	'PermissionsController@submit_role_permission');

Route::get('assigned_roles',			'PermissionsController@user_role_display');
Route::get('permission/{id}/user_role',	'PermissionsController@submit_user_role');
Route::post('add_user_role',			'PermissionsController@add_user_role');

// Route::get('permissionlist',			'PermissionController@permissionlistDisplay');
// Route::post('permissionlist',	        'PermissionController@permissionlist');
// Route::get('permission/permissionlist',	'PermissionController@permissionlistDisplay');
// Route::get('role_permission',	        'PermissionController@role_permission');
// Route::post('submit_role_permission',	'PermissionController@submit_role_permission');







// select2
Route::get('depertment_list_data',			'MasterdataController@depertmentlist');
Route::get('designation_list_data',			'MasterdataController@designationlist');
Route::get('religion_list_data',			'MasterdataController@religionlistdata');
Route::get('maritalstatus_list_data',		'MasterdataController@maritalstatuslistdata');
Route::get('blood_group_list_data',			'MasterdataController@bloodgrouplistdata');
Route::get('category_list_data',			'MasterdataController@categorylist');
Route::get('shift_list_data',				'MasterdataController@shiftlist');
Route::get('employee_list_data',			'MasterdataController@employeelist');
Route::get('join_employee_list',			'MasterdataController@joinemployeelist');
Route::get('joinemployeelist_accounts',		'MasterdataController@joinemployeelist_accounts');
Route::get('employeestatus_list_data',		'MasterdataController@employeestatuslist');
Route::get('location_list_data',			'MasterdataController@locationlist');
Route::get('location_list_data_all',		'MasterdataController@locationlistdataall');
Route::get('section_list_data',				'MasterdataController@sectionlist');
Route::get('employee_leave_type',			'MasterdataController@leavetypelist');
Route::get('monthlist',			            'MasterdataController@monthlist');
Route::get('userlist',			            'MasterdataController@userlist');
Route::get('getemployeejobinfo_details',    'MasterdataController@getemployeejobinfo_details');
Route::get('holiday_list_data',	            'MasterdataController@holiday_list_data');
Route::get('salaryheadgrouplist',	        'MasterdataController@salaryheadgrouplist');
Route::get('salarygrade_list',	            'MasterdataController@salarygrade_list');
Route::get('salary_head_list',	            'MasterdataController@salary_head_list');
Route::get('salary_head_loan_list',	        'MasterdataController@salary_head_loan_list');
Route::get('shiftrole_list_data',	        'MasterdataController@shiftrole_list_data');
Route::get('file_type_list',	            'MasterdataController@file_type_list');
Route::get('bonus_name_list',	            'MasterdataController@bonus_name_list');
Route::get('plantname_list_data',	        'MasterdataController@plantname_list_data');
Route::get('education_list_data',	        'MasterdataController@education_list_data');
Route::get('loantypes_list',	   	        'MasterdataController@loantypes_list');
Route::get('slap_name_list_data',	   	    'MasterdataController@slap_name_list_data');
Route::get('salary_master_listdata',	   	'MasterdataController@salary_master_listdata');
Route::get('kpi_daterange_listdata',	   	'MasterdataController@kpi_daterange_listdata');
Route::get('kpi_task_department_listdata',	'MasterdataController@kpi_task_department_listdata');
Route::get('get_kpi_mark_list',	         	'MasterdataController@get_kpi_mark_list');
Route::get('kpi_assesment_date_list_data',	'MasterdataController@kpi_assesment_date_list_data');
Route::get('get_bank_list',	             	'MasterdataController@get_bank_list');
Route::get('plantwithsection_list_data',	'MasterdataController@plantwithsection_list_data');
Route::get('increment_range_list_data',  	'MasterdataController@increment_range_list_data');
Route::get('department_listdata',  			'MasterdataController@department_listdata');





//Select2 Getdata
Route::get('getDesignationByEmployeeName',	'MasterdataController@getDesignationByEmployeeName');

//



// DashboardController
Route::post('provision_employeelist',	    'DashboardController@provision_employeelist');
Route::get('probation/{id}',				'DashboardController@probation');
Route::post('probation_confirm',			'DashboardController@probation_confirm');
Route::get('common_dashboard/{id}',	        'DashboardController@common_dashboard');




// Designation Controller
Route::resource('designation',				'DesignationController');
Route::post('designation_list',				'DesignationController@designationlist');
Route::get('designation/{id}/cancel/',		'DesignationController@cancel');



// Employee Controller
Route::resource('employee',					'EmployeeController');
Route::post('employee_list',				'EmployeeController@employeelist');
Route::get('employee/{id}/cancel/',			'EmployeeController@cancel');
Route::get('employeeinfo/{id}',		       	'EmployeeController@employeeinfo');
Route::get('employeeinfo/{id}/edit',		'EmployeeController@edit_employeeinfo');
Route::get('employeeinfo/{id}/print',		'EmployeeController@print_employeeinfo');
Route::post('modify_employeeinfo',			'EmployeeController@modify_employeeinfo');
Route::post('employeehistory_list',			'EmployeeController@employeehistory_list');


// Employee Join Controller
Route::resource('employeejoin',					'EmployeeJoinController');
Route::post('current_employeelist',				'EmployeeJoinController@current_employeelist');
Route::get('employeejoin/{id}/requestredflag',	'EmployeeJoinController@requestredflag');


// Route::get('current_employeelist',			'EmployeeJoinController@current_employeelist');


// Religion Controller
Route::resource('favourite_link',			    'FavouriteLinkController');
Route::post('favourite_link_list',				'FavouriteLinkController@favourite_link_list');
Route::get('favourite_link/{id}/cancel/',		'FavouriteLinkController@cancel');
Route::post('mynote_list',						'FavouriteLinkController@mynote_list');
Route::post('mynote_store',						'FavouriteLinkController@mynote_store');
Route::get('my_note/{id}/cancel/',				'FavouriteLinkController@mynote_cancel');

// Asset
Route::resource('asset',						'AssetInformationController');
Route::post('asset_list',						'AssetInformationController@asset_list');
Route::get('asset_list_data',					'AssetInformationController@asset_list_data');

Route::resource('asset_type', 					'AssetTypeController');
Route::post('asset_type_list', 					'AssetTypeController@asset_type_list');
Route::get('asset_type_list_data', 				'AssetTypeController@asset_type_list_data');

Route::resource('brand', 						'AssetBrandController');
Route::post('brand_list', 						'AssetBrandController@brand_list');
Route::get('brand_list_data', 					'AssetBrandController@brand_list_data');

// assetstore
Route::resource('assetstore',					'AssetStoreMasterController');
Route::post('asset_store_list',					'AssetStoreMasterController@asset_store_list');

// assetassign
Route::resource('assetassign',					'AssetAssignMasterController');
Route::post('asset_assign_list',				'AssetAssignMasterController@asset_assign_list');
Route::post('asset_assign_list_inactive',		'AssetAssignMasterController@asset_assign_list_inactive');
Route::get('asset_assign_list_get',				'AssetAssignMasterController@asset_assign_list_get');
Route::get('asset_data',						'AssetAssignMasterController@asset_data');
Route::get('asset_data_old',					'AssetAssignMasterController@asset_data_old');
Route::get('asset_assign_list_select',			'AssetAssignMasterController@asset_assign_list_select');
Route::post('asset_assign_list_post',			'AssetAssignMasterController@asset_assign_list_get');

Route::get('assigned_list_employee',			'AssetAssignMasterController@assigned_list_employee');

//asset_return_type
Route::resource('assetreturntype',				'AssetReturnTypeController');
Route::post('return_type_list',					'AssetReturnTypeController@return_type_list');
Route::get('return_type_list_data',				'AssetReturnTypeController@return_type_list_data');

// asset return
Route::resource('assetreturn',					'AssetReturnMasterController');
Route::post('asset_return_list',				'AssetReturnMasterController@asset_return_list');

// skill
Route::resource('skill',						'SkillController');
Route::post('skill_list', 						'SkillController@skill_list');
Route::get('skill_list_select', 				'SkillController@skill_list_select');

Route::resource('skillemployeewise',			'SkillEmployeewiseController');
Route::post('skill_employeewise_list',			'SkillEmployeewiseController@skill_employeewise_list');
Route::get('skill_employeewise_list_get',		'SkillEmployeewiseController@skill_employeewise_list_get');
Route::post('skill_employeewise_list_post',		'SkillEmployeewiseController@skill_employeewise_list_get');






