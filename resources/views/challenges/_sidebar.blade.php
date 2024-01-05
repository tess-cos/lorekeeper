<ul>
    <li class="sidebar-header"><a href="{{ url('quests') }}" class="card-link">Quests</a></li>
    @if(Auth::check())
        <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
            <div class="sidebar-section-header" >Quest List</div>
            <div class="sidebar-item"><a href="{{ url('quests/my-quests') }}" class="{{ set_active('quests/my-quests*') }}">My Quests</a></div>
        </li>
    @endif
</ul>
