{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Carian Sindiket & Rangkaian') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('syndicates.index') }}">{{ __('Sindiket') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ __('Carian') }}</li>
                        <li class="breadcrumb-item active">{{ __('Rangkaian') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    @include('elements.search')

    <section class="content">
        <div class="container-fluid">
            <!-- row -->
            @include('elements.alert')
            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Senarai Sindiket & Rangkaian') }}</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>{{ __('Nama') }}</th>
                                                <th>{{ __('No. Lesen') }}</th>
                                                <th>{{ __('Jenis') }}</th>
                                                <th>{{ __('No. Pengenalan') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($syndicates as $list)
                                                <tr>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="{{ __('Rangkaian Detail') }}"
                                                                    onclick="document.getElementById('form-chart-syndicate-{{$list->id_}}').submit();"
                                                                    class="btn btn-default btn-flat btn-xs">
                                                                <i class="fas fa-network-wired"></i>
                                                            </button>
                                                            @if($list->model == "Syndicate")
                                                                <a data-toggle="tooltip" title="Butiran"
                                                                   class="btn btn-xs btn-primary"
                                                                   href="{{ route('syndicates.show', $list->id_) }}">
                                                                    <i class="fas fa-book-open"></i>
                                                                </a>
                                                            @endif
                                                        </div>

                                                        <form target="_blank" id="form-chart-syndicate-{{$list->id_}}"
                                                              method="get"
                                                              action="{{ route('orgchart.index') }}">
                                                            @csrf
                                                            <input type="hidden" name="model_id" value="{{$list->id_}}">
                                                            <input type="hidden" name="model_type"
                                                                   value="{{$list->model}}">
                                                        </form>
                                                    </td>
                                                    <td>{{ ($syndicates->currentpage()-1) * $syndicates->perpage() + $loop->index + 1  }}</td>
                                                    <td>{{ $list->name_ }}</td>
                                                    <td>{{ $list->lcn_no == null ? __('Tiada Data'): $list->lcn_no}}</td>
                                                    <td>{{ $list->type }}</td>
                                                    <td>{{ $list->id_no == null ? __('Tiada Data'): $list->id_no}} </td>
                                                    <td>{!! $list->status ? '<span class="badge badge-success">'.__('Aktif').'</span>':'<span class="badge badge-danger">'.__('Tidak Aktif').'</span>' !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $syndicates->count() ? $syndicates->appends(request()->input())->links('pagination::bootstrap-4'):"" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
