<ul><div class="sideimg"></div>
<li class="sidebar-header"><a href="{{ url('designs/') }}">Approvals</a></li>
    @if(isset($request))
        <li class="sidebar-section">
            <div class="sidebar-section-header">Current Request</div>
            <div class="sidebar-item"><a href="{{ $request->url }}" class="{{ set_active('designs/'.$request->id) }}">View</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/comments' }}" class="{{ set_active('designs/' . $request->id . '/comments') }}">Comments</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/image' }}" class="{{ set_active('designs/' . $request->id . '/image') }}">Image</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/addons' }}" class="{{ set_active('designs/' . $request->id . '/addons') }}">Add-ons</a></div>
            <div class="sidebar-item"><a href="{{ $request->url . '/traits' }}" class="{{ set_active('designs/' . $request->id . '/traits') }}">Traits</a></div>
        </li>
    @endif
    <li class="sidebar-section" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
        <div class="sidebar-section-header">Design Approvals</div>
        <div class="sidebar-item"><a href="{{ url('designs') }}" class="{{ set_active('designs') }}">Drafts</a></div>
        <div class="sidebar-item"><a href="{{ url('designs/pending') }}" class="{{ set_active('designs/*') }}">Submissions</a></div>
    </li>
</ul>