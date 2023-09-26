<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ url('trades/listings') }}" class="card-link">plaza</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Trade Listings</div>
        <div class="sidebar-item"><a href="{{ url('trades/listings') }}" class="{{ set_active('trades/listings') }}">Active Listings</a></div>
        <div class="sidebar-item"><a href="{{ url('trades/listings/expired') }}" class="{{ set_active('trades/listings/expired') }}">My Expired Listings</a></div>
        <div class="sidebar-item"><a href="{{ url('trades/listings/create') }}" class="{{ set_active('trades/listings/create') }}">New Listing</a></div>
    </li>
    <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
        <div class="sidebar-section-header">Trade Queue</div>
        <div class="sidebar-item"><a href="{{ url('trades/open') }}">My Trades</a></div>
        <div class="sidebar-item"><a href="{{ url('trades/create') }}">New Trade</a></div>
    </li>
</ul>