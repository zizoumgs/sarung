@extends('layouts.admin')

@section('title')
	Category|Delete
@stop

@section('content')
    <h1 class="title">Delete Category
        <a href="{{ root::get_url_admin_blog_category()}}" class="btn btn-primary btn-xs" >View</a>
    </h1>
    <hr class="mar_25">
	<div class="col-md-7" style="padding:15px;">
    @if( Session::has('message')  )
        <div class="clear_25"></div>
        <div class="col-sm-9">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}  
            </div>
        </div>
        <div class="clear_25"></div>
    @endif
    {{ Form::open(array('url' => root::get_url_admin_blog_category('delete') , 'method' => 'post' ,
	'role' => 'form' ,'class' => 'form-horizontal')) ; }}
        {{ Form::hidden('id' , $id ,array('id'=>'id'))}}
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
				<input  name="category_name" class="form-control "
						id="category_name"
						type="text" placeholder="Category" title="Name Category" required value="{{$category_name}}" READONLY >
            </div>
        </div>
        
        <div class="form-group">
            <label for="slug" class="col-sm-2 control-label">Slug</label>
            <div class="col-sm-10">
				<input  name="slug_name" class="form-control "
						id="slug_name"
						type="text" placeholder="Slug" title="Slug Name" required value="{{$slug_name}}" READONLY>
            </div>
        </div>

        <div class="form-group">
            <label for="Parent_Name" class="col-sm-2 control-label">Parent</label>
            <div class="col-sm-10">
				<select class="form-control" name="parent_name">
                    <option value="0">-</option>
					@foreach( Taxonomy_Model::orderBy('id' , 'DESC')->get() as $model)
						<option value="{{ $model->term->id }}"
                        @if( $model->term->id == $parent_name)
                            selected
                        @endif
                        >{{ $model->term->name }}</option>
					@endforeach
				</select>
            </div>
        </div>
        <div class="form-group">
    		<label for="description_name" class="col-sm-2 control-label">Description</label>
       				<div class="col-sm-10">
						{{ Form::TextArea(	'description_name', $description_name ,
										array('id' => 'description_name' ,
										'class' => 'form-control' ,'Rows'=>'5', "READONLY" => "" )) }}
      				</div>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-2">
                {{ Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) ) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <br>
@stop

