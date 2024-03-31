<DIV CLASS="TAB-PANE FADE" ID="VEHICLES">
    @if($page == "edit")
        <div class="float-right m-1">
            @include('syndicates::elements.action_button',["route"=>route('vehicles.create', $syndicate->id_),"buttons" => ["add"]])
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('No. Pendaftaran') }}</th>
                <th>{{ __('Jenis') }}</th>
                <th>{{ __('Buatan') }}</th>
                <th>{{ __('Warna') }}</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($syndicate->vehicles as $vehicle)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $vehicle->REG_NO }}</td>
                    <td>{{ $vehicle->VEHICLE_CODE }}</td>
                    <td>{{ $vehicle->MAKE_ }}</td>
                    <td>{{ $vehicle->COLOUR }}</td>
                    <td class="text-center">
                        <form id="form-vehicle-delete-{{$syndicate->ID_}}" method="post"
                              action="{{ route('vehicles.destroy', $syndicate->ID_) }}">
                            @csrf @method('delete')
                            <input type="hidden" name="vehicle_id"
                                   value="{{ $vehicle->ID_ }}">
                        </form>

                        <div class="btn-group">
                            <a
                                data-toggle="tooltip"
                                title="{{ __('Kemaskini') }}"
                                class="btn btn-warning btn-xs"
                                href="{{ route('vehicles.show', [$syndicate->ID_, $vehicle->ID_]) }}">
                                <i class="far fa-edit"></i>
                            </a>
                            <a onclick="if(confirm('Padam Kenderaan?'))document.getElementById('form-vehicle-delete-{{$syndicate->id_}}').submit();"
                               data-toggle="tooltip"
                               title="{{ __('Padam') }}"
                               class="btn btn-danger btn-xs"
                            >
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
