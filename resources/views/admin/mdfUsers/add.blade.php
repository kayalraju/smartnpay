@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.AddMdfUser') }} <small>{{ trans('labels.AddMdfUser') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/mdf_users/display')}}"><i class="fa fa-money"></i>{{ trans('labels.ListingMdfUsers') }} </a></li>
                <li class="active">{{ trans('labels.AddMdfUser') }} </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.AddMdfUser') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info"><br>

                                        @if(session()->has('message'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ session()->get('message') }}
                                            </div>
                                        @endif

                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            {!! Form::open(array('url' =>'admin/mdf_users/add', 'method'=>'post', 'class' => 'form-horizontal  form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            <hr>
                                                <h4>{{ trans('labels.Personal Info') }} </h4>
                                            <hr> 
                                            <div class="form-group">
                                                <label for="first_name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FullName') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('first_name',  '', array('class'=>'form-control  field-validate', 'id'=>'first_name'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.fullNameText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Email') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('email',  '', array('class'=>'form-control  field-validate', 'id'=>'email'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.emailText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="gender" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Gender') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" id="gender" name="gender">
                                                        <option value="">Select gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <hr>
                                                <h4>{{ trans('labels.AddressInfo') }}</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label for="states_id" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" id="entry_state_id" name="states_id">
                                                        <option value="">Select State</option>
                                                    @if(count($stateData['states'])>0)
                                                    @foreach ($stateData['states'] as $key=>$states)
                                                        <option value="{{ $states->states_id }}">{{ $states->states_name }}</option>
                                                    @endforeach
                                                    @endif
                                                     <select class="form-control field-validate" id="entry_state_id" name="states_id">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="districts_id" class="col-sm-2 col-md-3 control-label">{{ trans('labels.District') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate districts_content" id="entry_district_id" name="districts_id">
                                                        <option value="">{{ trans('labels.SelectDistrict') }}</option>	
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="vidhan_sabhas_id" class="col-sm-2 col-md-3 control-label">{{ trans('labels.VidhanSabha') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate vidhan_sabhas_content" id="vidhan_sabhas_id" name="vidhan_sabhas_id">
                                                        <option value="">Select Vidhan Sabhas</option>	
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <hr>
                                                <h4>Account Info</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label for="account_types_id" class="col-sm-2 col-md-3 control-label">Account Type<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" id="account_types_id" name="account_types_id">
                                                        @if(count($accountTypesData['accountTypes'])>0)
                                                        @foreach ($accountTypesData['accountTypes'] as $key=>$accountTypes)
                                                        <option value="{{ $accountTypes->account_types_id }}">{{ $accountTypes->account_types_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <hr>
                                                <h4>{{ trans('labels.Login Info') }}</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label for="phone" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Phone') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('phone',  '', array('class'=>'form-control  field-validate', 'id'=>'phone'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.phoneText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 col-md-3 control-label">password
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('password',  '', array('class'=>'form-control  field-validate', 'id'=>'password'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.password') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="isActive">
                                                        <option value="1">{{ trans('labels.Active') }}</option>
                                                        <option value="0">{{ trans('labels.Inactive') }}</option>
                                                    </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.StatusText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/mdf_users/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>
                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
