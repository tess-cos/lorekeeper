<div><div class="sideimg"></div><ul class="text-center">
    <li class="sidebar-header"><a href="#" class="card-link">Featured</a></li>

    <li class="sidebar-section p-1">
        @if(isset($featured) && $featured)
            <li class="sidebar-header-fc">
                <a href="{{ $featured->url }}"><img style="margin-left: -4px; background-color: #f4e3e6 !important;" src="{{ $featured->image->thumbnailUrl }}" class="img-thumbnail" /></a>
</li>


            <li class="sidebar-header-fc" style="padding-top: 0.5px;"> <a style="color: #95b582; font-family: Mali; font-size: 12pt;" href="{{ $featured->url }}" class="h5 mb-0">@if(!$featured->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $featured->fullName }}</a>
            </li>
<li class="sidebar-header-fc p-1" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
            <div style="text-align: center; font-size: 10pt; text-transform: lowercase; padding-bottom: 15px;">
            <span style="color: #E5C1C7;">✿</span> courtesy of {{$featured->user->name}} <span style="color: #E5C1C7;">✿</span>
            </div>

        @else
            <p>There is no featured character.</p>
        @endif
    </li>
</ul>
</div>