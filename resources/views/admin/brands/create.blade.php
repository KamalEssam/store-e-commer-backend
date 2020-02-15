@extends('layouts.admin.master')

@section('title', trans('admin.brands'))

@section('page-title', trans('admin.brands'))

@section('page-small-title', trans('admin.add_brand'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.add_brand')])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'brands.store', 'id' => 'form-add-brand', 'role' => 'Form', 'files' => true ]) }}
                    @include('admin.brands.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
