<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ url('admin') }}" class="card-link">Admin Home</a></li>
    
    @foreach(Config::get('lorekeeper.admin_sidebar') as $key => $section)
        @if(Auth::user()->isAdmin || Auth::user()->hasPower($section['power']))
            <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
                <div class="sidebar-section-header">{{ str_replace(' ', '', $key) }}</div>
                
                @foreach($section['links'] as $item)
                    <div class="sidebar-item"><a href="{{ url($item['url']) }}" class="{{ set_active($item['url'] . '*') }}">{{ $item['name'] }}</a></div>
                @endforeach
            </li>
        @endif
    @endforeach

</ul>