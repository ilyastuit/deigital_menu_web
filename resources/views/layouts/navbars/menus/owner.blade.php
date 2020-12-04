<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurants.edit',  auth()->user()->restorant->id) }}">
            <i class="ni ni-shop text-info"></i> {{ __('Restaurant') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('items.index') }}">
            <i class="ni ni-collection text-pink"></i> {{ __('Menu') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('qr') }}">
            <i class="ni ni-mobile-button text-red"></i> {{ __('QR Builder') }}
        </a>
    </li>
</ul>
