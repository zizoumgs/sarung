@extends('layouts.admin')

@section('title')
	Event|Add
@stop

@section('content')
    <h1 class="title">Add
        <a href="{{ root::get_url_admin_event()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
    {{ Form::open(array('url' => root::get_url_admin_event('add') , 'method' => 'post' , 'role' => 'form' ,'class' => 'form-horizontal')) ; }}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
            </div>
        </div>
        <div class="form-group">
            <label for="short_name" class="col-sm-2 control-label">Short Name </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Short Name ">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                {{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
            </div>
        </div>
    {{ Form::close() }}
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-offset-2 col-sm-4">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
@stop

