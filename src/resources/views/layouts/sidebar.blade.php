<aside class="main-sidebar sidebar-light-white elevation-4">
    <a href="{{ route('syndicates.index') }}" class="brand-link">
        <img src="{{ asset('mpob_logo.png') }}"
             alt="MPOB Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
