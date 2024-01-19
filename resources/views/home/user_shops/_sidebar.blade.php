<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ url('usershops/shop-index') }}" class="card-link">Market</a></li>
@if(Auth::check())
        <li class="sidebar-section">
            <div class="sidebar-section-header">History</div>
            <div class="sidebar-item"><a href="{{ url('usershops/history') }}" class="{{ set_active('usershops/history*') }}">Purchase History</a></div>
            <div class="sidebar-section-header">My Currencies</div>
            @foreach(Auth::user()->getCurrencies(true) as $currency)
            <div class="sidebar-item pr-3" style="padding-bottom: 5px;">{!! $currency->display($currency->quantity) !!}</div>
            @endforeach
        </li>
    @endif

    <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
        <div class="sidebar-section-header">User Shops</div>
        <div class="sidebar-item"><a href="{{ url('usershops') }}" class="{{ set_active('usershops') }}">My Shop</a></div>
        <div class="sidebar-item"><a href="{{ url('usershops/shop-index') }}" class="{{ set_active('usershops/shop-index*') }}">All User Shops</a></div>
        <div class="sidebar-item"><a href="{{ url('usershops/item-search') }}" class="{{ set_active('usershops/item-search*') }}">Search For Item</a></div>
        <div class="sidebar-item"><a href="{{ url('usershops/pet-search') }}" class="{{ set_active('usershops/pet-search*') }}">Search For Pet</a></div>
</li>
</ul>