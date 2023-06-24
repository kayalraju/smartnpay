@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.MdfUsers') }} <small>{{ trans('labels.ListingMdfUsers') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.MdfUsers') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="col-lg-6 form-inline" id="contact-form">
                                <form  name='registration' id="registration" class="registration" method="get" action="{{url('admin/mdf_users/filter')}}">
                                    <input type="hidden"  value="{{csrf_token()}}">
                                    <div class="input-group-form search-panel ">
                                        <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy"  >
                                            <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                            <option value="MdfUserName"  @if(isset($name)) @if  ($name == "MdfUserName") {{ 'selected' }} @endif @endif>{{trans('labels.Name')}}</option>
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($param)) value="{{$param}}" @endif >
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($param,$name))  <a class="btn btn-danger " href="{{url('admin/mdf_users/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{url('admin/mdf_users/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('id', trans('labels.ID') )</th>
                                            <th>@sortablelink('first_name', trans('labels.FullName') )</th>
                                            <th>@sortablelink('email', trans('labels.Email') )</th>
                                            <th>@sortablelink('phone', trans('labels.Phone') )</th>
                                            <th>@sortablelink('states_name', trans('labels.StateName') )</th>
                                            <th>@sortablelink('districts_name', trans('labels.DistrictName') )</th>
                                            <th>@sortablelink('vidhan_sabhas_name', trans('labels.VidhanSabha') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($mdfUserData['mdfUsers'])>0)
                                            @foreach ($mdfUserData['mdfUsers'] as $key=>$mdfUsers)
                                                <tr>
                                                    <td>{{ $mdfUsers->id }}</td>
                                                    <td>{{ $mdfUsers->first_name }}</td>
                                                    <td>{{ $mdfUsers->email }}</td>
                                                    <td>{{ $mdfUsers->phone }}</td>
                                                    <td>{{ $mdfUsers->states_name }}</td>
                                                    <td>{{ $mdfUsers->districts_name }}</td>
                                                    <td>{{ $mdfUsers->vidhan_sabhas_name }}</td>
                                                    @php $id =$mdfUsers->id;   @endphp
                                                    <td>
                                                    <button mdf-users-id="{{ $mdfUsers->id }}" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Status') }}" style="border: none;" class="<?php echo $mdfUsers->status == 0?'badge bg-red':'badge bg-light-blue'; ?>" id="change_user_status"><?php echo $mdfUsers->status == 0?"Inactive":"Active"; ?></button>  
                                                   
                                                    <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/mdf_users/edit',$id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($mdfUserData['mdfUsers'] != null)
                                      <div class="col-xs-12 text-right">
                                          {{$mdfUserData['mdfUsers']->links()}}
                                      </div>
                                    @endif
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
            <!-- deleteMdfUserModal -->
            <div class="modal fade" id="deleteMdfUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteMdfUserModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteMdfUserModalLabel">{{ trans('labels.DeleteMdfUser') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/mdf_users/delete', 'name'=>'deleteMdfUser', 'id'=>'deleteMdfUser', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'mdfUsers_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteMdfUserText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteMdfUser">{{ trans('labels.DeleteMdfUser') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!--  row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
