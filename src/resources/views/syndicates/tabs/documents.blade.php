<div class="tab-pane fade" id="documents">
    @if($page == "edit")
        <div class="card card-success ">
            <div class="card-header rounded-0">
                <h3 class="card-title">   {{ __('Muat naik Dokumen') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('Nama Dokumen') }}</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="document_name">
                    </div>
                    <label class="col-sm-2 col-form-label">{{ __('Dokumen') }}</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="documents" onchange="previewDocs()">
                    </div>
                </div>

                <table class="table table-striped table-bordered" id="uploadingDocs"
                       data-action="{{route('documents.upload', $syndicate->id_)}}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Nama Dokumen') }}</th>
                        <th>{{ __('Dokumen') }}</th>
                        <th>{{ __('Tarikh') }}</th>
                        <th>{{ __('Tindakan') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <button onclick="uploadDocs()" class="btn btn-primary btn-xs float-right">
                            <i class="fas fa-upload"></i> Upload All
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header  rounded-0">
            <h3 class="card-title"> {{ __('Dokumen yang telah dimuat naik') }}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="uploadedDocs" class="table table-striped table-bordered"
                   data-action="{{ route('documents.delete', $syndicate->id_) }}">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Nama Pegawai') }}</th>
                    <th>{{ __('Dokumen') }}</th>
                    <th>{{ __('Tarikh') }}</th>
                    <th>{{ __('Tindakan') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($syndicate->getMedia('syndicate-documents') as $document)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{
                                $document->custom_properties['uploaded_by'] != null ? \App\Models\User::find($document->custom_properties['uploaded_by'])->name:''
                            }}
                        </td>
                        <td>{{ $document->name }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($document->create_dt)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <button class="btn btn-xs btn-danger docDelete" data-media-id="{{ $document->id }}">
                                <i class="fa fa-trash"></i></button>
                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
