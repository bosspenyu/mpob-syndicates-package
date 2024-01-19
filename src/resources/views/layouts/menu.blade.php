
<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>{{ __('Dashboard') }}</p>
    </a>
</li>
<li class="nav-item {{  Request::is('syndicates') || Request::is('syndicates/search') || Request::is('syndicates/*') ? 'menu-is-opening menu-open':'' }}">
    <a href="#" class="nav-link">
        <i class="fas fa-sitemap"></i>
        <p>{{ __('Sindiket') }}  <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{ route('syndicates.index') }}"
               class="nav-link">
                <i class="nav-icon far fa-circle {{ Request::is('syndicates') || Request::is('syndicates/*') ? 'text-info' : '' }}"></i>
                <p>Senarai</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Rujukan</li>
<li class="nav-item">
    <a href="{{ route('relationships.index') }}"
       class="nav-link {{ Request::is('relationships') || Request::is('relationships/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-link"></i>
        <p>{{ __('Hubungan') }}</p>
    </a>
</li>
