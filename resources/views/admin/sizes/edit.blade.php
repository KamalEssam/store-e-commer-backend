@extends('layouts.admin.master')

@section('title', trans('admin.sizes'))
@section('page-title', trans('admin.sizes'))
@section('page-small-title', trans('admin.edit_size'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.sizes')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($size, ['route' => ['sizes.update', $size->id], 'id' => 'form-add-size', 'role' => 'Form', 'method' => 'PATCH' ]) }}
                    @include('admin.sizes.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
