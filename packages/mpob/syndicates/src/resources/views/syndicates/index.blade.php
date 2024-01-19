@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Sindiket') }}</h1>
                </div>
            </div>
        </div>
    </section>


    @include('elements.search')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Senarai Sindiket') }}</h4>
                            <div class="float-right">
                                <a href="{{ route('syndicates.create') }}"
                                   class="btn btn-xs btn-primary">
                                    <i class="fa fa-plus-circle"></i> {{ __('Tambah') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @include('elements.alert')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>{{ __('Sindiket') }}</th>
                                            <th>{{ __('Sejak') }}</th>
                                            <th>{{ __('Lokasi') }}</th>
                                            <th>{{ __('Pengesahan') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Kemaskini') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($syndicates as $syndicate)
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                        <a data-toggle="tooltip" title="Butiran" class="btn btn-xs btn-primary"
                                                           href="{{ route('syndicates.show', $syndicate->id_) }}">
                                                            <i class="fas fa-book-open"></i>
                                                        </a>
                                                        <a data-toggle="tooltip" title="Kemaskini" class="btn btn-xs btn-warning" href="{{ route('syndicates.edit', $syndicate->id_) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form target="_blank" id="form-chart-syndicate-{{$syndicate->id_}}" method="get"
                                                              action="{{ route('orgchart.index') }}">
                                                            @csrf
                                                            <input type="hidden" name="model_id" value="{{$syndicate->id_}}">
                                                            <input type="hidden" name="model_type"
                                                                   value="{{class_basename($syndicate)}}">

                                                            <button
                                                                data-toggle="tooltip"
                                                                title="{{ __('Rangkaian Detail') }}"
                                                                class="btn btn-info btn-flat btn-xs">
                                                                <i class="fas fa-network-wired"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $syndicate->name_ }}</td>
                                                <td>{{ $syndicate->since }}</td>
                                                <td>
                                                    @if($syndicate->city_code_)
                                                        {{ $syndicate->city->name_ }}
                                                        ({{ ucfirst(strtolower($syndicate->city->state->name_)) }})
                                                    @endif
                                                </td>
                                                <td>{{ $syndicate->confirmation->name_}}</td>
                                                <td>{!! $syndicate->status ? '<span class="badge badge-success">'.__('Aktif').'</span>':'<span class="badge badge-danger">'.__('Tidak Aktif').'</span>' !!}</td>
                                                <td>{{ $syndicate->update_dt->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mx-auto">
                                    {!! $syndicates->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
