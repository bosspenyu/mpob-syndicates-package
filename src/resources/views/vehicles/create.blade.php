{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1>{{ __('Kenderaan') }}</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('syndicates.index') }}">{{ __('Sindiket') }} </a></li>
                        <li class="breadcrumb-item">{{ __('Kenderaan') }}</li>
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
                <div class="col-xl-12 col-xxl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Kenderaan Sindiket') }}</h4>
                        </div>
                        <form enctype="multipart/form-data" method="post" action="{{ route('vehicles.store', $syndicateId) }}">
                            @csrf
                            <div class="card-body">
                                @include('elements.alert')
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label>{{ __('No. Pendaftaran') }}</label>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('registration_no') ? 'is-invalid':'' }}"
                                                       name="registration_no">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('registration_no') }}
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>{{ __('Jenis') }}</label>
                                                <select name="type" id="type" class="select2-with-label-single form-control {{ $errors->has('type') ? 'is-invalid':'' }}">
                                                    <option value=""> {{ __('Pilih Jenis Kenderaan') }}</option>
                                                    @foreach($vehicleTypes as $key => $type)
                                                        <option value="{{ $key }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('type') }}
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>{{ __('Buatan') }}</label>
                                                <select name="maker" id="maker" class="select2-with-label-single form-control {{ $errors->has('maker') ? 'is-invalid':'' }}">
                                                    <option value=""> {{ __('Pilih Buatan Kenderaan') }}</option>
                                                    @foreach($vehicleMakes as $key => $maker)
                                                        <option value="{{ $key }}">{{ $maker }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('maker') }}
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>{{ __('Warna') }}</label>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('colour') ? 'is-invalid':'' }}"
                                                       name="colour">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('colour') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-xl-12">
                                        @include('elements.action_button',["route"=>route('syndicates.show', $syndicateId),"buttons"=>["save","back"]])
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
