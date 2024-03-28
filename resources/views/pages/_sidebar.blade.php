<div><div class="sideimg"></div><ul class="text-center">
    <li class="sidebar-header"><a href="#" class="card-link">Featured</a></li>

    <li class="sidebar-section p-1">
        @if(isset($featured) && $featured)
            <li class="sidebar-header-fc">
                <a href="{{ $featured->url }}"><img style="width: 90%; margin-left: 3.5px; background-color: #f4e3e6;" src="{{ $featured->image->thumbnailUrl }}" class="img-thumbnaill" /></a>
</li>


            <li class="sidebar-header-fc" style="padding-top: 0.5px;"> <a style="color: #95b582; font-family: Mali; font-size: 12pt;" href="{{ $featured->url }}" class="h5 mb-0">@if(!$featured->is_visible) <i class="fas fa-eye-slash"></i> @endif 

✿ {{ $featured->fullName }}</a>
            </li>
<li class="sidebar-header-fc p-1" style="border-bottom-left-radius: .50rem; border-bottom-right-radius: .50rem; padding-bottom: 10px;">
            <div style="text-align: center; font-size: 10pt; text-transform: lowercase; padding-bottom: 15px;">
            courtesy of {{$featured->user->name}}
            </div>

        @else
            <p>There is no featured character.</p>
        @endif
    </li>
</ul>
</div>