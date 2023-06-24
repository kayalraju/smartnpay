@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.Wallets') }} <small>{{ trans('labels.Wallets') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Wallets') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- <div class="box-header">
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
                        </div> -->

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
                                            <th>{{trans('labels.ID')}}</th>
                                            <th>{{trans('labels.FullName')}}</th>
                                            <th>{{trans('labels.Email')}}</th>
                                            <th>{{trans('labels.Phone')}}</th>
                                            <th>{{trans('labels.CurrentBalance')}}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['cspWallets'])>0)
                                            @foreach ($result['cspWallets'] as $key=>$cspWallets)
                                                <tr>
                                                    <td>{{ $cspWallets->accounts_id }}</td>
                                                    <td>{{ $cspWallets->first_name }}</td>
                                                    <td>{{ $cspWallets->email }}</td>
                                                    <td>{{ $cspWallets->phone }}</td>
                                                    <td>{{ $cspWallets->current_balance }}</td>
                                                    @php $id =$cspWallets->users_id;   @endphp
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="Credit" href="{{url('admin/wallets/csp/credit',$id)}}" class="badge bg-light-blue">Credit</a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Debit" href="{{url('admin/wallets/csp/debit',$id)}}" class="badge bg-light-blue">Debit</a>
                                                    
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
