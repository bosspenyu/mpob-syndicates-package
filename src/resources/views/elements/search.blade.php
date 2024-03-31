<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group p-3 border">
                    <legend class="px-3 w-auto">{{ __('Carian') }}</legend>
                    <form method="get">
                        <input type="hidden" class="advance_search" name="advance_search" value="false">
                        <input type="hidden" name="query" value="true">
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label>{{ __('Nama') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ request()->get('name') }}">
                            </div>
                            <div class="form-group col-md-3 text-center">
                                <a href="#" data-toggle="collapse" data-target="#advance_search"
                                   class="position-absolute nav-link" style="bottom: 0">
                                    <i class="fa fa-search"></i> {{ __('Terperinci') }}
                                </a>
                            </div>
                        </div>
                        <div class="collapse {{request()->get('advance_search') == "true" ? "show":""}}" id="advance_search">
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Negeri') }}</label>
                                            <select name="state_id" class="select2 form-control"
                                                    style="width: 100%">
                                                <option value="">{{ __('Pilih Negeri') }}</option>
                                                @foreach($states as $key => $state)
                                                    <option value="{{ $key }}" {{$key == request()->get('state_id') ? "selected":""}}> {{ $state }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Lokasi Operasi') }}</label>
                                        <select name="city_id" class="select2 form-control"
                                                style="width: 100%">
                                            <option value="">{{ __('Pilih Lokasi Operasi') }}</option>
                                            @foreach($cities as $city)
                                                <option
                                                    value="{{ $city->CODE_ }}" {{$city->CODE_ == request()->get('city_id') ? "selected":""}}>{{ ucfirst(strtolower($city->NAME_)) }}
                                                    ({{ $city->state->NAME_ }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('No. Kenderaan') }}</label>
                                        <input type="text" name="reg_no" class="form-control"
                                               placeholder="{{ __('MCV 1234') }}" value="{{ request()->get('vehicle_no') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('No. Lesen') }}</label>
                                        <input type="text" name="license_no" class="form-control"
                                               placeholder="{{ __('123456-X') }}" value="{{ request()->get('license_no') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Catatan') }}</label>
                                        <input type="text" name="note" class="form-control" value="{{ request()->get('note') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <button type="submit"
                                        class="btn btn-default custom-button-primary float-right">
                                    <i class="fa fa-search"></i> {{ __('Carian') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</section>
