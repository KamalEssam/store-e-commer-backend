@extends('layouts.admin.master')

@section('title', trans('admin.brands'))

@section('page-title', trans('admin.brands'))

@section('page-small-title', trans('admin.all_brands'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.brands')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a href="{{ route('brands.create') }}" id="sample_editable_1_2_new"
                               class="btn sbold green"> {{ ucwords(trans('admin.add_new')) }}
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover"
                           id="sample_4">
                        <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th class="text-center"> {{ trans('admin.name') }}</th>
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr class="odd gradeX">
                                <th class="hidden"></th>
                                <td class="text-center">
                                    {{ $brand[app()->getLocale() . '_name'] }}
                                </td>

                                <td class="text-center">
                                    <div class="margin-bottom-5">
                                        {{-- edit category --}}
                                        <a href="{{ route('brands.edit', $brand->id) }}"
                                           class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-edit"></i> {{ ucfirst(trans('admin.edit')) }}
                                        </a>
                                        {{-- delete category --}}
                                        <a class="btn btn-sm red btn-outline filter-cancel delete-btn"
                                           data-id="{{ $brand->id }}"
                                           data-link="{{ route('brands.destroy', $brand->id) }}"
                                           data-type="DELETE">
                                            <i class="fa fa-trash"></i> {{ ucfirst(trans('admin.delete')) }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
