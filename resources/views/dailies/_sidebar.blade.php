<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ url(__('dailies.dailies')) }}" class="card-link">{{__('dailies.dailies')}}</a></li>

    <li class="sidebar-section">
        @foreach($dailies as $daily)
        <div class="sidebar-item"><a href="{{ $daily->url }}" class="{{ set_active('dailies/'.$daily->id) }}">{{ $daily->name }}</a></div>
        @endforeach
    </li>
    <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
    <div class="sidebar-section-header">Other</div>
        <div class="sidebar-item"><a href="{{ url('activities') }}">Activities</a></div>
        <div class="sidebar-item"><a href="{{ url('helpwanted') }}">Help Wanted</a></div>
    </li>
</ul>