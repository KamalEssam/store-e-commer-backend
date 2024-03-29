@extends('layouts.admin.master')

@section('title', trans('admin.colors'))
@section('page-title', trans('admin.colors'))
@section('page-small-title', trans('admin.add_size'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.add_size')])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'sizes.store', 'id' => 'form-add-size', 'role' => 'Form']) }}
                    @include('admin.sizes.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
