<ul><div class="sideimg"></div>
    <li class="sidebar-header"><a href="{{ url('masterlist') }}" class="card-link">Masterlist</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Masterlist</div>
        <div class="sidebar-item"><a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}">Characters</a></div>
        @if(isset($sublists) && $sublists->count() > 0)
            @foreach($sublists as $sublist)
            <div class="sidebar-item"><a href="{{ url('sublist/'.$sublist->key) }}" class="{{ set_active('sublist/'.$sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach @endif
        
    </li>
    
        <li class="sidebar-section" style="border-bottom-left-radius: .50rem; margin-top: 0px; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
        <div class="sidebar-section-header">Sub Masterlists</div>
        <div class="sidebar-item"><a href="{{ url('myos') }}" class="{{ set_active('myos*') }}">MYO Slots</a></div>
        </li>
   
</ul>