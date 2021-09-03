{{ csrf_field() }}
	<div class="box-body">
		<div class="row" style="padding:80px;">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group has-feedback {{ $errors->has('employee_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">  
          <label class="col-lg-3 control-label">Employee Name</label>
          <div class="col-lg-9">
            <select style="width: 100%;" class="form-control select2" id="employee_name" name="hrm_employee_id" required autofocus >
              @if($form_type == 'edit')
                <option value="{{$data[0]->employee_id}}">{{$data[0]->employee_name}} </option>
              @endif
            </select>
            <input class="hidden" type="text" id="employee_id">
          </div>
        </div>

        <div class="form-group has-feedback {{ $errors->has('employee_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">  
          <label class="col-lg-3 control-label">Asset</label>
          <div class="col-lg-9">
            <select style="width: 100%;" class="form-control select2" id="asset_id" name="hrm_asset_assign_master_id" required autofocus >
              @if($form_type == 'edit')
                <option value="{{$data[0]->hrm_asset_id}}">{{$data[0]->asset}} </option>
              @endif
            </select>
          </div>
        </div>

        <div class="form-group has-feedback {{ $errors->has('employee_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">  
          <label class="col-lg-3 control-label">Note</label>
          <div class="col-lg-9">
            <input type="text" id="note" name="note" class="form-control" required autofocus>
          </div>
        </div>

        <div class="form-group has-feedback {{ $errors->has('employee_name') ? ' has-error' : '' }} col-lg-12 col-md-12 col-xs-12">  
          <label class="col-lg-3 control-label">Return Type</label>
          <div class="col-lg-9">
            <select style="width: 100%;" class="form-control select2" id="asset_return_type_id" name="asset_return_type_id" required autofocus >
              @if($form_type == 'edit')
                <option value="{{$data[0]->return_type_id}}">{{$data[0]->return_type_id}} </option>
              @endif
            </select>
          </div>
        </div>
      </div>

      <div class="row" style="padding-right: 30px;">
        <div class="form-group  col-lg-12 col-md-12 col-xs-12">
          <div class="col-lg-12">
            <input type="submit" id="btnSubmit" class="btn btn-success block btn-flat pull-right" value="Submit">
          </div>
        </div>
      </div>
    </div>
	</div>

