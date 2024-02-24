{{-- Extends layout --}}
@extends('layouts.master')

{{-- Content --}}
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $syndicate->name_ }}</h1>
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

    @include('syndicates::elements.search')

    <section class="content">
        <div class="container-fluid">
            <!-- row -->
            @include('syndicates::elements.alert')
            <div class="row">
                <div class="col-xl-12 col-xxl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Senarai Rangkaian') }}</h4>
                            <div class="float-right">
                                <a href="{{ route('syndicates.show', $syndicate->id_) }}"
                                   class="btn btn-default btn-xs float-right mx-1">
                                    <i class="fas fa-angle-double-left"></i> {{ __('Kembali') }}</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{ __('Hubungan') }}</th>
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
                                                            <button
                                                                data-toggle="tooltip"
                                                                title="{{ __('Tambah Rangkaian') }}"
                                                                onclick="document.getElementById('form-link-syndicate-{{$list->id_}}').submit();"
                                                                class="btn btn-default custom-button-primary btn-flat"><i class="fas fa-handshake"></i>
                                                            </button>
                                                            <button
                                                                data-toggle="tooltip"
                                                                title="{{ __('Rangkaian Detail') }}"
                                                                onclick="document.getElementById('form-chart-syndicate-{{$list->id_}}').submit();"
                                                                class="btn btn-default custom-button-primary btn-xs">
                                                                <i class="fas fa-network-wired"></i>
                                                            </button>
                                                        </div>

                                                        <form target="_blank" id="form-chart-syndicate-{{$list->id_}}" method="get"
                                                              action="{{ route('orgchart.index') }}">
                                                            @csrf
                                                            <input type="hidden" name="model_id" value="{{$list->id_}}">
                                                            <input type="hidden" name="model_type"
                                                                   value="{{$list->model}}">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form id="form-link-syndicate-{{$list->id_}}" method="post"
                                                              action="{{ route('networks.link', $syndicate->id_) }}">
                                                            @csrf
                                                            <input type="hidden" name="model_id" value="{{$list->id_}}">
                                                            <input type="hidden" name="model_type"
                                                                   value="{{$list->model}}">
                                                            <input type="hidden" name="advance_search"
                                                                   value="{{ request()->get('advance_search') }}">
                                                            <input type="hidden" name="name"
                                                                   value="{{ request()->get('name') }}">
                                                            <input type="hidden" name="vehicle_no"
                                                                   value="{{ request()->get('vehicle_no') }}">
                                                            <input type="hidden" name="license_no"
                                                                   value="{{ request()->get('license_no') }}">
                                                            <input type="hidden" name="note"
                                                                   value="{{ request()->get('note') }}">
                                                            <select name="relationship_id" id="relationship_id"
                                                                    class="form-control {{ $errors->has('relationship_id') ? 'is-invalid':'' }}">
                                                                <option value=""> --- {{ __('Pilihan') }}---
                                                                </option>
                                                                @foreach($relationships as $key => $relationship)
                                                                    <option
                                                                        value="{{ $key }}">{{ $relationship }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('relationship_id') }}
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>{{ ($syndicates->currentpage()-1) * $syndicates->perpage() + $loop->index + 1  }}</td>
                                                    <td>{{ $list->name_ }}</td>
                                                    <td>{{ $list->lcn_no == null ? __('Tiada Data'): $list->lcn_no}}</td>
                                                    <td>{{ $list->type }}</td>
                                                    <td>{{ $list->id_no == null ? __('Tiada Data'): $list->id_no}} </td>
                                                    <td>{!! $syndicate->status ? '<span class="badge badge-success">'.__('Aktif').'</span>':'<span class="badge badge-danger">'.__('Tidak Aktif').'</span>' !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $syndicates->count() ? $syndicates->links('pagination::bootstrap-4'):"" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
