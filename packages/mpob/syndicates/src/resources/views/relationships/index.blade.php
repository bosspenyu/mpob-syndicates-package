@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Hubungan') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Senarai Hubungan') }}</h4>
                            <div class="float-right">
                                <a href="{{ route('relationships.create') }}"
                                   class="btn btn-xs btn-primary">
                                    <i class="fa fa-plus-circle"></i> {{ __('Tambah') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @include('elements.alert')
                            <div class="row">
                                <div class="col-xl-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">Aktif</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#trash" type="button" role="tab" aria-controls="trash" aria-selected="false">Tidak Aktif</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('Nama') }}</th>
                                                        <th>{{ __('Dicipta') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($relationships as $relationship)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $relationship->name_ }}</td>
                                                            <td>{{ $relationship->create_dt->format('d/m/Y') }}</td>
                                                            <td>
                                                                <form id="form-relationship-{{$relationship->id_}}" method="post"
                                                                      action="{{ route('relationships.destroy', $relationship->id_) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                </form>
                                                                <div class="button-group">
                                                                    <a href="{{ route('relationships.edit', $relationship->id_) }}"
                                                                       class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                       onclick="if(confirm('Anda pasti untuk memadam rekod ini?'))document.getElementById('form-relationship-{{$relationship->id_}}').submit();"
                                                                       class="btn btn-xs btn-danger"><i class="fas fa-trash"></i>
                                                                    </a>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('Nama') }}</th>
                                                        <th>{{ __('Dipadam') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($trashRelationships as $relationship)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $relationship->name_ }}</td>
                                                            <td>{{ $relationship->create_dt->format('d/m/Y') }}</td>
                                                            <td>
                                                                <form id="form-relationship-restore-{{$relationship->id_}}" method="post"
                                                                      action="{{ route('relationships.restore', $relationship->id_) }}">
                                                                    @csrf
                                                                    @method('post')
                                                                </form>
                                                                <div class="button-group">
                                                                    <a href="javascript:void(0);"
                                                                       onclick="if(confirm('Anda pasti untuk memadam rekod ini?'))document.getElementById('form-relationship-restore-{{$relationship->id_}}').submit();"
                                                                       class="btn btn-xs btn-danger"><i class="fas fa-trash-restore"></i>
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
                            </div>
                            <div class="d-flex">
                                <div class="mx-auto">
                                    {!! $relationships->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
