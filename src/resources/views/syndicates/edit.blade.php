{{-- Extends layout --}}
@extends('layouts.app')

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
                        <li class="breadcrumb-item"><a href="{{ route('syndicates.index') }}">{{ __('Sindiket') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Kemaskini') }}</li>
                        <li class="breadcrumb-item active">{{ $syndicate->name_ }}</li>
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
                            <h4 class="card-title">{{ __('Profile Sindiket') }}</h4>
                        </div>

                        <div class="card-body">
                            @include('elements.alert')
                            <form id="syndicate-profile-form" enctype="multipart/form-data" method="post"
                                  action="{{route('syndicates.update', $syndicate->id_)}}">
                                @method('put') @csrf
                                <div class="row">
                                    <div class="{{ $syndicate->category->id == 2 ? "col-md-6":"col-md-12" }}">
                                        <div class="form-row mb-3">
                                            <div class="col-md-4">
                                                <label>{{ __('Kategori') }}</label>
                                                <input type="hidden" name="syndicate_category_id"
                                                       value="{{ $syndicate->category->id }}">
                                                <input type="text" readonly class="form-control"
                                                       value="{{ $syndicate->category->name }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('syndicate_category_id') }}
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label>{{ __('Nama') }}</label>
                                                <input type="text"
                                                       class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
                                                       name="name"
                                                       value="{{ $syndicate->name_ }}"
                                                >
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <label>{{ __('Aktif Sejak') }}</label>
                                                <select name="since"
                                                        class="select2 form-control {{ $errors->has('since') ? 'is-invalid':'' }}">
                                                    <option value=""> {{ __('Pilih Tahun') }} </option>
                                                    @for($i=2000; $i <= date('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ $syndicate->since == $i ? 'selected':'' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('since') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-4">
                                                <label>{{ __('Lokasi Operasi') }}</label>
                                                <select name="city_code"
                                                        class="select2 form-control {{ $errors->has('city_code') ? 'is-invalid':'' }}"
                                                        >
                                                    @foreach($cities as $city)
                                                        <option
                                                            value="{{ $city->code_ }}" {{ $syndicate->city_code_ == $city->code_ ? 'selected':'' }}>{{ ucfirst(strtolower($city->name_)) }}
                                                            ({{ $city->state->name_ }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city_code') }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>{{ __('Logitude') }}</label>
                                                <input type="text" name="longitude" class="form-control" value="{{ $syndicate->longitude }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('longitude') }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>{{ __('Latitude') }}</label>
                                                <input type="text" name="latitude" class="form-control" value="{{ $syndicate->latitude }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('Latitude') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <label>{{ __('Tags') }}</label>
                                                <select multiple="multiple" class="tags form-control" name="tags[]"
                                                        id="tags">
                                                    @foreach($tags as $id => $tag)
                                                        <option
                                                            value="{{ $id }}" {{ in_array($id, $syndicate->tags->pluck('id_')->toArray()) ? 'selected':'' }}>{{ $tag }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-12">
                                                <label>{{ __('Pengesahan') }}</label>
                                                <select name="ref_str_sts_code_" class="form-control">
                                                    @foreach($confirmation as $code => $name)
                                                        <option
                                                            value="{{ $code }}" {{ $code == $syndicate->ref_str_sts_code_ ? 'selected':'' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-md-2">
                                                <label>{{ __('Status') }}</label>
                                                <div class="form-group mb-0">
                                                    <input
                                                        name="status"
                                                        type="checkbox"
                                                        data-on-text="{{__('On')}}"
                                                        data-off-text="{{ __('Off') }}"
                                                        class="switch-style"
                                                        data-on-color="success"
                                                        data-off-color="danger"
                                                        data-size="small"
                                                        {{ $syndicate->status == 1 ? 'checked':'' }}
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <label>{{ __('Akses Ketua Unit/Wilayah') }}</label>
                                                <div class="form-group mb-0">
                                                    <input
                                                        name="is_restricted"
                                                        type="checkbox"
                                                        data-on-text="{{__('On')}}"
                                                        data-off-text="{{ __('Off') }}"
                                                        class="switch-style"
                                                        data-size="small"
                                                        data-on-color="success"
                                                        data-off-color="danger"
                                                        {{ $syndicate->is_restricted ? 'checked':'' }}
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 {{ $syndicate->category->id  == 2 ? : "d-none" }}">
                                        <fieldset class="border p-2">
                                            <div class="profile-pic mb-5">

                                                <img alt="User Pic"
                                                     src="{{ $syndicate->getFirstMediaUrl('syndicate-profile-image') ? $syndicate->getFirstMediaUrl('syndicate-profile-image'): asset('placeholder-profile.png') }}"
                                                     class="profile-image" height="200">
                                                <input name="syndicate-profile-image"
                                                       class="d-none syndicate-profile-image"
                                                       type="file"
                                                       onchange="previewFile()">
                                                <div style="color:#999;"></div>

                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="col-md-5">
                                                    <label>{{ __('Jenis') }}</label>
                                                    <select
                                                        name="syndicate_type_id"
                                                        class="select2 form-control {{ $errors->has('syndicate_type_id') ? 'is-invalid':'' }}"
                                                        id="multi-value-select">
                                                        <option value=""> --- {{ __('Sila Pilih') }} --- </option>
                                                        @foreach($syndicateTypes as $id => $type)
                                                            <option
                                                                value="{{ $id }}" {{ $syndicate->syndicate_type_id == $id ? "selected" :"" }}>{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('syndicate_type_id') }}
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label>{{ __('No. Identity') }}</label>
                                                    <input type="text"
                                                           class="form-control {{ $errors->has('identity_no') ? 'is-invalid':'' }}"
                                                           name="identity_no"
                                                           value="{{$syndicate->id_no}}"
                                                    >
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('identity_no') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xl-12">
                                    <button onclick="document.getElementById('syndicate-profile-archive').submit();"
                                            class="btn btn-dark btn-xs float-right mx-1"><i
                                            class="fas fa-archive"></i> {{ __('Arkib') }}</button>
                                    <button onclick="if(confirm('Anda pasti untuk memadam rekod ini?'))document.getElementById('syndicate-profile-destroy').submit();"
                                            class="btn btn-danger btn-xs float-right mx-1"><i
                                            class="fas fa-trash"></i> {{ __('Padam') }}</button>
                                    <button onclick="document.getElementById('syndicate-profile-form').submit();"
                                            class="btn btn-primary btn-xs float-right mx-1"><i
                                            class="fas fa-edit"></i> {{ __('Kemaskini') }}</button>
                                    @include('elements.action_button', ['route'=>route('syndicates.index'),"buttons"=>["back"]])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include("syndicates.tabs.index",["page"=>request()->route()->getActionMethod()])
        </div>
        <form method="post" id="syndicate-profile-archive"
              action="{{ route('syndicates.archive', $syndicate->id_) }}">
            @method('delete') @csrf
        </form>

        <form method="post" id="syndicate-profile-destroy"
              action="{{ route('syndicates.destroy', $syndicate->id_) }}">
            @method('delete') @csrf
        </form>
    </section>

@endsection
