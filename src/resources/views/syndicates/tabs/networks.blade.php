<div class="tab-pane fade show active" id="networks">

    @if($page == "edit")
        <div class="float-right m-1">
            @include('syndicates::elements.action_button',["route"=>route('networks.index', $syndicate->id_),"buttons" => ["add"]])
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
                                <form id="form-delete-network-{{$network->ID_}}" method="post"
                                      action="{{ route('networks.unlink', $syndicate->ID_) }}">
                                    @csrf @method('delete')
                                    <input type="hidden" name="model_id"
                                           value="{{$network->ID_}}">
                                    <input type="hidden" name="model_type"
                                           value="{{ class_basename($network) }}">
                                    <button type="submit"
                                            data-toggle="tooltip"
                                            title="{{ __("Padam Rangkaian") }}"
                                            class="btn btn-danger btn-xs btn-flat"><i
                                            class="fas fa-handshake-slash"></i></button>

                                </form>
                            @endif

                            <form target="_blank" id="form-chart-syndicate-{{$network->ID_}}" method="get"
                                  action="{{ route('orgchart.index') }}">
                                @csrf
                                <input type="hidden" name="model_id" value="{{$network->ID_}}">
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
                    <td>{{ $network->NAME_ }}</td>
                    <td>{{ $network->LCN_NO == null ? 'Tiada Data':$network->LCN_NO }}</td>
                    <td>{{ $network->TYPE == null ? "":$network->type['name'] }}</td>
                    <td>{{ $network->ID_NO }}</td>
                    <td>{{ $network->pivot->relationship->NAME_ }}</td>
                    <td>{{ $network->status_record->NAME_ }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
