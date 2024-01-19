<div class="tab-pane fade" id="vehicles">
    @if($page == "edit")
        <div class="float-right m-1">
            @include('elements.action_button',["route"=>route('vehicles.create', $syndicate->id_),"buttons" => ["add"]])
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
                    <td>{{ $vehicle->reg_no }}</td>
                    <td>{{ $vehicle->vehicle_code }}</td>
                    <td>{{ $vehicle->make_ }}</td>
                    <td>{{ $vehicle->colour }}</td>
                    <td class="text-center">
                        <form id="form-vehicle-delete-{{$syndicate->id_}}" method="post"
                              action="{{ route('vehicles.destroy', $syndicate->id_) }}">
                            @csrf @method('delete')
                            <input type="hidden" name="vehicle_id"
                                   value="{{ $vehicle->id_ }}">
                        </form>

                        <div class="btn-group">
                            <a
                                data-toggle="tooltip"
                                title="{{ __('Kemaskini') }}"
                                class="btn btn-warning btn-xs"
                                href="{{ route('vehicles.show', [$syndicate->id_, $vehicle->id_]) }}">
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
