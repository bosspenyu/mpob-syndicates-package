<div class="tab-pane fade show active" id="networks">

    @if($page == "edit")
        <div class="float-right m-1">
            @include('elements.action_button',["route"=>route('networks.index', $syndicate->id_),"buttons" => ["add"]])
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-condensed networks" style="border-collapse:collapse;">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>#</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('No. Lesen') }}</th>
                <th>{{ __('Jenis') }}</th>
                <th>{{ __('No. Pengenalan') }}</th>
                <th>{{ __('Hubungan') }}</th>
                <th>{{ __('Status') }}</th>

            </tr>
            </thead>
            <tbody>
            @foreach($networks as $network)
                <tr>
                    <td>
                        <div class="btn-group">
                            @if(request()->route()->getActionMethod() == "edit")
                                <form id="form-delete-network-{{$network->id_}}" method="post"
                                      action="{{ route('networks.unlink', $syndicate->id_) }}">
                                    @csrf @method('delete')
                                    <input type="hidden" name="model_id"
                                           value="{{$network->id_}}">
                                    <input type="hidden" name="model_type"
                                           value="{{ class_basename($network) }}">
                                    <button type="submit"
                                            data-toggle="tooltip"
                                            title="{{ __("Padam Rangkaian") }}"
                                            class="btn btn-danger btn-xs btn-flat"><i
                                            class="fas fa-handshake-slash"></i></button>

                                </form>
                            @endif

                            <form target="_blank" id="form-chart-syndicate-{{$network->id_}}" method="get"
                                  action="{{ route('orgchart.index') }}">
                                @csrf
                                <input type="hidden" name="model_id" value="{{$network->id_}}">
                                <input type="hidden" name="model_type"
                                       value="{{class_basename($network)}}">

                                <button
                                    data-toggle="tooltip"
                                    title="{{ __('Rangkaian Detail') }}"
                                    class="btn btn-default btn-flat btn-xs">
                                    <i class="fas fa-network-wired"></i>
                                </button>
                            </form>


                        </div>
                    </td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $network->name_ }}</td>
                    <td>{{ $network->lcn_no == null ? 'Tiada Data':$network->lcn_no }}</td>
                    <td>{{ $network->type == null ? "":$network->type['name'] }}</td>
                    <td>{{ $network->id_no }}</td>
                    <td>{{ $network->pivot->relationship->name_ }}</td>
                    <td>{{ $network->status_record->name_ }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
