@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditVidhanSabha') }} <small>{{ trans('labels.EditVidhanSabha') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/vidhan_sabhas/display')}}"><i class="fa fa-money"></i>{{ trans('labels.ListingVidhanSabhas') }}</a></li>
                <li class="active">{{ trans('labels.EditVidhanSabha') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditVidhanSabha') }}</h3>
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

                                            {!! Form::open(array('url' =>'admin/vidhan_sabhas/update', 'method'=>'post', 'class' => 'form-horizontal field-validat', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id',  $vidhanSabha->vidhan_sabhas_id , array('class'=>'form-control', 'id'=>'id')) !!}
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" id="entry_state_id" name="states_id">
                                                    @if(count($stateData['states'])>0)
                                                    @foreach ($stateData['states'] as $key=>$states)
                                                        <option value="{{ $states->states_id }}" <?php echo $vidhanSabha->states_id == $states->states_id?"selected":""; ?>>{{ $states->states_name }}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.District') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate districts_content" id="entry_district_id" name="districts_id">
                                                    <option value="">Select District</option>
                                                    @if(count($districtData['districts'])>0)
                                                    @foreach ($districtData['districts'] as $key=>$districts)
                                                        <option value="{{ $districts->districts_id }}" <?php echo $vidhanSabha->districts_id == $districts->districts_id?"selected":""; ?>>{{ $districts->districts_name }}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LanguageDirection') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.VidhanSabhaName') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('vidhan_sabhas_name', $vidhanSabha->vidhan_sabhas_name, array('class'=>'form-control field-validat', 'id'=>'vidhan_sabhas_name'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.VidhanSabhaNameText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/vidhan_sabhas/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
