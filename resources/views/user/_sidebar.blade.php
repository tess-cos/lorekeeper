
<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ $user->url }}" class="card-link">{{ Illuminate\Support\Str::limit($user->name, 10, $end='...') }}</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header" style="margin-top: -2.5px;">Gallery</div>
        <div class="sidebar-item"><a href="{{ $user->url.'/gallery' }}" class="{{ set_active('user/'.$user->name.'/gallery*') }}">Gallery</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/favorites' }}" class="{{ set_active('user/'.$user->name.'/favorites*') }}">Favorites</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/favorites/own-characters' }}" class="{{ set_active('user/'.$user->name.'/favorites/own-characters*') }}">Character Favorites</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">User</div>
        <div class="sidebar-item"><a href="{{ $user->url.'/aliases' }}" class="{{ set_active('user/'.$user->name.'/aliases*') }}">Aliases</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/characters' }}" class="{{ set_active('user/'.$user->name.'/characters*') }}">Characters</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/myos' }}" class="{{ set_active('user/'.$user->name.'/myos*') }}">MYO Slots</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/inventory' }}" class="{{ set_active('user/'.$user->name.'/inventory*') }}">Inventory</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/'.__('awards.awardcase') }}" class="{{ set_active('user/'.$user->name.'/awardcase*') }}">{{ucfirst(ucfirst(__('awards.awardcase')))}}</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/bank' }}" class="{{ set_active('user/'.$user->name.'/bank*') }}">Bank</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/shops' }}" class="{{ set_active('user/'.$user->name.'/shops*') }}">User Shops</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/pets' }}" class="{{ set_active('user/'.$user->name.'/pets*') }}">Pets</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/wishlists' }}" class="{{ set_active('user/'.$user->name.'/wishlists*') }}">Wishlists</a></div>
    </li>
    <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
        <div class="sidebar-section-header">History</div>
        <div class="sidebar-item"><a href="{{ $user->url.'/ownership' }}" class="{{ $user->url.'/ownership*' }}">Ownership History</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/item-logs' }}" class="{{ $user->url.'/currency-logs*' }}">Item Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/currency-logs' }}" class="{{ set_active($user->url.'/currency-logs*') }}">Currency Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/'.__('awards.award').'-logs' }}" class="{{ set_active($user->url.'/award-logs*') }}">{{ucfirst(ucfirst(__('awards.award')))}} Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/pet-logs' }}" class="{{ set_active($user->url.'/pet-logs*') }}">Pet Logs</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/spell-logs' }}" class="{{ set_active($user->url.'/spell-logs*') }}">Spellbook</a></div>
        <div class="sidebar-item"><a href="{{ $user->url.'/submissions' }}" class="{{ set_active($user->url.'/submissions*') }}">Submissions</a></div>
    </li>

    @if(Auth::check() && Auth::user()->hasPower('edit_user_info'))
        <li class="sidebar-section" style="border-radius: .50rem; margin-top: 12.5px; padding-bottom: 10px;">
            <div class="sidebar-header" style="border-top-left-radius: .50rem;  border-top-right-radius: .50rem; font-size: 11pt; margin-top: -2.5px; color: #fff; font-family: Hachi Maru Pop; text-transform: lowercase; font-weight: bold; margin-bottom: 5px; padding-bottom: 5px;">Admin</div>
            <div class="sidebar-item" "><a href="{{ $user->adminUrl }}">Edit User</a></div>
        </li>
    @endif
</ul>
