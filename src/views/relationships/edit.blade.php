{{-- Extends layout --}}
@extends('layouts.master')

{{-- Content --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1>{{ __('Hubungan') }}</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('relationships.index') }}">{{ __('Hubungan') }} </a></li>
                        <li class="breadcrumb-item active">{{ __('Tambah') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form enctype="multipart/form-data" method="post" action="{{ route('relationships.update', $id) }}">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                @include('syndicates::elements.alert')
                                <div class="row">
                                    <div class="{{ Request::input('category') == 2 ? "col-md-6":"col-md-12" }}">
                                        <div class="form-row mb-3">
                                            <div class="col-md-8">
                                                <label>{{ __('Nama') }}</label>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('name_') ? 'is-invalid':'' }}"
                                                       name="name_"
                                                       value="{{ $relationship->name_ }}"
                                                >
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name_') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <button type="submit"
                                                class="btn btn-default custom-button-primary float-right"><i
                                                class="fas fa-save"></i> {{ __('Kemaskini') }}</button>
                                        <a href="{{ route('relationships.index') }}"
                                           class="btn btn-default custom-button-primary float-right mx-1">
                                            <i class="fas fa-angle-double-left"></i> {{ __('Kembali') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
