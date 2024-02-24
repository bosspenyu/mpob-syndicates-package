<DIV CLASS="TAB-PANE FADE" ID="NOTES">
    <div class="pt-4">
        @if($page == "edit")
        <form method="post" action="{{ route('notes.store', $syndicate->ID_) }}">
            @csrf
            <div class="form-group row">
                <label
                    class="col-sm-2 col-form-label text-right">{{ __('Nota Baru') }}</label>
                <div class="col-sm-8">
                    <textarea
                        class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"
                        name="description" id="description" rows="5"></textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label text-right">Date:</label>
                <div class="input-group date col-sm-8" id="reservationdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input {{ $errors->has('date') ? 'is-invalid':'' }}" name="date" data-target="#reservationdate"/>
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                </div>
            </div>
            <div class="form-group row justify-content-center">
                <div class="col-xl-8">
                    <button class="btn btn-primary btn-xs btn-block">
                        {{ __('Simpan') }}
                    </button>
                </div>

            </div>
        </form>
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Tarikh') }}</th>
                <th>{{ __('Dimasukkan') }}</th>
                <th>{{ __('Nota') }}</th>
                <th>{{ __('Dokumen/Foto') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($syndicate->notes as $note)
                <tr>
                    <td class="align-text-top">{{ $loop->iteration }}</td>
                    <td class="align-text-top">{{ \Illuminate\Support\Carbon::parse($note->INSERT_DT)->format('d/m/Y g:i A') }}</td>
                    <td class="align-text-top">{{ $note->user->NAME }}</td>
                    <td class="col-xl-4 align-text-top">{{ $note->DESCRIPTION }}</td>
                    <td>
                        <ul class="note-list-images">
                            <li>
                                <button type="button" class="btn btn-default custom-button-primary" data-toggle="modal"
                                        data-target=".modal-note-{{$note->ID}}">
                                    <i class="fas fa-images"></i>
                                </button>
                            </li>
                            @foreach($note->getMedia('file') as $file)
                                <li class="image-{{ $file->ID }}">
                                    <form method="post"
                                          action="{{ route('notes.file.delete',[$syndicate->ID_, $note->ID_]) }}">
                                        @csrf @method('delete')
                                        <input type="hidden" name="media_id" value="{{ $file->ID }}">
                                        <a href="{{ $file->getFullUrl() }}" target="_blank">{{ $file->FILE_NAME }}</a>
                                        <a data-syndicate-id="{{$syndicate->ID_}}" data-note-id="{{ $note->ID_ }}"
                                           data-media-id="{{$file->ID}}" href="javascript:void(0)"
                                           onclick="remove(this)" class="btn btn-link mx-2"> <i class="fas fa-trash"></i></a>
                                    </form>

                                </li>
                            @endforeach
                        </ul>

                        <div class="modal fade modal-note-{{$note->ID}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Upload</h5>
                                        <button onclick="window.location.reload()" type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="dropzone">
                                            <form method="post" id="file-uploader" class="file-uploader dropzone"
                                                  action="{{ route('notes.upload', [$syndicate->ID_,$note->ID_]) }}"
                                                  class="dropzone" id="file-upload" enctype="multipart/form-data">
                                                @csrf
                                                <div class="dz-message">
                                                    <div class="col-xs-8">
                                                        <div class="message">
                                                            <p>Drop files here or Click to Upload</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fallback">
                                                    <input type="file" name="file" multiple>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button onclick="window.location.reload()" type="button"
                                                class="btn btn-xs btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
