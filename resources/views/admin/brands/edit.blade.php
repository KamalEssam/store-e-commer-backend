@extends('layouts.admin.master')

@section('title', trans('admin.brands'))

@section('page-title', trans('admin.brands'))

@section('page-small-title', trans('admin.edit_brand'))


@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.brands')])
@endsection



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($brand, ['route' => ['brands.update', $brand->id], 'id' => 'form-add-brand', 'role' => 'Form', 'method' => 'PATCH' ]) }}
                    @include('admin.brands.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
