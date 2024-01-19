<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <!-- Nav tabs -->
                <div class="default-tab">
                    <ul class="nav nav-tabs" role="tablist" id="myTab">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab"
                               href="#networks">{{ __('Rangkaian') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab"
                               href="#complaints">{{ __('Aduan/Kes') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vehicles">{{ __('Kenderaan') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#notes">{{ __('Investigation Diary (ID)') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#documents">{{ __('Dokumen') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include('syndicates.tabs.networks',["page"=>$page])
                        @include('syndicates.tabs.complaints',["page"=>$page])
                        @include('syndicates.tabs.vehicles',["page"=>$page])
                        @include('syndicates.tabs.notes',["page"=>$page])
                        @include('syndicates.tabs.documents',["page"=>$page])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
