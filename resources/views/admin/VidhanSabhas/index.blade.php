@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.VidhanSabhas') }} <small>{{ trans('labels.ListingVidhanSabhas') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.VidhanSabhas') }}</li>
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
                                <form  name='registration' id="registration" class="registration" method="get" action="{{url('admin/vidhan_sabhas/filter')}}">
                                    <input type="hidden"  value="{{csrf_token()}}">
                                    <div class="input-group-form search-panel ">
                                        <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy"  >
                                            <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                            <option value="VidhanSabhaName"  @if(isset($name)) @if  ($name == "VidhanSabhaName") {{ 'selected' }} @endif @endif>{{trans('labels.VidhanSabhas')}}</option>
                                            <option value="VidhanSabhaName"  @if(isset($name)) @if  ($name == "VidhanSabhaName") {{ 'selected' }} @endif @endif>{{trans('labels.VidhanSabha')}}</option>
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($param)) value="{{$param}}" @endif >
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($param,$name))  <a class="btn btn-danger " href="{{url('admin/vidhan_sabhas/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{url('admin/vidhan_sabhas/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>@sortablelink('vidhan_sabhas_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('vidhan_sabhas_name', trans('labels.VidhanSabha') )</th>
                                            <th>@sortablelink('districts_name', trans('labels.District') )</th>
                                            <th>@sortablelink('states_name', trans('labels.State') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($vidhanSabhaData['vidhan_sabhas'])>0)
                                            @foreach ($vidhanSabhaData['vidhan_sabhas'] as $key=>$vidhan_sabhas)
                                                <tr>
                                                    <td>{{ $vidhan_sabhas->vidhan_sabhas_id }}</td>
                                                    <td>{{ $vidhan_sabhas->vidhan_sabhas_name }}</td>
                                                    <td>{{ $vidhan_sabhas->districts_name }}</td>
                                                    <td>{{ $vidhan_sabhas->states_name }}</td>
                                                    @php $id =$vidhan_sabhas->vidhan_sabhas_id;   @endphp
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/vidhan_sabhas/edit',$id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a  data-toggle="tooltip" data-placement="bottom" title=" {{ trans('labels.Delete') }}" id="deleteVidhanSabhasId" vidhan_sabhas_id ="{{ $vidhan_sabhas->vidhan_sabhas_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                                    @if($vidhanSabhaData['vidhan_sabhas'] != null)
                                      <div class="col-xs-12 text-right">
                                          {{$vidhanSabhaData['vidhan_sabhas']->links()}}
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
            <!-- deleteVidhanSabhasModal -->
            <div class="modal fade" id="deleteVidhanSabhasModal" tabindex="-1" role="dialog" aria-labelledby="deleteVidhanSabhasModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteVidhanSabhasModalLabel">{{ trans('labels.DeleteVidhanSabhas') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/vidhan_sabhas/delete', 'name'=>'deleteVidhanSabhas', 'id'=>'deleteVidhanSabhas', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'vidhan_sabhas_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteVidhanSabhasText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteVidhanSabhas">{{ trans('labels.DeleteVidhanSabhas') }}</button>
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
