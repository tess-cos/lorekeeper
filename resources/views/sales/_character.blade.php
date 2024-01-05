<div class="card h-100" style="border: 0; background-color: #f8f7f2 !important; padding: 5px; border-radius: 15px;">
    <div class="m-1">
        <div class="row">
            <div class="col-md-6 text-center align-self-center">
                <a href="{{ $character->character->url }}"><img style="background: #fff; border: 1px solid #f4e3e6; padding: 0px;" src="{{ $loop->count == 1 ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="mw-100 img-thumbnail" alt="{{ $character->fullName }}" /></a>
            </div>
            <div class="col-md text-center" style="padding: 15px;">
                <div class="mt-2">
                    <h5>
                        {{ $character->displayType }}: <a href="{{ $character->character->url }}">{!! $character->character->slug !!}</a><br /><span style="font-family: Poppins, sans-serif; font-size: 12pt;" class="{{ $character->is_open && $character->sales->is_open ? 'text-success' : 'text-primary' }}">[{{ $character->is_open && $character->sales->is_open ? 'Open' : 'Closed' }}]</span><br/>
                        <small>
                            {!! $character->image->species->displayName !!} {!! $character->image->rarity->displayName !!}<br/>
                        </small>
                    </h5>

                    @if($loop->count == 1)
                        <div class="mb-2">
                            @if(Config::get('lorekeeper.extensions.traits_by_category'))
                                <div>
                                    @php $traitgroup = $character->image->features()->get()->groupBy('feature_category_id') @endphp
                                    @if($character->image->features()->count())
                                        @foreach($traitgroup as $key => $group)
                                        <div>
                                            @if($group->count() > 1)
                                                <div>
                                                    <strong>{!! $key ? $group->first()->feature->category->displayName : 'Miscellaneous' !!}:</strong>
                                                    @foreach($group as $feature)
                                                        {!! $feature->feature->displayName !!}@if($feature->data) ({{ $feature->data }})@endif{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </div>
                                            @else
                                                <strong>{!! $key ? $group->first()->feature->category->displayName : 'Miscellaneous' !!}:</strong>
                                                {!! $group->first()->feature->displayName !!}
                                                    @if($group->first()->data)
                                                        ({{ $group->first()->data }})
                                                    @endif
                                            @endif
                                        </div>
                                        @endforeach
                                    @else
                                        <div>No traits listed.</div>
                                    @endif
                                </div>
                            @else
                                <div>
                                    <?php $features = $character->image->features()->with('feature.category')->get(); ?>
                                    @if($features->count())
                                        @foreach($features as $feature)
                                            <div>@if($feature->feature->feature_category_id) <strong>{!! $feature->feature->category->displayName !!}:</strong> @endif {!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
                                        @endforeach
                                    @else
                                        <div>No traits listed.</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    
                        <div class="mb-2 sp" style="font-size:9pt;">
                           <p style="margin-bottom: -5px;">design:
                            @foreach($character->image->designers as $designer)
                                {!! $designer->displayLink() !!}{{ !$loop->last ? ', ' : '' }}
                            @endforeach</p>
                            <p style="margin-bottom: -5px;">art:
                            @foreach($character->image->artists as $artist)
                                {!! $artist->displayLink() !!}{{ !$loop->last ? ', ' : '' }}
                            @endforeach</p>
                        </div>

                        <p style="margin-bottom: 10px;">{!! $character->description !!}</p>
                        <h6 style="font-size: 9.5pt; font-family: Poppins, serif;">
                        {!! $character->price !!}</h6>
                        {!! isset($character->link) || isset($character->data['end_point']) ? '<br/>' : '' !!}
                        @if(isset($character->data['end_point']))
                            {{ $character->data['end_point'] }}
                        @endif
                        {{ (isset($character->link) && ((!isset($character->sales->comments_open_at) || Auth::check() && Auth::user()->hasPower('edit_pages')) || $character->sales->comments_open_at < Carbon\Carbon::now())) && isset($character->data['end_point']) ? ' ・ ' : '' }}
                        @if(isset($character->link) && ((!isset($character->sales->comments_open_at) || Auth::check() && Auth::user()->hasPower('edit_pages')) || $character->sales->comments_open_at < Carbon\Carbon::now()))
                            <a href="{{ $character->link }}">{{ $character->typeLink }}</a>
                        @endif
                    </h6>

                </div>
            </div>
        </div>
    </div>
</div>
