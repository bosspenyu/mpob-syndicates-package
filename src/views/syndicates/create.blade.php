{{-- Extends layout --}}
@extends('layouts.master')

{{-- Content --}}
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1>{{ __('Sindiket') }}</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('syndicates.index') }}">{{ __('Sindiket') }} </a></li>
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
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Profile Sindiket') }}</h3>
                        </div>
                        <form enctype="multipart/form-data" method="post" action="{{ route('syndicates.store') }}">
                            @csrf
                            <div class="card-body">
                                @include('syndicates::elements.alert')
                                <div class="row">
                                    <div class="{{ Request::input('category') == 2 ? "col-md-6":"col-md-12" }}">
                                        <div class="form-row mb-3">
                                            <div class="col-md-4">
                                                <label>{{ __('Kategori') }}</label>
                                                <select
                                                    onchange="window.location=`{{ route('syndicates.create') }}?category=${this.value}`"
                                                    name="syndicate_category_id"
                                                    class="select2 form-control {{ $errors->has('syndicate_category_id') ? 'is-invalid':'' }}"
                                                >
                                                    @foreach($syndicateCategories as $id => $category)
                                                        <option
                                                            value="{{ $id }}" {{ Request::input('category') == $id ? 'selected':'' }}>
                                                            {{ $category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('syndicate_category_id') }}
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label>{{ __('Nama') }}</label>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                                                       name="name"
                                                       value="{{ old('name') }}"
                                                >
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-6">
                                                <label>{{ __('Aktif Sejak') }}</label>
                                                <select name="since"
                                                        class="select2 form-control {{ $errors->has('since') ? 'is-invalid':'' }}"
                                                >
                                                    <option value=""> {{ __('Pilih Tahun') }} </option>
                                                    @for($i=2000; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}" {{ old("since") == $i ? "selected":"" }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('since') }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ __('Lokasi Operasi') }}</label>
                                                <select name="city_code"
                                                        class="select2 form-control {{ $errors->has('city_code') ? 'is-invalid':'' }}"
                                                >
                                                    <option value=""> {{ __('Pilih Lokasi') }} </option>
                                                    @foreach($cities as $city)
                                                        <option
                                                            value="{{ $city->CODE_ }}" {{ old('city_code') == $city->CODE_ ? "selected":"" }}>{{ ucfirst(strtolower($city->NAME_)) }}
                                                            ({{ $city->state->NAME_ }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city_code') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-6">
                                                <label>{{ __('Logitude') }}</label>
                                                <input type="text" name="longitude" value="{{ old('longitude') }}" class="form-control">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('longitude') }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ __('Latitude') }}</label>
                                                <input type="text" name="latitude" value="{{ old('latitude') }}" class="form-control">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('latitude') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <label>{{ __('Tags') }}</label>
                                                <select multiple="multiple" class="tags form-control" name="tags[]"
                                                        id="tags">
                                                    @foreach($tags as $id => $tag)
                                                        <option value="{{ $id }}" {{ (collect(old('tags'))->contains($id)) ? 'selected':'' }}>{{ $tag }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 {{ Request::input('category') == 2 ? : "d-none" }}">
                                        <fieldset class="border p-2">
                                            <div class="profile-pic mb-5">

                                                <img alt="User Pic"
                                                     src="{{ asset('placeholder-profile.png') }}"
                                                     class="profile-image" height="200">
                                                <input name="syndicate-profile-image"
                                                       class="d-none syndicate-profile-image"
                                                       type="file"
                                                       onchange="previewFile()">
                                                <div style="color:#999;"></div>

                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="col-md-6">
                                                    <label>{{ __('Jenis') }}</label>
                                                    <select
                                                        name="syndicate_type_id"
                                                        class="select2 form-control {{ $errors->has('syndicate_type_id') ? 'is-invalid':'' }}"
                                                        id="multi-value-select">
                                                        <option value=""> --- {{ __('Sila Pilih') }} ---</option>
                                                        @foreach($syndicateTypes as $id => $type)
                                                            <option
                                                                value="{{ $id }}" {{ old('syndicate_type_id') == $id ? "selected":"" }}>
                                                                {{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('syndicate_type_id') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label>{{ __('No. Identity') }}</label>
                                                    <input type="text"
                                                           class="form-control {{ $errors->has('identity_no') ? 'is-invalid':'' }}"
                                                           name="identity_no"
                                                           value="{{ old('identity_no') }}"
                                                    >
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('identity_no') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-xl-12">
                                        @include('syndicates::elements.action_button',["route"=>route('syndicates.index'),"buttons"=>["save","back"] ])
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
